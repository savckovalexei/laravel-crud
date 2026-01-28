<?php

/**
 * Resource для форматирования данных продукта
 * 
 * Используется для единообразного форматирования данных продукта
 * в JSON ответах API. Позволяет контролировать, какие поля
 * возвращаются и в каком формате.
 * 
 * @package App\Http\Resources
 */
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив для JSON ответа
     * 
     * Определяет структуру данных продукта, которая будет возвращена клиенту.
     * Можно добавить вычисляемые поля, форматирование и т.д.
     * 
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'quantity' => (int) $this->quantity,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
