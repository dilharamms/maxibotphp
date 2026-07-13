<?php
$page_title = "Shopping Cart";
$active_nav = "cart";
require_once 'includes/header.php';
?>

<section class="section-padding" style="background-color: var(--light);">
    <div class="container">
        
        <h1 style="font-size: 38px; margin-bottom: 30px;"><i class="fa-solid fa-cart-shopping" style="color: var(--primary);"></i> Your Shopping Cart</h1>

        <div class="cart-layout">
            <!-- Left Side: Items List Container -->
            <div>
                <div class="cart-items-wrap" id="cart-items-wrapper">
                    <!-- Javascript will render items here dynamically -->
                    <div style="text-align: center; padding: 40px;">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: var(--primary);"></i>
                        <p style="margin-top: 16px; color: var(--text-muted);">Loading your cart items...</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary & Checkout Form -->
            <div id="cart-summary-wrapper" style="display: none;">
                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">LKR 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span id="summary-delivery">LKR 0</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Order Total</span>
                        <span id="summary-total">LKR 0</span>
                    </div>

                    <!-- Checkout Shipping Form -->
                    <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                        <h4 style="font-size: 16px; margin-bottom: 16px;"><i class="fa-solid fa-truck" style="color: var(--secondary);"></i> Delivery Address</h4>
                        
                        <form id="checkout-form" onsubmit="event.preventDefault(); CartManager.clearCart(); alert('Order Placed Successfully! Thank you for shopping with Maxibot Sri Lanka. Our team will contact you shortly to verify delivery.'); location.href='products.php';">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="form-label" style="font-size: 12px;">Recipient Name *</label>
                                <input type="text" class="form-control" style="padding: 8px 12px; font-size: 13px;" placeholder="Full Name" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="form-label" style="font-size: 12px;">Delivery Address *</label>
                                <input type="text" class="form-control" style="padding: 8px 12px; font-size: 13px;" placeholder="Street Address, City" required>
                            </div>
                            <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 12px;">District *</label>
                                    <select class="form-control" style="padding: 8px 12px; font-size: 13px;" required>
                                        <option>Colombo</option>
                                        <option>Gampaha</option>
                                        <option>Kalutara</option>
                                        <option>Kandy</option>
                                        <option>Galle</option>
                                        <option>Kurunegala</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 12px;">Phone Number *</label>
                                    <input type="tel" class="form-control" style="padding: 8px 12px; font-size: 13px;" placeholder="0771234567" required>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label" style="font-size: 12px;">Payment Method</label>
                                <select class="form-control" style="padding: 8px 12px; font-size: 13px;">
                                    <option>Cash on Delivery (COD)</option>
                                    <option>Bank Transfer (BOC/HNB/Sampath)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">Confirm Order <i class="fa-solid fa-circle-check"></i></button>
                        </form>
                    </div>

                    <div style="text-align: center; margin-top: 16px; font-size: 12px; color: var(--text-muted);">
                        <i class="fa-solid fa-lock" style="color: var(--secondary);"></i> Secure Checkout Process
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
