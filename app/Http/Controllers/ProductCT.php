<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductCT extends Controller
{
    public function store( Request $request) {
        $validator = Validator::make( $request->all(), [
           'name' => 'required|max:255',
           'description' => 'required',
           'price' => 'required|numeric',
           'image' => 'required|max:255',
           'category_id' => 'required|numeric',
           'expired_at' => 'required|date',
           'modified_by' => 'required|max:255'
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(442);
        }

        $validated = $validator->validated();

        Product::create( $validated );

        return response()->json("Data produk berhasil disimpan", 200);
    }
    public function show () {
        $products = Product::all();

        return response()->json([
            'message' => 'Data Produk',
            'data' => $products
        ], 200);
    }
    public function update( Request $request, $id){
        $validator = Validator::make( $request->all(), [
            'name' => 'sometimes|max:255',
            'description' => 'sometimes',
            'price' => 'sometimes|numeric',
            'image' => 'sometimes|max:255',
            'category_id' => 'sometimes|numeric',
            'modified_by' => 'sometimes|max:255',
            'expired_at' => 'sometimes|date'
         ]);
         
         if ( $validator->fails() ) {
             return response()->json( $validator->messages() )->setStatusCode(442);
        }

        $validated = $validator->validated();
        $product = Product::find( $id );

        if ( $product ) {
            Product::where( 'id', $id )->update($validated);

            return response()->json("Data dengan id: {$id} berhasil di update", 200);
        }
    }
    public function delete($id) {
        $product = Product::where('id', $id)->get();

        if($product) {
           Product::where('id', $id)->delete();

           return response()->json("Data dengan id: {$id} berhasil dihapus", 200);
        }
    }
}