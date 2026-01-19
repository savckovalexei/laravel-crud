<!--Главная страница (главный шаблон приложения)-->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Генерируемый CSRF-токен -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Управление товарами</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/libs/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Стили для иконок -->
    <link rel="stylesheet" href="{{ asset('css/libs/all.min.css') }}">
    <!-- Стили для страницы -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <!-- Контент страницы -->
        @yield('content')
    </div>
    <!-- Модальные окна -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Добавить товар</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="productForm">
                    <div class="modal-body">
                        <input type="hidden" id="productId" name="id">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Название товара *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Цена *</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Количество *</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Подключение Bootstrap JS Bundle с Popper -->
    <script src="{{ asset('js/libs/bootstrap.bundle.min.js') }}"></script>
    <!-- Подключение jQuery -->
    <script src="{{ asset('js/libs/jquery-3.6.0.min.js') }}"></script>
    <!--- Подключение пользовательских JavaScript файлов/или сценарий из шаблонов -->
    @yield('scripts')
</body>
</html>