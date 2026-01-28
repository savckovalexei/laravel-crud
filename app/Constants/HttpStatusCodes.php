<?php

/**
 * Константы HTTP статус кодов
 * 
 * Содержит константы для HTTP статус кодов.
 * Используется для улучшения читаемости кода и избежания магических чисел.
 * 
 * @package App\Constants
 */
namespace App\Constants;

class HttpStatusCodes
{
    // Успешные ответы
    public const OK = 200;
    public const CREATED = 201;
    public const NO_CONTENT = 204;

    // Ошибки клиента
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const UNPROCESSABLE_ENTITY = 422;

    // Ошибки сервера
    public const INTERNAL_SERVER_ERROR = 500;
    public const SERVICE_UNAVAILABLE = 503;
}
