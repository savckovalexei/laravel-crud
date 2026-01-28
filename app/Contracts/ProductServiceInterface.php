<?php

/**
 * Интерфейс для сервиса работы с товарами
 * 
 * Определяет контракт для всех операций с товарами.
 * Позволяет легко заменять реализацию и создавать моки для тестирования.
 * 
 * @package App\Contracts
 */
namespace App\Contracts;

use App\Constants\PaginationConstants;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * Получить все товары с фильтрацией и пагинацией
     * 
     * @param array $filters Массив фильтров ['search' => строка поиска]
     * @param int $perPage Количество товаров на странице
     * @return LengthAwarePaginator Пагинированный список товаров
     */
    public function getAllProducts(array $filters = [], int $perPage = PaginationConstants::DEFAULT_PER_PAGE): LengthAwarePaginator;

    /**
     * Получить товар по ID
     * 
     * @param int $id ID товара
     * @return Product|null Объект товара или null если не найден
     */
    public function getProductById(int $id): ?Product;

    /**
     * Создать новый товар
     * 
     * @param array $data Валидированные данные товара
     * @return Product Созданный товар
     * 
     * @throws \Exception Если произошла ошибка при создании
     */
    public function createProduct(array $data): Product;

    /**
     * Обновить существующий товар
     * 
     * @param int $id ID товара для обновления
     * @param array $data Данные для обновления
     * @return bool True если обновление успешно
     * 
     * @throws ProductNotFoundException Если товар не найден
     * @throws \Exception Если произошла ошибка при обновлении
     */
    public function updateProduct(int $id, array $data): bool;

    /**
     * Удалить товар
     * 
     * @param int $id ID товара для удаления
     * @return bool True если удаление успешно
     * 
     * @throws ProductNotFoundException Если товар не найден
     * @throws \Exception Если произошла ошибка при удалении
     */
    public function deleteProduct(int $id): bool;
}
