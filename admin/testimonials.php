<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/admin-nav.php';

$message = '';
$message_type = '';

// Handle Delete Testimonial Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);
    try {
        $stmt = $db->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$delete_id]);
        $message = "Testimonial deleted successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $message = "Error deleting testimonial: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Handle Form Submit (Add/Edit Testimonial)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_testimonial'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $text = trim($_POST['text']);
    $avatar = trim($_POST['avatar']);
    
    // Auto-generate avatar letter if left blank
    if ($avatar === '' && $name !== '') {
        $avatar = strtoupper(substr($name, 0, 1));
    }

    if ($name !== '' && $role !== '' && $text !== '') {
        try {
            if ($id > 0) {
                // Edit mode
                $stmt = $db->prepare("UPDATE testimonials SET name = ?, role = ?, text = ?, avatar = ? WHERE id = ?");
                $stmt->execute([$name, $role, $text, $avatar, $id]);
                $message = "Testimonial updated successfully!";
            } else {
                // Add mode
                $stmt = $db->prepare("INSERT INTO testimonials (name, role, text, avatar) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $role, $text, $avatar]);
                $message = "Testimonial added successfully!";
            }
            $message_type = "success";
        } catch (Exception $e) {
            $message = "Error saving testimonial: " . $e->getMessage();
            $message_type = "danger";
        }
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    }
}

// Fetch active item for Edit Mode
$edit_testimonial = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_testimonial = $stmt->fetch();
}

// Fetch all testimonials
try {
    $testimonials = $db->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $testimonials = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial Manager - Maxibot Admin</title>
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
                    <h1 class="admin-title">Testimonial Manager</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Add, edit, or remove client reviews and school testimonials displayed on the home page.</p>
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
                    <h2 class="box-title"><?php echo $edit_testimonial ? 'Edit Testimonial' : 'Add New Testimonial'; ?></h2>
                    
                    <form action="testimonials.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $edit_testimonial ? $edit_testimonial['id'] : 0; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1.5fr 0.5fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="name">Author Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['name']) : ''; ?>" placeholder="e.g. Mrs. Jayawardena" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="avatar">Avatar Letter</label>
                                <input type="text" name="avatar" id="avatar" class="form-control" value="<?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['avatar']) : ''; ?>" placeholder="e.g. K" maxlength="1">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="role">Designation / Role *</label>
                            <input type="text" name="role" id="role" class="form-control" value="<?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['role']) : ''; ?>" placeholder="e.g. ICT Teacher, Parent" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="text">Testimonial Quote *</label>
                            <textarea name="text" id="text" class="form-control" rows="5" placeholder="Type review text..." required><?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['text']) : ''; ?></textarea>
                        </div>

                        <button type="submit" name="save_testimonial" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Testimonial</button>
                        <?php if ($edit_testimonial): ?>
                            <a href="testimonials.php" class="btn btn-outline">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Navigation List Box -->
                <div class="content-box">
                    <h2 class="box-title">Active Testimonials</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <?php if (count($testimonials) > 0): ?>
                            <?php foreach ($testimonials as $t): ?>
                                <div style="background-color: var(--light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px; position: relative;">
                                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                            <?php echo htmlspecialchars($t['avatar']); ?>
                                        </div>
                                        <div>
                                            <strong style="font-size: 14px; color: var(--dark);"><?php echo htmlspecialchars($t['name']); ?></strong><br>
                                            <span style="font-size: 11px; color: var(--text-muted);"><?php echo htmlspecialchars($t['role']); ?></span>
                                        </div>
                                    </div>
                                    <p style="font-size: 13px; color: var(--text-main); font-style: italic; margin-bottom: 40px;">
                                        "<?php echo htmlspecialchars($t['text']); ?>"
                                    </p>
                                    <div style="position: absolute; bottom: 15px; right: 15px; display: flex; gap: 8px;">
                                        <a href="testimonials.php?action=edit&id=<?php echo $t['id']; ?>" class="btn btn-outline btn-sm" style="padding: 4px 8px;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="testimonials.php?action=delete&id=<?php echo $t['id']; ?>" class="btn btn-danger btn-sm" style="padding: 4px 8px;" title="Delete" onclick="return confirm('Are you sure you want to delete this testimonial?');"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; color: var(--text-muted); padding: 40px 0; border: 1px dashed var(--border-color); border-radius: var(--border-radius);">No testimonials in database.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
