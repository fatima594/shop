<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }






    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        // معالجة تحميل الصورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products');
        } else {
            return back()->withInput()->with('error', __('Image is required.'));
        }

        // إنشاء منتج جديد
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->image = $imagePath;
        $product->price = $validatedData['price'];
        $product->weight = $validatedData['weight'];
        $product->quantity = $validatedData['quantity'];
        $product->category_id = $validatedData['category_id'];
        $product->save();

        return redirect()->route('admin.products.index')->with('status', __('Product :name added successfully', ['name' => $validatedData['name']]));
    }

    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9 .-]*$/u',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'sometimes|image',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->weight = $validatedData['weight'];
        $product->quantity = $validatedData['quantity'];
        $product->category_id = $validatedData['category_id'];

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('public/products');
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('status', __(':name product data has been updated', ['name' => $validatedData['name']]));
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete(str_replace('public/', '', $product->image));
        }

        $product->delete();

        return back()->with('status', __('Product deleted successfully'));
    }


}
