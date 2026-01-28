    $(document).ready(function() {
        loadProducts();
        
        // Поиск при нажатии Enter
        $('#searchInput').keypress(function(e) {
            if (e.which === 13) {
                loadProducts();
            }
        });
        
        // Поиск при нажатии кнопки
        $('#searchButton').click(function() {
            loadProducts();
        });
        
        // Обработка отправки формы
        $('#productForm').submit(function(e) {
            e.preventDefault();
            saveProduct();
        });
    });
    
    function loadProducts(page = 1) {
        const search = $('#searchInput').val();
        
        $.ajax({
            url: '/products',
            type: 'GET',
            data: {
                search: search,
                page: page
            },
            success: function(response) {
                $('#productsTable').html(response.html);
                $('#paginationContainer').html(response.pagination);
               
                // Обновляем общее количество товаров
                if (response.total !== undefined) { 
                    updateProductsCount(response.total);
                }
                
                // Назначаем обработчики событий для пагинации
                $('.pagination .page-link').click(function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    if (page) {
                        loadProducts(page);
                    }
                });
            },
            error: function() {
                $('#productsTable').html('<div class="alert alert-danger">Ошибка загрузки данных</div>');
            }
        });
    }
    
    function openModal(productId = null) {
        $('#productForm')[0].reset();
        $('.invalid-feedback').empty();
        $('.form-control').removeClass('is-invalid');
        
        if (productId) {
            $('#modalTitle').text('Редактировать товар');
            $('#productId').val(productId);
            
            $.ajax({
                url: `/products/${productId}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const product = response.product;
                        $('#name').val(product.name);
                        $('#description').val(product.description);
                        $('#price').val(product.price);
                        $('#quantity').val(product.quantity);
                    }
                }
            });
        } else {
            $('#modalTitle').text('Добавить товар');
            $('#productId').val('');
        }
        
        new bootstrap.Modal(document.getElementById('productModal')).show();
    }
    
    function saveProduct() {
        const productId = $('#productId').val();
        const url = productId ? `/products/${productId}` : '/products';
        const method = productId ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: $('#productForm').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#productModal').modal('hide');
                    loadProducts();
                    
                    // Показываем уведомление
                    showAlert('success', response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').empty();
                    $('.form-control').removeClass('is-invalid');
                    
                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid');
                        $(`#${key}`).next('.invalid-feedback').text(value[0]);
                    });
                } else {
                    showAlert('danger', 'Произошла ошибка');
                }
            }
        });
    }
    
    function deleteProduct(productId) {
        if (confirm('Вы уверены, что хотите удалить этот товар?')) {
            $.ajax({
                url: `/products/${productId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        loadProducts();
                        showAlert('success', response.message);
                    }
                },
                error: function() {
                    showAlert('danger', 'Ошибка при удалении товара');
                }
            });
        }
    }
    
    function showAlert(type, message) {
        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(alert);
        
        setTimeout(() => {
            alert.alert('close');
        }, 3000);
    }
    
    function updateProductsCount(total) {
        let countText = '';
        if (total === 0) {
            countText = 'Товары не найдены';
        } else {
            const lastDigit = total % 10;
            const lastTwoDigits = total % 100;
            
            let word = 'товаров';
            if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
                word = 'товаров';
            } else if (lastDigit === 1) {
                word = 'товар';
            } else if (lastDigit >= 2 && lastDigit <= 4) {
                word = 'товара';
            }
            
            countText = `Найдено: ${total} ${word}`;
        }
        
        $('#totalCount').text(countText);
    }