<?php
$page_title = "About Us";
$active_nav = "about";
require_once 'includes/header.php';
?>

<section class="section-padding" style="background-color: var(--light);">
    <div class="container" style="max-width: 900px;">
        
        <h1 style="font-size: 42px; margin-bottom: 20px; text-align: center;">Our Story & Mission</h1>
        <p style="font-size: 18px; color: var(--text-muted); text-align: center; margin-bottom: 50px; line-height: 1.8;">
            Maxibot has been operating for over five years, dedicated to igniting creativity, critical thinking, and innovation in the next generation of creators in Sri Lanka.
        </p>

        <!-- Company Values -->
        <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 40px; margin-bottom: 50px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 26px; margin-bottom: 20px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">Why Maxibot was Founded</h2>
            <p style="margin-bottom: 20px; line-height: 1.7;">
                In a rapidly evolving technological landscape, memorizing textbook facts is no longer enough. The future belongs to critical thinkers and creators. Maxibot was founded to bridge the gap between abstract academic theories and hands-on electrical and mechanical construction.
            </p>
            <p style="line-height: 1.7;">
                By providing affordable, easy-to-use microcontrollers, detailed sensors, robotic chassis, and logical gaming puzzles, we empower parents, classrooms, and teachers to deliver premium STEAM (Science, Technology, Engineering, Arts, and Mathematics) education locally, without high import costs.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 60px;">
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 30px;">
                <h3 style="font-size: 20px; margin-bottom: 12px; color: var(--primary);"><i class="fa-solid fa-microchip"></i> Authentic Quality</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">Every ESP32 module, Arduino board, and sensor we supply undergoes strict quality-control checks, ensuring stable operation in student lab projects.</p>
            </div>
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 30px;">
                <h3 style="font-size: 20px; margin-bottom: 12px; color: var(--secondary);"><i class="fa-solid fa-headset"></i> Local Support</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">Located in Kandaliyaddapaluwa, Ragama and Kotikawatta, we are here to support you over the phone or email if you have issues uploading code.</p>
            </div>
        </div>

        <!-- Refund & Returns Policy Section -->
        <div id="refund" style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 40px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 26px; margin-bottom: 20px; color: #b91c1c; border-bottom: 2px solid #fee2e2; padding-bottom: 10px;"><i class="fa-solid fa-shield-halved"></i> Refund & Returns Policy</h2>
            <p style="margin-bottom: 20px; line-height: 1.7;">
                We want you to build with complete confidence. Maxibot offers a comprehensive return policy for all our electronic components, kits, and educational toys:
            </p>
            
            <ul style="display: flex; flex-direction: column; gap: 16px; font-size: 14px; line-height: 1.6; margin-bottom: 24px; padding-left: 0;">
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-exclamation" style="color: #ef4444; font-size: 16px; margin-top: 3px; flex-shrink: 0;"></i>
                    <div>
                        <strong>Defective Products:</strong> If an electronic board or sensor fails to function out of the box, you must notify us within <strong>48 hours</strong> of delivery. Contact our sales department at <a href="mailto:sales@maxibot.lk" style="color: var(--primary); font-weight: 600;">sales@maxibot.lk</a> to organize a replacement.
                    </div>
                </li>
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-solid fa-clock" style="color: var(--secondary); font-size: 16px; margin-top: 3px; flex-shrink: 0;"></i>
                    <div>
                        <strong>Change of Mind:</strong> Sealed, unopened, and resellable kits can be returned within <strong>14 days</strong> of purchase. Note that high-value microelectronic microchips or developer boards may be subject to a restocking fee if opened.
                    </div>
                </li>
                <li style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-solid fa-receipt" style="color: var(--dark); font-size: 16px; margin-top: 3px; flex-shrink: 0;"></i>
                    <div>
                        <strong>Original Invoice:</strong> A proof of purchase or original cash register receipt is required for all refund and warranty requests.
                    </div>
                </li>
            </ul>
            
            <p style="font-size: 13px; color: var(--text-muted); font-style: italic;">
                For general support queries regarding assembly, programming codes, or deliveries, contact us directly at <a href="mailto:info@maxibot.lk" style="color: var(--secondary);">info@maxibot.lk</a>.
            </p>
        </div>

    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
