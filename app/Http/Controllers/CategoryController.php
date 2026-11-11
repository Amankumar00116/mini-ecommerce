<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function show(Category $category)
    {
        $products = $category->products;
        
        $title = $category->category_name;

        return view('category-products', compact('category', 'products', 'title'));
    }

    public function group($type)
{
    if ($type === 'men') {

        $categoryIds = [6, 7, 16, 12, 13, 18,];

        $title = 'Men';

    } elseif ($type === 'women') {

        $categoryIds = [8, 9, 10, 17, 21];

        $title = 'Women';

    } elseif ($type === 'kids') {

        $categoryIds = [15];

        $title = 'Kids';

   }else {

        abort(404);
    }

    $products = Product::whereIn('category_id', $categoryIds)->get();

    return view('category-products', compact('products', 'title'));
}
}
