<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company; 

class ProductController extends Controller
{
   
    public function index(Request $request)
    {
    
        $keyword = $request->input('keyword');
        $company = $request->input('company');

      
        $query = Product::query();

       
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        
        if ($company) {
            $query->where('company_id', $company);
        }

        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $companies =  \App\Models\Company::pluck('name', 'id');

        return view('products.index', compact('products', 'companies'));
    }

    

    public function create()
    {
       $companies = Company::all();
       return view('products.create', compact('companies'));

    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', '商品を追加しました');
    }

   
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

   
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all(); 

        return view('products.edit', compact('product','companies'));
    }

    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}

