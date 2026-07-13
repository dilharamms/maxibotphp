<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/auth-check.php'; // Will redirect if not logged in

// Count stats
try {
    $count_products = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $count_testimonials = $db->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
    $count_menus = $db->query("SELECT COUNT(*) FROM navigation")->fetchColumn();
} catch (Exception $e) {
    $count_products = $count_testimonials = $count_menus = 0;
}

$message = '';
$message_type = '';

// Handle Settings Update Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings_to_update = [
        'promo_bar_text' => $_POST['promo_bar_text'],
        'logo_text' => $_POST['logo_text'],
        'footer_desc' => $_POST['footer_desc'],
        'contact_address_ragama' => $_POST['contact_address_ragama'],
        'contact_phone_ragama' => $_POST['contact_phone_ragama'],
        'contact_address_kotikawatta' => $_POST['contact_address_kotikawatta'],
        'contact_phone_kotikawatta' => $_POST['contact_phone_kotikawatta'],
        'contact_email_general' => $_POST['contact_email_general'],
        'contact_email_sales' => $_POST['contact_email_sales'],
        'operating_hours' => $_POST['operating_hours']
    ];
    
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("REPLACE INTO settings (`key`, value) VALUES (?, ?)");
        foreach ($settings_to_update as $k => $v) {
            $stmt->execute([$k, trim($v)]);
        }
        $db->commit();
        $message = "General settings updated successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $db->rollBack();
        $message = "Error updating settings: " . $e->getMessage();
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Maxibot Admin</title>
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
                    <h1 class="admin-title">Admin Dashboard</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></p>
                </div>
                <div class="admin-user-nav">
                    <span>Role: <strong class="badge badge-info"><?php echo htmlspecialchars($_SESSION['admin_role']); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline btn-sm"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Dashboard Stats widgets -->
            <div class="stats-grid">
                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Total Products</h3>
                        <div class="stats-value"><?php echo $count_products; ?></div>
                    </div>
                    <div class="stats-icon" style="color: var(--primary); background-color: var(--primary-light);"><i class="fa-solid fa-box-open"></i></div>
                </div>
                
                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Testimonials</h3>
                        <div class="stats-value"><?php echo $count_testimonials; ?></div>
                    </div>
                    <div class="stats-icon" style="color: var(--secondary); background-color: var(--secondary-light);"><i class="fa-solid fa-quote-left"></i></div>
                </div>

                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Navigation Links</h3>
                        <div class="stats-value"><?php echo $count_menus; ?></div>
                    </div>
                    <div class="stats-icon" style="color: #f59e0b; background-color: #fef3c7;"><i class="fa-solid fa-bars"></i></div>
                </div>

                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Active Users</h3>
                        <div class="stats-value">1</div>
                    </div>
                    <div class="stats-icon" style="color: #10b981; background-color: #d1fae5;"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>

            <!-- Settings Settings Form -->
            <div class="content-box">
                <h2 class="box-title"><i class="fa-solid fa-gears" style="color: var(--primary);"></i> Global Header, Footer & Store Settings</h2>
                
                <form action="index.php" method="POST">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <!-- Logo Text -->
                        <div class="form-group">
                            <label class="form-label" for="logo_text">Website Logo Name</label>
                            <input type="text" name="logo_text" id="logo_text" class="form-control" value="<?php echo htmlspecialchars(get_setting('logo_text', 'MaxiBot')); ?>" required>
                            <span style="font-size: 11px; color: var(--text-muted);">Suffixes like "Bot" style in teal automatically. E.g. "MaxiBot" -> "Maxi" + "Bot"</span>
                        </div>
                        
                        <!-- Top Banner Promo text -->
                        <div class="form-group">
                            <label class="form-label" for="promo_bar_text">Header Announcement Text</label>
                            <input type="text" name="promo_bar_text" id="promo_bar_text" class="form-control" value="<?php echo htmlspecialchars(get_setting('promo_bar_text', 'Free delivery across Sri Lanka for orders above LKR 10,000!')); ?>" required>
                        </div>
                    </div>

                    <!-- Footer Description -->
                    <div class="form-group">
                        <label class="form-label" for="footer_desc">Footer Company Description</label>
                        <textarea name="footer_desc" id="footer_desc" class="form-control" rows="3" required><?php echo htmlspecialchars(get_setting('footer_desc')); ?></textarea>
                    </div>

                    <!-- Branch Locations Contacts -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <div>
                            <h3 style="font-size: 15px; margin-bottom: 12px; color: var(--primary);">Ragama Office Details</h3>
                            <div class="form-group">
                                <label class="form-label" for="contact_address_ragama">Address</label>
                                <textarea name="contact_address_ragama" id="contact_address_ragama" class="form-control" rows="2" required><?php echo htmlspecialchars(get_setting('contact_address_ragama')); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact_phone_ragama">Phone Line</label>
                                <input type="text" name="contact_phone_ragama" id="contact_phone_ragama" class="form-control" value="<?php echo htmlspecialchars(get_setting('contact_phone_ragama')); ?>" required>
                            </div>
                        </div>
                        
                        <div>
                            <h3 style="font-size: 15px; margin-bottom: 12px; color: var(--secondary);">Kotikawatta Outlet Details</h3>
                            <div class="form-group">
                                <label class="form-label" for="contact_address_kotikawatta">Address</label>
                                <textarea name="contact_address_kotikawatta" id="contact_address_kotikawatta" class="form-control" rows="2" required><?php echo htmlspecialchars(get_setting('contact_address_kotikawatta')); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact_phone_kotikawatta">Phone Line</label>
                                <input type="text" name="contact_phone_kotikawatta" id="contact_phone_kotikawatta" class="form-control" value="<?php echo htmlspecialchars(get_setting('contact_phone_kotikawatta')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Emails and Operating Hours -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <div>
                            <h3 style="font-size: 15px; margin-bottom: 12px; color: var(--dark);">Support Email Accounts</h3>
                            <div class="form-group">
                                <label class="form-label" for="contact_email_general">General Enquiry Email</label>
                                <input type="email" name="contact_email_general" id="contact_email_general" class="form-control" value="<?php echo htmlspecialchars(get_setting('contact_email_general', 'info@maxibot.lk')); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact_email_sales">Sales / Return Email</label>
                                <input type="email" name="contact_email_sales" id="contact_email_sales" class="form-control" value="<?php echo htmlspecialchars(get_setting('contact_email_sales', 'sales@maxibot.lk')); ?>" required>
                            </div>
                        </div>
                        
                        <div>
                            <h3 style="font-size: 15px; margin-bottom: 12px; color: var(--dark);">Store Schedule</h3>
                            <div class="form-group">
                                <label class="form-label" for="operating_hours">Operating Hours Description</label>
                                <textarea name="operating_hours" id="operating_hours" class="form-control" rows="4" required><?php echo htmlspecialchars(get_setting('operating_hours')); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 12px 24px;"><i class="fa-solid fa-floppy-disk"></i> Save Site Configuration</button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
