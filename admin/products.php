<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/admin-nav.php';

$message = '';
$message_type = '';

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);
    try {
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$delete_id]);
        $message = "Product deleted successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $message = "Error deleting product: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Handle Form Submit (Add or Edit Product)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $price = floatval($_POST['price']);
    $rating = floatval($_POST['rating']);
    $reviews = intval($_POST['reviews']);
    $age = trim($_POST['age']);
    $description = trim($_POST['description']);
    $full_desc = trim($_POST['full_desc']);
    $in_stock = isset($_POST['in_stock']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Parse Key-value specs into JSON
    $specs_text = trim($_POST['specs_text']);
    $specs_array = [];
    if ($specs_text !== '') {
        $lines = explode("\n", $specs_text);
        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $specs_array[trim($parts[0])] = trim($parts[1]);
            }
        }
    }
    $specs_json = json_encode($specs_array);

    // Map categories keys to readable names
    $categories_names = [
        'steam-kits' => 'STEAM & Robotics Kits',
        'electronics' => 'Electronic Components',
        'puzzles' => 'Educational Toys',
        'tools' => 'Tools & Prototyping'
    ];
    $category_name = isset($categories_names[$category]) ? $categories_names[$category] : 'General';

    // Image Upload Handling
    $image_path = isset($_POST['existing_image']) ? $_POST['existing_image'] : 'images/placeholder.svg';
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['product_image']['tmp_name'];
        $file_name = basename($_FILES['product_image']['name']);
        
        // Clean filename and ensure extension is valid
        $file_name_clean = preg_replace("/[^a-zA-Z0-9_\.-]/", "", $file_name);
        $target_dir = dirname(__DIR__) . '/images/';
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . $file_name_clean;
        
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image_path = 'images/' . $file_name_clean;
        }
    }

    try {
        if ($id > 0) {
            // Edit mode
            $stmt = $db->prepare("UPDATE products SET name = :name, category = :category, category_name = :category_name, price = :price, rating = :rating, reviews = :reviews, image = :image, description = :description, full_desc = :full_desc, specs = :specs, age = :age, in_stock = :in_stock, is_featured = :is_featured WHERE id = :id");
            $stmt->execute([
                ':name' => $name, ':category' => $category, ':category_name' => $category_name,
                ':price' => $price, ':rating' => $rating, ':reviews' => $reviews,
                ':image' => $image_path, ':description' => $description, ':full_desc' => $full_desc,
                ':specs' => $specs_json, ':age' => $age, ':in_stock' => $in_stock,
                ':is_featured' => $is_featured, ':id' => $id
            ]);
            $message = "Product updated successfully!";
        } else {
            // Add mode
            $stmt = $db->prepare("INSERT INTO products (name, category, category_name, price, rating, reviews, image, description, full_desc, specs, age, in_stock, is_featured) VALUES (:name, :category, :category_name, :price, :rating, :reviews, :image, :description, :full_desc, :specs, :age, :in_stock, :is_featured)");
            $stmt->execute([
                ':name' => $name, ':category' => $category, ':category_name' => $category_name,
                ':price' => $price, ':rating' => $rating, ':reviews' => $reviews,
                ':image' => $image_path, ':description' => $description, ':full_desc' => $full_desc,
                ':specs' => $specs_json, ':age' => $age, ':in_stock' => $in_stock,
                ':is_featured' => $is_featured
            ]);
            $message = "Product added successfully!";
        }
        $message_type = "success";
    } catch (Exception $e) {
        $message = "Database error: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Fetch active product for Edit Mode
$edit_product = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_product = $stmt->fetch();
    if ($edit_product) {
        // Decode specifications back into key: value lines for textarea editing
        $specs_arr = json_decode($edit_product['specs'], true);
        $specs_text_val = '';
        if (is_array($specs_arr)) {
            foreach ($specs_arr as $k => $v) {
                $specs_text_val .= "$k: $v\n";
            }
        }
        $edit_product['specs_text'] = trim($specs_text_val);
    }
}

// Fetch all products
try {
    $products = $db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manager - Maxibot Admin</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <?php include __DIR__ . '/includes/admin-nav.php'; ?>

        <!-- Main Workspace -->
        <main class="admin-main">
            <!-- Header bar -->
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Product Manager</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Manage your inventory of kits, modules, tools, and puzzles.</p>
                </div>
                <div>
                    <a href="products.php?action=add" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Product</a>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Add/Edit form overlay or section -->
            <?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
                <div class="content-box">
                    <h2 class="box-title"><?php echo $_GET['action'] === 'edit' ? 'Edit Product Details' : 'Add New Product'; ?></h2>
                    
                    <form action="products.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $edit_product ? $edit_product['id'] : 0; ?>">
                        <input type="hidden" name="existing_image" value="<?php echo $edit_product ? $edit_product['image'] : 'images/placeholder.svg'; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="name">Product Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="category">Category *</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="steam-kits" <?php echo ($edit_product && $edit_product['category'] === 'steam-kits') ? 'selected' : ''; ?>>STEAM & Robotics Kits</option>
                                    <option value="electronics" <?php echo ($edit_product && $edit_product['category'] === 'electronics') ? 'selected' : ''; ?>>Electronic Components</option>
                                    <option value="puzzles" <?php echo ($edit_product && $edit_product['category'] === 'puzzles') ? 'selected' : ''; ?>>Educational Toys</option>
                                    <option value="tools" <?php echo ($edit_product && $edit_product['category'] === 'tools') ? 'selected' : ''; ?>>Tools & Prototyping</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="price">Price (LKR) *</label>
                                <input type="number" name="price" id="price" class="form-control" value="<?php echo $edit_product ? $edit_product['price'] : 0; ?>" required step="0.01">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="rating">Rating (out of 5) *</label>
                                <input type="number" name="rating" id="rating" class="form-control" value="<?php echo $edit_product ? $edit_product['rating'] : 4.8; ?>" required step="0.1" min="0" max="5">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="reviews">Review Count</label>
                                <input type="number" name="reviews" id="reviews" class="form-control" value="<?php echo $edit_product ? $edit_product['reviews'] : 0; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="age">Age Recommendation</label>
                                <input type="text" name="age" id="age" class="form-control" value="<?php echo $edit_product ? htmlspecialchars($edit_product['age']) : 'All Ages'; ?>" placeholder="e.g. Ages 8+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Short Description (for catalog card) *</label>
                            <input type="text" name="description" id="description" class="form-control" value="<?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="full_desc">Full Description (for details view) *</label>
                            <textarea name="full_desc" id="full_desc" class="form-control" rows="4" required><?php echo $edit_product ? htmlspecialchars($edit_product['full_desc']) : ''; ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="specs_text">Technical Specifications (One parameter per line)</label>
                                <textarea name="specs_text" id="specs_text" class="form-control" rows="6" placeholder="Main Controller: Uno R3&#10;Power: 6V DC&#10;Size: 10cm x 15cm"><?php echo $edit_product ? htmlspecialchars($edit_product['specs_text']) : ''; ?></textarea>
                                <span style="font-size: 11px; color: var(--text-muted);">Format: Key : Value. Each parameters on its own line.</span>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="product_image">Product Image File</label>
                                <input type="file" name="product_image" id="product_image" class="form-control" style="padding: 6px 12px; margin-bottom: 12px;">
                                
                                <?php if ($edit_product && $edit_product['image']): ?>
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <img src="../<?php echo $edit_product['image']; ?>" alt="Current Image" style="width: 70px; height: 70px; object-fit: contain; border: 1px solid var(--border-color); padding: 5px; border-radius: var(--border-radius);">
                                        <span style="font-size: 12px; color: var(--text-muted);">Current: <?php echo htmlspecialchars($edit_product['image']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="display: flex; gap: 30px; margin-bottom: 24px;">
                            <label class="checkbox-label">
                                <input type="checkbox" name="in_stock" class="checkbox-input" <?php echo ($edit_product && !$edit_product['in_stock']) ? '' : 'checked'; ?>>
                                In Stock (Available for purchase)
                            </label>
                            
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_featured" class="checkbox-input" <?php echo ($edit_product && $edit_product['is_featured']) ? 'checked' : ''; ?>>
                                Mark as Best Seller / Featured
                            </label>
                        </div>

                        <button type="submit" name="save_product" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Product Details</button>
                        <a href="products.php" class="btn btn-outline">Cancel</a>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Products Listing Grid -->
            <div class="content-box">
                <h2 class="box-title">Product Catalog Inventory</h2>
                
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th>Best Seller</th>
                                <th style="width: 150px; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $p): ?>
                                    <tr>
                                        <td>
                                            <img src="../<?php echo $p['image']; ?>" alt="img" onerror="this.src='../images/placeholder.svg'" style="width: 44px; height: 44px; object-fit: contain; border: 1px solid var(--border-color); border-radius: 4px; padding: 2px;">
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($p['name']); ?></strong><br>
                                            <span style="font-size: 11px; color: var(--text-muted);">Age Recommendation: <?php echo htmlspecialchars($p['age']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                                        <td><strong>LKR <?php echo number_format($p['price']); ?></strong></td>
                                        <td>
                                            <?php if ($p['in_stock']): ?>
                                                <span class="badge badge-success">In Stock</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Out of Stock</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['is_featured']): ?>
                                                <span class="badge badge-info">Yes</span>
                                            <?php else: ?>
                                                <span style="color: var(--text-muted);">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="products.php?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-outline btn-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="products.php?action=delete&id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px 0;">No products in database. Click Add Product to start.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
