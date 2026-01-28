<?php
/**
 * Request класс для валидации данных товара
 * 
 * Содержит правила валидации для создания и обновления товаров.
 * Использует разные правила для операций создания и обновления.
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
     * Использует разные правила для создания и обновления.
     * 
     * @return array
     */
    public function rules(): array
    {
        // Определяем правила в зависимости от HTTP метода
        if ($this->isMethod('post')) {
            // Правила для создания товара
            return $this->rulesForCreate();
        } else {
            // Правила для обновления товара
            return $this->rulesForUpdate();
        }
    }

    /**
     * Правила валидации для создания товара
     * 
     * Все поля обязательны при создании нового товара.
     * 
     * @return array
     */
    protected function rulesForCreate(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0'
        ];
    }

    /**
     * Правила валидации для обновления товара
     * 
     * Поля опциональны при обновлении (можно обновить только часть полей).
     * 
     * @return array
     */
    protected function rulesForUpdate(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|integer|min:0'
        ];
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
            // Название товара
            'name.required' => 'Название товара обязательно для заполнения',
            'name.string' => 'Название товара должно быть текстом',
            'name.max' => 'Название товара не должно превышать 255 символов',
            
            // Описание
            'description.string' => 'Описание должно быть текстом',
            
            // Цена
            'price.required' => 'Цена обязательна для заполнения',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена не может быть отрицательной',
            
            // Количество
            'quantity.required' => 'Количество обязательно для заполнения',
            'quantity.integer' => 'Количество должно быть целым числом',
            'quantity.min' => 'Количество не может быть отрицательным'
        ];
    }

    /**
     * Пользовательские имена атрибутов для сообщений об ошибках
     * 
     * Определяет понятные названия полей на русском языке.
     * 
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'название товара',
            'description' => 'описание',
            'price' => 'цена',
            'quantity' => 'количество'
        ];
    }
}