<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Products::all();   
        
        return view('layouts.dashboard', compact('products'));
    }

    public function show($params) 
    {
        $productDetail = Products::find($params);

        if(!$productDetail) {
           return response()->json(['error' => 'Product not found'], 404);
        }
        
        return response()->json($productDetail);
    }

    public function getProducts() 
    {
        $products = Products::all();

        return response()->json($products);
    }
 
  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'picture' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'required|string',
            'stocks' => 'required|string',
        ]);

            if ($request->hasFile('picture')) {

                $destination_path = 'public/images';

                $image = $request->file('picture');

                $image_name = $image->getClientOriginalName();
                
                $path = $request->file('picture')->storeAs($destination_path, $image_name);

                $validated['picture'] = $image_name;

                Products::create([
                    'product_name' => $validated['product_name'],
                    'description' =>  $validated['description'],
                    'price' =>  $validated['price'],
                    'category' =>  $validated['category'],
                    'picture' => $validated['picture'],
                    'status' =>  $validated['status'],
                    'stocks' =>  $validated['stocks'],
                ]);
            }

            $products = Products::all();   
        
        return response()->json($products);
    }

    public function updateForm(Products $id, Request $request) 
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'picture' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'required|string',
            'stocks' => 'required|string',
        ]);

        if ($request->hasFile('picture')) {

            $destination_path = 'public/images';

            $image = $request->file('picture');

            $image_name = $image->getClientOriginalName();

            $path = $request->file('picture')->storeAs($destination_path, $image_name);

            $validated['picture'] = $image_name;
            
            $id->update([ 
                'product_name' => $validated['product_name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'category' => $validated['category'],
                'picture' => $validated['picture'],
                'status' => $validated['status'],
                'stocks' => $validated['stocks'],
            ]);
            
        } else {
            $id->update([ 
                'product_name' => $validated['product_name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'category' => $validated['category'],
                'status' => $validated['status'],
                'stocks' => $validated['stocks'],
            ]);
        }
        $products = Products::all();   

        return response()->json($products);
    }

    public function destroy(Request $request) 
    {

        $deletedProduct  = Products::where('id', $request->id)->delete();

        if(!$deletedProduct) {
            return response()->json(['error' => 'product id was not found']);
        }

        $products = Products::all();

        return response()->json($products);
    }

    public function filtered(Request $request)
    {
        $selectedCategories = $request->input('categories', []); 
        $sortPrice = $request->input('sort-price');
    
        $isFeatured = $request->input('isFeatured');

        //$isOnSale = $request->input('isOnSale');    
    
        $query = Products::query();
    
        if (!empty($selectedCategories)) {
            $query->whereIn('category', $selectedCategories);
        }
    
        if ($isFeatured) {
            $query->where('status', $isFeatured);
        }
    
        if ($sortPrice === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sortPrice === 'desc') {
            $query->orderBy('price', 'desc');
        }
    
        $filteredProducts = $query->get();

        return response()->json($filteredProducts);
    }
}
