<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     public function index()
    {
        $categories = Category::all();

        return view('welcome', compact('categories'));
    }


    public function create(){
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }


    public function products(){

    $categories = Category::all();

    $categoryId = request('category_id');


    if ($categoryId) {

    $products = Product::where('category_id', $categoryId)->get();

} else {

    $products = Product::all();

}
return view('products.index', compact(
    'products',
    'categories',
    'categoryId',
));
    }


    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'product_name' => 'required',
        'price' => 'required',
        'quantity' => 'required',
        'size' => 'required',
        'image' => 'nullable|image'
    ]);

    $imagePath = null;

if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('products', 'public');
}


    Product::create([
        'category_id' => $request->category_id,
        'product_name' => $request->product_name,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'size' => $request->size,
        'image' => $imagePath,
    ]);

    return redirect('/products/create')->with('success', 'Product added successfully');

}

// Search Bar...
public function search(Request $request)
{
    $query = trim($request->input('query', ''));

    $products = Product::with('category')
        ->where('product_name', 'LIKE', "%{$query}%")
        ->orWhereHas('category', function ($categoryQuery) use ($query) {
            $categoryQuery->where(
                'category_name',
                'LIKE',
                "%{$query}%"
            );

            if (
                stripos('Casual Shirt', $query) !== false ||
                stripos($query, 'Casual Shirt') !== false
            ) {
                $categoryQuery->orWhere('id', 6);
            }
        })
        ->get();

    $title = 'Search Results';

    return view('category-products', compact('products', 'title'));
}

// Search Bar- Suggestions...

public function suggestions(Request $request)
{
    $query = trim($request->input('query', ''));

    if (strlen($query) < 2) {
        return response()->json([]);
    }

    $products = Product::where('product_name', 'LIKE', "%{$query}%")
        ->select('product_name')
        ->distinct()
        ->limit(5)
        ->pluck('product_name');

    $categories = \App\Models\Category::where(
        'category_name',
        'LIKE',
        "%{$query}%"
    )
        ->limit(5)
        ->pluck('category_name');

    return response()->json([
        'products' => $products,
        'categories' => $categories,
    ]);
}


// admin product table (EDIT).=======
public function edit($id){
    $product = Product::findOrFail($id);

    $categories = Category::all();

    return view('products.edit', compact('product', 'categories'));
}

// admin product table (UPDATE).=======
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->update([
        'product_name' => $request->product_name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'size' => $request->size,
    ]);

    return redirect('/products');
}

// admin product table (DELETE).=======
public function destroy($id)
{
    $product = Product::findOrFail($id);

    $product->delete();

    return redirect('/products');
}
}
