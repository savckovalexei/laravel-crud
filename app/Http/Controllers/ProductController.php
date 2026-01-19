<?php

/**
 * Контроллер для управления товарами
 * 
 * Обрабатывает CRUD операции для товаров через AJAX запросы.
 * Все методы возвращают JsonResponse для интеграции с фронтендом.
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    /**
     * Сервис для работы с товарами
     * 
     * @var ProductService
     */

    protected $productService;

    /**
     * Конструктор контроллера
     * 
     * Внедрение зависимости ProductService через DI контейнер Laravel.
     * 
     * @param ProductService $productService Сервис для бизнес-логики товаров
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * Получить список товаров с пагинацией и поиском
     * 
     * Метод обрабатывает AJAX запросы для отображения таблицы товаров.
     * Поддерживает поиск по названию и пагинацию.
     * 
     * @param Request $request HTTP запрос с параметрами фильтрации
     * @return JsonResponse JSON ответ с HTML таблицы и пагинации
     * 
     * @throws \Exception При ошибках в сервисе
     */
    public function index(Request $request): JsonResponse
    {
       
       // Подготавливаем фильтры из запроса
        $filters = [
            'search' => $request->input('search')
        ];
        
        // Получаем товары через сервис с применением фильтров
        $products = $this->productService->getAllProducts($filters);
        // Возвращаем JSON ответ с HTML представлениями
        return response()->json([
            'html' => view('products.partials.table', compact('products'))->render(),
            'pagination' => view('products.partials.pagination', compact('products'))->render()
        ]);
    }

    /**
     * Создать новый товар
     * 
     * Метод обрабатывает AJAX POST запрос для создания товара.
     * Валидация выполняется через ProductRequest.
     * 
     * @param ProductRequest $request Валидированный запрос с данными товара
     * @return JsonResponse JSON ответ с результатом операции
     * 
     * @throws \Exception При ошибках создания товара
     */

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            
            // Получаем валидированные данные из запроса
            $validatedData = $request->validated();
            // Создаем товар через сервис
            $product = $this->productService->createProduct($validatedData);
            // Возвращаем успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Товар успешно создан',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании товара'
            ], 500);
        }
    }

    /**
     * Получить информацию о конкретном товаре
     * 
     * Используется для заполнения формы редактирования.
     * 
     * @param int $id ID товара
     * @return JsonResponse JSON ответ с данными товара
     */
    public function show(int $id): JsonResponse
    {
        // Получаем товар через сервис
        $product = $this->productService->getProductById($id);

        // Проверяем найден ли товар
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Товар не найден'
            ], 404);
        }
        // Возвращаем данные товара
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Обновить существующий товар
     * 
     * Метод обрабатывает AJAX PUT запрос для обновления товара.
     * Поддерживает обновление изображений и их удаление.
     * 
     * @param ProductRequest $request Валидированный запрос с данными для обновления
     * @param int $id ID товара для обновления
     * @return JsonResponse JSON ответ с результатом операции
     */
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            // Получаем валидированные данные
            $data = $request->validated();
            // Обновляем товар через сервис
            $updated = $this->productService->updateProduct($id, $data);
            // Проверяем успешность обновления
            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Товар не найден'
                ], 404);
            }
            // Возвращаем успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Товар успешно обновлен'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении товара'
            ], 500);
        }
    }

    /**
     * Удалить товар
     * 
     * Метод обрабатывает AJAX DELETE запрос для удаления товара.
     * Удаляет товар и все связанные с ним изображения.
     * 
     * @param int $id ID товара для удаления
     * @return JsonResponse JSON ответ с результатом операции
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            // Удаляем товар через сервис
            $deleted = $this->productService->deleteProduct($id);
            // Проверяем успешность удаления
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Товар не найден'
                ], 404);
            }
            // Возвращаем успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Товар успешно удален'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении товара'
            ], 500);
        }
    }
}