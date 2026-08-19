<!-- BACKDROP DEL CARRITO -->
<div id="cartBackdrop" class="cart-backdrop"></div>

<!-- PANEL LATERAL (CART DRAWER) -->
<aside id="cartDrawer" class="cart-drawer" aria-label="Carrito de Compras">
    <!-- Header -->
    <div class="cart-drawer-header">
        <div class="cart-drawer-title-group">
            <div class="cart-drawer-icon">
                <i class="bi bi-bag-heart"></i>
            </div>
            <div>
                <h3 class="cart-drawer-title">Tu Carrito de Compras</h3>
                <span class="cart-drawer-subtitle" id="drawerHeaderCount">(0 prendas)</span>
            </div>
        </div>
        <button type="button" class="cart-drawer-close js-close-cart" aria-label="Cerrar carrito">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Body / Items List -->
    <div class="cart-drawer-body">
        <!-- Lista de productos añadidos -->
        <div id="cartDrawerItems" class="cart-items-wrapper"></div>

        <!-- Estado vacío -->
        <div id="cartDrawerEmpty" class="cart-drawer-empty d-none">
            <div class="cart-drawer-empty-icon">
                <i class="bi bi-bag-x"></i>
            </div>
            <h4 class="font-heading fs-5 mb-2">Tu carrito está vacío</h4>
            <p class="text-secondary small mb-4">
                Aún no has agregado ninguna prenda a tu pedido. Explora nuestro catálogo y elige tus favoritas.
            </p>
            <button type="button" class="btn btn-glass btn-sm js-close-cart">
                <i class="bi bi-arrow-left"></i> Continuar Explorando
            </button>
        </div>

        <!-- Formulario opcional de datos de envío y pago para WhatsApp -->
        <div class="cart-checkout-details">
            <details>
                <summary class="cart-checkout-details-summary">
                    <span><i class="bi bi-person-lines-fill text-dark me-1"></i> Datos de Entrega / Pago (Opcional)</span>
                    <i class="bi bi-chevron-down small"></i>
                </summary>
                <div class="cart-checkout-details-body">
                    <div class="cart-input-group">
                        <label for="checkoutCustomerName">Tu Nombre Completo:</label>
                        <input type="text" id="checkoutCustomerName" class="cart-input-control" placeholder="Ej: María Rodríguez">
                    </div>
                    <div class="cart-input-group">
                        <label for="checkoutCustomerCity">Ciudad / Dirección de Entrega:</label>
                        <input type="text" id="checkoutCustomerCity" class="cart-input-control" placeholder="Ej: Lima, Miraflores">
                    </div>
                    <div class="cart-input-group">
                        <label for="checkoutCustomerPayment">Método de Pago Preferido:</label>
                        <select id="checkoutCustomerPayment" class="cart-input-control">
                            <option value="">Seleccionar método...</option>
                            <option value="Yape">Yape</option>
                            <option value="Plin">Plin</option>
                            <option value="Transferencia BCP / BBVA / Interbank">Transferencia Bancaria</option>
                            <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                            <option value="Contraentrega (según cobertura)">Contraentrega</option>
                        </select>
                    </div>
                    <div class="cart-input-group">
                        <label for="checkoutCustomerNotes">Nota adicional:</label>
                        <input type="text" id="checkoutCustomerNotes" class="cart-input-control" placeholder="Ej: Enviar en empaque para regalo">
                    </div>
                </div>
            </details>
        </div>
    </div>

    <!-- Footer Summary & WhatsApp CTA -->
    <div id="cartDrawerFooter" class="cart-drawer-footer">
        <div class="cart-summary-row">
            <span>Subtotal estimado:</span>
            <span id="cartDrawerSubtotal" class="fw-semibold">S/ 0.00</span>
        </div>
        <div class="cart-summary-row">
            <span>Envío / Despacho:</span>
            <span class="text-success small fw-semibold">A coordinar por WhatsApp</span>
        </div>
        <div class="cart-summary-row total-row">
            <span>Total a pagar:</span>
            <span id="cartDrawerTotal" class="cart-total-amount">S/ 0.00</span>
        </div>

        <button type="button" id="cartDrawerCheckoutBtn" class="btn-cart-whatsapp">
            <i class="bi bi-whatsapp"></i>
            <span>Finalizar Pedido por WhatsApp</span>
        </button>

        <button type="button" id="cartDrawerClearBtn" class="btn-cart-clear">
            <i class="bi bi-trash3"></i> Vaciar Carrito
        </button>
    </div>
</aside>

<!-- BOTÓN FLOTANTE DEL CARRITO (FAB) -->
<button type="button" id="floatingCartBtn" class="cart-floating-btn js-open-cart" title="Ver Carrito de Compras" aria-label="Abrir carrito de compras">
    <i class="bi bi-bag-check"></i>
    <span class="cart-count-badge d-none">0</span>
</button>

<!-- MODAL DE SELECCIÓN RÁPIDA DE TALLA (QUICK ADD) -->
<div class="modal fade" id="quickAddSizeModal" tabindex="-1" aria-labelledby="quickModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-bottom-0 pb-0 pt-3 px-3">
                <h6 class="modal-title font-heading fw-bold" id="quickModalTitle">Seleccionar Prenda</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded-3 bg-light">
                    <img id="quickModalImg" src="" alt="Prenda" class="rounded-2" style="width: 54px; height: 54px; object-fit: cover;">
                    <div>
                        <div class="small text-muted">Precio unitario:</div>
                        <div id="quickModalPrice" class="fs-5 fw-bold text-dark">S/ 0.00</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary mb-2">
                        <i class="bi bi-rulers"></i> Elige tu Talla:
                    </label>
                    <div class="quick-size-selector">
                        <button type="button" class="quick-size-btn" data-size="S">S</button>
                        <button type="button" class="quick-size-btn active" data-size="M">M</button>
                        <button type="button" class="quick-size-btn" data-size="L">L</button>
                        <button type="button" class="quick-size-btn" data-size="XL">XL</button>
                        <button type="button" class="quick-size-btn" data-size="Única">Única</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary mb-2">Cantidad:</label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="cart-stepper">
                            <button type="button" class="cart-stepper-btn" id="quickModalDecBtn">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="cart-stepper-val fs-6 px-2" id="quickModalQty">1</span>
                            <button type="button" class="cart-stepper-btn" id="quickModalIncBtn">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <span class="small text-muted">unidad(es)</span>
                    </div>
                </div>

                <button type="button" id="quickModalConfirmBtn" class="btn btn-gradient-primary w-100 py-2">
                    <i class="bi bi-bag-plus"></i> Agregar al Carrito
                </button>
            </div>
        </div>
    </div>
</div>
