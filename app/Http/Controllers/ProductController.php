<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company; 

class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Product::with('company')
         ->search($request->keyword)
         ->filterByCompany($request->company_id);

        $products = $query
         ->orderBy('id', 'desc')
         ->paginate(10)
         ->withQueryString();  
         
        $companies = Company::pluck('company_name', 'id');

        return view('products.index', compact('products', 'companies'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048'
        ]);

        $data = [
            'product_name' => $request->name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
        ];



        if ($request->hasFile('img_path')) {
           $data['img_path'] = $request->file('img_path')->store('products', 'public');
           }

        Product::create($data);

        return redirect()->route('products.index')->with('success', '商品を追加しました');
    }

   
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

   
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all(); 

        return view('products.edit', compact('product','companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048'
        ]);

        $data = [
            'product_name' => $request->name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
    ];

        if ($request->hasFile('img_path')) {
            $data['img_path'] = $request->file('img_path')->store('products', 'public');
           }
           

        $product->update($data);

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}

