<?php
$page_title = "Product Catalog";
$active_nav = "products";
require_once 'includes/products-db.php';

// Retrieve all products from mockup database
$products = ProductsDB::get_all_products();
$categories = ProductsDB::get_categories();

// Filter parameters from GET request
$filter_cat = isset($_GET['cat']) ? $_GET['cat'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$price_max = isset($_GET['price_max']) ? intval($_GET['price_max']) : 30000;
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Filter products array in PHP
$filtered_products = array_filter($products, function($p) use ($filter_cat, $search_query, $price_max) {
    // Category filter
    if ($filter_cat && $p['category'] !== $filter_cat) {
        return false;
    }
    
    // Price filter
    if ($p['price'] > $price_max) {
        return false;
    }
    
    // Keyword search filter
    if ($search_query) {
        $name_match = stripos($p['name'], $search_query) !== false;
        $desc_match = stripos($p['description'], $search_query) !== false;
        if (!$name_match && !$desc_match) {
            return false;
        }
    }
    
    return true;
});

// Sort products
if ($sort_by === 'price-asc') {
    usort($filtered_products, function($a, $b) {
        return $a['price'] <=> $b['price'];
    });
} elseif ($sort_by === 'price-desc') {
    usort($filtered_products, function($a, $b) {
        return $b['price'] <=> $a['price'];
    });
} elseif ($sort_by === 'rating') {
    usort($filtered_products, function($a, $b) {
        return $b['rating'] <=> $a['rating'];
    });
}

require_once 'includes/header.php';
?>

<section class="section-padding" style="background-color: var(--light);">
    <div class="container">
        
        <!-- Breadcrumb / Header -->
        <div style="margin-bottom: 24px;">
            <a href="index.php" style="color: var(--text-muted); font-size: 14px;">Home</a> 
            <span style="color: var(--text-muted); font-size: 14px; margin: 0 8px;">/</span> 
            <span style="font-size: 14px; font-weight: 600; color: var(--dark);">Products</span>
        </div>

        <h1 style="font-size: 38px; margin-bottom: 30px;">STEAM & Electronics Catalog</h1>

        <div class="catalog-layout">
            <!-- Sidebar Filters -->
            <aside class="catalog-sidebar">
                <form action="products.php" method="GET" id="catalog-filter-form">
                    
                    <!-- Search Keyword -->
                    <div class="filter-group">
                        <h4 class="filter-title">Search</h4>
                        <div style="position: relative;">
                            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Keywords..." class="form-control" style="width: 100%; padding-right: 36px;">
                            <button type="submit" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">Categories</h4>
                        <div class="filter-list">
                            <label class="filter-item">
                                <input type="radio" name="cat" value="" <?php echo $filter_cat == '' ? 'checked' : ''; ?> onchange="this.form.submit()">
                                <span>All Categories</span>
                            </label>
                            <?php foreach ($categories as $cat_key => $cat_name): ?>
                                <label class="filter-item">
                                    <input type="radio" name="cat" value="<?php echo $cat_key; ?>" <?php echo $filter_cat == $cat_key ? 'checked' : ''; ?> onchange="this.form.submit()">
                                    <span><?php echo $cat_name; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">Max Price</h4>
                        <div class="range-wrap">
                            <input type="range" name="price_max" min="0" max="30000" step="500" value="<?php echo $price_max; ?>" class="range-input" id="price-slider" onchange="this.form.submit()">
                            <div class="range-values">
                                <span>LKR 0</span>
                                <span id="price-slider-value" style="color: var(--primary); font-weight: 700;">LKR <?php echo number_format($price_max); ?></span>
                            </div>
                        </div>
                    </div>

                    <a href="products.php" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; margin-top: 10px;">Clear All Filters</a>
                </form>
            </aside>

            <!-- Main Catalog Panel -->
            <main>
                <!-- Sorting & Counter header -->
                <div class="catalog-header">
                    <div class="catalog-count">
                        Showing <strong><?php echo count($filtered_products); ?></strong> of <strong><?php echo count($products); ?></strong> products
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 14px; color: var(--text-muted);">Sort By:</span>
                        <select class="sort-select" onchange="location.href = 'products.php?cat=<?php echo urlencode($filter_cat); ?>&search=<?php echo urlencode($search_query); ?>&price_max=<?php echo $price_max; ?>&sort=' + this.value">
                            <option value="default" <?php echo $sort_by == 'default' ? 'selected' : ''; ?>>Featured</option>
                            <option value="price-asc" <?php echo $sort_by == 'price-asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price-desc" <?php echo $sort_by == 'price-desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="rating" <?php echo $sort_by == 'rating' ? 'selected' : ''; ?>>Customer Rating</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if (count($filtered_products) > 0): ?>
                    <div class="product-grid">
                        <?php foreach ($filtered_products as $p): ?>
                            <div class="product-card">
                                <div class="product-card-img-wrap">
                                    <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>" onerror="this.src='images/placeholder.svg'">
                                    <?php if ($p['is_featured']): ?>
                                        <span class="badge badge-new product-card-badge">Best Seller</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-card-content">
                                    <span class="product-card-cat"><?php echo $p['category_name']; ?></span>
                                    <h3 class="product-card-title"><a href="product-detail.php?id=<?php echo $p['id']; ?>"><?php echo $p['name']; ?></a></h3>
                                    
                                    <div class="product-rating">
                                        <?php
                                        $full_stars = floor($p['rating']);
                                        $has_half = ($p['rating'] - $full_stars) >= 0.5;
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
                                        <span class="product-rating-count">(<?php echo $p['reviews']; ?>)</span>
                                    </div>
                                    
                                    <div class="product-card-footer">
                                        <div class="product-price">LKR <?php echo number_format($p['price']); ?></div>
                                        <a href="product-detail.php?id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm" style="padding: 8px 12px;"><i class="fa-solid fa-eye"></i> View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="cart-empty" style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius);">
                        <div class="cart-empty-icon" style="color: var(--text-muted);"><i class="fa-regular fa-face-frown"></i></div>
                        <h3 class="cart-empty-text">No products match your filters</h3>
                        <p style="color: var(--text-muted); margin-bottom: 24px;">Try searching for other keywords, expanding your price range, or selecting a different category.</p>
                        <a href="products.php" class="btn btn-primary">Reset Filters</a>
                    </div>
                <?php endif; ?>
            </main>
        </div>

    </div>
</section>

<script>
    // Update price slider value label instantly on sliding
    const slider = document.getElementById('price-slider');
    const sliderVal = document.getElementById('price-slider-value');
    if (slider && sliderVal) {
        slider.addEventListener('input', function() {
            sliderVal.textContent = 'LKR ' + parseInt(slider.value).toLocaleString('en-US');
        });
    }
</script>

<?php require_once 'includes/footer.php'; ?>
