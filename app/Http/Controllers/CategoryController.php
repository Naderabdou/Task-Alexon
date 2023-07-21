<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\CategoryTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use CategoryTrait;

    public function index()
    {
        $categories= Category::all();
        return view('dashboard.category.index',compact('categories'));
    }


    public function store(StoreCategoryRequest $request)

    {
        $data=$request->validated();
        $category = new Category();
        $this->extracted($data, $category, $request);
        return redirect()->route('category.index')->with('success', 'تم اضافة القسم بنجاح');
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findorFail($id);
        $data = $request->validated();
        $this->extracted($data, $category, $request);
        return redirect()->route('category.index')->with('success', 'تم تعديل القسم بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::findorFail($id);
        $this->deleteImage($category->image);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'تم حذف القسم بنجاح');
    }

}
