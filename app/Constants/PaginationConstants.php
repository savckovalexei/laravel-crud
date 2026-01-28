<?php

/**
 * Константы для пагинации
 * 
 * Содержит константы, связанные с пагинацией данных.
 * Используется для устранения магических чисел в коде.
 * 
 * @package App\Constants
 */
namespace App\Constants;

class PaginationConstants
{
    /**
     * Количество элементов на странице по умолчанию
     */
    public const DEFAULT_PER_PAGE = 10;

    /**
     * Минимальное количество элементов на странице
     */
    public const MIN_PER_PAGE = 1;

    /**
     * Максимальное количество элементов на странице
     */
    public const MAX_PER_PAGE = 100;
}
