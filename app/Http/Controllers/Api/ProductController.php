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
            "image" => ["required", "image"],
            "description" => ["required", "string"],
            "price" => ["required", "integer"]
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
            "description"=> $request->description,
            "price"=> $request->price
        ]);

        return ApiResponseClass::sendResponse($product, 'New product added successfully', 200);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $product = Products::findOrFail($id);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return ApiResponseClass::sendResponse([], "Product with id $id not found", 404);
            }
        }
        return ApiResponseClass::sendResponse($product, '', 200);
    }

    /**
     * Update the specified product in database.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified product from datbase.
     */
    public function destroy(string $id)
    {
        //
    }
}
