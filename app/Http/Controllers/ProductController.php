<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company; 
use App\Http\Requests\ProductRequest;


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

    
    public function store(ProductRequest $request)
    {

        $data = $request->validated();


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

   
    public function edit(Product $product)
    {
        $companies = Company::pluck('company_name', 'id');
        return view('products.edit', compact('product', 'companies'));
    }

    public function create()
    {
        $companies = Company::pluck('company_name', 'id');
        return view('products.create', compact('companies'));
    }

    
    public function update(ProductRequest $request, Product $product)
    {
        
      try {
        $data = $request->validated();

        if ($request->hasFile('img_path')) {
            $data['img_path'] = $request->file('img_path')->store('products', 'public');
           }
           

        $product->update($data);

        return redirect()
             ->route('products.index')
             ->with('success', '商品を更新しました');
      
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '商品更新に失敗しました');
        }
    
    
    
    }
    
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', '商品を削除しました');
     
        } catch (\Exception $e) {
            return back()
                ->with('error', '商品削除に失敗しました');
    
        }
    }
}

