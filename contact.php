<?php
$page_title = "Contact Support";
$active_nav = "contact";
require_once 'includes/header.php';
?>

<section class="section-padding" style="background-color: var(--light);">
    <div class="container">
        
        <div class="contact-grid" style="margin-bottom: 80px;">
            <!-- Left: Contact Details -->
            <div class="contact-info-card">
                <h1 class="contact-title">Get in Touch</h1>
                <p class="contact-intro">
                    Whether you have questions about custom STEAM classroom kits, bulk microcontroller pricing, or need technical help troubleshooting a sensor code, we are here to support you.
                </p>
                
                <div class="contact-details">
                    <!-- Location 1 -->
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                        <div>
                            <h3 class="contact-detail-label">Ragama Office (Main Hub)</h3>
                            <p class="contact-detail-text">
                                <?php echo nl2br(htmlspecialchars(get_setting('contact_address_ragama', "No. 559/6, Kandaliyaddapaluwa,\nRagama, Sri Lanka."))); ?>
                            </p>
                            <p class="contact-detail-text" style="margin-top: 6px; font-weight: 600;">
                                <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars(get_setting('contact_phone_ragama', '+94 762 012 900')); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Location 2 -->
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fa-solid fa-store"></i></div>
                        <div>
                            <h3 class="contact-detail-label">Kotikawatta Outlet</h3>
                            <p class="contact-detail-text">
                                <?php echo nl2br(htmlspecialchars(get_setting('contact_address_kotikawatta', "236/2B, TC Road,\nKotikawatta, Sri Lanka."))); ?>
                            </p>
                            <p class="contact-detail-text" style="margin-top: 6px; font-weight: 600;">
                                <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars(get_setting('contact_phone_kotikawatta', '+94 11-419-3515')); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Email Support -->
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <h3 class="contact-detail-label">Email Support</h3>
                            <p class="contact-detail-text"><?php echo htmlspecialchars(get_setting('contact_email_general', 'info@maxibot.lk')); ?> (General Inquiry)</p>
                            <p class="contact-detail-text"><?php echo htmlspecialchars(get_setting('contact_email_sales', 'sales@maxibot.lk')); ?> (Refunds / Orders)</p>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--border-color); font-size: 14px;">
                    <strong>Office Operating Hours:</strong><br>
                    <?php echo htmlspecialchars(get_setting('operating_hours', 'Monday - Saturday: 8:30 AM to 6:30 PM (Closed on Sundays & Poya Days)')); ?>
                </div>
            </div>

            <!-- Right: Enquiry Form -->
            <div class="contact-form-wrap">
                <h2 class="form-title">Send a Message</h2>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Message sent successfully! Thank you for contacting Maxibot support.'); this.reset();">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name *</label>
                            <input type="text" class="form-control" required placeholder="e.g. Dilhara">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" required placeholder="e.g. +94 77 123 4567">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" class="form-control" required placeholder="e.g. dilhara@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject *</label>
                        <input type="text" class="form-control" required placeholder="e.g. Bulk Arduino Uno inquiry">
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Your Message *</label>
                        <textarea class="form-control" required placeholder="Type your detailed message here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Accordion FAQ section -->
        <div id="faq" style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 32px; text-align: center; margin-bottom: 40px;">Frequently Asked Questions</h2>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <!-- FAQ 1 -->
                <details style="background-color: #fff; padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--border-color); cursor: pointer;" open>
                    <summary style="font-weight: 700; font-size: 16px; color: var(--dark); list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        Do you deliver outside Colombo and Gampaha?
                        <i class="fa-solid fa-angle-down" style="font-size: 14px;"></i>
                    </summary>
                    <p style="margin-top: 12px; color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                        Yes, we deliver island-wide across Sri Lanka using reliable courier partners. Orders for Gampaha, Ragama, and Colombo typically arrive within 1-2 working days. Outstation deliveries take 2-4 working days.
                    </p>
                </details>
                <!-- FAQ 2 -->
                <details style="background-color: #fff; padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--border-color); cursor: pointer;">
                    <summary style="font-weight: 700; font-size: 16px; color: var(--dark); list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        What payment methods do you support?
                        <i class="fa-solid fa-angle-down" style="font-size: 14px;"></i>
                    </summary>
                    <p style="margin-top: 12px; color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                        We support Bank Transfers (BOC, HNB, Sampath Bank), Credit/Debit Card payments, and Cash on Delivery (COD) for most postal codes across Sri Lanka.
                    </p>
                </details>
                <!-- FAQ 3 -->
                <details style="background-color: #fff; padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--border-color); cursor: pointer;">
                    <summary style="font-weight: 700; font-size: 16px; color: var(--dark); list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        Can I pick up my order physically from the store?
                        <i class="fa-solid fa-angle-down" style="font-size: 14px;"></i>
                    </summary>
                    <p style="margin-top: 12px; color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                        Yes, store pick-up is available at our Kotikawatta outlet or Ragama office. Please contact us via phone or place your order online and select "Pick Up" to coordinate a convenient collection time.
                    </p>
                </details>
            </div>
        </div>

    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
