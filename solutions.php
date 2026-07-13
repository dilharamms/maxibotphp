<?php
$page_title = "Educational Solutions";
$active_nav = "solutions";
require_once 'includes/header.php';
?>

<!-- Solutions Hero -->
<section class="hero-section" style="min-height: 450px; background: linear-gradient(135deg, #e0f2fe 0%, #eff6ff 100%);">
    <div class="container hero-container" style="grid-template-columns: 1.2fr 0.8fr;">
        <div>
            <span class="badge badge-secondary" style="margin-bottom: 16px;">For Institutions & Educators</span>
            <h1 class="hero-title" style="font-size: 48px;">Transform Classrooms Into <span>Innovation Hubs</span></h1>
            <p class="hero-desc">
                Maxibot provides comprehensive STEAM robotics laboratory setups, step-by-step teacher training, and hardware kits tailored for Sri Lankan educational environments.
            </p>
            <a href="#consultation" class="btn btn-primary">Book Consultation <i class="fa-solid fa-calendar-check"></i></a>
        </div>
        <div style="font-size: 120px; text-align: center; color: var(--primary); opacity: 0.8;">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
    </div>
</section>

<!-- Section: School Labs -->
<section class="section-padding" id="school-labs" style="background-color: #fff;">
    <div class="container spotlight-grid">
        <div class="spotlight-img">
            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); width: 100%; height: 350px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 80px;">
                <i class="fa-solid fa-cubes-stacked"></i>
            </div>
        </div>
        <div class="spotlight-content">
            <span class="spotlight-pre">Robotics Lab Packages</span>
            <h2 class="spotlight-title">School STEAM Labs</h2>
            <p class="spotlight-text">
                Establish an active, collaborative coding workspace for your students. Our school packages come equipped with organized storage systems, charging hubs, and multiple MaxiBot Starter or Ranger kits to accommodate classes of up to 40 students working in pairs.
            </p>
            <div class="spotlight-features" style="margin-bottom: 24px;">
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Optimized for groups: 10/15/20 robot bundles</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Tough plastic storage crates & battery chargers included</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Step-by-step setup assistance in Gampaha, Colombo & island-wide</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Curriculum & Training -->
<section class="section-padding" id="curriculum" style="background-color: var(--light); border-top: 1px solid var(--border-color);">
    <div class="container spotlight-grid reverse">
        <div class="spotlight-img">
            <div style="background: linear-gradient(135deg, var(--secondary), #047857); width: 100%; height: 350px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 80px;">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
        </div>
        <div class="spotlight-content">
            <span class="spotlight-pre">Academic Syllabus Support</span>
            <h2 class="spotlight-title">Syllabus-Aligned Learning</h2>
            <p class="spotlight-text">
                Don't just buy robots—educate with intent. Our curricula are designed by educational technology experts to align seamlessly with the G.C.E. Advanced Level (A/L) and Ordinary Level (O/L) ICT subjects, introducing logic gates, algorithm diagrams, loops, and microcontrollers practically.
            </p>
            <div class="spotlight-features" style="margin-bottom: 24px;">
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Over 30 structured coding challenge worksheets</span>
                </div>
                <div class="spotlight-feat-item">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Powerpoint teaching slide-decks for classroom display</span>
                </div>
                <div class="spotlight-feat-item" id="teacher-training">
                    <i class="fa-solid fa-circle-check spotlight-feat-icon"></i>
                    <span>Local teacher training seminars with certification</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Inquiry Form -->
<section class="section-padding" id="consultation" style="background-color: #fff; border-top: 1px solid var(--border-color);">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">Schedule a School Demonstration</h2>
            <p class="section-subtitle">Interested in introducing Maxibot to your school or academy? Get in touch with our solutions team for a free demonstration in Sri Lanka.</p>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;" class="contact-form-wrap">
            <h3 class="form-title" style="text-align: center;"><i class="fa-solid fa-envelope-open-text" style="color: var(--primary);"></i> Request a Custom Quote</h3>
            
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you! Your school inquiry has been sent successfully. Our team will contact you within 24 hours.'); this.reset();">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Contact Name *</label>
                        <input type="text" placeholder="e.g. Mr. Alwis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Institution / School Name *</label>
                        <input type="text" placeholder="e.g. Ragama ICT Academy" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="tel" placeholder="e.g. +94 77 123 4567" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" placeholder="e.g. info@yourschool.com" class="form-control" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Estimated Student Group Size</label>
                        <select class="form-control">
                            <option>Under 20 students</option>
                            <option>20 - 50 students</option>
                            <option>50 - 100 students</option>
                            <option>100+ students</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">How can we help you? *</label>
                        <textarea placeholder="Describe your school's current computer/IT labs and what kits you are interested in..." class="form-control" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">Submit Consultation Request</button>
            </form>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
