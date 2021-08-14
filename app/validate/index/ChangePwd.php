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
declare (strict_types=1);

namespace app\validate\index;

use think\Validate;

class ChangePwd extends Validate
 {
protected $rule = [
         'oldpassword' => 'require',
         'newpassword' => ['require', 'min' => 6, 'max' => 12, 'regex' => '/^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)(?!([^(0-9a-zA-Z)]|[\(\)])+$)([^(0-9a-zA-Z)]|[\(\)]|[a-z]|[A-Z]|[0-9]){6,}$/
'],
         'renewpassword' => 'require|confirm:newpassword',
    ];

    protected $message = [
        'oldpassword.require' => '旧密码不能为空',
        'newpassword.require' => '新密码不能为空',
        'renewpassword.require' => '确认密码不能为空',
        'newpassword.min' => '密码不能小于6个字符',
        'newpassword.max' => '密码最多不能超过12个字符',
        'newpassword.regex' => '密码必须包含大小写字母/数字/符号任意两者组合',
        'renewpassword.confirm' => '两次密码不一致！',
    ];

//'require|max:16|min:6'
}