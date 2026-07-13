    <!-- Footer Section -->
    <footer class="footer-wrap">
        <div class="container" style="padding-top: 100px;">
            <!-- Newsletter Sign-Up Box -->
            <div class="newsletter-box" id="footer-newsletter-section">
                <div class="newsletter-text">
                    <h3>Inspire Creativity in Your Inbox</h3>
                    <p>Subscribe to receive coding guides, new STEAM product releases, and exclusive local offers in Sri Lanka.</p>
                </div>
                <form action="#" class="newsletter-form" id="newsletter-form-action" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Maxibot newsletter!'); this.reset();">
                    <input type="email" placeholder="Enter your email address" class="newsletter-input" required id="newsletter-email-input">
                    <button type="submit" class="btn btn-white btn-sm" id="newsletter-submit-btn">Subscribe</button>
                </form>
            </div>

            <!-- Footer Directory Structure -->
            <div class="footer-grid">
                <!-- Branding Col -->
                <div class="footer-brand-col">
                    <div class="logo footer-logo" style="display: flex; align-items: center; margin-bottom: 20px;">
                        <img src="images/logo-w.png" alt="Maxibot Logo" style="height: 38px; width: auto; object-fit: contain;" onerror="this.style.display='none'; document.getElementById('svg-footer-logo').style.display='block';">
                        <svg id="svg-footer-logo" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 50" width="150" height="38" aria-label="Maxibot Logo">
                            <rect x="5" y="10" width="30" height="30" rx="6" fill="#FFF" />
                            <rect x="11" y="16" width="18" height="12" rx="3" fill="#029BA5" />
                            <circle cx="16" cy="22" r="2.2" fill="#111827" />
                            <circle cx="24" cy="22" r="2.2" fill="#111827" />
                            <line x1="20" y1="5" x2="20" y2="10" stroke="#FFF" stroke-width="3" stroke-linecap="round" />
                            <circle cx="20" cy="4" r="2" fill="#029BA5" />
                            <text x="45" y="33" font-family="'Outfit', sans-serif" font-size="22" font-weight="800" fill="#FFF"><?php echo format_logo_text($logo_text); ?></text>
                        </svg>
                    </div>
                    <p class="footer-about-text">
                        <?php echo htmlspecialchars(get_setting('footer_desc', 'Maxibot is dedicated to expanding STEAM and robotics education in Sri Lanka, equipping future-ready makers with premium parts and toys.')); ?>
                    </p>
                    <div class="footer-socials">
                        <a href="https://facebook.com" target="_blank" class="footer-social-link" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://youtube.com" target="_blank" class="footer-social-link" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="footer-social-link" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://instagram.com" target="_blank" class="footer-social-link" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Products Directory Col -->
                <div>
                    <h4 class="footer-col-title">Shop Products</h4>
                    <ul class="footer-links">
                        <li><a href="products.php?cat=steam-kits" class="footer-link">STEAM Robotics Kits</a></li>
                        <li><a href="products.php?cat=electronics" class="footer-link">Sensors & Modules</a></li>
                        <li><a href="products.php?cat=electronics" class="footer-link">Microcontrollers</a></li>
                        <li><a href="products.php?cat=puzzles" class="footer-link">Educational Toys</a></li>
                        <li><a href="products.php?cat=tools" class="footer-link">Prototyping Equipment</a></li>
                    </ul>
                </div>

                <!-- Solutions Directory Col -->
                <div>
                    <h4 class="footer-col-title">Solutions</h4>
                    <ul class="footer-links">
                        <li><a href="solutions.php#school-labs" class="footer-link">Robotics Lab Setup</a></li>
                        <li><a href="solutions.php#curriculum" class="footer-link">STEAM Curriculum</a></li>
                        <li><a href="solutions.php#teacher-training" class="footer-link">Teacher Training</a></li>
                        <li><a href="solutions.php#makers" class="footer-link">Home DIY Kits</a></li>
                    </ul>
                </div>

                <!-- Learning Col -->
                <div>
                    <h4 class="footer-col-title">Software & Code</h4>
                    <ul class="footer-links">
                        <li><a href="software.php" class="footer-link">MaxiCode Desktop</a></li>
                        <li><a href="software.php" class="footer-link">MaxiCode Mobile App</a></li>
                        <li><a href="software.php#blockly" class="footer-link">Scratch Coding Interface</a></li>
                        <li><a href="software.php#python" class="footer-link">Python Editor Tool</a></li>
                    </ul>
                </div>

                <!-- Contact & Support Col -->
                <div>
                    <h4 class="footer-col-title">Support & Policy</h4>
                    <ul class="footer-links">
                        <li><a href="about.php" class="footer-link">Our Company Story</a></li>
                        <li><a href="contact.php" class="footer-link">Contact Support</a></li>
                        <li><a href="contact.php#faq" class="footer-link">Frequently Asked Questions</a></li>
                        <li><a href="about.php#refund" class="footer-link">Refund & Returns Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Bar -->
            <div class="footer-bottom">
                <div>
                    © 2026 <?php echo htmlspecialchars($logo_text); ?> Sri Lanka. All Rights Reserved. Designed to inspire young creators.
                </div>
                <div style="display: flex; gap: 16px; font-size: 20px; align-items: center; opacity: 0.6;">
                    <i class="fa-brands fa-cc-visa" title="Visa"></i>
                    <i class="fa-brands fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fa-solid fa-money-bill-transfer" title="Bank Transfer / Cash on Delivery"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Main JavaScript Logic Link -->
    <script src="js/main.js"></script>
</body>
</html>
