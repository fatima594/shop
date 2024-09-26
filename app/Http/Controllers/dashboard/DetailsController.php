<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function indexByCategory($categoryId)
    {
        // Fetch the specified category by ID
        $category = Category::findOrFail($categoryId);

        // Fetch the posts associated with the category
        // $blogs = Blog::where('category_id', $categoryId)->get(); // 10 posts per page
        $products = Product::where('category_id', $categoryId)->paginate(10);

        // Pass the category and blogs to the view
        return view('layouts.pages.products', compact('category', 'products'));
    }

    /**
     * Display a specific blog and its category.
     */
    public function show($slug)
    {
        // Fetch the product by slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Fetch related products based on the product's category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('slug', '!=', $slug) // Exclude the current product
            ->limit(3) // Limit the number of related products
            ->get();

        // Fetch all categories
        $categories = Category::all();

        // Display the product, related products, and categories in the view
        return view('layouts.pages.single-product', compact('product', 'relatedProducts', 'categories'));
    }

}
