<?php

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemException;
use think\Controller;

class Theme extends Controller
{
    /**
     * @url /theme?ids=id1,id2,id3
     * @return 一组 theme 模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);

        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);
        if ($result->isEmpty()) {
            throw new ThemException();
        }
        return $result;
    }

    /**
     * @url /theme/:id
     * @param $id
     * @return string
     */
    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if (!$theme) {
            throw new ThemException();
        }
        return $theme;
    }
}
