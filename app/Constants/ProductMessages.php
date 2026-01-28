<?php

/**
 * Константы сообщений для операций с товарами
 * 
 * Содержит все текстовые сообщения, используемые при работе с товарами.
 * Централизованное хранение сообщений упрощает их изменение и локализацию.
 * 
 * @package App\Constants
 */
namespace App\Constants;

class ProductMessages
{
    // Сообщения об успешных операциях
    public const CREATED_SUCCESS = 'Товар успешно создан';
    public const UPDATED_SUCCESS = 'Товар успешно обновлен';
    public const DELETED_SUCCESS = 'Товар успешно удален';

    // Сообщения об ошибках
    public const CREATE_ERROR = 'Ошибка при создании товара';
    public const UPDATE_ERROR = 'Ошибка при обновлении товара';
    public const DELETE_ERROR = 'Ошибка при удалении товара';
    public const NOT_FOUND = 'Товар не найден';

    // Сообщения для логирования
    public const LOG_CREATE_ERROR = 'Ошибка при создании товара';
    public const LOG_UPDATE_ERROR = 'Ошибка при обновлении товара';
    public const LOG_DELETE_ERROR = 'Ошибка при удалении товара';
}
