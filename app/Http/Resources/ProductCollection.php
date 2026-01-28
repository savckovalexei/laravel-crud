<?php

/**
 * Collection для форматирования коллекции продуктов
 * 
 * Используется для форматирования списка продуктов.
 * Наследуется от ResourceCollection и автоматически
 * применяет ProductResource к каждому элементу коллекции.
 * 
 * @package App\Http\Resources
 */
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Преобразовать коллекцию ресурсов в массив
     * 
     * Автоматически применяет ProductResource к каждому продукту
     * в коллекции и возвращает структурированный массив.
     * 
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
