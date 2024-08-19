<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display all products (10 items per page)
     */
    public function index()
    {
        $products = Products::orderBy("id", "desc")->paginate(10);
        return ApiResponseClass::sendResponse($products, '', 200);
    }

    /**
     * Store a newly created product in database.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            "image" => ["required", "mimes:jpeg,jpg,png"],
            "description" => ["required", "string", "max:255"],
            "price" => ["required", "numeric"]
        ]);

        if ($request->file('image')) {
            $fileExtention = $request->file('image')->getClientOriginalExtension();
            do {
                $newFileName = sha1(time());
                $fileExist = Products::where('image', "$newFileName.$fileExtention")->get();
            }
            while (!$fileExist->isEmpty());
            $image = Storage::disk('public')->putFileAs("images", $request->file('image'), "$newFileName.$fileExtention");
        }

        $product = Products::create([
            "image" => Storage::url($image),
            "description" => $request->description,
            "price" => $request->price
        ]);

        return ApiResponseClass::sendResponse($product, 'New product added successfully', 201);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $product = Products::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return ApiResponseClass::sendError('Product not found', 404);
        }

        return ApiResponseClass::sendResponse($product, '', 200);
    }

    /**
     * Update the specified product in database.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "description" => ["string", "max:255"],
            "price" => ["numeric"]
        ]);

        try {
            $product = Products::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return ApiResponseClass::sendError('Product not found', 404);
        }

        $product->fill($validatedData);

        try {
            if ($product->isDirty()) {
                $product->save();
            }
        } catch (\Exception $e) {
            return ApiResponseClass::sendError('Error updating product', 500);
        }

        return ApiResponseClass::sendResponse($product, 'Product edited successfully', 200);
    }

    /**
     * Remove the specified product from datbase.
     */
    public function destroy(string $id)
    {
        try {
            $product = Products::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return ApiResponseClass::sendError('Product not found', 404);
        }

        $imagePath = explode("/", $product->image);
        $imageName = end($imagePath);

        Storage::disk("public")->delete("images/$imageName");

        $product->delete();

        return response()->noContent();
    }
}
