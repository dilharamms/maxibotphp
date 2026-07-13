<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/auth-check.php';

$message = '';
$message_type = '';

// Handle Delete Menu Item Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);
    try {
        $stmt = $db->prepare("DELETE FROM navigation WHERE id = ?");
        $stmt->execute([$delete_id]);
        $message = "Menu item deleted successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $message = "Error deleting menu item: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Handle Form Submit (Add/Edit Menu Item)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_menu'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $label = trim($_POST['label']);
    $url = trim($_POST['url']);
    $sort_order = intval($_POST['sort_order']);
    
    if ($label !== '' && $url !== '') {
        try {
            if ($id > 0) {
                // Edit mode
                $stmt = $db->prepare("UPDATE navigation SET label = ?, url = ?, sort_order = ? WHERE id = ?");
                $stmt->execute([$label, $url, $sort_order, $id]);
                $message = "Menu item updated successfully!";
            } else {
                // Add mode
                $stmt = $db->prepare("INSERT INTO navigation (label, url, sort_order) VALUES (?, ?, ?)");
                $stmt->execute([$label, $url, $sort_order]);
                $message = "Menu item added successfully!";
            }
            $message_type = "success";
        } catch (Exception $e) {
            $message = "Error saving menu item: " . $e->getMessage();
            $message_type = "danger";
        }
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    }
}

// Fetch active item for Edit Mode
$edit_menu = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM navigation WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_menu = $stmt->fetch();
}

// Fetch all navigation items
try {
    $menus = $db->query("SELECT * FROM navigation ORDER BY sort_order ASC")->fetchAll();
} catch (Exception $e) {
    $menus = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Menu Manager - Maxibot Admin</title>
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
                    <h1 class="admin-title">Navigation Menu Manager</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Add, edit, or reorder the links in the main header navigation menu.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px;">
                <!-- Add/Edit Form Box -->
                <div class="content-box">
                    <h2 class="box-title"><?php echo $edit_menu ? 'Edit Menu Link' : 'Add New Menu Link'; ?></h2>
                    
                    <form action="menus.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $edit_menu ? $edit_menu['id'] : 0; ?>">
                        
                        <div class="form-group">
                            <label class="form-label" for="label">Menu Label *</label>
                            <input type="text" name="label" id="label" class="form-control" value="<?php echo $edit_menu ? htmlspecialchars($edit_menu['label']) : ''; ?>" placeholder="e.g. Courses" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="url">Menu URL *</label>
                            <input type="text" name="url" id="url" class="form-control" value="<?php echo $edit_menu ? htmlspecialchars($edit_menu['url']) : ''; ?>" placeholder="e.g. products.php or https://custom-link.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="sort_order">Sort Order *</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo $edit_menu ? $edit_menu['sort_order'] : 0; ?>" required>
                            <span style="font-size: 11px; color: var(--text-muted);">Lower numbers display first (left to right).</span>
                        </div>

                        <button type="submit" name="save_menu" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Menu Item</button>
                        <?php if ($edit_menu): ?>
                            <a href="menus.php" class="btn btn-outline">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Navigation List Box -->
                <div class="content-box">
                    <h2 class="box-title">Active Navigation Links</h2>
                    
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Sort</th>
                                    <th>Label</th>
                                    <th>Link URL</th>
                                    <th style="width: 120px; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($menus) > 0): ?>
                                    <?php foreach ($menus as $m): ?>
                                        <tr>
                                            <td>
                                                <strong class="badge badge-info" style="font-size: 12px;"><?php echo $m['sort_order']; ?></strong>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($m['label']); ?></strong></td>
                                            <td><code style="font-size: 13px; color: var(--secondary);"><?php echo htmlspecialchars($m['url']); ?></code></td>
                                            <td style="text-align: right;">
                                                <a href="menus.php?action=edit&id=<?php echo $m['id']; ?>" class="btn btn-outline btn-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="menus.php?action=delete&id=<?php echo $m['id']; ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this menu item?');"><i class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px 0;">No menus in database.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
