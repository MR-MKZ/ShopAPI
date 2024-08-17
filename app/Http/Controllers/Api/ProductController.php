<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products (10 items per page)
     */
    public function index()
    {
        $products = Products::orderBy("id","desc")->paginate(10);
        return response()->json($products, 200);
    }

    /**
     * Store a newly created product in database.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        //
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
