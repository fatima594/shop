<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }




    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:8',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'يجب عليك إدخال الحقل.',
            'image.required' => 'يجب عليك إدخال الصورة.',
        ]);

        // إذا تم تحميل الصورة، قم بتخزينها
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/category');
        }

        // قم بإنشاء الفئة مع الصورة
        Category::create([
            'name' => $validatedData['name'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // تحديث الاسم
        $category->update([
            'name' => $request->name,
        ]);

        // التحقق مما إذا كان هناك ملف صورة جديد
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('image')->store('public/category');

            // تحديث مسار الصورة في قاعدة البيانات
            $category->update([
                'image' => $imagePath,
            ]);
        }

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        // حذف السجلات المرتبطة من جدول products
        $category->products()->delete(); // أو بدلاً من ذلك يمكن تحديثهم إذا كنت لا تريد حذفهم

        if ($category->image) {
            Storage::disk('public')->delete(str_replace('public/', '', $category->image));
        }

        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }

}
