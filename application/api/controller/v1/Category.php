<?php

namespace app\api\controller\v1;

use app\lib\exception\CategoryException;
use think\Controller;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}
