<?php
$page_title = "MaxiCode Software & Tools";
$active_nav = "software";
require_once 'includes/header.php';
?>

<!-- Software Hero Section -->
<section class="hero-section" style="min-height: 480px; background: linear-gradient(135deg, #1e2937 0%, #111827 100%); color: #fff;">
    <div class="hero-bg-shapes">
        <div class="hero-shape hero-shape-1" style="background-color: rgba(2, 155, 165, 0.15)"></div>
    </div>
    <div class="container hero-container">
        <div>
            <span class="badge badge-new" style="margin-bottom: 16px;"><i class="fa-solid fa-code"></i> Version 2.5.0 Released</span>
            <h1 class="hero-title" style="color: #fff; font-size: 50px;">Coding Made <span>Visual & Professional</span></h1>
            <p class="hero-desc" style="color: #94a3b8;">
                Download MaxiCode, our Scratch 3.0 & Python IDE. Learn to write algorithms visually and transition to professional coding in Python seamlessly. Available for Windows, Mac, and mobile.
            </p>
            <div class="hero-btns">
                <a href="#download-grid" class="btn btn-secondary">Get Desktop Version <i class="fa-solid fa-circle-arrow-down"></i></a>
                <a href="#features" class="btn btn-outline" style="border-color: rgba(255,255,255,0.2); color: #fff;">See Features</a>
            </div>
        </div>
        <div style="font-size: 150px; text-align: center; color: var(--secondary); opacity: 0.8;">
            <i class="fa-solid fa-laptop-code"></i>
        </div>
    </div>
</section>

<!-- Section: Features -->
<section class="section-padding" id="features" style="background-color: #fff;">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">One software, infinite possibilities</h2>
            <p class="section-subtitle">MaxiCode connects kids to physical engineering in the easiest way possible.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 60px;">
            <!-- Feat 1 -->
            <div style="background-color: var(--light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 30px;">
                <div class="category-card-icon" style="margin: 0 0 20px 0;"><i class="fa-solid fa-cubes"></i></div>
                <h3 style="font-size: 20px; margin-bottom: 12px;">1. Blockly / Scratch Code</h3>
                <p style="color: var(--text-muted); font-size: 14px;">Great for beginners aged 6+. Move blocks to control robot motors, play tone alarms, detect light levels, and measure coordinates.</p>
            </div>
            <!-- Feat 2 -->
            <div style="background-color: var(--light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 30px;">
                <div class="category-card-icon" style="margin: 0 0 20px 0; background-color: var(--secondary-light); color: var(--secondary);"><i class="fa-brands fa-python"></i></div>
                <h3 style="font-size: 20px; margin-bottom: 12px;">2. Python Live Translator</h3>
                <p style="color: var(--text-muted); font-size: 14px;">Perfect for G.C.E. ICT students. Watch visual block stacks compile instantly into Python lines side-by-side, teaching standard syntax structures.</p>
            </div>
            <!-- Feat 3 -->
            <div style="background-color: var(--light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 30px;">
                <div class="category-card-icon" style="margin: 0 0 20px 0; background-color: #fef3c7; color: #d97706;"><i class="fa-solid fa-bolt"></i></div>
                <h3 style="font-size: 20px; margin-bottom: 12px;">3. Direct USB / BT Uploader</h3>
                <p style="color: var(--text-muted); font-size: 14px;">Plug in your board (Uno, Mega, ESP32) and click upload. MaxiCode compiles and flashes programs instantly with zero configuration.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section: Download Grid -->
<section class="section-padding" id="download-grid" style="background-color: var(--light); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">Download MaxiCode Workspace</h2>
            <p class="section-subtitle">Select your device platform below to begin creating. MaxiCode is completely free to use.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px; max-width: 900px; margin: 0 auto;">
            <!-- Desktop -->
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 40px; text-align: center; box-shadow: var(--shadow-sm);">
                <i class="fa-solid fa-computer" style="font-size: 48px; color: var(--primary); margin-bottom: 20px;"></i>
                <h3 style="font-size: 22px; margin-bottom: 10px;">MaxiCode for Desktop</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 30px;">Includes full Python compilation engine and direct USB uploading drivers.</p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="#" class="btn btn-primary" onclick="event.preventDefault(); alert('Downloading MaxiCode for Windows installer (64-bit)...');"><i class="fa-brands fa-windows"></i> Windows 10/11 (.exe)</a>
                    <a href="#" class="btn btn-outline" onclick="event.preventDefault(); alert('Downloading MaxiCode for macOS installer...');"><i class="fa-brands fa-apple"></i> macOS (10.15+) (.dmg)</a>
                </div>
            </div>

            <!-- Mobile -->
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 40px; text-align: center; box-shadow: var(--shadow-sm);">
                <i class="fa-solid fa-mobile-screen-button" style="font-size: 48px; color: var(--secondary); margin-bottom: 20px;"></i>
                <h3 style="font-size: 22px; margin-bottom: 10px;">MaxiCode for Mobile</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 30px;">Program your robot kits wirelessly via Bluetooth 4.0 using tablets or phones.</p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="#" class="btn btn-secondary" onclick="event.preventDefault(); alert('Downloading MaxiCode Android APK...');"><i class="fa-brands fa-android"></i> Android (.apk)</a>
                    <a href="#" class="btn btn-outline" onclick="event.preventDefault(); alert('Opening App Store link...');"><i class="fa-brands fa-apple"></i> iOS App Store</a>
                </div>
            </div>
        </div>
        
        <!-- Requirements -->
        <div style="max-width: 600px; margin: 40px auto 0 auto; text-align: center; font-size: 13px; color: var(--text-muted);">
            <strong>System Requirements:</strong> Intel Core i3 or equivalent, 4GB RAM, 1GB disk space, USB 2.0 port for cable uploading, or Bluetooth 4.0 for wireless connection.
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
