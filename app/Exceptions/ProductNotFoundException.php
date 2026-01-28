<?php

/**
 * Исключение для случая, когда товар не найден
 * 
 * Используется для явной обработки ситуаций, когда запрашиваемый товар
 * не существует в базе данных.
 * 
 * @package App\Exceptions
 */
namespace App\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    /**
     * Конструктор исключения
     * 
     * @param int $id ID товара, который не был найден
     * @param int $code Код ошибки
     * @param \Throwable|null $previous Предыдущее исключение
     */
    public function __construct(int $id, int $code = 404, ?\Throwable $previous = null)
    {
        $message = "Товар с ID {$id} не найден";
        parent::__construct($message, $code, $previous);
    }
}
