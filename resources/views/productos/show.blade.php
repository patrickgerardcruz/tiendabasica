<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }} — Moda & Boutique</title>
    <meta name="description" content="{{ Str::limit($producto->descripcion, 150) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="glass-nav py-3 mb-4">
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
                <a href="{{ route('productos.index') }}" class="btn btn-glass btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    <span>Volver a la Colección</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" class="text-secondary text-decoration-none"><i class="bi bi-house-door"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" class="text-secondary text-decoration-none">Colección</a></li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $producto->nombre }}</li>
            </ol>
        </nav>

        <div class="product-detail-card">
            <div class="row g-0">

                <div class="col-12 col-lg-6">
                    <div class="detail-img-wrapper">
                        <div class="card-floating-badge" style="top: 20px; left: 20px;">
                            <span class="dot"></span>
                            <span>En Stock</span>
                        </div>

                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 class="detail-img"
                                 alt="{{ $producto->nombre }}">
                        @else
                            <div class="card-img-placeholder" style="min-height: 480px;">
                                <i class="bi bi-camera" style="font-size: 4rem;"></i>
                                <span class="fs-6">Fotografía de Prenda</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-lg-6 p-4 p-md-5 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light text-dark small fw-bold mb-3 border">
                            <i class="bi bi-stars text-warning"></i> Prenda de Temporada
                        </div>

                        <h1 class="font-heading fs-2 fw-bold text-dark mb-2">{{ $producto->nombre }}</h1>

                        <div class="d-flex align-items-baseline gap-2 mb-4">
                            <span class="text-warning-emphasis fs-4 fw-bold">S/</span>
                            <span class="precio" style="font-size: 2.4rem;">
                                {{ number_format($producto->precio, 2) }}
                            </span>
                            <span class="text-muted small ms-2">/ Unidad</span>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase small fw-bold text-secondary mb-2" style="letter-spacing: 0.05em;">Detalles y Confección</h6>
                            <p class="text-secondary leading-relaxed" style="font-size: 0.98rem;">
                                {{ $producto->descripcion ?: 'Prenda diseñada con materiales de alta calidad, excelente caída y acabados de primera. Perfecta para lucir elegante en cualquier ocasión.' }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern mb-2">
                                <i class="bi bi-rulers text-secondary"></i> Selecciona tu Talla:
                            </label>
                            <div class="d-flex flex-wrap gap-2" id="sizeSelectorContainer">
                                <button type="button" class="size-pill" data-size="S">S</button>
                                <button type="button" class="size-pill active" data-size="M">M</button>
                                <button type="button" class="size-pill" data-size="L">L</button>
                                <button type="button" class="size-pill" data-size="XL">XL</button>
                                <button type="button" class="size-pill" data-size="Estándar / Única">Talla Única</button>
                            </div>
                        </div>

                        <div class="mb-4 p-3 rounded-3" style="background: #f8f8f7; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-secondary fw-semibold">Cantidad:</span>
                                <span class="small text-muted">Total estimado: <strong class="text-dark fs-6" id="totalPriceDisplay">S/ {{ number_format($producto->precio, 2) }}</strong></span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="quantity-stepper">
                                    <button type="button" class="stepper-btn" id="decreaseQtyBtn" title="Disminuir cantidad">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="stepper-value" id="quantityValue">1</span>
                                    <button type="button" class="stepper-btn" id="increaseQtyBtn" title="Aumentar cantidad">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <span class="small text-muted">prenda(s)</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <button type="button" class="btn btn-gradient-primary w-100 py-3 fs-6" id="addToCartDetailBtn">
                                <i class="bi bi-bag-plus fs-5"></i>
                                <span>Agregar al Carrito</span>
                            </button>

                            <a href="https://wa.me/51960325666?text={{ urlencode('Hola! Quiero comprar 1 unidad de: ' . $producto->nombre . ' en talla M (Total: S/ ' . number_format($producto->precio, 2) . '). ¿Tienen disponibilidad?') }}"
                               target="_blank"
                               class="btn btn-whatsapp w-100 py-3 fs-6"
                               id="dynamicWhatsAppBtn"
                               rel="noopener noreferrer">
                                <i class="bi bi-whatsapp fs-5"></i>
                                <span>Comprar Directo por WhatsApp</span>
                            </a>
                        </div>
                    </div>

                    <div class="row g-2 mt-2 pt-3 border-top border-light-subtle">
                        <div class="col-12 col-sm-6">
                            <div class="feature-benefit-card">
                                <div class="feature-icon-box">
                                    <i class="bi bi-truck text-dark"></i>
                                </div>
                                <div>
                                    <div class="text-dark small fw-bold">Envíos a todo el país</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Despacho rápido y seguro</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="feature-benefit-card">
                                <div class="feature-icon-box">
                                    <i class="bi bi-arrow-repeat text-dark"></i>
                                </div>
                                <div>
                                    <div class="text-dark small fw-bold">Cambio de Talla</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Garantía de satisfacción</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @auth
                        <div class="d-flex gap-2 mt-4 pt-3 border-top border-light-subtle">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-admin w-50">
                                <i class="bi bi-pencil-square"></i> Editar Prenda
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}"
                                  method="POST"
                                  class="w-50 m-0"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta prenda?');">
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

    </main>

    <footer class="modern-footer mt-5">
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
            const unitPrice = {{ (float) $producto->precio }};
            const productName = @json($producto->nombre);
            const productImage = @json($producto->imagen ? asset('storage/' . $producto->imagen) : '');
            const productId = {{ $producto->id }};
            const phoneNumber = '51960325666';

            let quantity = 1;
            let selectedSize = 'M';

            const quantityValue = document.getElementById('quantityValue');
            const totalPriceDisplay = document.getElementById('totalPriceDisplay');
            const dynamicWhatsAppBtn = document.getElementById('dynamicWhatsAppBtn');
            const addToCartDetailBtn = document.getElementById('addToCartDetailBtn');
            const decreaseQtyBtn = document.getElementById('decreaseQtyBtn');
            const increaseQtyBtn = document.getElementById('increaseQtyBtn');
            const sizePills = document.querySelectorAll('.size-pill');

            function updateCalculator() {
                quantityValue.textContent = quantity;
                const total = (unitPrice * quantity).toFixed(2);
                totalPriceDisplay.textContent = `S/ ${Number(total).toLocaleString('es-PE', { minimumFractionDigits: 2 })}`;

                const message = `Hola! Quiero comprar ${quantity} unidad(es) de la prenda "${productName}" en talla ${selectedSize}. Total estimado: S/ ${total}. ¿Tienen stock disponible?`;
                if (dynamicWhatsAppBtn) {
                    dynamicWhatsAppBtn.href = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
                }
            }

            sizePills.forEach(pill => {
                pill.addEventListener('click', () => {
                    sizePills.forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');
                    selectedSize = pill.getAttribute('data-size') || 'M';
                    updateCalculator();
                });
            });

            if (decreaseQtyBtn) {
                decreaseQtyBtn.addEventListener('click', () => {
                    if (quantity > 1) {
                        quantity--;
                        updateCalculator();
                    }
                });
            }

            if (increaseQtyBtn) {
                increaseQtyBtn.addEventListener('click', () => {
                    if (quantity < 99) {
                        quantity++;
                        updateCalculator();
                    }
                });
            }

            if (addToCartDetailBtn) {
                addToCartDetailBtn.addEventListener('click', () => {
                    if (window.BoutiqueCart) {
                        window.BoutiqueCart.add({
                            id: productId,
                            name: productName,
                            price: unitPrice,
                            image: productImage,
                            size: selectedSize,
                            quantity: quantity
                        });
                        window.BoutiqueCart.open();
                    }
                });
            }
        });
    </script>
</body>
</html>