<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/auth-check.php';

$message = '';
$message_type = '';

// Handle Homepage Sections Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_homepage'])) {
    try {
        $db->beginTransaction();
        
        // Fetch all section IDs to update
        $stmt_ids = $db->query("SELECT section_id, image FROM homepage_sections");
        $all_sections = $stmt_ids->fetchAll();
        
        $stmt_update = $db->prepare("UPDATE homepage_sections SET title = :title, subtitle = :subtitle, description = :description, image = :image, btn_text = :btn_text, btn_url = :btn_url, is_active = :is_active WHERE section_id = :section_id");

        foreach ($all_sections as $sec) {
            $sid = $sec['section_id'];
            
            $title = isset($_POST['title_' . $sid]) ? trim($_POST['title_' . $sid]) : '';
            $subtitle = isset($_POST['subtitle_' . $sid]) ? trim($_POST['subtitle_' . $sid]) : '';
            $description = isset($_POST['desc_' . $sid]) ? trim($_POST['desc_' . $sid]) : '';
            $btn_text = isset($_POST['btn_text_' . $sid]) ? trim($_POST['btn_text_' . $sid]) : '';
            $btn_url = isset($_POST['btn_url_' . $sid]) ? trim($_POST['btn_url_' . $sid]) : '';
            $is_active = isset($_POST['active_' . $sid]) ? 1 : 0;
            
            // Image Upload Handling
            $image_path = $sec['image']; // Default to current database value
            
            if (isset($_FILES['image_' . $sid]) && $_FILES['image_' . $sid]['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['image_' . $sid]['tmp_name'];
                $file_name = basename($_FILES['image_' . $sid]['name']);
                
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

            $stmt_update->execute([
                ':title' => $title,
                ':subtitle' => $subtitle,
                ':description' => $description,
                ':image' => $image_path,
                ':btn_text' => $btn_text,
                ':btn_url' => $btn_url,
                ':is_active' => $is_active,
                ':section_id' => $sid
            ]);
        }

        $db->commit();
        $message = "Homepage sections updated successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $db->rollBack();
        $message = "Error saving homepage sections: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Fetch all sections
try {
    $stmt = $db->query("SELECT * FROM homepage_sections");
    $sections_raw = $stmt->fetchAll();
    
    // Key by section_id for easy lookup
    $sections = [];
    foreach ($sections_raw as $sec) {
        $sections[$sec['section_id']] = $sec;
    }
} catch (Exception $e) {
    $sections = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Editor - Maxibot Admin</title>
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
                    <h1 class="admin-title">Homepage Section Editor</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Toggle homepage sections on or off, edit layouts, modify copy texts, and upload new graphics.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="homepage.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="save_homepage" value="1">
                
                <!-- 1. Hero Section -->
                <?php if (isset($sections['hero'])): $s = $sections['hero']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-rectangle-ad" style="color: var(--primary); margin-right: 8px;"></i> 1. Hero Banner</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_hero" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="title_hero">Hero Title (HTML Allowed)</label>
                            <input type="text" name="title_hero" id="title_hero" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                            <span style="font-size: 11px; color: var(--text-muted);">E.g. <code>Unlock the Power of &lt;span&gt;Robotics &amp; Coding&lt;/span&gt;</code></span>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_hero">Hero Subtitle / Description *</label>
                            <textarea name="desc_hero" id="desc_hero" class="form-control" rows="3" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="btn_text_hero">CTA Button Label</label>
                                <input type="text" name="btn_text_hero" id="btn_text_hero" class="form-control" value="<?php echo htmlspecialchars($s['btn_text']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="btn_url_hero">CTA Button URL</label>
                                <input type="text" name="btn_url_hero" id="btn_url_hero" class="form-control" value="<?php echo htmlspecialchars($s['btn_url']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="image_hero">Hero Graphic Image</label>
                            <input type="file" name="image_hero" id="image_hero" class="form-control" style="padding: 6px 12px; margin-bottom: 10px;">
                            <?php if ($s['image']): ?>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <img src="../<?php echo $s['image']; ?>" alt="Hero Current" style="height: 60px; object-fit: contain; border: 1px solid var(--border-color); padding: 3px; border-radius: 4px;">
                                    <span style="font-size: 12px; color: var(--text-muted);">Current: <?php echo htmlspecialchars($s['image']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 2. Categories Section -->
                <?php if (isset($sections['categories'])): $s = $sections['categories']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-shapes" style="color: var(--secondary); margin-right: 8px;"></i> 2. Product Categories Grid</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_categories" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="title_categories">Categories Section Title *</label>
                            <input type="text" name="title_categories" id="title_categories" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_categories">Categories Description *</label>
                            <textarea name="desc_categories" id="desc_categories" class="form-control" rows="2" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 3. Spotlight 1 (Starter Kit) -->
                <?php if (isset($sections['spotlight1'])): $s = $sections['spotlight1']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-star" style="color: #f59e0b; margin-right: 8px;"></i> 3. Spotlight Feature 1 (Starter DIY Kit)</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_spotlight1" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="title_spotlight1">Feature Title *</label>
                                <input type="text" name="title_spotlight1" id="title_spotlight1" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subtitle_spotlight1">Pre-title/Label *</label>
                                <input type="text" name="subtitle_spotlight1" id="subtitle_spotlight1" class="form-control" value="<?php echo htmlspecialchars($s['subtitle']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_spotlight1">Detailed Text Description *</label>
                            <textarea name="desc_spotlight1" id="desc_spotlight1" class="form-control" rows="3" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="btn_text_spotlight1">Buy Button Label</label>
                                <input type="text" name="btn_text_spotlight1" id="btn_text_spotlight1" class="form-control" value="<?php echo htmlspecialchars($s['btn_text']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="btn_url_spotlight1">Buy Link URL</label>
                                <input type="text" name="btn_url_spotlight1" id="btn_url_spotlight1" class="form-control" value="<?php echo htmlspecialchars($s['btn_url']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="image_spotlight1">Spotlight Image</label>
                            <input type="file" name="image_spotlight1" id="image_spotlight1" class="form-control" style="padding: 6px 12px; margin-bottom: 10px;">
                            <?php if ($s['image']): ?>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <img src="../<?php echo $s['image']; ?>" alt="Spotlight 1 Current" style="height: 60px; object-fit: contain; border: 1px solid var(--border-color); padding: 3px; border-radius: 4px;">
                                    <span style="font-size: 12px; color: var(--text-muted);">Current: <?php echo htmlspecialchars($s['image']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 4. Spotlight 2 (Ranger Kit) -->
                <?php if (isset($sections['spotlight2'])): $s = $sections['spotlight2']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-truck-monster" style="color: var(--primary); margin-right: 8px;"></i> 4. Spotlight Feature 2 (Ranger 3-in-1 Kit)</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_spotlight2" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="title_spotlight2">Feature Title *</label>
                                <input type="text" name="title_spotlight2" id="title_spotlight2" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subtitle_spotlight2">Pre-title/Label *</label>
                                <input type="text" name="subtitle_spotlight2" id="subtitle_spotlight2" class="form-control" value="<?php echo htmlspecialchars($s['subtitle']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_spotlight2">Detailed Text Description *</label>
                            <textarea name="desc_spotlight2" id="desc_spotlight2" class="form-control" rows="3" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="btn_text_spotlight2">Buy Button Label</label>
                                <input type="text" name="btn_text_spotlight2" id="btn_text_spotlight2" class="form-control" value="<?php echo htmlspecialchars($s['btn_text']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="btn_url_spotlight2">Buy Link URL</label>
                                <input type="text" name="btn_url_spotlight2" id="btn_url_spotlight2" class="form-control" value="<?php echo htmlspecialchars($s['btn_url']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="image_spotlight2">Spotlight Image</label>
                            <input type="file" name="image_spotlight2" id="image_spotlight2" class="form-control" style="padding: 6px 12px; margin-bottom: 10px;">
                            <?php if ($s['image']): ?>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <img src="../<?php echo $s['image']; ?>" alt="Spotlight 2 Current" style="height: 60px; object-fit: contain; border: 1px solid var(--border-color); padding: 3px; border-radius: 4px;">
                                    <span style="font-size: 12px; color: var(--text-muted);">Current: <?php echo htmlspecialchars($s['image']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 5. Software Section -->
                <?php if (isset($sections['software'])): $s = $sections['software']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-code" style="color: var(--secondary); margin-right: 8px;"></i> 5. Software Showcase (MaxiCode)</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_software" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label" for="title_software">Software Section Title *</label>
                                <input type="text" name="title_software" id="title_software" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subtitle_software">Pre-title/Label *</label>
                                <input type="text" name="subtitle_software" id="subtitle_software" class="form-control" value="<?php echo htmlspecialchars($s['subtitle']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_software">Detailed Software Description *</label>
                            <textarea name="desc_software" id="desc_software" class="form-control" rows="3" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 6. Solutions Section -->
                <?php if (isset($sections['solutions'])): $s = $sections['solutions']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-school" style="color: var(--primary); margin-right: 8px;"></i> 6. STEAM Solutions Grid</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_solutions" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="title_solutions">Solutions Section Title *</label>
                            <input type="text" name="title_solutions" id="title_solutions" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_solutions">Solutions Subtitle *</label>
                            <textarea name="desc_solutions" id="desc_solutions" class="form-control" rows="2" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 7. Testimonials Section -->
                <?php if (isset($sections['testimonials'])): $s = $sections['testimonials']; ?>
                    <div class="content-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
                            <h2 style="font-size: 18px; margin-bottom: 0;"><i class="fa-solid fa-quote-left" style="color: var(--secondary); margin-right: 8px;"></i> 7. Reviews & Testimonials Section</h2>
                            <label class="checkbox-label">
                                <input type="checkbox" name="active_testimonials" class="checkbox-input" <?php echo $s['is_active'] ? 'checked' : ''; ?>>
                                <strong style="font-size: 14px;">Enable Section</strong>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="title_testimonials">Testimonials Section Title *</label>
                            <input type="text" name="title_testimonials" id="title_testimonials" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="desc_testimonials">Testimonials Subtitle *</label>
                            <textarea name="desc_testimonials" id="desc_testimonials" class="form-control" rows="2" required><?php echo htmlspecialchars($s['description']); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 50px;">
                    <button type="submit" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px;"><i class="fa-solid fa-floppy-disk"></i> Save Homepage Configuration</button>
                </div>
            </form>
        </main>
    </div>

</body>
</html>
