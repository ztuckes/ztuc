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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class SendMail
{
    public static function sendEmail($email,$list,$code,$subject)
    { 
        $toemail = $email;//定义收件人的邮箱
        $mail = new PHPMailer();
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = $list['host'];// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = $list['email'];// 发送方的163邮箱用户名

        $mail->Password = $list['password'];// 发送方的邮箱密码
        $mail->SMTPSecure = "ssl";// 使用ssl协议方式</span><span style="color:#333333;">
        $mail->Port = $list['port'];// 163邮箱的ssl协议方式端口号是465/994
        $mail->setFrom($list['email'],__('September Technology Limited'));// 设置发件人信息
        $mail->addAddress($toemail,'九月科技');// 设置收件人信息
        $mail->addReplyTo($list['email'],"Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址

        $mail->Subject = $subject;// 邮件标题
        $mail->Body = str_replace(array('%email', '%code'), array($email, $code), __('Mail sending'));// 邮件正文

        if(!$mail->send()){// 发送邮件
            return __('Send failed').$mail->ErrorInfo;// 输出错误信息
        }else{ 
            return __('Sent successfully');
        }
    }
}