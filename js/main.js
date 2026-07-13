// Maxibot Website Core Interactivity Script

document.addEventListener('DOMContentLoaded', function() {
    
    // ----------------------------------------------------
    // 1. Sticky Header & Navigation Highlight
    // ----------------------------------------------------
    const header = document.getElementById('sticky-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.style.boxShadow = 'var(--shadow-md)';
            header.style.padding = '4px 0';
        } else {
            header.style.boxShadow = 'var(--shadow-sm)';
            header.style.padding = '0';
        }
    });

    // ----------------------------------------------------
    // 2. Mobile Drawer Navigation Menu
    // ----------------------------------------------------
    const mobileOpenBtn = document.getElementById('menu-mobile-open');
    const mobileCloseBtn = document.getElementById('menu-mobile-close');
    const mobileDrawer = document.getElementById('menu-mobile-drawer');
    const mobileOverlay = document.getElementById('menu-mobile-overlay');

    if (mobileOpenBtn && mobileDrawer && mobileOverlay) {
        mobileOpenBtn.addEventListener('click', function() {
            mobileDrawer.classList.add('open');
            mobileOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Lock background scroll
        });
    }

    const closeMobileMenu = function() {
        if (mobileDrawer) mobileDrawer.classList.remove('open');
        if (mobileOverlay) mobileOverlay.style.display = 'none';
        document.body.style.overflow = ''; // Unlock scroll
    };

    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileMenu);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

    // ----------------------------------------------------
    // 3. Dropdown Search Toggle
    // ----------------------------------------------------
    const searchTrigger = document.getElementById('search-trigger');
    const searchOverlay = document.getElementById('search-dropdown-overlay');
    const searchInput = document.getElementById('search-overlay-input');

    if (searchTrigger && searchOverlay) {
        searchTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (searchOverlay.style.display === 'block') {
                searchOverlay.style.display = 'none';
            } else {
                searchOverlay.style.display = 'block';
                if (searchInput) searchInput.focus();
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchOverlay.contains(e.target) && e.target !== searchTrigger && !searchTrigger.contains(e.target)) {
                searchOverlay.style.display = 'none';
            }
        });
    }

    // ----------------------------------------------------
    // 4. Shopping Cart State Manager (LocalStorage based)
    // ----------------------------------------------------
    const CartManager = {
        getCart: function() {
            let cart = localStorage.getItem('maxibot_cart');
            return cart ? JSON.parse(cart) : [];
        },

        saveCart: function(cart) {
            localStorage.setItem('maxibot_cart', JSON.stringify(cart));
            this.updateBadge();
            // Dispatch custom event to update cart page if open
            window.dispatchEvent(new Event('cartUpdated'));
        },

        addToCart: function(product, qty = 1) {
            let cart = this.getCart();
            let existingItemIndex = cart.findIndex(item => item.id == product.id);

            if (existingItemIndex > -1) {
                cart[existingItemIndex].qty += parseInt(qty);
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    category: product.category,
                    price: parseFloat(product.price),
                    image: product.image,
                    qty: parseInt(qty)
                });
            }
            this.saveCart(cart);
            this.toast(`Added "${product.name}" to cart!`);
        },

        removeItem: function(id) {
            let cart = this.getCart();
            cart = cart.filter(item => item.id != id);
            this.saveCart(cart);
        },

        updateQty: function(id, qty) {
            let cart = this.getCart();
            let index = cart.findIndex(item => item.id == id);
            if (index > -1) {
                cart[index].qty = parseInt(qty);
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                }
                this.saveCart(cart);
            }
        },

        clearCart: function() {
            this.saveCart([]);
        },

        updateBadge: function() {
            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                let cart = this.getCart();
                let count = cart.reduce((total, item) => total + item.qty, 0);
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        },

        toast: function(message) {
            // Create mini pop-up toast alert
            const toast = document.createElement('div');
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = 'var(--dark)';
            toast.style.color = '#fff';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = 'var(--border-radius)';
            toast.style.boxShadow = 'var(--shadow-lg)';
            toast.style.zIndex = '9999';
            toast.style.fontSize = '14px';
            toast.style.fontWeight = '600';
            toast.style.animation = 'fadeInUp 0.3s ease';
            toast.innerHTML = `<i class="fa-solid fa-circle-check" style="color: var(--secondary); margin-right: 8px;"></i> ${message}`;
            
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    };

    // Initialize badge count
    CartManager.updateBadge();
    window.CartManager = CartManager; // Expose globally for inline event handlers

    // ----------------------------------------------------
    // 5. Product Detail Page Actions (Quantity & Add to Cart)
    // ----------------------------------------------------
    const qtyMinus = document.getElementById('detail-qty-minus');
    const qtyPlus = document.getElementById('detail-qty-plus');
    const qtyVal = document.getElementById('detail-qty-val');
    const addToCartBtn = document.getElementById('detail-add-to-cart');

    if (qtyMinus && qtyPlus && qtyVal) {
        qtyMinus.addEventListener('click', function() {
            let current = parseInt(qtyVal.textContent);
            if (current > 1) qtyVal.textContent = current - 1;
        });

        qtyPlus.addEventListener('click', function() {
            let current = parseInt(qtyVal.textContent);
            qtyVal.textContent = current + 1;
        });
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const product = {
                id: addToCartBtn.getAttribute('data-id'),
                name: addToCartBtn.getAttribute('data-name'),
                category: addToCartBtn.getAttribute('data-cat'),
                price: addToCartBtn.getAttribute('data-price'),
                image: addToCartBtn.getAttribute('data-image')
            };
            const qty = qtyVal ? parseInt(qtyVal.textContent) : 1;
            CartManager.addToCart(product, qty);
        });
    }

    // Product Detail Gallery Thumb Switcher
    const mainImg = document.getElementById('detail-main-img');
    const thumbs = document.querySelectorAll('.thumb-item');
    if (mainImg && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
                mainImg.src = thumb.getAttribute('data-src');
            });
        });
    }

    // ----------------------------------------------------
    // 6. Shopping Cart Page Render Logic
    // ----------------------------------------------------
    const cartTableWrap = document.getElementById('cart-items-wrapper');
    const cartSummaryWrap = document.getElementById('cart-summary-wrapper');

    function renderCartPage() {
        if (!cartTableWrap) return; // Exit if not on cart page
        
        let cart = CartManager.getCart();
        
        if (cart.length === 0) {
            cartTableWrap.innerHTML = `
                <div class="cart-empty">
                    <div class="cart-empty-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                    <h3 class="cart-empty-text">Your shopping cart is empty</h3>
                    <p style="margin-bottom: 24px; color: var(--text-muted);">Explore our catalog to find awesome coding kits and electronic components.</p>
                    <a href="products.php" class="btn btn-primary">Start Shopping</a>
                </div>
            `;
            if (cartSummaryWrap) cartSummaryWrap.style.display = 'none';
            return;
        }

        if (cartSummaryWrap) cartSummaryWrap.style.display = 'block';

        let cartHTML = '';
        let subtotal = 0;

        cart.forEach(item => {
            let itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            cartHTML += `
                <div class="cart-item">
                    <div class="cart-item-img">
                        <img src="${item.image}" alt="${item.name}" onerror="this.src='images/placeholder.png'">
                    </div>
                    <div>
                        <h4 class="cart-item-title">${item.name}</h4>
                        <span class="cart-item-cat">${item.category.toUpperCase().replace('-', ' ')}</span>
                    </div>
                    <div class="qty-selector" style="margin-bottom: 0;">
                        <button class="qty-btn" onclick="CartManager.updateQty(${item.id}, ${item.qty - 1})">-</button>
                        <span class="qty-number">${item.qty}</span>
                        <button class="qty-btn" onclick="CartManager.updateQty(${item.id}, ${item.qty + 1})">+</button>
                    </div>
                    <div class="product-price" style="font-size: 16px; text-align: right;">LKR ${itemTotal.toLocaleString('en-US')}</div>
                    <button class="cart-item-remove" onclick="CartManager.removeItem(${item.id})"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            `;
        });

        cartTableWrap.innerHTML = cartHTML;

        // Render Summary
        if (cartSummaryWrap) {
            let delivery = subtotal >= 10000 ? 0 : 450;
            let total = subtotal + delivery;
            
            document.getElementById('summary-subtotal').textContent = `LKR ${subtotal.toLocaleString('en-US')}`;
            document.getElementById('summary-delivery').textContent = delivery === 0 ? 'FREE' : `LKR ${delivery.toLocaleString('en-US')}`;
            document.getElementById('summary-total').textContent = `LKR ${total.toLocaleString('en-US')}`;
        }
    }

    // Initial cart render on page load
    renderCartPage();

    // Listen to custom updates
    window.addEventListener('cartUpdated', renderCartPage);

});
