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

use App\Constants\HttpStatusCodes;
use App\Constants\ProductMessages;
use App\Contracts\ProductServiceInterface;
use App\Exceptions\ProductNotFoundException;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\HandlesJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use HandlesJsonResponse;
    
    /**
     * Сервис для работы с товарами
     * 
     * @var ProductServiceInterface
     */

    protected $productService;

    /**
     * Конструктор контроллера
     * 
     * Внедрение зависимости ProductServiceInterface через DI контейнер Laravel.
     * Использование интерфейса позволяет легко заменять реализацию и создавать моки для тестов.
     * 
     * @param ProductServiceInterface $productService Сервис для бизнес-логики товаров
     */
    public function __construct(ProductServiceInterface $productService)
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
        // Возвращаем JSON ответ с HTML представлениями и общим количеством
        return $this->dataResponse([
            'html' => view('products.partials.table', compact('products'))->render(),
            'pagination' => view('products.partials.pagination', compact('products'))->render(),
            'total' => $products->total()
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
            // Возвращаем успешный ответ с отформатированными данными
            return $this->successResponse('Товар успешно создан', [
                'product' => new ProductResource($product)
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при создании товара', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse('Ошибка при создании товара');
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
        try {
            // Получаем товар через сервис
            $product = $this->productService->getProductById($id);

            // Проверяем найден ли товар
            if (!$product) {
                return $this->notFoundResponse(ProductMessages::NOT_FOUND);
            }
            // Возвращаем данные товара в отформатированном виде
            return $this->dataResponse(['product' => new ProductResource($product)]);
        } catch (ProductNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        }
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
            $this->productService->updateProduct($id, $data);
            // Возвращаем успешный ответ
            return $this->successResponse(ProductMessages::UPDATED_SUCCESS);
        } catch (ProductNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        } catch (\Exception $e) {
            Log::error(ProductMessages::LOG_UPDATE_ERROR, [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse(ProductMessages::UPDATE_ERROR);
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
            $this->productService->deleteProduct($id);
            // Возвращаем успешный ответ
            return $this->successResponse(ProductMessages::DELETED_SUCCESS);
        } catch (ProductNotFoundException $e) {
            return $this->notFoundResponse($e->getMessage());
        } catch (\Exception $e) {
            Log::error(ProductMessages::LOG_DELETE_ERROR, [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse(ProductMessages::DELETE_ERROR);
        }
    }
}