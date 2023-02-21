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

    public  function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::find($id);
        $product->title = $request->title;
        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->file('file')->storeAs('uploads', $imageName, 'public');
            $data = [
                'name' => $request->name,
                'image' => $imageName,
            ];
            $product->update($data);

            return response()->json([
                'message' => 'New product updated'
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json(['message' => 'Product is  deleted']);
    }
}
