<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    
    public function store(Request $request) 
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

         try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);


            if ($product->stock <= 0) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => '在庫切れです。'
                ], 400);
            }
    
            Sale::create([
                'product_id' => $product->id
            ]);
    
            $product->decrement('stock');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '購入ありがとうございます！',
                'product_id' => $product->id,
                'stock' => $product->stock,
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => '購入処理に失敗しました。'
            ], 500);
        }
    }
}