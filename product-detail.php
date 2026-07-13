<?php
require_once 'includes/products-db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$product = ProductsDB::get_product_by_id($id);

if (!$product) {
    header("Location: products.php");
    exit();
}

$page_title = $product['name'];
$active_nav = "products";
$related = ProductsDB::get_related_products($product['category'], $product['id'], 4);
require_once 'includes/header.php';
?>

<section class="section-padding" style="background-color: var(--light);">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <div style="margin-bottom: 30px;">
            <a href="index.php" style="color: var(--text-muted); font-size: 14px;">Home</a> 
            <span style="color: var(--text-muted); font-size: 14px; margin: 0 8px;">/</span> 
            <a href="products.php" style="color: var(--text-muted); font-size: 14px;">Products</a> 
            <span style="color: var(--text-muted); font-size: 14px; margin: 0 8px;">/</span> 
            <a href="products.php?cat=<?php echo $product['category']; ?>" style="color: var(--text-muted); font-size: 14px;"><?php echo $product['category_name']; ?></a> 
            <span style="color: var(--text-muted); font-size: 14px; margin: 0 8px;">/</span> 
            <span style="font-size: 14px; font-weight: 600; color: var(--dark);"><?php echo $product['name']; ?></span>
        </div>

        <!-- Product detail content layout -->
        <div class="detail-layout">
            <!-- Left Side: Gallery Viewer -->
            <div class="gallery-container">
                <div class="main-image-wrap">
                    <img id="detail-main-img" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" onerror="this.src='images/placeholder.svg'">
                </div>
                <!-- Thumbnails grid -->
                <div class="thumb-grid">
                    <div class="thumb-item active" data-src="<?php echo $product['image']; ?>">
                        <img src="<?php echo $product['image']; ?>" alt="View 1" onerror="this.src='images/placeholder.svg'" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <!-- Mockup additional details/angles -->
                    <div class="thumb-item" data-src="images/placeholder.svg">
                        <img src="images/placeholder.svg" alt="View 2" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="thumb-item" data-src="images/placeholder.svg">
                        <img src="images/placeholder.svg" alt="View 3" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="thumb-item" data-src="images/placeholder.svg">
                        <img src="images/placeholder.svg" alt="View 4" style="max-height: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>

            <!-- Right Side: Info Panel -->
            <div class="detail-info">
                <div class="detail-cat-age">
                    <span class="badge badge-secondary"><?php echo $product['category_name']; ?></span>
                    <span class="badge badge-tag"><i class="fa-solid fa-child"></i> <?php echo $product['age']; ?></span>
                </div>
                
                <h1 class="detail-title"><?php echo $product['name']; ?></h1>
                
                <div class="product-rating" style="font-size: 15px; margin-bottom: 20px;">
                    <?php
                    $full_stars = floor($product['rating']);
                    $has_half = ($product['rating'] - $full_stars) >= 0.5;
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } elseif ($i == $full_stars + 1 && $has_half) {
                            echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    }
                    ?>
                    <span class="product-rating-count">(<?php echo $product['reviews']; ?> customer reviews)</span>
                </div>

                <div class="detail-price">LKR <?php echo number_format($product['price']); ?></div>
                
                <p class="detail-desc">
                    <?php echo $product['full_desc']; ?>
                </p>

                <!-- Purchase UI Box -->
                <div class="purchase-wrap">
                    <!-- Stock status indicator -->
                    <div style="margin-bottom: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                        <?php if ($product['in_stock']): ?>
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #22c55e; display: inline-block;"></span>
                            <span style="color: #22c55e;">In Stock - Available to order</span>
                        <?php else: ?>
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #ef4444; display: inline-block;"></span>
                            <span style="color: #ef4444;">Out of Stock - Restocking soon</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($product['in_stock']): ?>
                        <div class="qty-label">Quantity</div>
                        <div class="qty-selector">
                            <button class="qty-btn" id="detail-qty-minus"><i class="fa-solid fa-minus"></i></button>
                            <span class="qty-number" id="detail-qty-val">1</span>
                            <button class="qty-btn" id="detail-qty-plus"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="purchase-actions">
                            <button class="btn btn-primary" id="detail-add-to-cart" 
                                    data-id="<?php echo $product['id']; ?>" 
                                    data-name="<?php echo htmlspecialchars($product['name']); ?>" 
                                    data-cat="<?php echo $product['category']; ?>"
                                    data-price="<?php echo $product['price']; ?>"
                                    data-image="<?php echo $product['image']; ?>">
                                Add to Cart <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    <?php else: ?>
                        <button class="btn btn-outline" style="width: 100%;" onclick="alert('We will notify you when this item is back in stock. Thank you!');">Notify Me When Available</button>
                    <?php endif; ?>
                </div>

                <!-- Fast shipping disclaimer -->
                <div style="display: flex; gap: 16px; background-color: #fff; padding: 16px; border-radius: var(--border-radius); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-truck-fast" style="color: var(--secondary); font-size: 24px; margin-top: 4px;"></i>
                    <div>
                        <h4 style="font-size: 14px; margin-bottom: 2px;">Local Delivery Service</h4>
                        <p style="color: var(--text-muted); font-size: 12px;">Delivery island-wide (Ragama, Colombo, Gampaha within 1-2 days. Outstation within 3 days).</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Technical Specifications Section -->
        <h2 class="spec-table-title">Product Specifications</h2>
        <table class="spec-table">
            <tbody>
                <?php foreach ($product['specs'] as $key => $value): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($key); ?></td>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Related products section -->
        <?php if (count($related) > 0): ?>
            <h2 style="font-size: 26px; margin: 60px 0 24px 0;">Related STEAM Resources</h2>
            <div class="product-grid">
                <?php foreach ($related as $rp): ?>
                    <div class="product-card">
                        <div class="product-card-img-wrap">
                            <img src="<?php echo $rp['image']; ?>" alt="<?php echo $rp['name']; ?>" onerror="this.src='images/placeholder.svg'">
                        </div>
                        <div class="product-card-content">
                            <span class="product-card-cat"><?php echo $rp['category_name']; ?></span>
                            <h3 class="product-card-title"><a href="product-detail.php?id=<?php echo $rp['id']; ?>"><?php echo $rp['name']; ?></a></h3>
                            <div class="product-card-footer">
                                <div class="product-price">LKR <?php echo number_format($rp['price']); ?></div>
                                <a href="product-detail.php?id=<?php echo $rp['id']; ?>" class="btn btn-secondary btn-sm" style="padding: 8px 12px;">Configure</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
