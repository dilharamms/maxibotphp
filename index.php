<?php
$page_title = "STEAM Education & Robotics Sri Lanka";
$active_nav = "home";
require_once 'includes/products-db.php';
$featured_products = ProductsDB::get_featured_products();
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-bg-shapes">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
    </div>
    <div class="container hero-container">
        <div class="hero-content">
            <span class="badge badge-new" style="margin-bottom: 16px;"><i class="fa-solid fa-graduation-cap"></i> STEAM Learning 2026</span>
            <h1 class="hero-title">Unlock the Power of <span>Robotics & Coding</span></h1>
            <p class="hero-desc">
                From screen-free logical coding toys to advanced metal-build programmable robots, Maxibot inspires Sri Lanka's young minds to create, program, and innovate.
            </p>
            <div class="hero-btns">
                <a href="products.php" class="btn btn-primary">Explore Products <i class="fa-solid fa-bag-shopping"></i></a>
                <a href="solutions.php" class="btn btn-outline">For Classrooms <i class="fa-solid fa-school"></i></a>
            </div>
        </div>
        <div class="hero-image-wrapper">
            <img src="images/maxibot_starter.png" alt="MaxiBot Starter DIY Robot" onerror="this.src='images/placeholder.svg'">
        </div>
    </div>
</section>

<!-- Product Categories Grid Section -->
<section class="section-padding">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">Fueling curiosity at every step</h2>
            <p class="section-subtitle">We categorize our resources to support a progressive STEAM learning journey, serving schools, hobbyists, and young creators.</p>
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

<!-- Spotlight Feature 1: MaxiBot Starter -->
<section class="spotlight-section section-padding">
    <div class="container spotlight-grid">
        <div class="spotlight-content">
            <span class="spotlight-pre">Flagship Robot Kit</span>
            <h2 class="spotlight-title">MaxiBot Starter DIY Robot Kit</h2>
            <p class="spotlight-text">
                The perfect gateway to logical thinking and electronic engineering. MaxiBot Starter provides kids with an interactive hands-on experience of building a robot from scratch. Using high-quality aluminum chassis and block-based programming, coding becomes a fun, play-driven activity.
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
                <a href="product-detail.php?id=1" class="btn btn-primary btn-sm">Buy Now (LKR 12,500)</a>
                <a href="product-detail.php?id=1" class="btn btn-outline btn-sm">Learn More</a>
            </div>
        </div>
        <div class="spotlight-img">
            <img src="images/maxibot_starter.png" alt="MaxiBot Starter DIY Robot Kit" onerror="this.src='images/placeholder.svg'" style="background-color: #f8fafc; padding: 40px; width: 100%;">
        </div>
    </div>
</section>

<!-- Spotlight Feature 2: MaxiBot Ranger (Reversed Layout) -->
<section class="spotlight-section section-padding" style="background-color: var(--light);">
    <div class="container spotlight-grid reverse">
        <div class="spotlight-content">
            <span class="spotlight-pre">Advanced 3-in-1 Robotics</span>
            <h2 class="spotlight-title">MaxiBot Ranger Kit</h2>
            <p class="spotlight-text">
                Ranger integrates three unique configurations: a high-speed tracked tank, a two-wheeled self-balancing raptor, and a three-wheeled racing car. Geared with advanced encoder motors, light sensors, and gyro stabilization, it enables students to delve deep into robot kinematics and code in Python.
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
                <a href="product-detail.php?id=2" class="btn btn-secondary btn-sm">Shop Ranger (LKR 24,000)</a>
                <a href="product-detail.php?id=2" class="btn btn-outline btn-sm">Full Specifications</a>
            </div>
        </div>
        <div class="spotlight-img">
            <img src="images/maxibot_ranger.png" alt="MaxiBot Ranger 3-in-1 Kit" onerror="this.src='images/placeholder.svg'" style="background-color: #fff; padding: 40px; width: 100%;">
        </div>
    </div>
</section>

<!-- Software Showcase: MaxiCode -->
<section class="software-section section-padding">
    <div class="container software-grid">
        <div>
            <span class="spotlight-pre" style="color: var(--secondary);">Coding Environment</span>
            <h2>MaxiCode Programming Software</h2>
            <p style="color: #94a3b8; font-size: 16px; margin: 20px 0 30px 0;">
                MaxiCode makes coding intuitive. Based on Scratch 3.0 block-coding, beginners can drag and drop logic blocks to control motors, read sensor outputs, and play sounds. When ready, switch to Python mode to see your code translated side-by-side!
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
            <a href="software.php" class="btn btn-secondary">Download Software <i class="fa-solid fa-download"></i></a>
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

<!-- Educational Solutions Showcase -->
<section class="section-padding" style="background-color: #fff;">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">Empowering Classrooms in Sri Lanka</h2>
            <p class="section-subtitle">We partner with schools to establish future-ready makerspaces and code laboratories.</p>
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

<!-- Testimonials Section -->
<section class="section-padding testimonials-section">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">Loved by Teachers and Parents</h2>
            <p class="section-subtitle">See how Maxibot products are transforming STEAM learning in Sri Lanka.</p>
        </div>
        <div class="testimonials-grid">
            <!-- T1 -->
            <div class="testimonial-card">
                <p class="testimonial-text">
                    "Setting up the robotics lab at our school was effortless with Maxibot. The Starter Kit is incredibly durable, and our students were programming obstacle avoidance on day one."
                </p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar" style="background-color: var(--primary);">K</div>
                    <div>
                        <div class="testimonial-info-name">Mrs. K. Jayawardena</div>
                        <div class="testimonial-info-role">ICT Headmistress, Colombo school</div>
                    </div>
                </div>
            </div>
            <!-- T2 -->
            <div class="testimonial-card">
                <p class="testimonial-text">
                    "My 9-year-old son spends hours building and tweaking his MaxiBot. It's the best educational gift we have got him. The Scratch software makes logic easy to absorb."
                </p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar" style="background-color: var(--secondary);">M</div>
                    <div>
                        <div class="testimonial-info-name">Dr. M. Perera</div>
                        <div class="testimonial-info-role">Parent & Engineering Professor</div>
                    </div>
                </div>
            </div>
            <!-- T3 -->
            <div class="testimonial-card">
                <p class="testimonial-text">
                    "As an electronic enthusiast, Maxibot is my primary supplier in Sri Lanka. Fast local shipping and authentic components like the ESP32 make prototyping a breeze."
                </p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar" style="background-color: var(--dark);">S</div>
                    <div>
                        <div class="testimonial-info-name">Shanaka Alwis</div>
                        <div class="testimonial-info-role">Robotics Hobbyist & DIY Maker</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
