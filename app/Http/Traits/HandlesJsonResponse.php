<?php

/**
 * Trait для унификации JSON ответов в контроллерах
 * 
 * Предоставляет методы для создания стандартизированных JSON ответов,
 * что устраняет дублирование кода и обеспечивает единообразие API.
 * 
 * @package App\Http\Traits
 */
namespace App\Http\Traits;

use App\Constants\HttpStatusCodes;
use Illuminate\Http\JsonResponse;

trait HandlesJsonResponse
{
    /**
     * Создать успешный JSON ответ
     * 
     * @param string $message Сообщение об успехе
     * @param mixed $data Дополнительные данные для ответа
     * @param int $statusCode HTTP статус код
     * @return JsonResponse
     */
    protected function successResponse(string $message, $data = null, int $statusCode = HttpStatusCodes::OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Создать JSON ответ с ошибкой
     * 
     * @param string $message Сообщение об ошибке
     * @param int $statusCode HTTP статус код
     * @param array $errors Дополнительные ошибки валидации
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = HttpStatusCodes::INTERNAL_SERVER_ERROR, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Создать JSON ответ "не найдено"
     * 
     * @param string $message Сообщение
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Ресурс не найден'): JsonResponse
    {
        return $this->errorResponse($message, HttpStatusCodes::NOT_FOUND);
    }

    /**
     * Создать JSON ответ с данными (для успешных операций с данными)
     * 
     * @param mixed $data Данные для ответа
     * @param string|null $message Опциональное сообщение
     * @return JsonResponse
     */
    protected function dataResponse($data, ?string $message = null): JsonResponse
    {
        $response = [
            'success' => true,
        ];

        if ($message !== null) {
            $response['message'] = $message;
        }

        // Если данные - массив, добавляем их напрямую, иначе в ключ 'data'
        if (is_array($data)) {
            $response = array_merge($response, $data);
        } else {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
}
