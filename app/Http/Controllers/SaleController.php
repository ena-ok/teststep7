<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //
    public function store($id) {
        $product = Product::find($id);
        if ($product->stock > 0) {
            $product->stock--;
            $product->save();
    
            Sale::create([
                'product_id' => $product->id
            ]);
    
            return redirect('/')->with('success', '購入ありがとうございます！');
        }
    
        return redirect('/')->with('error', '在庫切れです。');
    }
    

}

