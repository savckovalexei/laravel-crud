@extends('layouts.app')

@section('content')
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Управление товарами</h2>
            <button class="btn btn-primary" onclick="openModal()">
                <i class="fas fa-plus"></i> Добавить товар
            </button>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Поиск по названию...">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div id="productsCount" class="text-muted">
                    <i class="fas fa-box"></i> <span id="totalCount">Загрузка...</span>
                </div>
            </div>
        </div>
        
        <div id="productsTable">
            <!-- Таблица будет загружена через AJAX -->
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Загрузка...</span>
                </div>
            </div>
        </div>
        
        <div id="paginationContainer" class="mt-3">
            <!-- Пагинация будет загружена через AJAX -->
        </div>
    </div>
@endsection

@section('scripts')
<!-- Подключение JavaScript сценария -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection