<?php
// Helper to check active link
if (!function_exists('is_active_admin_page')) {
    function is_active_admin_page($name) {
        $current_file = basename($_SERVER['PHP_SELF']);
        return ($current_file === $name) ? 'active' : '';
    }
}
?>
<div class="admin-sidebar">
    <div class="sidebar-logo">
        <i class="fa-solid fa-screwdriver-wrench" style="color: var(--primary);"></i>
        MaxiAdmin
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="index.php" class="sidebar-link <?php echo is_active_admin_page('index.php'); ?>">
                <i class="fa-solid fa-chart-line"></i> Dashboard & Settings
            </a>
        </li>
        <li>
            <a href="homepage.php" class="sidebar-link <?php echo is_active_admin_page('homepage.php'); ?>">
                <i class="fa-solid fa-house-chimney"></i> Homepage Editor
            </a>
        </li>
        <li>
            <a href="products.php" class="sidebar-link <?php echo is_active_admin_page('products.php'); ?>">
                <i class="fa-solid fa-box-open"></i> Product Manager
            </a>
        </li>
        <li>
            <a href="pages.php" class="sidebar-link <?php echo is_active_admin_page('pages.php'); ?>">
                <i class="fa-solid fa-file-invoice"></i> Other Pages Editor
            </a>
        </li>
        <li>
            <a href="menus.php" class="sidebar-link <?php echo is_active_admin_page('menus.php'); ?>">
                <i class="fa-solid fa-bars-staggered"></i> Menu Link Manager
            </a>
        </li>
        <li>
            <a href="testimonials.php" class="sidebar-link <?php echo is_active_admin_page('testimonials.php'); ?>">
                <i class="fa-solid fa-quote-left"></i> Testimonial Manager
            </a>
        </li>
    </ul>

    <div style="margin-top: auto; display: flex; flex-direction: column; gap: 10px;">
        <a href="../index.php" target="_blank" class="sidebar-link" style="background-color: var(--dark-surface); color: #fff;">
            <i class="fa-solid fa-square-share-nodes"></i> View Main Site
        </a>
        <a href="logout.php" class="sidebar-link" style="color: #f87171;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
        </a>
    </div>
</div>
