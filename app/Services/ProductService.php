<?php
namespace App\Services;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getAllProducts(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->getProductById($id);
        
        if (!$product) {
            return false;
        }

        return $product->update($data);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->getProductById($id);
        
        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}