<?php
// Maxibot MySQL Database Connection & Initialization Helper

// Simple helper to load environment variables from .env file
if (!function_exists('load_env_file')) {
    function load_env_file($path) {
        if (!file_exists($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);
                // Remove surrounding quotes
                $val = trim($val, '"\'');
                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv("$key=$val");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
    }
}

// Load env configurations
load_env_file(dirname(__DIR__) . '/.env');

$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_port = getenv('DB_PORT') ?: '3306';
$db_name = getenv('DB_DATABASE') ?: 'maxibot';
$db_user = getenv('DB_USERNAME') ?: 'root';
$db_pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';

try {
    // 1. Connect to MySQL without a database selected first
    $dsn = "mysql:host=$db_host;port=$db_port;charset=utf8mb4";
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // 2. Auto-create database if not exists
    $db->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // 3. Switch to database
    $db->exec("USE `$db_name`");
    
    // 4. Create Tables using MySQL Syntax
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) DEFAULT 'admin'
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS settings (
        `key` VARCHAR(255) PRIMARY KEY,
        value TEXT
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS navigation (
        id INT AUTO_INCREMENT PRIMARY KEY,
        label VARCHAR(255) NOT NULL,
        url VARCHAR(255) NOT NULL,
        sort_order INT DEFAULT 0
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        text TEXT NOT NULL,
        name VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL,
        avatar VARCHAR(10) NOT NULL
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(100) NOT NULL,
        section VARCHAR(100) NOT NULL,
        block_key VARCHAR(255) UNIQUE NOT NULL,
        block_value TEXT
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        category_name VARCHAR(150) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        rating DECIMAL(3,2) NOT NULL,
        reviews INT NOT NULL,
        image VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL,
        full_desc TEXT NOT NULL,
        specs TEXT NOT NULL,
        age VARCHAR(50) NOT NULL,
        in_stock TINYINT DEFAULT 1,
        is_featured TINYINT DEFAULT 0
    ) ENGINE=InnoDB");

    $db->exec("CREATE TABLE IF NOT EXISTS homepage_sections (
        section_id VARCHAR(100) PRIMARY KEY,
        title VARCHAR(255),
        subtitle VARCHAR(255),
        description TEXT,
        image VARCHAR(255),
        btn_text VARCHAR(255),
        btn_url VARCHAR(255),
        is_active TINYINT DEFAULT 1
    ) ENGINE=InnoDB");

    // 5. Seed default administrator if empty
    $user_check = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($user_check == 0) {
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
    }

    // 6. Seed default settings if empty
    $settings_check = $db->query("SELECT COUNT(*) FROM settings")->fetchColumn();
    if ($settings_check == 0) {
        $default_settings = [
            'promo_bar_text' => 'Free delivery across Sri Lanka for orders above LKR 10,000!',
            'logo_text' => 'MaxiBot',
            'footer_desc' => 'Maxibot is dedicated to expanding STEAM and robotics education in Sri Lanka, equipping future-ready makers with premium parts and toys.',
            'contact_address_ragama' => "No. 559/6, Kandaliyaddapaluwa,\nRagama, Sri Lanka.",
            'contact_phone_ragama' => '+94 762 012 900',
            'contact_address_kotikawatta' => "236/2B, TC Road,\nKotikawatta, Sri Lanka.",
            'contact_phone_kotikawatta' => '+94 11-419-3515',
            'contact_email_general' => 'info@maxibot.lk',
            'contact_email_sales' => 'sales@maxibot.lk',
            'operating_hours' => 'Monday - Saturday: 8:30 AM to 6:30 PM (Closed on Sundays & Poya Days)'
        ];
        
        $stmt = $db->prepare("INSERT INTO settings (`key`, value) VALUES (?, ?)");
        foreach ($default_settings as $k => $v) {
            $stmt->execute([$k, $v]);
        }
    }

    // 7. Seed default navigation if empty
    $nav_check = $db->query("SELECT COUNT(*) FROM navigation")->fetchColumn();
    if ($nav_check == 0) {
        $default_nav = [
            ['label' => 'Products', 'url' => 'products.php', 'sort_order' => 1],
            ['label' => 'Solutions', 'url' => 'solutions.php', 'sort_order' => 2],
            ['label' => 'Software & Code', 'url' => 'software.php', 'sort_order' => 3],
            ['label' => 'About Us', 'url' => 'about.php', 'sort_order' => 4],
            ['label' => 'Contact', 'url' => 'contact.php', 'sort_order' => 5]
        ];
        
        $stmt = $db->prepare("INSERT INTO navigation (label, url, sort_order) VALUES (?, ?, ?)");
        foreach ($default_nav as $n) {
            $stmt->execute([$n['label'], $n['url'], $n['sort_order']]);
        }
    }

    // 8. Seed default testimonials if empty
    $test_check = $db->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
    if ($test_check == 0) {
        $default_testimonials = [
            [
                'text' => 'Setting up the robotics lab at our school was effortless with Maxibot. The Starter Kit is incredibly durable, and our students were programming obstacle avoidance on day one.',
                'name' => 'Mrs. K. Jayawardena',
                'role' => 'ICT Headmistress, Colombo school',
                'avatar' => 'K'
            ],
            [
                'text' => "My 9-year-old son spends hours building and tweaking his MaxiBot. It's the best educational gift we have got him. The Scratch software makes logic easy to absorb.",
                'name' => 'Dr. M. Perera',
                'role' => 'Parent & Engineering Professor',
                'avatar' => 'M'
            ],
            [
                'text' => 'As an electronic enthusiast, Maxibot is my primary supplier in Sri Lanka. Fast local shipping and authentic components like the ESP32 make prototyping a breeze.',
                'name' => 'Shanaka Alwis',
                'role' => 'Robotics Hobbyist & DIY Maker',
                'avatar' => 'S'
            ]
        ];
        
        $stmt = $db->prepare("INSERT INTO testimonials (text, name, role, avatar) VALUES (?, ?, ?, ?)");
        foreach ($default_testimonials as $t) {
            $stmt->execute([$t['text'], $t['name'], $t['role'], $t['avatar']]);
        }
    }

    // 9. Seed default pages if empty
    $pages_check = $db->query("SELECT COUNT(*) FROM pages")->fetchColumn();
    if ($pages_check == 0) {
        $default_pages = [
            ['slug' => 'home', 'section' => 'hero', 'block_key' => 'home_hero_title', 'block_value' => 'Unlock the Power of <span>Robotics & Coding</span>'],
            ['slug' => 'home', 'section' => 'hero', 'block_key' => 'home_hero_subtitle', 'block_value' => "From screen-free logical coding toys to advanced metal-build programmable robots, Maxibot inspires Sri Lanka's young minds to create, program, and innovate."],
            ['slug' => 'solutions', 'section' => 'hero', 'block_key' => 'sol_hero_title', 'block_value' => 'Transform Classrooms Into <span>Innovation Hubs</span>'],
            ['slug' => 'solutions', 'section' => 'hero', 'block_key' => 'sol_hero_subtitle', 'block_value' => 'Maxibot provides comprehensive STEAM robotics laboratory setups, step-by-step teacher training, and hardware kits tailored for Sri Lankan educational environments.'],
            ['slug' => 'about', 'section' => 'hero', 'block_key' => 'about_hero_title', 'block_value' => 'Our Story & Mission'],
            ['slug' => 'about', 'section' => 'hero', 'block_key' => 'about_hero_subtitle', 'block_value' => 'Maxibot has been operating for over five years, dedicated to igniting creativity, critical thinking, and innovation in the next generation of creators in Sri Lanka.'],
            ['slug' => 'about', 'section' => 'story', 'block_key' => 'about_story_title', 'block_value' => 'Why Maxibot was Founded'],
            ['slug' => 'about', 'section' => 'story', 'block_key' => 'about_story_content', 'block_value' => "<p>In a rapidly evolving technological landscape, memorizing textbook facts is no longer enough. The future belongs to critical thinkers and creators. Maxibot was founded to bridge the gap between abstract academic theories and hands-on electrical and mechanical construction.</p>\n<p>By providing affordable, easy-to-use microcontrollers, detailed sensors, robotic chassis, and logical gaming puzzles, we empower parents, classrooms, and teachers to deliver premium STEAM (Science, Technology, Engineering, Arts, and Mathematics) education locally, without high import costs.</p>"],
            ['slug' => 'about', 'section' => 'refund', 'block_key' => 'about_refund_content', 'block_value' => "<p>We want you to build with complete confidence. Maxibot offers a comprehensive return policy for all our electronic components, kits, and educational toys:</p>\n<ul style=\"display: flex; flex-direction: column; gap: 16px; font-size: 14px; line-height: 1.6; margin-bottom: 24px; padding-left: 0;\">\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-circle-exclamation\" style=\"color: #ef4444; font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Defective Products:</strong> If an electronic board or sensor fails to function out of the box, you must notify us within <strong>48 hours</strong> of delivery. Contact our sales department at sales@maxibot.lk to organize a replacement.</div></li>\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-clock\" style=\"color: var(--secondary); font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Change of Mind:</strong> Sealed, unopened, and resellable kits can be returned within <strong>14 days</strong> of purchase. Note that high-value microelectronic microchips or developer boards may be subject to a restocking fee if opened.</div></li>\n<li style=\"display: flex; gap: 12px; align-items: flex-start;\"><i class=\"fa-solid fa-receipt\" style=\"color: var(--dark); font-size: 16px; margin-top: 3px; flex-shrink: 0;\"></i>\n<div><strong>Original Invoice:</strong> A proof of purchase or original cash register receipt is required for all refund and warranty requests.</div></li>\n</ul>\n<p style=\"font-size: 13px; color: var(--text-muted); font-style: italic;\">For general support queries regarding assembly, programming codes, or deliveries, contact us directly at info@maxibot.lk.</p>"]
        ];
        
        $stmt = $db->prepare("INSERT INTO pages (slug, section, block_key, block_value) VALUES (?, ?, ?, ?)");
        foreach ($default_pages as $p) {
            $stmt->execute([$p['slug'], $p['section'], $p['block_key'], $p['block_value']]);
        }
    }

    // 10. Seed default products if empty
    $prod_check = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($prod_check == 0) {
        $default_products = [
            [
                'name' => 'MaxiBot Starter DIY Robot Kit',
                'category' => 'steam-kits',
                'category_name' => 'STEAM & Robotics Kits',
                'price' => 12500,
                'rating' => 4.8,
                'reviews' => 42,
                'image' => 'images/maxibot_starter.png',
                'description' => 'The perfect entry-level programming robot for kids. Easy to assemble, block-based coding, and hours of educational play.',
                'full_desc' => 'The MaxiBot Starter DIY Robot Kit is the ultimate educational playmate for beginners curious about coding and robotics. Structured with high-grade anodized aluminum parts, it is sturdy and safe. Students will learn the fundamentals of electronics, mechanics, and scratch programming as they assemble the robot and bring it to life.',
                'specs' => json_encode([
                    'Main Controller' => 'MaxiCore Uno (Arduino Compatible)',
                    'Programming Software' => 'MaxiCode (Block-based / Scratch 3.0)',
                    'Connectivity' => 'Bluetooth 4.0 / USB',
                    'Power Supply' => '6 x AA Batteries (not included) or 3.7V LiPo',
                    'Recommended Age' => '6 - 12 Years',
                    'Package Contents' => 'Aluminum chassis, MaxiCore board, ultrasonic sensor, line follower, 2 x motors, Bluetooth module, tools, instruction manual'
                ]),
                'age' => 'Ages 6-12',
                'in_stock' => 1,
                'is_featured' => 1
            ],
            [
                'name' => 'MaxiBot Ranger 3-in-1 Robot Kit',
                'category' => 'steam-kits',
                'category_name' => 'STEAM & Robotics Kits',
                'price' => 24000,
                'rating' => 4.9,
                'reviews' => 28,
                'image' => 'images/maxibot_ranger.png',
                'description' => 'An advanced three-in-one robot kit supporting tank, self-balancing, and racing configurations. Programmable in Scratch and Python.',
                'full_desc' => 'Take robotics to the next level with the MaxiBot Ranger. Build three different designs: a rugged Off-Road Land Raider (tank), a self-balancing Dashing Raptor, and an agile Nervous Bird. Supported by powerful smart motors and rich sensors, it is ready for advanced coding challenges and python scripting.',
                'specs' => json_encode([
                    'Main Controller' => 'MaxiCore Mega2560',
                    'Programming Software' => 'MaxiCode (Scratch / Python)',
                    'Connectivity' => 'Bluetooth / USB',
                    'Motors' => '2 x Encoder Motors (high torque)',
                    'Sensors' => 'Ultrasonic, Line Follower, Gyroscope/Accelerometer, Sound Sensor',
                    'Recommended Age' => '10 Years +'
                ]),
                'age' => 'Ages 10+',
                'in_stock' => 1,
                'is_featured' => 1
            ],
            [
                'name' => 'MaxiBot Smart Home IoT Kit',
                'category' => 'steam-kits',
                'category_name' => 'STEAM & Robotics Kits',
                'price' => 18500,
                'rating' => 4.7,
                'reviews' => 19,
                'image' => 'images/maxibot_smarthome.svg',
                'description' => 'Learn home automation and IoT. Connect sensors, control fans and lights, and display readings on an LCD screen.',
                'full_desc' => 'Build and program your own miniature smart house! This kit includes a wooden smart house model and an array of components to simulate temperature control, smart door locks, automated lighting, and rain detection. Connect it to the web and control it using your phone.',
                'specs' => json_encode([
                    'Main Controller' => 'ESP32 NodeMCU Smart Board',
                    'Programming Software' => 'Arduino IDE / MaxiCode Web',
                    'Connectivity' => 'Wi-Fi 802.11 b/g/n & Bluetooth',
                    'Modules Included' => '1602 LCD, DHT11 Temp/Humidity, Servo Motor, Relay Module, Rain Sensor, Soil Moisture, LDR light sensor, Gas Sensor',
                    'Recommended Age' => '12 Years +'
                ]),
                'age' => 'Ages 12+',
                'in_stock' => 1,
                'is_featured' => 0
            ],
            [
                'name' => 'Maxicore Uno R3 Microcontroller Board',
                'category' => 'electronics',
                'category_name' => 'Electronic Components',
                'price' => 2400,
                'rating' => 4.6,
                'reviews' => 110,
                'image' => 'images/maxicore_uno.svg',
                'description' => 'Genuine compatible Uno R3 microcontroller board. Perfect for DIY electronics, Arduino projects, and education.',
                'full_desc' => 'The MaxiCore Uno R3 is a fully compatible Arduino board designed to provide a reliable, low-cost microprocessing tool for classrooms, hobbyists, and professional prototyping. Built with high-quality circuit prints and standard headers.',
                'specs' => json_encode([
                    'Microcontroller' => 'ATmega328P',
                    'Operating Voltage' => '5V',
                    'Input Voltage' => '7-12V (recommended)',
                    'Digital I/O Pins' => '14 (6 provide PWM output)',
                    'Analog Input Pins' => '6',
                    'Flash Memory' => '32 KB (ATmega328P)'
                ]),
                'age' => 'All Ages',
                'in_stock' => 1,
                'is_featured' => 1
            ],
            [
                'name' => 'ESP32 NodeMCU Wi-Fi + Bluetooth Module',
                'category' => 'electronics',
                'category_name' => 'Electronic Components',
                'price' => 1800,
                'rating' => 4.8,
                'reviews' => 74,
                'image' => 'images/esp32_module.svg',
                'description' => 'Powerful development board with built-in Wi-Fi and Bluetooth. The standard engine for modern IoT and smart projects.',
                'full_desc' => 'The ESP32 is a feature-rich MCU board with integrated Wi-Fi and Bluetooth connectivity, designed for high-performance Internet of Things (IoT) applications. Features ultra-low power consumption and multiple peripheral interfaces.',
                'specs' => json_encode([
                    'Processor' => 'Tensilica Xtensa Dual-Core 32-bit LX6',
                    'Wi-Fi' => '802.11 b/g/n (up to 150 Mbps)',
                    'Bluetooth' => 'v4.2 BR/EDR and BLE specifications',
                    'SRAM' => '520 KB',
                    'Pins' => '38-pin layout'
                ]),
                'age' => 'Ages 12+',
                'in_stock' => 1,
                'is_featured' => 0
            ],
            [
                'name' => 'HC-SR04 Ultrasonic Distance Sensor',
                'category' => 'electronics',
                'category_name' => 'Electronic Components',
                'price' => 450,
                'rating' => 4.5,
                'reviews' => 150,
                'image' => 'images/ultrasonic_sensor.svg',
                'description' => 'Precision ultrasonic ranging sensor. Ideal for robotic obstacle avoidance and distance measurement experiments.',
                'full_desc' => 'The HC-SR04 ultrasonic sensor uses sonar to determine distance to an object. It offers excellent non-contact range detection with high accuracy and stable readings from 2cm to 400cm.',
                'specs' => json_encode([
                    'Power Supply' => '5V DC',
                    'Quiescent Current' => '< 2mA',
                    'Effectual Angle' => '< 15°',
                    'Ranging Distance' => '2cm - 400cm',
                    'Resolution' => '0.3 cm'
                ]),
                'age' => 'All Ages',
                'in_stock' => 1,
                'is_featured' => 0
            ],
            [
                'name' => 'L298N Dual H-Bridge Motor Driver',
                'category' => 'electronics',
                'category_name' => 'Electronic Components',
                'price' => 650,
                'rating' => 4.4,
                'reviews' => 88,
                'image' => 'images/motor_driver.svg',
                'description' => 'High-power dual DC motor controller module. Drives two DC motors or one stepper motor with ease.',
                'full_desc' => 'The L298N motor driver module allows you to control the speed and direction of two DC motors, or control one bipolar stepper motor. Perfect for wheel-drive mobile robots.',
                'specs' => json_encode([
                    'Driver Chip' => 'L298N dual H-bridge driver chip',
                    'Drive Terminal Power Supply' => '+5V to +35V',
                    'Peak Drive Current' => '2A per bridge',
                    'Control Signal Input Voltage' => 'Low: -0.3V to 1.5V, High: 2.3V to Vss',
                    'Board Size' => '43mm x 43mm x 27mm'
                ]),
                'age' => 'All Ages',
                'in_stock' => 1,
                'is_featured' => 0
            ],
            [
                'name' => '3D Wooden Robotic Arm Puzzle',
                'category' => 'puzzles',
                'category_name' => 'Educational Toys',
                'price' => 4500,
                'rating' => 4.7,
                'reviews' => 31,
                'image' => 'images/robotic_arm_puzzle.svg',
                'description' => 'Assemble a functional mechanical arm. Teaches gears, pulleys, and mechanical principles. No glue required.',
                'full_desc' => 'This 3D wooden puzzle allows kids and hobbyists to construct a fully mechanical, operational robotic arm using laser-cut plywood pieces. Using hydraulic syringes or geared mechanisms, the arm rotates and grips items.',
                'specs' => json_encode([
                    'Material' => 'Natural Laser-cut Plywood',
                    'Number of Pieces' => '138 pieces',
                    'Assembly Time' => '2 - 3 Hours',
                    'Dimensions' => '280mm x 150mm x 200mm',
                    'Glue Required' => 'No (interlocking joints)'
                ]),
                'age' => 'Ages 8+',
                'in_stock' => 1,
                'is_featured' => 1
            ],
            [
                'name' => 'Gravity Maze Marble Run Logic Game',
                'category' => 'puzzles',
                'category_name' => 'Educational Toys',
                'price' => 3800,
                'rating' => 4.8,
                'reviews' => 22,
                'image' => 'images/gravity_maze.svg',
                'description' => 'A gravity-powered logic maze that challenges minds. Includes 60 challenge cards from beginner to expert.',
                'full_desc' => 'Gravity Maze is a logic game, marble run, and STEM toy all rolled into one. It contains 60 challenges of increasing difficulty. Players arrange translucent towers to guide marbles from start to target, strengthening critical thinking.',
                'specs' => json_encode([
                    'Target Learning' => 'Spatial Reasoning, Logic Planning, Problem Solving',
                    'Included Parts' => '1 Game Grid, 10 Gravity Maze Towers, 3 Marbles, 60 Challenge Cards',
                    'Recommended Age' => '8 Years +'
                ]),
                'age' => 'Ages 8+',
                'in_stock' => 0,
                'is_featured' => 0
            ],
            [
                'name' => 'Solderless Breadboard - 830 Points',
                'category' => 'tools',
                'category_name' => 'Tools & Prototyping',
                'price' => 600,
                'rating' => 4.5,
                'reviews' => 195,
                'image' => 'images/breadboard.svg',
                'description' => 'Full-size solderless breadboard for electronic circuits. Standard 0.1 inch hole pitch with adhesive back.',
                'full_desc' => 'This is a premium full-size solderless breadboard with 830 connection points, two power rails, and a standard grid layout. Ideal for prototyping circuits before permanent soldering.',
                'specs' => json_encode([
                    'Tie Points' => '830 points (630 tie points in terminal strip, 200 in distribution strips)',
                    'Dimensions' => '16.5cm x 5.5cm',
                    'Pitch' => '2.54mm (0.1 inch)',
                    'Material' => 'ABS Plastic, Nickel plated phosphor bronze contacts'
                ]),
                'age' => 'All Ages',
                'in_stock' => 1,
                'is_featured' => 0
            ],
            [
                'name' => 'Premium Jumper Wire Ribbon (40-Pin)',
                'category' => 'tools',
                'category_name' => 'Tools & Prototyping',
                'price' => 350,
                'rating' => 4.6,
                'reviews' => 240,
                'image' => 'images/jumper_wires.svg',
                'description' => 'Multi-colored 40-pin flexible jumper wire ribbon. Selectable male-to-male or male-to-female contacts.',
                'full_desc' => 'These 20cm long jumper wires are perfect for breadboard connections and microcontrollers. They can be split into individual wires or kept as a ribbon. High-quality pins ensure secure electrical contact.',
                'specs' => json_encode([
                    'Count' => '40 wires per ribbon',
                    'Length' => '20 cm',
                    'Connectors' => 'Male to Male (also available in Female-to-Female and Make-to-Female)',
                    'Conductors' => 'Standard copper-clad aluminum wires'
                ]),
                'age' => 'All Ages',
                'in_stock' => 1,
                'is_featured' => 0
            ]
        ];
        
        $stmt = $db->prepare("INSERT INTO products (name, category, category_name, price, rating, reviews, image, description, full_desc, specs, age, in_stock, is_featured) VALUES (:name, :category, :category_name, :price, :rating, :reviews, :image, :description, :full_desc, :specs, :age, :in_stock, :is_featured)");
        foreach ($default_products as $p) {
            $stmt->execute($p);
        }
    }

    // 11. Seed default homepage sections if empty
    $home_check = $db->query("SELECT COUNT(*) FROM homepage_sections")->fetchColumn();
    if ($home_check == 0) {
        $default_home_sections = [
            [
                'section_id' => 'hero',
                'title' => 'Unlock the Power of <span>Robotics & Coding</span>',
                'subtitle' => 'STEAM Learning 2026',
                'description' => "From screen-free logical coding toys to advanced metal-build programmable robots, Maxibot inspires Sri Lanka's young minds to create, program, and innovate.",
                'image' => 'images/maxibot_starter.png',
                'btn_text' => 'Explore Products',
                'btn_url' => 'products.php',
                'is_active' => 1
            ],
            [
                'section_id' => 'categories',
                'title' => 'Fueling curiosity at every step',
                'subtitle' => '',
                'description' => 'We categorize our resources to support a progressive STEAM learning journey, serving schools, hobbyists, and young creators.',
                'image' => '',
                'btn_text' => '',
                'btn_url' => '',
                'is_active' => 1
            ],
            [
                'section_id' => 'spotlight1',
                'title' => 'MaxiBot Starter DIY Robot Kit',
                'subtitle' => 'Flagship Robot Kit',
                'description' => 'The perfect gateway to logical thinking and electronic engineering. MaxiBot Starter provides kids with an interactive hands-on experience of building a robot from scratch. Using high-quality aluminum chassis and block-based programming, coding becomes a fun, play-driven activity.',
                'image' => 'images/maxibot_starter.png',
                'btn_text' => 'Buy Now (LKR 12,500)',
                'btn_url' => 'product-detail.php?id=1',
                'is_active' => 1
            ],
            [
                'section_id' => 'spotlight2',
                'title' => 'MaxiBot Ranger Kit',
                'subtitle' => 'Advanced 3-in-1 Robotics',
                'description' => 'Ranger integrates three unique configurations: a high-speed tracked tank, a two-wheeled self-balancing raptor, and a three-wheeled racing car. Geared with advanced encoder motors, light sensors, and gyro stabilization, it enables students to delve deep into robot kinematics and code in Python.',
                'image' => 'images/maxibot_ranger.png',
                'btn_text' => 'Shop Ranger (LKR 24,000)',
                'btn_url' => 'product-detail.php?id=2',
                'is_active' => 1
            ],
            [
                'section_id' => 'software',
                'title' => 'MaxiCode Programming Software',
                'subtitle' => 'Coding Environment',
                'description' => 'MaxiCode makes coding intuitive. Based on Scratch 3.0 block-coding, beginners can drag and drop logic blocks to control motors, read sensor outputs, and play sounds. When ready, switch to Python mode to see your code translated side-by-side!',
                'image' => '',
                'btn_text' => 'Download Software',
                'btn_url' => 'software.php',
                'is_active' => 1
            ],
            [
                'section_id' => 'solutions',
                'title' => 'Empowering Classrooms in Sri Lanka',
                'subtitle' => '',
                'description' => 'We partner with schools to establish future-ready makerspaces and code laboratories.',
                'image' => '',
                'btn_text' => '',
                'btn_url' => '',
                'is_active' => 1
            ],
            [
                'section_id' => 'testimonials',
                'title' => 'Loved by Teachers and Parents',
                'subtitle' => '',
                'description' => 'See how Maxibot products are transforming STEAM learning in Sri Lanka.',
                'image' => '',
                'btn_text' => '',
                'btn_url' => '',
                'is_active' => 1
            ]
        ];
        
        $stmt = $db->prepare("INSERT INTO homepage_sections (section_id, title, subtitle, description, image, btn_text, btn_url, is_active) VALUES (:section_id, :title, :subtitle, :description, :image, :btn_text, :btn_url, :is_active)");
        foreach ($default_home_sections as $s) {
            $stmt->bindValue(':section_id', $s['section_id'], PDO::PARAM_STR);
            $stmt->bindValue(':title', $s['title'], PDO::PARAM_STR);
            $stmt->bindValue(':subtitle', $s['subtitle'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $s['description'], PDO::PARAM_STR);
            $stmt->bindValue(':image', $s['image'], PDO::PARAM_STR);
            $stmt->bindValue(':btn_text', $s['btn_text'], PDO::PARAM_STR);
            $stmt->bindValue(':btn_url', $s['btn_url'], PDO::PARAM_STR);
            $stmt->bindValue(':is_active', $s['is_active'], PDO::PARAM_INT);
            $stmt->execute();
        }
    }

} catch (PDOException $e) {
    die("Database initialization error: " . $e->getMessage());
}

// Global Helper function to retrieve a specific setting
if (!function_exists('get_setting')) {
    function get_setting($key, $default = '') {
        global $db;
        try {
            $stmt = $db->prepare("SELECT value FROM settings WHERE `key` = ?");
            $stmt->execute([$key]);
            $val = $stmt->fetchColumn();
            return $val !== false ? $val : $default;
        } catch (Exception $e) {
            return $default;
        }
    }
}

// Global Helper function to retrieve a specific page block text
if (!function_exists('get_page_block')) {
    function get_page_block($key, $default = '') {
        global $db;
        try {
            $stmt = $db->prepare("SELECT block_value FROM pages WHERE block_key = ?");
            $stmt->execute([$key]);
            $val = $stmt->fetchColumn();
            return $val !== false ? $val : $default;
        } catch (Exception $e) {
            return $default;
        }
    }
}
?>
