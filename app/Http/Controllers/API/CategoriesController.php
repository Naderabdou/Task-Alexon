<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $categories = Category::selection()->get();
        if ($categories->count() == 0) {
            return $this->returnError('E001', 'لا يوجد بيانات');
        }
        return $this -> returnData('categories', $categories, 'تم استرجاع البيانات بنجاح');
    }
}
