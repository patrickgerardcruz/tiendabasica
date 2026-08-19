/**
 * ==========================================================================
 * BOUTIQUE & MODA - SHOPPING CART & WHATSAPP CHECKOUT SYSTEM
 * ==========================================================================
 */

(function () {
    'use strict';

    const CART_STORAGE_KEY = 'boutique_cart_v1';
    const WHATSAPP_PHONE = '51960325666';

    // Estado en memoria
    let cart = [];

    // Cargar carrito desde localStorage
    function loadCart() {
        try {
            const stored = localStorage.getItem(CART_STORAGE_KEY);
            cart = stored ? JSON.parse(stored) : [];
            if (!Array.isArray(cart)) cart = [];
        } catch (e) {
            console.error('Error cargando el carrito desde localStorage:', e);
            cart = [];
        }
    }

    // Guardar carrito en localStorage
    function saveCart() {
        try {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {
            console.error('Error guardando el carrito:', e);
        }
        renderCartUI();
    }

    // Obtener total de unidades en el carrito
    function getCartCount() {
        return cart.reduce((sum, item) => sum + (parseInt(item.quantity, 10) || 0), 0);
    }

    // Obtener total a pagar en soles
    function getCartTotal() {
        return cart.reduce((sum, item) => sum + ((parseFloat(item.price) || 0) * (parseInt(item.quantity, 10) || 0)), 0);
    }

    // Formatear precio en Soles
    function formatPrice(amount) {
        return `S/ ${parseFloat(amount).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // Mostrar notificación Toast
    function showToast(message, icon = 'bi-bag-check-fill') {
        let container = document.getElementById('cartToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'cartToastContainer';
            container.className = 'cart-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        toast.innerHTML = `
            <i class="bi ${icon} text-success fs-5"></i>
            <div class="cart-toast-content">${message}</div>
            <button type="button" class="cart-toast-close" aria-label="Cerrar">&times;</button>
        `;

        container.appendChild(toast);

        // Animación de entrada
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        const closeBtn = toast.querySelector('.cart-toast-close');
        const removeToast = () => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        };

        closeBtn.addEventListener('click', removeToast);
        setTimeout(removeToast, 3500);
    }

    // Añadir producto al carrito
    function addToCart(product) {
        // Estructura esperada de product: { id, name, price, image, size, quantity }
        const id = String(product.id);
        const size = product.size || 'M';
        const qty = parseInt(product.quantity, 10) || 1;
        const price = parseFloat(product.price) || 0;
        const name = product.name || 'Prenda de Colección';
        const image = product.image || '';

        // Buscar si ya existe la misma prenda con la misma talla
        const existingIndex = cart.findIndex(item => String(item.id) === id && item.size === size);

        if (existingIndex > -1) {
            cart[existingIndex].quantity += qty;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                image: image,
                size: size,
                quantity: qty
            });
        }

        saveCart();
        showToast(`<strong>${name}</strong> (${size}) agregada al carrito`);

        // Animación en el botón del carrito
        animateCartButtons();
    }

    // Actualizar cantidad de un ítem
    function updateItemQuantity(id, size, delta) {
        const item = cart.find(i => String(i.id) === String(id) && i.size === size);
        if (!item) return;

        item.quantity += delta;

        if (item.quantity <= 0) {
            removeFromCart(id, size, false);
        } else {
            saveCart();
        }
    }

    // Eliminar ítem del carrito
    function removeFromCart(id, size, notify = true) {
        const itemToRemove = cart.find(i => String(i.id) === String(id) && i.size === size);
        cart = cart.filter(item => !(String(item.id) === String(id) && item.size === size));
        saveCart();

        if (notify && itemToRemove) {
            showToast(`<strong>${itemToRemove.name}</strong> eliminada del carrito`, 'bi-trash3');
        }
    }

    // Vaciar todo el carrito
    function clearCart() {
        if (cart.length === 0) return;
        if (confirm('¿Estás seguro de que deseas vaciar tu carrito de compras?')) {
            cart = [];
            saveCart();
            showToast('El carrito ha sido vaciado', 'bi-trash3');
        }
    }

    // Efecto de rebote / animación en los botones del carrito
    function animateCartButtons() {
        const badges = document.querySelectorAll('.cart-count-badge');
        badges.forEach(badge => {
            badge.classList.remove('cart-bump-animation');
            void badge.offsetWidth; // Forzar reflow
            badge.classList.add('cart-bump-animation');
        });
    }

    // Abrir Drawer del Carrito
    function openCart() {
        const drawer = document.getElementById('cartDrawer');
        const backdrop = document.getElementById('cartBackdrop');
        if (drawer && backdrop) {
            drawer.classList.add('is-open');
            backdrop.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
    }

    // Cerrar Drawer del Carrito
    function closeCart() {
        const drawer = document.getElementById('cartDrawer');
        const backdrop = document.getElementById('cartBackdrop');
        if (drawer && backdrop) {
            drawer.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    }

    // Alternar Drawer del Carrito
    function toggleCart() {
        const drawer = document.getElementById('cartDrawer');
        if (drawer && drawer.classList.contains('is-open')) {
            closeCart();
        } else {
            openCart();
        }
    }

    // Renderizar la interfaz del carrito
    function renderCartUI() {
        const count = getCartCount();
        const total = getCartTotal();

        // Actualizar insignias de conteo
        const badges = document.querySelectorAll('.cart-count-badge');
        badges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }
        });

        // Actualizar botón flotante
        const floatingBtn = document.getElementById('floatingCartBtn');
        if (floatingBtn) {
            if (count > 0) {
                floatingBtn.classList.add('has-items');
            } else {
                floatingBtn.classList.remove('has-items');
            }
        }

        // Actualizar contador del Drawer
        const drawerHeaderCount = document.getElementById('drawerHeaderCount');
        if (drawerHeaderCount) {
            drawerHeaderCount.textContent = `(${count} prenda${count === 1 ? '' : 's'})`;
        }

        // Elementos dentro del Drawer
        const itemsContainer = document.getElementById('cartDrawerItems');
        const emptyState = document.getElementById('cartDrawerEmpty');
        const footerSection = document.getElementById('cartDrawerFooter');
        const totalDisplay = document.getElementById('cartDrawerTotal');
        const subtotalDisplay = document.getElementById('cartDrawerSubtotal');

        if (!itemsContainer) return;

        if (cart.length === 0) {
            itemsContainer.innerHTML = '';
            if (emptyState) emptyState.classList.remove('d-none');
            if (footerSection) footerSection.classList.add('d-none');
            return;
        }

        if (emptyState) emptyState.classList.add('d-none');
        if (footerSection) footerSection.classList.remove('d-none');

        if (totalDisplay) totalDisplay.textContent = formatPrice(total);
        if (subtotalDisplay) subtotalDisplay.textContent = formatPrice(total);

        // Generar lista de ítems en el Drawer
        itemsContainer.innerHTML = cart.map(item => {
            const itemSubtotal = (parseFloat(item.price) || 0) * item.quantity;
            const imgSrc = item.image ? item.image : '';

            return `
                <div class="cart-item-card" data-id="${item.id}" data-size="${item.size}">
                    <div class="cart-item-img-box">
                        ${imgSrc ? `<img src="${imgSrc}" alt="${item.name}" loading="lazy">` : `<div class="cart-item-placeholder"><i class="bi bi-camera"></i></div>`}
                    </div>
                    <div class="cart-item-details">
                        <div class="cart-item-header">
                            <h6 class="cart-item-title" title="${item.name}">${item.name}</h6>
                            <button type="button" class="cart-item-remove-btn" data-action="remove" title="Eliminar del carrito">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        <div class="cart-item-meta">
                            <span class="cart-item-size-badge"><i class="bi bi-tag"></i> Talla: <strong>${item.size}</strong></span>
                            <span class="cart-item-unit-price">${formatPrice(item.price)}</span>
                        </div>
                        <div class="cart-item-footer">
                            <div class="cart-stepper">
                                <button type="button" class="cart-stepper-btn" data-action="decrease" title="Disminuir">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="cart-stepper-val">${item.quantity}</span>
                                <button type="button" class="cart-stepper-btn" data-action="increase" title="Aumentar">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div class="cart-item-subtotal">
                                ${formatPrice(itemSubtotal)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Generar y enviar pedido por WhatsApp
    function checkoutWhatsApp() {
        if (cart.length === 0) {
            alert('Tu carrito de compras está vacío. Agrega algunas prendas primero.');
            return;
        }

        // Obtener datos opcionales del cliente
        const nameInput = document.getElementById('checkoutCustomerName');
        const cityInput = document.getElementById('checkoutCustomerCity');
        const paymentInput = document.getElementById('checkoutCustomerPayment');
        const notesInput = document.getElementById('checkoutCustomerNotes');

        const customerName = nameInput ? nameInput.value.trim() : '';
        const customerCity = cityInput ? cityInput.value.trim() : '';
        const customerPayment = paymentInput ? paymentInput.value : '';
        const customerNotes = notesInput ? notesInput.value.trim() : '';

        const totalItems = getCartCount();
        const totalPrice = getCartTotal();

        // Armar el mensaje en texto plano (sin emojis) para evitar
        // problemas de codificación al abrirse el enlace en WhatsApp
        let message = `*NUEVO PEDIDO - MODA & BOUTIQUE*\n`;
        message += `--------------------------------------\n`;
        message += `Hola! Deseo comprar las siguientes prendas:\n\n`;

        cart.forEach((item, index) => {
            const itemSubtotal = (parseFloat(item.price) || 0) * item.quantity;
            message += `${index + 1}. *${item.name}*\n`;
            message += `   - Talla: *${item.size}*\n`;
            message += `   - Cantidad: *${item.quantity}* un.\n`;
            message += `   - Precio: ${formatPrice(item.price)} c/u\n`;
            message += `   - Subtotal: *${formatPrice(itemSubtotal)}*\n\n`;
        });

        message += `--------------------------------------\n`;
        message += `Total de prendas: ${totalItems}\n`;
        message += `TOTAL A PAGAR: *${formatPrice(totalPrice)}*\n`;
        message += `--------------------------------------\n`;

        // Datos adicionales si fueron completados
        let hasExtraDetails = false;
        let extraInfo = `\n*DATOS DE ENTREGA Y PAGO:*\n`;

        if (customerName) {
            extraInfo += `Cliente: ${customerName}\n`;
            hasExtraDetails = true;
        }
        if (customerCity) {
            extraInfo += `Ciudad/Direcci\u00f3n: ${customerCity}\n`;
            hasExtraDetails = true;
        }
        if (customerPayment) {
            extraInfo += `Pago: ${customerPayment}\n`;
            hasExtraDetails = true;
        }
        if (customerNotes) {
            extraInfo += `Nota: ${customerNotes}\n`;
            hasExtraDetails = true;
        }

        if (hasExtraDetails) {
            message += extraInfo;
        }

        message += `\n\u00bfTienen disponibilidad para coordinar el pago y envio? Muchas gracias!`;

        // Abrir WhatsApp Web o App
        const whatsappUrl = `https://wa.me/${WHATSAPP_PHONE}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }

    // Modal de Selección Rápida de Talla para el catálogo
    let quickAddCurrentProduct = null;

    function openQuickAddModal(productData) {
        quickAddCurrentProduct = productData;
        const modalEl = document.getElementById('quickAddSizeModal');
        if (!modalEl) {
            // Fallback si no hay modal: agregar con talla M
            addToCart({
                id: productData.id,
                name: productData.name,
                price: productData.price,
                image: productData.image,
                size: 'M',
                quantity: 1
            });
            openCart();
            return;
        }

        // Llenar información del producto en el modal
        const titleEl = document.getElementById('quickModalTitle');
        const priceEl = document.getElementById('quickModalPrice');
        const imgEl = document.getElementById('quickModalImg');
        const qtyEl = document.getElementById('quickModalQty');

        if (titleEl) titleEl.textContent = productData.name;
        if (priceEl) priceEl.textContent = formatPrice(productData.price);
        if (imgEl) {
            if (productData.image) {
                imgEl.src = productData.image;
                imgEl.alt = productData.name;
                imgEl.classList.remove('d-none');
            } else {
                imgEl.classList.add('d-none');
            }
        }
        if (qtyEl) qtyEl.textContent = '1';

        // Resetear botones de talla a M
        const sizeButtons = modalEl.querySelectorAll('.quick-size-btn');
        sizeButtons.forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-size') === 'M');
        });

        // Mostrar modal usando Bootstrap Modal
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }

    // Inicializar listeners al cargar el DOM
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
        renderCartUI();

        // Listener para abrir drawer desde navbar o botones
        document.querySelectorAll('.js-open-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openCart();
            });
        });

        // Listener para cerrar drawer
        document.querySelectorAll('.js-close-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                closeCart();
            });
        });

        // Listener en backdrop para cerrar
        const backdrop = document.getElementById('cartBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', closeCart);
        }

        // Delegación de eventos en los ítems del Drawer (aumentar, disminuir, eliminar)
        const itemsContainer = document.getElementById('cartDrawerItems');
        if (itemsContainer) {
            itemsContainer.addEventListener('click', (e) => {
                const target = e.target.closest('[data-action]');
                if (!target) return;

                const itemCard = target.closest('.cart-item-card');
                if (!itemCard) return;

                const id = itemCard.dataset.id;
                const size = itemCard.dataset.size;
                const action = target.dataset.action;

                if (action === 'increase') {
                    updateItemQuantity(id, size, 1);
                } else if (action === 'decrease') {
                    updateItemQuantity(id, size, -1);
                } else if (action === 'remove') {
                    removeFromCart(id, size);
                }
            });
        }

        // Listener para vaciar carrito
        const clearCartBtn = document.getElementById('cartDrawerClearBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', (e) => {
                e.preventDefault();
                clearCart();
            });
        }

        // Listener para checkout por WhatsApp
        const checkoutBtn = document.getElementById('cartDrawerCheckoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                checkoutWhatsApp();
            });
        }

        // Delegación para botones "Agregar al Carrito" en el catálogo
        document.addEventListener('click', (e) => {
            const addBtn = e.target.closest('.js-add-to-cart-quick');
            if (addBtn) {
                e.preventDefault();
                const productData = {
                    id: addBtn.dataset.id,
                    name: addBtn.dataset.name,
                    price: parseFloat(addBtn.dataset.price) || 0,
                    image: addBtn.dataset.image || '',
                    size: addBtn.dataset.size || 'M',
                    quantity: parseInt(addBtn.dataset.qty, 10) || 1
                };

                // Si viene sin talla específica, abrimos el modal de selección rápida
                if (!addBtn.dataset.size) {
                    openQuickAddModal(productData);
                } else {
                    addToCart(productData);
                    openCart();
                }
            }
        });

        // Modal Quick Add: Interacciones
        const quickModalEl = document.getElementById('quickAddSizeModal');
        if (quickModalEl) {
            let selectedSize = 'M';
            let selectedQty = 1;

            const sizeBtns = quickModalEl.querySelectorAll('.quick-size-btn');
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    selectedSize = btn.dataset.size || 'M';
                });
            });

            const qtyVal = document.getElementById('quickModalQty');
            const incBtn = document.getElementById('quickModalIncBtn');
            const decBtn = document.getElementById('quickModalDecBtn');

            if (incBtn && qtyVal) {
                incBtn.addEventListener('click', () => {
                    if (selectedQty < 99) {
                        selectedQty++;
                        qtyVal.textContent = selectedQty;
                    }
                });
            }

            if (decBtn && qtyVal) {
                decBtn.addEventListener('click', () => {
                    if (selectedQty > 1) {
                        selectedQty--;
                        qtyVal.textContent = selectedQty;
                    }
                });
            }

            const confirmBtn = document.getElementById('quickModalConfirmBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', () => {
                    if (quickAddCurrentProduct) {
                        addToCart({
                            id: quickAddCurrentProduct.id,
                            name: quickAddCurrentProduct.name,
                            price: quickAddCurrentProduct.price,
                            image: quickAddCurrentProduct.image,
                            size: selectedSize,
                            quantity: selectedQty
                        });

                        const bsModal = bootstrap.Modal.getInstance(quickModalEl);
                        if (bsModal) bsModal.hide();

                        // Resetear
                        selectedQty = 1;
                        selectedSize = 'M';
                        if (qtyVal) qtyVal.textContent = '1';

                        setTimeout(() => openCart(), 350);
                    }
                });
            }
        }

        // Tecla ESC para cerrar el carrito
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeCart();
            }
        });
    });

    // Exponer API global por si se necesita desde vistas específicas (como show.blade.php)
    window.BoutiqueCart = {
        add: addToCart,
        remove: removeFromCart,
        updateQty: updateItemQuantity,
        clear: clearCart,
        open: openCart,
        close: closeCart,
        toggle: toggleCart,
        checkout: checkoutWhatsApp,
        getCount: getCartCount,
        getTotal: getCartTotal
    };

})();