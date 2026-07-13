<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . " | Maxibot Sri Lanka" : "Maxibot | STEAM Education & Robotics Sri Lanka"; ?></title>
    <meta name="description" content="Empowering the next generation of innovators in Sri Lanka with high-quality STEAM robotics kits, microcontrollers, electronic sensors, and creative educational toys.">
    <link rel="stylesheet" href="css/style.css">
    <!-- FontAwesome for UI icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <!-- Top Announcement Bar -->
    <div class="promo-bar">
        Free delivery across Sri Lanka for orders above LKR 10,000! 
        <a href="products.php">Shop Catalog <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <!-- Sticky Main Navigation Header -->
    <header class="header-wrapper" id="sticky-header">
        <div class="container header-container">
            <!-- Brand Logo -->
            <a href="index.php" class="logo" id="main-logo-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 50" width="160" height="40" aria-label="Maxibot Logo">
                    <rect x="5" y="10" width="30" height="30" rx="6" fill="#6568FE" />
                    <rect x="11" y="16" width="18" height="12" rx="3" fill="#029BA5" />
                    <circle cx="16" cy="22" r="2.2" fill="#FFF" />
                    <circle cx="24" cy="22" r="2.2" fill="#FFF" />
                    <line x1="20" y1="5" x2="20" y2="10" stroke="#6568FE" stroke-width="3" stroke-linecap="round" />
                    <circle cx="20" cy="4" r="2" fill="#029BA5" />
                    <text x="45" y="33" font-family="'Outfit', sans-serif" font-size="22" font-weight="800" fill="#111827">Maxi<tspan fill="#029BA5">Bot</tspan></text>
                </svg>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="nav-menu" id="primary-navigation" role="navigation">
                <!-- Products Menu Item -->
                <div class="nav-item <?php echo (isset($active_nav) && $active_nav == 'products') ? 'active' : ''; ?>">
                    <a href="products.php" class="nav-link">Products <i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></a>
                    <!-- Mega Dropdown Menu -->
                    <div class="dropdown-menu">
                        <div>
                            <div class="dropdown-col-title">STEAM Kits</div>
                            <div class="dropdown-list">
                                <a href="products.php?cat=steam-kits" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-robot"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">STEAM & Robotics Kits</span>
                                        <span class="dropdown-desc">Interactive building & programming kits</span>
                                    </div>
                                </a>
                                <a href="products.php?cat=puzzles" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-puzzle-piece"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">Educational Toys</span>
                                        <span class="dropdown-desc">Logic games, 3D puzzles & STEM toys</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown-col-title">Electronics & Tools</div>
                            <div class="dropdown-list">
                                <a href="products.php?cat=electronics" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-microchip"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">Electronic Components</span>
                                        <span class="dropdown-desc">Microcontrollers, sensors & actuators</span>
                                    </div>
                                </a>
                                <a href="products.php?cat=tools" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">Tools & Prototyping</span>
                                        <span class="dropdown-desc">Breadboards, wires, and work equipment</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solutions Menu Item -->
                <div class="nav-item <?php echo (isset($active_nav) && $active_nav == 'solutions') ? 'active' : ''; ?>">
                    <a href="solutions.php" class="nav-link">Solutions <i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></a>
                    <div class="dropdown-menu" style="width: 320px; grid-template-columns: 1fr;">
                        <div>
                            <div class="dropdown-col-title">STEAM Education</div>
                            <div class="dropdown-list">
                                <a href="solutions.php#school-labs" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-school"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">For Schools & Labs</span>
                                        <span class="dropdown-desc">Syllabus-aligned robotics labs</span>
                                    </div>
                                </a>
                                <a href="solutions.php#makers" class="dropdown-link">
                                    <div class="dropdown-icon"><i class="fa-solid fa-lightbulb"></i></div>
                                    <div class="dropdown-info">
                                        <span class="dropdown-name">For Makers & Parents</span>
                                        <span class="dropdown-desc">Guided DIY creative learning</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Software Menu Item -->
                <div class="nav-item <?php echo (isset($active_nav) && $active_nav == 'software') ? 'active' : ''; ?>">
                    <a href="software.php" class="nav-link">Software & Code</a>
                </div>

                <!-- About Us Menu Item -->
                <div class="nav-item <?php echo (isset($active_nav) && $active_nav == 'about') ? 'active' : ''; ?>">
                    <a href="about.php" class="nav-link">About Us</a>
                </div>

                <!-- Contact Menu Item -->
                <div class="nav-item <?php echo (isset($active_nav) && $active_nav == 'contact') ? 'active' : ''; ?>">
                    <a href="contact.php" class="nav-link">Contact</a>
                </div>
            </nav>

            <!-- Actions Controls -->
            <div class="header-actions">
                <!-- Search Button -->
                <button class="action-btn" id="search-trigger" aria-label="Open Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                <!-- Cart Button -->
                <a href="cart.php" class="action-btn" id="cart-badge-container" aria-label="Shopping Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count" id="cart-count-badge">0</span>
                </a>
                
                <a href="products.php" class="btn btn-primary btn-sm" id="shop-cta-nav">Buy Now</a>
                <button class="mobile-nav-toggle" id="menu-mobile-open" aria-label="Open Menu"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>

        <!-- Pop-down Search Bar -->
        <div class="search-overlay" id="search-dropdown-overlay">
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for kits, sensors, motors..." class="search-input" id="search-overlay-input">
                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            </form>
        </div>
    </header>

    <!-- Mobile Side Navigation Drawer -->
    <div class="mobile-menu-overlay" id="menu-mobile-overlay"></div>
    <div class="mobile-menu-wrapper" id="menu-mobile-drawer">
        <div class="mobile-menu-header">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 50" width="130" height="36" aria-label="Maxibot Logo">
                    <rect x="5" y="10" width="30" height="30" rx="6" fill="#6568FE" />
                    <rect x="11" y="16" width="18" height="12" rx="3" fill="#029BA5" />
                    <circle cx="16" cy="22" r="2.2" fill="#FFF" />
                    <circle cx="24" cy="22" r="2.2" fill="#FFF" />
                    <line x1="20" y1="5" x2="20" y2="10" stroke="#6568FE" stroke-width="3" stroke-linecap="round" />
                    <circle cx="20" cy="4" r="2" fill="#029BA5" />
                    <text x="45" y="33" font-family="'Outfit', sans-serif" font-size="22" font-weight="800" fill="#111827">Maxi<tspan fill="#029BA5">Bot</tspan></text>
                </svg>
            </div>
            <button class="mobile-menu-close" id="menu-mobile-close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <ul class="mobile-nav-list">
            <li class="mobile-nav-item">
                <a href="products.php" class="mobile-nav-link">Products</a>
                <div class="mobile-submenu">
                    <a href="products.php?cat=steam-kits" class="mobile-submenu-link">• STEAM & Robotics Kits</a>
                    <a href="products.php?cat=electronics" class="mobile-submenu-link">• Electronic Components</a>
                    <a href="products.php?cat=puzzles" class="mobile-submenu-link">• Educational Toys</a>
                    <a href="products.php?cat=tools" class="mobile-submenu-link">• Tools & Prototyping</a>
                </div>
            </li>
            <li class="mobile-nav-item">
                <a href="solutions.php" class="mobile-nav-link">Solutions</a>
                <div class="mobile-submenu">
                    <a href="solutions.php#school-labs" class="mobile-submenu-link">• For Schools & Labs</a>
                    <a href="solutions.php#makers" class="mobile-submenu-link">• For Makers & Parents</a>
                </div>
            </li>
            <li class="mobile-nav-item">
                <a href="software.php" class="mobile-nav-link">Software & Code</a>
            </li>
            <li class="mobile-nav-item">
                <a href="about.php" class="mobile-nav-link">About Us</a>
            </li>
            <li class="mobile-nav-item">
                <a href="contact.php" class="mobile-nav-link">Contact</a>
            </li>
        </ul>
        <div style="margin-top: auto; display: flex; flex-direction: column; gap: 12px;">
            <a href="cart.php" class="btn btn-outline" style="width: 100%;"><i class="fa-solid fa-cart-shopping"></i> Cart Summary</a>
            <a href="products.php" class="btn btn-primary" style="width: 100%;">Shop Now</a>
        </div>
    </div>
