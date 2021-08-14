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
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/13
 * Time: 20:11
 */

namespace app\controller\index;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Category;
use app\model\admin\Article;

/**
 * 首页控制器
 * Class Index
 * @package app\controller\index
 */
class Column extends InitController
{
    /**
     * 跳板
     * @return string|\think\response\Redirect
     * @throws \think\db\exception\DbException
     * @author: MK
     * @Time: 2020/4/13 21:41
     */
    public function index()
    {
        // 获取参数,解密
        $id = base64_decode($this->request->get('ZcT'));

        // 恶意请求参数，跳转首页
        if (!$id) {
            return redirect('/');
        }

        // 跳转模板
        $column = Category::findCategory($id);

        switch ($column['column']) {
            case 1:
                return $this->columnOne($column->id);
                break;
            case 2:
                return $this->columnTwo();
                break;
            default:
                return redirect('/');
        }

    }

    /**
     * 模板一,瀑布流模板
     * @return string
     * @param int $id
     * @throws \think\db\exception\DbException
     * @author: MK
     * @Time: 2020/4/13 21:35
     */
    public function columnOne($id)
    {
        $article = Article::getArticle($id);
        View::assign('article', $article);
        // 分页
        View::assign('page', $article->render());
        return View::fetch('/index/column/column_one');
    }

    // 模板二，宫格流模板
    public function columnTwo()
    {

        return View::fetch('/index/column/column_two');
    }
}