<?php
$page_title = "STEAM Education & Robotics Sri Lanka";
$active_nav = "home";
require_once 'includes/db.php';
require_once 'includes/products-db.php';
$featured_products = ProductsDB::get_featured_products();

// Fetch homepage sections details
$sections = [];
try {
    $stmt = $db->query("SELECT * FROM homepage_sections");
    while ($row = $stmt->fetch()) {
        $sections[$row['section_id']] = $row;
    }
} catch (Exception $e) {
    // Fail silently
}

require_once 'includes/header.php';
?>

<!-- 1. Hero Section -->
<?php if (isset($sections['hero']) && $sections['hero']['is_active']): 
    $s = $sections['hero'];
?>
<section class="hero-section">
    <div class="hero-bg-shapes">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
    </div>
    <div class="container hero-container">
        <div class="hero-content">
            <span class="badge badge-new" style="margin-bottom: 16px;"><i class="fa-solid fa-graduation-cap"></i> <?php echo htmlspecialchars($s['subtitle']); ?></span>
            <h1 class="hero-title"><?php echo $s['title']; ?></h1>
            <p class="hero-desc">
                <?php echo htmlspecialchars($s['description']); ?>
            </p>
            <div class="hero-btns">
                <?php if ($s['btn_text']): ?>
                    <a href="<?php echo htmlspecialchars($s['btn_url']); ?>" class="btn btn-primary"><?php echo htmlspecialchars($s['btn_text']); ?> <i class="fa-solid fa-bag-shopping"></i></a>
                <?php endif; ?>
                <a href="solutions.php" class="btn btn-outline">For Classrooms <i class="fa-solid fa-school"></i></a>
            </div>
        </div>
        <div class="hero-image-wrapper">
            <img src="<?php echo htmlspecialchars($s['image']); ?>" alt="Hero Graphic" onerror="this.src='images/placeholder.svg'">
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 2. Product Categories Grid Section -->
<?php if (isset($sections['categories']) && $sections['categories']['is_active']): 
    $s = $sections['categories'];
?>
<section class="section-padding">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title"><?php echo htmlspecialchars($s['title']); ?></h2>
            <p class="section-subtitle"><?php echo htmlspecialchars($s['description']); ?></p>
        </div>
        <div class="categories-grid">
            <!-- Cat 1 -->
            <a href="products.php?cat=steam-kits" class="category-card">
                <div class="category-card-icon"><i class="fa-solid fa-robot"></i></div>
                <h3 class="category-card-title">STEAM Kits</h3>
                <p class="category-card-desc">DIY programmable robot sets for block-based and Python learners.</p>
            </a>
            <!-- Cat 2 -->
            <a href="products.php?cat=electronics" class="category-card">
                <div class="category-card-icon"><i class="fa-solid fa-microchip"></i></div>
                <h3 class="category-card-title">Electronics</h3>
                <p class="category-card-desc">Microcontrollers (Arduino, ESP32), sensor modules, and motor drivers.</p>
            </a>
            <!-- Cat 3 -->
            <a href="products.php?cat=puzzles" class="category-card">
                <div class="category-card-icon"><i class="fa-solid fa-shapes"></i></div>
                <h3 class="category-card-title">Educational Toys</h3>
                <p class="category-card-desc">Mechanical wooden puzzles, logic games, and science toolkits.</p>
            </a>
            <!-- Cat 4 -->
            <a href="products.php?cat=tools" class="category-card">
                <div class="category-card-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                <h3 class="category-card-title">Prototyping</h3>
                <p class="category-card-desc">Solderless breadboards, jumper wires, batteries, and makerspace tools.</p>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 3. Spotlight Feature 1: MaxiBot Starter -->
<?php if (isset($sections['spotlight1']) && $sections['spotlight1']['is_active']): 
    $s = $sections['spotlight1'];
?>
<section class="spotlight-section section-padding">
    <div class="container spotlight-grid">
        <div class="spotlight-content">
            <span class="spotlight-pre"><?php echo htmlspecialchars($s['subtitle']); ?></span>
            <h2 class="spotlight-title"><?php echo htmlspecialchars($s['title']); ?></h2>
            <p class="spotlight-text">
                <?php echo htmlspecialchars($s['description']); ?>
            </p>
            <div class="spotlight-features">
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Assembly in less than 45 minutes (no soldering required)</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Program obstacle-avoidance or line-following logics</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Compatible with standard building bricks</span>
                </div>
            </div>
            <div class="hero-btns">
                <?php if ($s['btn_text']): ?>
                    <a href="<?php echo htmlspecialchars($s['btn_url']); ?>" class="btn btn-primary btn-sm"><?php echo htmlspecialchars($s['btn_text']); ?></a>
                <?php endif; ?>
                <a href="product-detail.php?id=1" class="btn btn-outline btn-sm">Learn More</a>
            </div>
        </div>
        <div class="spotlight-img">
            <img src="<?php echo htmlspecialchars($s['image']); ?>" alt="Spotlight Feature 1" onerror="this.src='images/placeholder.svg'" style="background-color: #f8fafc; padding: 40px; width: 100%;">
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 4. Spotlight Feature 2: MaxiBot Ranger (Reversed Layout) -->
<?php if (isset($sections['spotlight2']) && $sections['spotlight2']['is_active']): 
    $s = $sections['spotlight2'];
?>
<section class="spotlight-section section-padding" style="background-color: var(--light);">
    <div class="container spotlight-grid reverse">
        <div class="spotlight-content">
            <span class="spotlight-pre"><?php echo htmlspecialchars($s['subtitle']); ?></span>
            <h2 class="spotlight-title"><?php echo htmlspecialchars($s['title']); ?></h2>
            <p class="spotlight-text">
                <?php echo htmlspecialchars($s['description']); ?>
            </p>
            <div class="spotlight-features">
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>3 distinct mechanical designs in one package</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Strong metallic build with rubber crawler tracks</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Supports both block-coding and Python scripting</span>
                </div>
            </div>
            <div class="hero-btns">
                <?php if ($s['btn_text']): ?>
                    <a href="<?php echo htmlspecialchars($s['btn_url']); ?>" class="btn btn-secondary btn-sm"><?php echo htmlspecialchars($s['btn_text']); ?></a>
                <?php endif; ?>
                <a href="product-detail.php?id=2" class="btn btn-outline btn-sm">Full Specifications</a>
            </div>
        </div>
        <div class="spotlight-img">
            <img src="<?php echo htmlspecialchars($s['image']); ?>" alt="Spotlight Feature 2" onerror="this.src='images/placeholder.svg'" style="background-color: #fff; padding: 40px; width: 100%;">
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 5. Software Showcase: MaxiCode -->
<?php if (isset($sections['software']) && $sections['software']['is_active']): 
    $s = $sections['software'];
?>
<section class="software-section section-padding">
    <div class="container software-grid">
        <div>
            <span class="spotlight-pre" style="color: var(--secondary);"><?php echo htmlspecialchars($s['subtitle']); ?></span>
            <h2><?php echo htmlspecialchars($s['title']); ?></h2>
            <p style="color: #94a3b8; font-size: 16px; margin: 20px 0 30px 0;">
                <?php echo htmlspecialchars($s['description']); ?>
            </p>
            <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-solid fa-cubes" style="color: var(--secondary); font-size: 20px; margin-top: 4px;"></i>
                    <div>
                        <h4 style="color: #fff; margin-bottom: 4px;">Block Programming</h4>
                        <p style="color: #64748b; font-size: 13px;">Drag-and-drop mechanics make it easy to learn logic flow, variables, and loops.</p>
                    </div>
                </div>
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-brands fa-python" style="color: var(--secondary); font-size: 20px; margin-top: 4px;"></i>
                    <div>
                        <h4 style="color: #fff; margin-bottom: 4px;">Python Translation</h4>
                        <p style="color: #64748b; font-size: 13px;">One-click conversion teaches syntax structures as students transition to text programming.</p>
                    </div>
                </div>
            </div>
            <?php if ($s['btn_text']): ?>
                <a href="<?php echo htmlspecialchars($s['btn_url']); ?>" class="btn btn-secondary"><?php echo htmlspecialchars($s['btn_text']); ?> <i class="fa-solid fa-download"></i></a>
            <?php endif; ?>
        </div>
        
        <!-- CSS Simulated Blockly Code Mockup -->
        <div class="software-mockup">
            <div class="mockup-header">
                <div class="mockup-dots">
                    <span class="mockup-dot dot-red"></span>
                    <span class="mockup-dot dot-yellow"></span>
                    <span class="mockup-dot dot-green"></span>
                </div>
                <span class="mockup-title">MaxiCode v2.5.0 - Workspace</span>
                <span style="color: #64748b; font-size: 12px;"><i class="fa-solid fa-play"></i> Run</span>
            </div>
            <div class="mockup-content">
                <div class="mockup-sidebar">
                    <div class="mockup-block-cat cat-motion"><i class="fa-solid fa-person-running"></i> Motion</div>
                    <div class="mockup-block-cat cat-looks"><i class="fa-solid fa-eye"></i> Looks</div>
                    <div class="mockup-block-cat cat-control"><i class="fa-solid fa-repeat"></i> Control</div>
                    <div class="mockup-block-cat cat-operators"><i class="fa-solid fa-calculator"></i> Math</div>
                </div>
                <div class="mockup-canvas">
                    <div class="scratch-block scratch-block-hat">
                        <i class="fa-solid fa-flag"></i> when green flag clicked
                    </div>
                    <div class="scratch-block scratch-block-stack" style="background-color: var(--secondary);">
                        initialize ultrasonic sensor on Port 3
                    </div>
                    <div class="scratch-block scratch-block-stack" style="background-color: #8b5cf6;">
                        repeat forever
                    </div>
                    <div class="scratch-block scratch-block-nested" style="background-color: #f59e0b;">
                        if &lt; distance <span style="background-color: #0f172a; padding: 2px 6px; border-radius: 4px;">20 cm</span> &gt; then
                    </div>
                    <div class="scratch-block scratch-block-nested" style="background-color: #ef4444; margin-left: 24px;">
                        stop motors &amp; reverse 2s
                    </div>
                    <div class="scratch-block scratch-block-nested" style="background-color: var(--primary); margin-left: 24px;">
                        turn robot right 90 degrees
                    </div>
                    <div class="scratch-block scratch-block-nested" style="background-color: #8b5cf6; margin-left: 16px;">
                        else
                    </div>
                    <div class="scratch-block scratch-block-nested" style="background-color: var(--primary); margin-left: 24px;">
                        move forward at speed 100%
                    </div>
                    <div class="scratch-block scratch-block-end">
                        end repeat
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 6. Educational Solutions Showcase -->
<?php if (isset($sections['solutions']) && $sections['solutions']['is_active']): 
    $s = $sections['solutions'];
?>
<section class="section-padding" style="background-color: #fff;">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title"><?php echo htmlspecialchars($s['title']); ?></h2>
            <p class="section-subtitle"><?php echo htmlspecialchars($s['description']); ?></p>
        </div>
        <div class="solutions-grid">
            <!-- Solution 1 -->
            <div class="solution-item">
                <div class="solution-item-img">
                    <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px;">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                </div>
                <div class="solution-item-content">
                    <h3 class="solution-item-title">School STEAM Labs</h3>
                    <p class="solution-item-text">Complete sets of robots, electronics, and construction supplies customized to fit local school curriculums and group projects.</p>
                    <a href="solutions.php#school-labs" style="font-weight: 700; color: var(--primary);">Lab Solutions <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
            <!-- Solution 2 -->
            <div class="solution-item">
                <div class="solution-item-img">
                    <div style="background: linear-gradient(135deg, var(--secondary), #0d9488); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
                <div class="solution-item-content">
                    <h3 class="solution-item-title">Curriculum Materials</h3>
                    <p class="solution-item-text">Step-by-step teacher guides, slides, homework assignments, and challenges aligned with G.C.E. ICT frameworks.</p>
                    <a href="solutions.php#curriculum" style="font-weight: 700; color: var(--secondary);">View Syllabus <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
            <!-- Solution 3 -->
            <div class="solution-item">
                <div class="solution-item-img">
                    <div style="background: linear-gradient(135deg, #1f2937, #111827); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px;">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                </div>
                <div class="solution-item-content">
                    <h3 class="solution-item-title">Teacher Training</h3>
                    <p class="solution-item-text">Professional development programs and seminars in Colombo and island-wide to empower ICT teachers to teach coding.</p>
                    <a href="solutions.php#teacher-training" style="font-weight: 700; color: var(--dark);">Training Details <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 7. Testimonials Section -->
<?php if (isset($sections['testimonials']) && $sections['testimonials']['is_active']): 
    $s = $sections['testimonials'];
?>
<section class="section-padding testimonials-section">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title"><?php echo htmlspecialchars($s['title']); ?></h2>
            <p class="section-subtitle"><?php echo htmlspecialchars($s['description']); ?></p>
        </div>
        <div class="testimonials-grid">
            <?php
            try {
                $t_stmt = $db->query("SELECT * FROM testimonials");
                $all_t = $t_stmt->fetchAll();
            } catch (Exception $e) {
                $all_t = [];
            }
            foreach ($all_t as $t_item):
            ?>
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "<?php echo htmlspecialchars($t_item['text']); ?>"
                    </p>
                    <div class="testimonial-user">
                        <div class="testimonial-avatar" style="background-color: var(--primary);"><?php echo htmlspecialchars($t_item['avatar']); ?></div>
                        <div>
                            <div class="testimonial-info-name"><?php echo htmlspecialchars($t_item['name']); ?></div>
                            <div class="testimonial-info-role"><?php echo htmlspecialchars($t_item['role']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Trusted Partners Block -->
<section class="partners-section" style="background-color: #fff; border-top: 1px solid var(--border-color); padding: 50px 0;">
    <div class="container">
        <h3 style="text-align: center; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 24px; font-weight: 600;">Our Educational & Prototyping Partners</h3>
        <div class="partners-logo-grid" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 30px 50px;">
            <img src="images/partners/creative-kids-logo.png" alt="Creative Kids" style="height: 44px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
            <img src="images/partners/bashademy-logo-web.png" alt="Bashademy" style="height: 40px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
            <img src="images/partners/mms-1.png" alt="MMS" style="height: 44px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
            <img src="images/partners/mp-1.png" alt="MP" style="height: 44px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
            <img src="images/partners/mt-1.png" alt="MT" style="height: 44px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
            <img src="images/partners/WhatsApp Image 2026-07-09 at 11.35.02 PM-Photoroom.png" alt="Maxibot Partner" style="height: 48px; width: auto; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition);" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
