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

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require|min:2|max:8|unique:user|chsDash',
        'password' => ['require', 'regex' => '/^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)(?!([^(0-9a-zA-Z)]|[\(\)])+$)([^(0-9a-zA-Z)]|[\(\)]|[a-z]|[A-Z]|[0-9]){6,}$/
'],
        'email' => 'require|email|unique:user',
        'mobile' => 'mobile|unique:user',
        'captcha' => 'captcha',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名不能为空',
        'username.unique' => '用户名已存在',
        'username.chsDash' => '用户名只能是汉字、字母、数字和下划线_及破折号-',
        'username.min' => '用户名不能小于2个字符',
        'username.max' => '用户名不能大于8个字符',
        'password.require' => '密码不能为空',
        'password.regex' => '密码必须包含大小写字母/数字/符号任意两者组合',
        'email.email' => '电子邮箱格式不正确',
        'email.require' => '电子邮箱不能为空',
        'email.unique' => '邮箱已存在',
        'mobile.mobile' => '手机号格式不正确',
        'mobile.unique' => '手机号已存在',
        'captcha.captcha' => '刷新验证码，重新输入！',
    ];
}
