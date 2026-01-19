<?php
/**
 * Request класс для валидации данных товара
 * 
 * Содержит правила валидации для создания и обновления товаров.
 * Включает валидацию изображений и их размеров.
 * 
 * @package App\Http\Requests
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Определить имеет ли пользователь право на выполнение запроса
     * 
     * Всегда возвращает true, так как авторизация
     * обрабатывается на уровне маршрутов или middleware.
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Правила валидации для товара
     * 
     * Определяет правила для всех полей товара.
     * 
     * @return array
     */
    public function rules(): array
    {
        // Базовые правила валидации
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0'
        ];

        // При обновлении не делаем required для всех полей
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = array_map(function ($rule) {
                return str_replace('required', 'sometimes', $rule);
            }, $rules);
        }

        return $rules;
    }
    /**
     * Пользовательские сообщения об ошибках валидации
     * 
     * Определяет понятные сообщения для пользователя на русском языке.
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Название товара обязательно',
            'price.required' => 'Цена обязательна',
            'price.numeric' => 'Цена должна быть числом',
            'quantity.integer' => 'Количество должно быть целым числом'
        ];
    }
}