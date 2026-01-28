<?php
/**
 * Сервис для работы с товарами
 * 
 * Содержит бизнес-логику операций с товарами: создание, чтение, обновление, удаление.
 * Отделяет логику приложения от контроллеров и моделей.
 * Реализует ProductServiceInterface для обеспечения контракта.
 * 
 * @package App\Services
 */
namespace App\Services;

use App\Constants\PaginationConstants;
use App\Contracts\ProductServiceInterface;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    /**
     * Получить все товары с фильтрацией и пагинацией
     * 
     * Возвращает пагинированный список товаров с возможностью поиска по названию.
     * 
     * @param array $filters Массив фильтров ['search' => строка поиска]
     * @param int $perPage Количество товаров на странице
     * @return LengthAwarePaginator Пагинированный список товаров
     */
    
    public function getAllProducts(array $filters = [], int $perPage = PaginationConstants::DEFAULT_PER_PAGE): LengthAwarePaginator
    {
        $query = Product::query();
        // Применяем фильтр поиска если указан
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        // Возвращаем пагинированный результат
        return $query->latest()->paginate($perPage);
    }
    /**
     * Получить товар по ID
     * 
     * Используется для операций с конкретным товаром.
     * 
     * @param int $id ID товара
     * @return Product|null Объект товара или null если не найден
     */
    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }
    /**
     * Создать новый товар
     * 
     * Возвращает созданный товар.
     * 
     * @param array $data Валидированные данные товара
     * @return Product Созданный товар
     * 
     * @throws \Exception Если произошла ошибка при создании
     */
    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Обновить существующий товар
     * 
     * Обновляет данные товара. Использует прямой запрос UPDATE для оптимизации (один запрос к БД).
     * 
     * @param int $id ID товара для обновления
     * @param array $data Данные для обновления
     * @return bool True если обновление успешно
     * 
     * @throws ProductNotFoundException Если товар не найден
     * @throws \Exception Если произошла ошибка при обновлении
     */
    public function updateProduct(int $id, array $data): bool
    {
        // Используем прямой запрос UPDATE (один запрос к БД вместо двух)
        // Возвращает количество обновленных строк (0 если товар не найден)
        $affected = Product::where('id', $id)->update($data);
        
        if ($affected === 0) {
            throw new ProductNotFoundException($id);
        }
        
        return true;
    }
    /**
     * Удалить товар
     * 
     * Удаляет товар. Использует прямой запрос DELETE для оптимизации (один запрос к БД).
     * 
     * @param int $id ID товара для удаления
     * @return bool True если удаление успешно
     * 
     * @throws ProductNotFoundException Если товар не найден
     * @throws \Exception Если произошла ошибка при удалении
     */
    public function deleteProduct(int $id): bool
    {
        // Используем прямой запрос DELETE (один запрос к БД вместо двух)
        // Возвращает количество удаленных строк (0 если товар не найден)
        $affected = Product::where('id', $id)->delete();
        
        if ($affected === 0) {
            throw new ProductNotFoundException($id);
        }
        
        return true;
    }
}