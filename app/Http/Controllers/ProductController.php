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

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')){
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }

        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');

        $sortableColumns = ['id', 'name', 'price', 'stock'];

        if (!in_array($sort, $sortableColumns)) {
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }


        $products = $query
         ->orderBy($sort, $direction)
         ->paginate(10)
         ->withQueryString();  
         
        $companies = Company::pluck('company_name', 'id');

        if ($request->ajax()) {
          return response()->json([
            'products' => $products,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        }
        
        return view('products.index', compact('products', 'companies','sort', 'direction'));
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


    public function show(int $id)
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

            if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '商品を削除しました'
            ]);
            }

            return redirect()
                ->route('products.index')
                ->with('success', '商品を削除しました');
     
        } catch (\Exception $e) {
            if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => '削除に失敗しました'
            ], 500);
        }

            return back()
                ->with('error', '商品削除に失敗しました');
    
        }
    }
}

