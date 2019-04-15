<?php

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
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
        if(!$result) {
            throw new ThemException();
        }
        return $result;
    }

    public function getComplexOne($id)
    {
        return 'success';
    }
}
