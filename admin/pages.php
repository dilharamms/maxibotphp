<?php
session_start();
require_once dirname(__DIR__) . '/includes/db.php';
require_once __DIR__ . '/includes/admin-nav.php';

$message = '';
$message_type = '';

// Handle Page Blocks Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_blocks'])) {
    $blocks = [
        'home_hero_title' => $_POST['home_hero_title'],
        'home_hero_subtitle' => $_POST['home_hero_subtitle'],
        'about_hero_title' => $_POST['about_hero_title'],
        'about_hero_subtitle' => $_POST['about_hero_subtitle'],
        'about_story_title' => $_POST['about_story_title'],
        'about_story_content' => $_POST['about_story_content'],
        'about_refund_content' => $_POST['about_refund_content']
    ];
    
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT OR REPLACE INTO pages (slug, section, block_key, block_value) VALUES (:slug, :section, :block_key, :block_value)");
        
        // Define metadata mapping for each block key
        $meta = [
            'home_hero_title' => ['slug' => 'home', 'section' => 'hero'],
            'home_hero_subtitle' => ['slug' => 'home', 'section' => 'hero'],
            'about_hero_title' => ['slug' => 'about', 'section' => 'hero'],
            'about_hero_subtitle' => ['slug' => 'about', 'section' => 'hero'],
            'about_story_title' => ['slug' => 'about', 'section' => 'story'],
            'about_story_content' => ['slug' => 'about', 'section' => 'story'],
            'about_refund_content' => ['slug' => 'about', 'section' => 'refund']
        ];
        
        foreach ($blocks as $k => $v) {
            $stmt->execute([
                ':slug' => $meta[$k]['slug'],
                ':section' => $meta[$k]['section'],
                ':block_key' => $k,
                ':block_value' => $v
            ]);
        }
        
        $db->commit();
        $message = "Page content blocks updated successfully!";
        $message_type = "success";
    } catch (Exception $e) {
        $db->rollBack();
        $message = "Error saving page blocks: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Helper to safely get seeded page blocks
$blocks_data = [
    'home_hero_title' => get_page_block('home_hero_title', 'Unlock the Power of <span>Robotics & Coding</span>'),
    'home_hero_subtitle' => get_page_block('home_hero_subtitle', "From screen-free logical coding toys to advanced metal-build programmable robots, Maxibot inspires Sri Lanka's young minds to create, program, and innovate."),
    'about_hero_title' => get_page_block('about_hero_title', 'Our Story & Mission'),
    'about_hero_subtitle' => get_page_block('about_hero_subtitle', 'Maxibot has been operating for over five years, dedicated to igniting creativity, critical thinking, and innovation in the next generation of creators in Sri Lanka.'),
    'about_story_title' => get_page_block('about_story_title', 'Why Maxibot was Founded'),
    'about_story_content' => get_page_block('about_story_content', "<p>In a rapidly evolving technological landscape, memorizing textbook facts is no longer enough. The future belongs to critical thinkers and creators. Maxibot was founded to bridge the gap between abstract academic theories and hands-on electrical and mechanical construction.</p>\n<p>By providing affordable, easy-to-use microcontrollers, detailed sensors, robotic chassis, and logical gaming puzzles, we empower parents, classrooms, and teachers to deliver premium STEAM (Science, Technology, Engineering, Arts, and Mathematics) education locally, without high import costs.</p>"),
    'about_refund_content' => get_page_block('about_refund_content', "<p>We want you to build with complete confidence. Maxibot offers a comprehensive return policy for all our electronic components, kits, and educational toys:</p>\n<ul style=\"display: flex; flex-direction: column; gap: 16px; font-size: 14px; line-height: 1.6; margin-bottom: 24px; padding-left: 0;\">\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-circle-exclamation\" style=\"color: #ef4444; font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Defective Products:</strong> If an electronic board or sensor fails to function out of the box, you must notify us within <strong>48 hours</strong> of delivery. Contact our sales department at sales@maxibot.lk to organize a replacement.</div></li>\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-clock\" style=\"color: var(--secondary); font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Change of Mind:</strong> Sealed, unopened, and resellable kits can be returned within <strong>14 days</strong> of purchase. Note that high-value microelectronic microchips or developer boards may be subject to a restocking fee if opened.</div></li>\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-receipt\" style=\"color: var(--dark); font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Original Invoice:</strong> A proof of purchase or original cash register receipt is required for all refund and warranty requests.</div></li>\n</ul>\n<p style=\"font-size: 13px; color: var(--text-muted); font-style: italic;\">For general support queries regarding assembly, programming codes, or deliveries, contact us directly at info@maxibot.lk.</p>")
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Block Editor - Maxibot Admin</title>
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
                    <h1 class="admin-title">Page Block Editor</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Modify text content, heroes, stories, and policy blocks across the website.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="pages.php" method="POST">
                
                <!-- Homepage Tab -->
                <div class="content-box">
                    <h2 class="box-title"><i class="fa-solid fa-house" style="color: var(--primary);"></i> Homepage Content Blocks</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="home_hero_title">Hero Title Text (HTML Allowed)</label>
                        <input type="text" name="home_hero_title" id="home_hero_title" class="form-control" value="<?php echo htmlspecialchars($blocks_data['home_hero_title']); ?>" required>
                        <span style="font-size: 11px; color: var(--text-muted);">Use <code>&lt;span&gt;Word&lt;/span&gt;</code> to style text in gradient brand colors.</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="home_hero_subtitle">Hero Subtitle</label>
                        <textarea name="home_hero_subtitle" id="home_hero_subtitle" class="form-control" rows="3" required><?php echo htmlspecialchars($blocks_data['home_hero_subtitle']); ?></textarea>
                    </div>
                </div>

                <!-- About Us Tab -->
                <div class="content-box">
                    <h2 class="box-title"><i class="fa-solid fa-circle-info" style="color: var(--secondary);"></i> About Us Page Content Blocks</h2>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label" for="about_hero_title">About Hero Title</label>
                            <input type="text" name="about_hero_title" id="about_hero_title" class="form-control" value="<?php echo htmlspecialchars($blocks_data['about_hero_title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about_story_title">About Story Title</label>
                            <input type="text" name="about_story_title" id="about_story_title" class="form-control" value="<?php echo htmlspecialchars($blocks_data['about_story_title']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="about_hero_subtitle">About Hero Subtitle</label>
                        <textarea name="about_hero_subtitle" id="about_hero_subtitle" class="form-control" rows="2" required><?php echo htmlspecialchars($blocks_data['about_hero_subtitle']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="about_story_content">Why Founded Story Paragraphs (HTML Allowed)</label>
                        <textarea name="about_story_content" id="about_story_content" class="form-control" rows="5" required><?php echo htmlspecialchars($blocks_data['about_story_content']); ?></textarea>
                        <span style="font-size: 11px; color: var(--text-muted);">Use <code>&lt;p&gt;Paragraph Text&lt;/p&gt;</code> to separate stories.</span>
                    </div>
                </div>

                <!-- Refund Policy tab -->
                <div class="content-box">
                    <h2 class="box-title"><i class="fa-solid fa-shield-halved" style="color: var(--danger);"></i> Refund & Returns Policy Content (HTML Allowed)</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="about_refund_content">Refund Details Content Box</label>
                        <textarea name="about_refund_content" id="about_refund_content" class="form-control" rows="10" required><?php echo htmlspecialchars($blocks_data['about_refund_content']); ?></textarea>
                        <span style="font-size: 11px; color: var(--text-muted);">This editor accepts full HTML structuring (ul, li, div, p).</span>
                    </div>
                </div>

                <div style="margin-bottom: 50px;">
                    <button type="submit" name="save_blocks" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px;"><i class="fa-solid fa-floppy-disk"></i> Save All Page Content Blocks</button>
                </div>
            </form>
        </main>
    </div>

</body>
</html>
