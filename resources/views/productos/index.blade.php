<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique & Moda — Catálogo Exclusivo de Ropa</title>
    <meta name="description" content="Catálogo exclusivo de ropa, vestidos, conjuntos y accesorios de moda con compra directa por WhatsApp.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

    <div class="trust-bar text-center d-none d-md-block">
        <div class="container d-flex justify-content-center align-items-center flex-wrap">
            <span class="trust-item"><i class="bi bi-stars text-warning"></i> Nueva Colección de Temporada</span>
            <span class="trust-item"><i class="bi bi-truck text-info"></i> Envíos a todo el país</span>
            <span class="trust-item"><i class="bi bi-whatsapp text-success"></i> Asesoría de Tallas y Pedidos 24/7</span>
            <span class="trust-item"><i class="bi bi-shield-check text-success"></i> Calidad Premium Garantizada</span>
        </div>
    </div>

    <nav class="glass-nav py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('productos.index') }}" class="navbar-brand-logo">
                <div class="brand-icon-box">
                    <i class="bi bi-bag-heart"></i>
                </div>
                <div>
                    <h2 class="brand-title">MODA & BOUTIQUE</h2>
                    <p class="brand-subtitle">Colección Oficial</p>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="cart-nav-btn js-open-cart" title="Ver carrito de compras">
                    <i class="bi bi-bag-heart-fill cart-nav-icon"></i>
                    <span class="d-none d-sm-inline">Mi Carrito</span>
                    <span class="cart-count-badge d-none">0</span>
                </button>

                @auth
                    <a href="{{ route('productos.create') }}" class="btn btn-gradient-primary btn-sm px-3">
                        <i class="bi bi-plus-lg"></i>
                        <span class="d-none d-sm-inline">Nueva Prenda</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-admin btn-sm" title="Cerrar sesión de administrador">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline">Salir</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('exito'))
        <div class="container mt-4 animate-fade-in">
            <div class="alert-modern-success">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>
                    <strong>¡Operación Exitosa!</strong>
                    <div>{{ session('exito') }}</div>
                </div>
            </div>
        </div>
    @endif

    <header class="hero-section">
        <div class="container">
            <div class="hero-pill-badge">
                <i class="bi bi-stars text-warning"></i>
                <span>TENDENCIAS & ALTA MODA {{ date('Y') }}</span>
            </div>
            <h1 class="hero-title">Estilo, Elegancia & Tendencia</h1>
            <p class="hero-description">
                Descubre nuestra selección exclusiva de prendas. Selecciona tu favorita y realiza tu pedido o consulta disponibilidad de tallas por WhatsApp.
            </p>
        </div>
    </header>

    <main class="container pb-5">

        <div class="filter-search-container">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="search-input-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text"
                               id="liveSearchInput"
                               class="search-input"
                               placeholder="Buscar prenda por nombre, color, estilo, tela..."
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-12 col-md-5 col-lg-4 d-flex justify-content-md-end align-items-center gap-2">
                    <select id="sortBySelect" class="filter-select w-100">
                        <option value="default">Ordenar por: Destacados</option>
                        <option value="price-asc">Precio: Menor a Mayor</option>
                        <option value="price-desc">Precio: Mayor a Menor</option>
                        <option value="name-asc">Nombre: A - Z</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-light-subtle small text-secondary">
                <span>Mostrando <strong id="productCounter" class="text-dark">{{ $productos->count() }}</strong> prendas disponibles</span>
                <span class="text-success fw-semibold"><i class="bi bi-check2-circle"></i> Disponibilidad en tienda</span>
            </div>
        </div>

        @if($productos->isEmpty())
            <div class="empty-catalog-state glass-panel">
                <div class="empty-icon-circle">
                    <i class="bi bi-bag"></i>
                </div>
                <h3 class="font-heading fs-4 mb-2">Aún no hay prendas en el catálogo</h3>
                <p class="text-secondary max-w-md mx-auto mb-4">
                    Estamos preparando las prendas de la nueva temporada. Vuelve pronto o agrega nuevos artículos si eres administrador.
                </p>
                @auth
                    <a href="{{ route('productos.create') }}" class="btn btn-gradient-primary">
                        <i class="bi bi-plus-circle"></i> Agregar la Primera Prenda
                    </a>
                @else
                    <a href="https://wa.me/51960325666?text={{ urlencode('Hola, me gustaría información sobre la nueva colección de ropa') }}" target="_blank" class="btn btn-whatsapp">
                        <i class="bi bi-whatsapp"></i> Consultar por WhatsApp
                    </a>
                @endauth
            </div>
        @else
            <div class="row g-4" id="productsGrid">
                @foreach($productos as $producto)
                    <div class="col-12 col-sm-6 col-lg-4 product-card-item"
                         data-name="{{ strtolower($producto->nombre) }}"
                         data-description="{{ strtolower($producto->descripcion ?? '') }}"
                         data-price="{{ (float) $producto->precio }}">
                        <div class="card-producto">

                            <div class="card-img-wrapper">
                                <div class="card-floating-badge">
                                    <span class="dot"></span>
                                    <span>Nueva Colección</span>
                                </div>

                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         class="card-producto-img"
                                         alt="{{ $producto->nombre }}"
                                         loading="lazy">
                                @else
                                    <div class="card-img-placeholder">
                                        <i class="bi bi-camera"></i>
                                        <span>Prenda de Temporada</span>
                                    </div>
                                @endif

                                <a href="{{ route('productos.show', $producto) }}"
                                   class="quick-view-btn"
                                   title="Ver detalles de la prenda">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title" title="{{ $producto->nombre }}">{{ $producto->nombre }}</h5>

                                <p class="card-text">
                                    {{ Str::limit($producto->descripcion ?? 'Prenda de alta confección con diseño exclusivo y máxima comodidad.', 80) }}
                                </p>

                                <div class="price-container">
                                    <span class="price-currency">S/</span>
                                    <span class="precio">{{ number_format($producto->precio, 2) }}</span>
                                </div>

                                <button type="button"
                                        class="btn btn-gradient-primary w-100 mb-2 js-add-to-cart-quick"
                                        data-id="{{ $producto->id }}"
                                        data-name="{{ $producto->nombre }}"
                                        data-price="{{ $producto->precio }}"
                                        data-image="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : '' }}">
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Agregar al Carrito</span>
                                </button>

                                <a href="{{ route('productos.show', $producto) }}" class="btn btn-glass w-100 mb-2">
                                    <i class="bi bi-eye"></i>
                                    <span>Ver Prenda y Tallas</span>
                                </a>

                                <a href="https://wa.me/51960325666?text={{ urlencode('Hola! Quiero comprar esta prenda: ' . $producto->nombre . ' (S/ ' . number_format($producto->precio, 2) . '). ¿Tienen stock en mi talla?') }}"
                                   target="_blank"
                                   class="btn btn-whatsapp w-100 mb-2"
                                   rel="noopener noreferrer">
                                    <i class="bi bi-whatsapp"></i>
                                    <span>Comprar Directo por WhatsApp</span>
                                </a>

                                @auth
                                    <div class="d-flex gap-2 pt-2 mt-2 border-top border-light-subtle">
                                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-admin w-50">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto) }}"
                                              method="POST"
                                              class="w-50 m-0"
                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-admin-danger w-100">
                                                <i class="bi bi-trash3"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResultsState" class="empty-catalog-state glass-panel d-none mt-4">
                <div class="empty-icon-circle">
                    <i class="bi bi-search"></i>
                </div>
                <h3 class="font-heading fs-4 mb-2">No se encontraron prendas</h3>
                <p class="text-secondary max-w-md mx-auto mb-3">
                    No encontramos ninguna prenda que coincida con tu búsqueda. Intenta con otros términos o limpia el filtro.
                </p>
                <button type="button" id="clearSearchBtn" class="btn btn-glass">
                    <i class="bi bi-x-circle"></i> Limpiar Búsqueda
                </button>
            </div>
        @endif

    </main>

    <footer class="modern-footer">
        <div class="container">
            <div class="row g-4 align-items-center justify-content-between">
                <div class="col-12 col-md-5 text-center text-md-start">
                    <div class="d-flex align-items-center gap-2 justify-content-center justify-content-md-start mb-2">
                        <div class="brand-icon-box" style="width: 34px; height: 34px; font-size: 1rem;">
                            <i class="bi bi-bag-heart"></i>
                        </div>
                        <h4 class="brand-title fs-5 mb-0 text-white">MODA & BOUTIQUE</h4>
                    </div>
                    <p class="small text-white-50 mb-0">
                        Prendas exclusivas, últimas tendencias y atención personalizada directa por WhatsApp.
                    </p>
                </div>

                <div class="col-12 col-md-4 text-center">
                    <div class="d-flex justify-content-center gap-3 mb-2">
                        <a href="https://wa.me/51960325666" target="_blank" class="footer-social-link" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="#" class="footer-social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="footer-social-link" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                    <div class="small text-white-50">Asesoría personalizada en cada compra</div>
                </div>

                <div class="col-12 col-md-3 text-center text-md-end small text-white-50">
                    <div>© {{ date('Y') }} Moda & Boutique.</div>
                    <div>Todos los derechos reservados.</div>
                </div>
            </div>
        </div>
    </footer>

    @include('productos.partials.cart-drawer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('liveSearchInput');
            const sortBySelect = document.getElementById('sortBySelect');
            const productsGrid = document.getElementById('productsGrid');
            const productCounter = document.getElementById('productCounter');
            const noResultsState = document.getElementById('noResultsState');
            const clearSearchBtn = document.getElementById('clearSearchBtn');

            if (!productsGrid) return;

            const productItems = Array.from(document.querySelectorAll('.product-card-item'));

            function filterAndSortProducts() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const sortMode = sortBySelect ? sortBySelect.value : 'default';

                let visibleItems = [];

                productItems.forEach(item => {
                    const name = item.getAttribute('data-name') || '';
                    const desc = item.getAttribute('data-description') || '';
                    const matches = name.includes(query) || desc.includes(query);

                    item.classList.toggle('d-none', !matches);
                    if (matches) visibleItems.push(item);
                });

                if (sortMode === 'price-asc') {
                    visibleItems.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
                } else if (sortMode === 'price-desc') {
                    visibleItems.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
                } else if (sortMode === 'name-asc') {
                    visibleItems.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
                }

                visibleItems.forEach(item => productsGrid.appendChild(item));

                if (productCounter) {
                    productCounter.textContent = visibleItems.length;
                }

                if (noResultsState) {
                    noResultsState.classList.toggle('d-none', visibleItems.length !== 0);
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterAndSortProducts);
            }

            if (sortBySelect) {
                sortBySelect.addEventListener('change', filterAndSortProducts);
            }

            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', () => {
                    if (searchInput) {
                        searchInput.value = '';
                        filterAndSortProducts();
                    }
                });
            }

            // Atajo Secreto: Ctrl+Shift+S o Alt+S para ir al login de Staff
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 's') || (e.altKey && e.key.toLowerCase() === 's')) {
                    e.preventDefault();
                    window.location.href = '{{ route("login") }}';
                }
            });

            // Atajo Secreto: Doble clic en el icono del logo para ir al login
            const brandLogoBox = document.querySelector('.navbar-brand-logo .brand-icon-box');
            if (brandLogoBox) {
                brandLogoBox.addEventListener('dblclick', (e) => {
                    e.preventDefault();
                    window.location.href = '{{ route("login") }}';
                });
            }
        });
    </script>
</body>
</html>