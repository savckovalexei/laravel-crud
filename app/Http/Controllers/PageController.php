<?php
/**
 * Контроллер для статических страниц
 * 
 * Обрабатывает запросы к статическим страницам приложения.
 * Не содержит бизнес-логики, только отображение представлений.
 * 
 * @package App\Http\Controllers
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Отобразить главную страницу приложения
     * 
     * Возвращает представление главной страницы с таблицей товаров.
     * Фронтенд загружает данные товаров через AJAX запросы.
     * 
     * @param Request $request HTTP запрос
     * @return \Illuminate\View\View Представление главной страницы
     */
    public function index()
    {
        return view('home');
    }
}
