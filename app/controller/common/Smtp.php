<?php
/**
 * +----------------------------------------------------------------------
 * | 九月科技-ztuc.cn
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: ztucke@ztuc.cn
 *                 ..:::::::::::'           | DATETIME: 2020/01/31
 *             '::::::::::::'
 *                .::::::::::
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 * +----------------------------------------------------------------------
 */

namespace app\controller\common;
class Smtp
{

    /* Public Variables */

    var $smtp_port; //smtp_port 端口号

    var $time_out;

    var $host_name; //服务器主机名

    var $log_file;

    var $relay_host; //服务器主机地址

    var $debug;

    var $auth; //验证

    var $user; //服务器用户名

    var $pass; //服务器密码

    /* Private Variables */

    var $sock;

    /* Constractor 构造方法*/

    function __construct($relay_host = "", $smtp_port = 25, $user, $pass, $auth = false)

    {

        $this->debug = FALSE;

        $this->smtp_port = $smtp_port;

        $this->relay_host = $relay_host;

        $this->time_out = 30; //is used in fsockopen()

        #

        $this->auth = $auth; //auth

        $this->user = $user;

        $this->pass = $pass;

        #

        $this->host_name = "localhost"; //is used in HELO command

        // $this->host_name = "smtp.163.com"; //is used in HELO command

        $this->log_file = "";


        $this->sock = FALSE;

    }

    /* Main Function */

    function sendmail($to, $from, $subject = "", $body = "", $mailtype, $cc = "", $bcc = "", $additional_headers = "")

    {

        $header = "";

        $mail_from = $this->getAddress($this->stripComment($from));

        $body = mb_ereg_replace("(^|(\r\n))(\\.)", "\\1.\\3", $body);

        $header .= "MIME-Version:1.0\r\n";

        if ($mailtype == "HTML") { //邮件发送类型

            //$header .= "Content-Type:text/html\r\n";

            $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        }

        $header .= "To: " . $to . "\r\n";

        if ($cc != "") {

            $header .= "Cc: " . $cc . "\r\n";

        }

        $header .= "From: " . $from . "\r\n";

        // $header .= "From: $from<".$from.">\r\n";  //这里只显示邮箱地址，不够人性化

        $header .= "Subject: " . $subject . "\r\n";

        $header .= $additional_headers;

        $header .= "Date: " . date("r") . "\r\n";

        $header .= "X-Mailer:By (PHP/" . phpversion() . ")\r\n";

        list($msec, $sec) = explode(" ", microtime());

        $header .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $mail_from . ">\r\n";

        $TO = explode(",", $this->stripComment($to));


        if ($cc != "") {

            $TO = array_merge($TO, explode(",", $this->stripComment($cc))); //合并一个或多个数组

        }


        if ($bcc != "") {

            $TO = array_merge($TO, explode(",", $this->stripComment($bcc)));

        }


        $sent = TRUE;

        foreach ($TO as $rcpt_to) {

            $rcpt_to = $this->getAddress($rcpt_to);

            if (!$this->smtpSockopen($rcpt_to)) {

                $this->logWrite("Error: Cannot send email to " . $rcpt_to . "\n");

                $sent = FALSE;

                continue;

            }

            if ($this->smtpSend($this->host_name, $mail_from, $rcpt_to, $header, $body)) {

                $this->logWrite("E-mail has been sent to <" . $rcpt_to . ">\n");

            } else {

                $this->logWrite("Error: Cannot send email to <" . $rcpt_to . ">\n");

                $sent = FALSE;

            }

            fclose($this->sock);

            $this->logWrite("Disconnected from remote host\n");

        }

        //echo "<br>";

        //echo $header;

        return $sent;

    }

    /* Private Functions */

    function smtpSend($helo, $from, $to, $header, $body = "")

    {

        if (!$this->smtpPutcmd("HELO", $helo)) {

            return $this->smtp_error("sending HELO command");

        }

        #auth

        if ($this->auth) {

            if (!$this->smtpPutcmd("AUTH LOGIN", base64_encode($this->user))) {

                return $this->smtp_error("sending HELO command");

            }


            if (!$this->smtpPutcmd("", base64_encode($this->pass))) {

                return $this->smtp_error("sending HELO command");

            }

        }

        #

        if (!$this->smtpPutcmd("MAIL", "FROM:<" . $from . ">")) {

            return $this->smtp_error("sending MAIL FROM command");

        }


        if (!$this->smtpPutcmd("RCPT", "TO:<" . $to . ">")) {

            return $this->smtp_error("sending RCPT TO command");

        }


        if (!$this->smtpPutcmd("DATA")) {

            return $this->smtp_error("sending DATA command");

        }


        if (!$this->smtpMessage($header, $body)) {

            return $this->smtp_error("sending message");

        }


        if (!$this->smtpEom()) {

            return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");

        }


        if (!$this->smtpPutcmd("QUIT")) {

            return $this->smtp_error("sending QUIT command");

        }


        return TRUE;

    }

    function smtpSockopen($address)

    {

        if ($this->relay_host == "") {

            return $this->smtpSockopen_mx($address);

        } else {

            return $this->smtpSockopenRelay();

        }

    }

    function smtpSockopenRelay()

    {

        $this->logWrite("Trying to " . $this->relay_host . ":" . $this->smtp_port . "\n");

        $this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);

        if (!($this->sock && $this->smtpOk())) {

            $this->logWrite("Error: Cannot connenct to relay host " . $this->relay_host . "\n");

            $this->logWrite("Error: " . $errstr . " (" . $errno . ")\n");

            return FALSE;

        }

        $this->logWrite("Connected to relay host " . $this->relay_host . "\n");

        return TRUE;;

    }

    function smtpSockopenMx($address)

    {

        $domain = ereg_replace("^.+@([^@]+)$", "\\1", $address);

        if (!@getmxrr($domain, $MXHOSTS)) {

            $this->logWrite("Error: Cannot resolve MX \"" . $domain . "\"\n");

            return FALSE;

        }

        foreach ($MXHOSTS as $host) {

            $this->logWrite("Trying to " . $host . ":" . $this->smtp_port . "\n");

            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);

            if (!($this->sock && $this->smtpOk())) {

                $this->logWrite("Warning: Cannot connect to mx host " . $host . "\n");

                $this->logWrite("Error: " . $errstr . " (" . $errno . ")\n");

                continue;

            }

            $this->logWrite("Connected to mx host " . $host . "\n");

            return TRUE;

        }

        $this->logWrite("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")\n");

        return FALSE;

    }

    function smtpMessage($header, $body)

    {

        fputs($this->sock, $header . "\r\n" . $body);

        $this->smtpDebug("> " . str_replace("\r\n", "\n" . "> ", $header . "\n> " . $body . "\n> "));


        return TRUE;

    }

    function smtpEom()

    {

        fputs($this->sock, "\r\n.\r\n");

        $this->smtpDebug(". [EOM]\n");


        return $this->smtpOk();

    }

    function smtpOk()

    {

        $response = str_replace("\r\n", "", fgets($this->sock, 512));

        $this->smtpDebug($response . "\n");


        if (!mb_ereg("^[23]", $response)) {

            fputs($this->sock, "QUIT\r\n");

            fgets($this->sock, 512);

            $this->logWrite("Error: Remote host returned \"" . $response . "\"\n");

            return FALSE;

        }

        return TRUE;

    }

    function smtpPutcmd($cmd, $arg = "")

    {

        if ($arg != "") {

            if ($cmd == "")

                $cmd = $arg;

            else

                $cmd = $cmd . " " . $arg;

        }


        fputs($this->sock, $cmd . "\r\n");

        $this->smtpDebug("> " . $cmd . "\n");


        return $this->smtpOk();

    }

    function smtpError($string)

    {

        $this->logWrite("Error: Error occurred while " . $string . ".\n");

        return FALSE;

    }

    function logWrite($message)

    {

        $this->smtPDebug($message);


        if ($this->log_file == "") {

            return TRUE;

        }


        $message = date("M d H:i:s ") . get_current_user() . "[" . getmypid() . "]: " . $message;

        if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {

            $this->smtpDebug("Warning: Cannot open log file \"" . $this->log_file . "\"\n");

            return FALSE;

        }

        flock($fp, LOCK_EX);

        fputs($fp, $message);

        fclose($fp);


        return TRUE;

    }

    function stripComment($address)

    {

        $comment = "\\([^()]*\\)";

        while (mb_ereg($comment, $address)) {

            $address = mb_ereg_replace($comment, "", $address);

        }


        return $address;

    }

    function getAddress($address)

    {

        $address = mb_ereg_replace("([ \t\r\n])+", "", $address);

        $address = mb_ereg_replace("^.*<(.+)>.*$", "\\1", $address);


        return $address;

    }

    function smtpDebug($message)

    {

        if ($this->debug) {

            return $message . "<br>";

        }

    }

    function getAttachType($image_tag) //

    {


        $filedata = array();


        $img_file_con = fopen($image_tag, "r");

        unset($image_data);

        while ($tem_buffer = AddSlashes(fread($img_file_con, filesize($image_tag))))

            $image_data .= $tem_buffer;

        fclose($img_file_con);


        $filedata['context'] = $image_data;

        $filedata['filename'] = basename($image_tag);

        $extension = substr($image_tag, strrpos($image_tag, "."), strlen($image_tag) - strrpos($image_tag, "."));

        switch ($extension) {

            case ".gif":

                $filedata['type'] = "image/gif";

                break;

            case ".gz":

                $filedata['type'] = "application/x-gzip";

                break;

            case ".htm":

                $filedata['type'] = "text/html";

                break;

            case ".html":

                $filedata['type'] = "text/html";

                break;

            case ".jpg":

                $filedata['type'] = "image/jpeg";

                break;

            case ".tar":

                $filedata['type'] = "application/x-tar";

                break;

            case ".txt":

                $filedata['type'] = "text/plain";

                break;

            case ".zip":

                $filedata['type'] = "application/zip";

                break;

            default:

                $filedata['type'] = "application/octet-stream";

                break;

        }


        return $filedata;

    }

}