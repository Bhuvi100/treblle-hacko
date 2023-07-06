<?php

namespace App\Http\Controllers\v1\Admin;

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

    public function store(ProductRequest $request)
    {
        $this->authorize('create',Product::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = \Str::replace('public/', '', $request->file('image')->store('public/images/products'));
        }

        return new ProductResource(Product::create($validated));
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return new ProductResource($product);
    }

    public function update(ProductRequest $request,Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                if (\Storage::exists('public/' . $product->image)) {
                    \Storage::delete('public/' . $product->image);
                }
            }

            $validated['image'] = \Str::replace('public/', '', $request->file('image')->store('public/images/products'));
        }

        $product->update($validated);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json();
    }
}
