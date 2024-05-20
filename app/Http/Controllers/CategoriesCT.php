<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;

class CategoriesCT extends Controller

{
    public function store( Request $request) {
        $validator = Validator::make( $request->all(), [
           'name' => 'required|max:255'
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(442);
        }

        $validated = $validator->validated();

        Categories::create( $validated );

        return response()->json("Data berhasil disimpan", 200);
    }
    public function show () {
        $products = Categories::all();

        return response()->json([
            'message' => 'Data Produk',
            'data' => $products
        ], 200);
    }
    public function update( Request $request, $id){
        $validator = Validator::make( $request->all(), [
            'name' => 'sometimes|max:255'
         ]);
         
         if ( $validator->fails() ) {
             return response()->json( $validator->messages() )->setStatusCode(442);
        }

        $validated = $validator->validated();
        $product = Categories::find( $id );

        if ( $product ) {
            Categories::where( 'id', $id )->update($validated);

            return response()->json("Data dengan id: {$id} berhasil di update", 200);
        }
    }
    public function delete($id) {
        $product = Categories::where('id', $id)->get();

        if($product) {
           Categories::where('id', $id)->delete();

           return response()->json("Data dengan id: {$id} berhasil dihapus", 200);
        }
    }
}