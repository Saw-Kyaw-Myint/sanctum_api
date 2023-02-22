<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    //store
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);


        $product = new Product();
        if ($request->file('image')) {
            $file_name = time() . '_image.' . $request->file('image')->extension();
            $imageName = $request->file('image')->storeAs('uploads', $file_name, 'public');
            $data = [
                'name' => $request->name,
                'image' => $imageName,
            ];
            info($data);
            $product->create($data);

            return response()->json([
                'message' => 'New product created'
            ]);
        }
    }

    // edit
    public function edit($id)
    {
        $product = Product::find($id);
        
        return response()->json($product);
    }

    //update
    public  function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png|nullable'
        ]);
    

        $product = Product::find($id);
        if ($request->image!=null) {
            $file_name = time() . '_update.' . $request->file('image')->extension();
            $imageName = $request->file('image')->storeAs('uploads', $file_name, 'public');
        }else{
            $imageName=$product->image;
        }

        $data = [
            'name' => $request->name,
            'image' => $imageName,
        ];
        info($data);
        $product->update($data);

        return response()->json([
            'message' => 'New product updated'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json(['message' => 'Product is  deleted']);
    }
}
