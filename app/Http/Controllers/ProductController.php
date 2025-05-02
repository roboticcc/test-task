<?php
namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): AnonymousResourceCollection
    {
        $filters = request()->input('properties', []);
        $products = $this->productService->getFilteredProducts($filters);
        return ProductResource::collection($products);
    }
}