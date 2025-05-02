<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getFilteredProducts(array $filters = []): LengthAwarePaginator
    {
        return Product::with('properties')
            ->filterByProperties($filters)
            ->paginate(40);
    }
}