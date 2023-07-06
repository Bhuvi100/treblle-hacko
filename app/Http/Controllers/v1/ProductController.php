<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny',Product::class);

        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        $this->authorize('view',$product);

        return new ProductResource($product);
    }
}
