<?php
// Maxibot Product Database Helper

class ProductsDB {
    private static $products = [
        [
            'id' => 1,
            'name' => 'MaxiBot Starter DIY Robot Kit',
            'category' => 'steam-kits',
            'category_name' => 'STEAM & Robotics Kits',
            'price' => 12500,
            'rating' => 4.8,
            'reviews' => 42,
            'image' => 'images/maxibot_starter.png',
            'description' => 'The perfect entry-level programming robot for kids. Easy to assemble, block-based coding, and hours of educational play.',
            'full_desc' => 'The MaxiBot Starter DIY Robot Kit is the ultimate educational playmate for beginners curious about coding and robotics. Structured with high-grade anodized aluminum parts, it is sturdy and safe. Students will learn the fundamentals of electronics, mechanics, and scratch programming as they assemble the robot and bring it to life.',
            'specs' => [
                'Main Controller' => 'MaxiCore Uno (Arduino Compatible)',
                'Programming Software' => 'MaxiCode (Block-based / Scratch 3.0)',
                'Connectivity' => 'Bluetooth 4.0 / USB',
                'Power Supply' => '6 x AA Batteries (not included) or 3.7V LiPo',
                'Recommended Age' => '6 - 12 Years',
                'Package Contents' => 'Aluminum chassis, MaxiCore board, ultrasonic sensor, line follower, 2 x motors, Bluetooth module, tools, instruction manual'
            ],
            'age' => 'Ages 6-12',
            'in_stock' => true,
            'is_featured' => true
        ],
        [
            'id' => 2,
            'name' => 'MaxiBot Ranger 3-in-1 Robot Kit',
            'category' => 'steam-kits',
            'category_name' => 'STEAM & Robotics Kits',
            'price' => 24000,
            'rating' => 4.9,
            'reviews' => 28,
            'image' => 'images/maxibot_ranger.png',
            'description' => 'An advanced three-in-one robot kit supporting tank, self-balancing, and racing configurations. Programmable in Scratch and Python.',
            'full_desc' => 'Take robotics to the next level with the MaxiBot Ranger. Build three different designs: a rugged Off-Road Land Raider (tank), a self-balancing Dashing Raptor, and an agile Nervous Bird. Supported by powerful smart motors and rich sensors, it is ready for advanced coding challenges and python scripting.',
            'specs' => [
                'Main Controller' => 'MaxiCore Mega2560',
                'Programming Software' => 'MaxiCode (Scratch / Python)',
                'Connectivity' => 'Bluetooth / USB',
                'Motors' => '2 x Encoder Motors (high torque)',
                'Sensors' => 'Ultrasonic, Line Follower, Gyroscope/Accelerometer, Sound Sensor',
                'Recommended Age' => '10 Years +'
            ],
            'age' => 'Ages 10+',
            'in_stock' => true,
            'is_featured' => true
        ],
        [
            'id' => 3,
            'name' => 'MaxiBot Smart Home IoT Kit',
            'category' => 'steam-kits',
            'category_name' => 'STEAM & Robotics Kits',
            'price' => 18500,
            'rating' => 4.7,
            'reviews' => 19,
            'image' => 'images/maxibot_smarthome.svg',
            'description' => 'Learn home automation and IoT. Connect sensors, control fans and lights, and display readings on an LCD screen.',
            'full_desc' => 'Build and program your own miniature smart house! This kit includes a wooden smart house model and an array of components to simulate temperature control, smart door locks, automated lighting, and rain detection. Connect it to the web and control it using your phone.',
            'specs' => [
                'Main Controller' => 'ESP32 NodeMCU Smart Board',
                'Programming Software' => 'Arduino IDE / MaxiCode Web',
                'Connectivity' => 'Wi-Fi 802.11 b/g/n & Bluetooth',
                'Modules Included' => '1602 LCD, DHT11 Temp/Humidity, Servo Motor, Relay Module, Rain Sensor, Soil Moisture, LDR light sensor, Gas Sensor',
                'Recommended Age' => '12 Years +'
            ],
            'age' => 'Ages 12+',
            'in_stock' => true,
            'is_featured' => false
        ],
        [
            'id' => 4,
            'name' => 'MaxiCore Uno R3 Microcontroller Board',
            'category' => 'electronics',
            'category_name' => 'Electronic Components',
            'price' => 2400,
            'rating' => 4.6,
            'reviews' => 110,
            'image' => 'images/maxicore_uno.svg',
            'description' => 'Genuine compatible Uno R3 microcontroller board. Perfect for DIY electronics, Arduino projects, and education.',
            'full_desc' => 'The MaxiCore Uno R3 is a fully compatible Arduino board designed to provide a reliable, low-cost microprocessing tool for classrooms, hobbyists, and professional prototyping. Built with high-quality circuit prints and standard headers.',
            'specs' => [
                'Microcontroller' => 'ATmega328P',
                'Operating Voltage' => '5V',
                'Input Voltage' => '7-12V (recommended)',
                'Digital I/O Pins' => '14 (6 provide PWM output)',
                'Analog Input Pins' => '6',
                'Flash Memory' => '32 KB (ATmega328P)'
            ],
            'age' => 'All Ages',
            'in_stock' => true,
            'is_featured' => true
        ],
        [
            'id' => 5,
            'name' => 'ESP32 NodeMCU Wi-Fi + Bluetooth Module',
            'category' => 'electronics',
            'category_name' => 'Electronic Components',
            'price' => 1800,
            'rating' => 4.8,
            'reviews' => 74,
            'image' => 'images/esp32_module.svg',
            'description' => 'Powerful development board with built-in Wi-Fi and Bluetooth. The standard engine for modern IoT and smart projects.',
            'full_desc' => 'The ESP32 is a feature-rich MCU board with integrated Wi-Fi and Bluetooth connectivity, designed for high-performance Internet of Things (IoT) applications. Features ultra-low power consumption and multiple peripheral interfaces.',
            'specs' => [
                'Processor' => 'Tensilica Xtensa Dual-Core 32-bit LX6',
                'Wi-Fi' => '802.11 b/g/n (up to 150 Mbps)',
                'Bluetooth' => 'v4.2 BR/EDR and BLE specifications',
                'SRAM' => '520 KB',
                'Pins' => '38-pin layout'
            ],
            'age' => 'Ages 12+',
            'in_stock' => true,
            'is_featured' => false
        ],
        [
            'id' => 6,
            'name' => 'HC-SR04 Ultrasonic Distance Sensor',
            'category' => 'electronics',
            'category_name' => 'Electronic Components',
            'price' => 450,
            'rating' => 4.5,
            'reviews' => 150,
            'image' => 'images/ultrasonic_sensor.svg',
            'description' => 'Precision ultrasonic ranging sensor. Ideal for robotic obstacle avoidance and distance measurement experiments.',
            'full_desc' => 'The HC-SR04 ultrasonic sensor uses sonar to determine distance to an object. It offers excellent non-contact range detection with high accuracy and stable readings from 2cm to 400cm.',
            'specs' => [
                'Power Supply' => '5V DC',
                'Quiescent Current' => '< 2mA',
                'Effectual Angle' => '< 15°',
                'Ranging Distance' => '2cm - 400cm',
                'Resolution' => '0.3 cm'
            ],
            'age' => 'All Ages',
            'in_stock' => true,
            'is_featured' => false
        ],
        [
            'id' => 7,
            'name' => 'L298N Dual H-Bridge Motor Driver',
            'category' => 'electronics',
            'category_name' => 'Electronic Components',
            'price' => 650,
            'rating' => 4.4,
            'reviews' => 88,
            'image' => 'images/motor_driver.svg',
            'description' => 'High-power dual DC motor controller module. Drives two DC motors or one stepper motor with ease.',
            'full_desc' => 'The L298N motor driver module allows you to control the speed and direction of two DC motors, or control one bipolar stepper motor. Perfect for wheel-drive mobile robots.',
            'specs' => [
                'Driver Chip' => 'L298N dual H-bridge driver chip',
                'Drive Terminal Power Supply' => '+5V to +35V',
                'Peak Drive Current' => '2A per bridge',
                'Control Signal Input Voltage' => 'Low: -0.3V to 1.5V, High: 2.3V to Vss',
                'Board Size' => '43mm x 43mm x 27mm'
            ],
            'age' => 'All Ages',
            'in_stock' => true,
            'is_featured' => false
        ],
        [
            'id' => 8,
            'name' => '3D Wooden Robotic Arm Puzzle',
            'category' => 'puzzles',
            'category_name' => 'Educational Toys',
            'price' => 4500,
            'rating' => 4.7,
            'reviews' => 31,
            'image' => 'images/robotic_arm_puzzle.svg',
            'description' => 'Assemble a functional mechanical arm. Teaches gears, pulleys, and mechanical principles. No glue required.',
            'full_desc' => 'This 3D wooden puzzle allows kids and hobbyists to construct a fully mechanical, operational robotic arm using laser-cut plywood pieces. Using hydraulic syringes or geared mechanisms, the arm rotates and grips items.',
            'specs' => [
                'Material' => 'Natural Laser-cut Plywood',
                'Number of Pieces' => '138 pieces',
                'Assembly Time' => '2 - 3 Hours',
                'Dimensions' => '280mm x 150mm x 200mm',
                'Glue Required' => 'No (interlocking joints)'
            ],
            'age' => 'Ages 8+',
            'in_stock' => true,
            'is_featured' => true
        ],
        [
            'id' => 9,
            'name' => 'Gravity Maze Marble Run Logic Game',
            'category' => 'puzzles',
            'category_name' => 'Educational Toys',
            'price' => 3800,
            'rating' => 4.8,
            'reviews' => 22,
            'image' => 'images/gravity_maze.svg',
            'description' => 'A gravity-powered logic maze that challenges minds. Includes 60 challenge cards from beginner to expert.',
            'full_desc' => 'Gravity Maze is a logic game, marble run, and STEM toy all rolled into one. It contains 60 challenges of increasing difficulty. Players arrange translucent towers to guide marbles from start to target, strengthening critical thinking.',
            'specs' => [
                'Target Learning' => 'Spatial Reasoning, Logic Planning, Problem Solving',
                'Included Parts' => '1 Game Grid, 10 Gravity Maze Towers, 3 Marbles, 60 Challenge Cards',
                'Recommended Age' => '8 Years +'
            ],
            'age' => 'Ages 8+',
            'in_stock' => false,
            'is_featured' => false
        ],
        [
            'id' => 10,
            'name' => 'Solderless Breadboard - 830 Points',
            'category' => 'tools',
            'category_name' => 'Tools & Prototyping',
            'price' => 600,
            'rating' => 4.5,
            'reviews' => 195,
            'image' => 'images/breadboard.svg',
            'description' => 'Full-size solderless breadboard for electronic circuits. Standard 0.1 inch hole pitch with adhesive back.',
            'full_desc' => 'This is a premium full-size solderless breadboard with 830 connection points, two power rails, and a standard grid layout. Ideal for prototyping circuits before permanent soldering.',
            'specs' => [
                'Tie Points' => '830 points (630 tie points in terminal strip, 200 in distribution strips)',
                'Dimensions' => '16.5cm x 5.5cm',
                'Pitch' => '2.54mm (0.1 inch)',
                'Material' => 'ABS Plastic, Nickel plated phosphor bronze contacts'
            ],
            'age' => 'All Ages',
            'in_stock' => true,
            'is_featured' => false
        ],
        [
            'id' => 11,
            'name' => 'Premium Jumper Wire Ribbon (40-Pin)',
            'category' => 'tools',
            'category_name' => 'Tools & Prototyping',
            'price' => 350,
            'rating' => 4.6,
            'reviews' => 240,
            'image' => 'images/jumper_wires.svg',
            'description' => 'Multi-colored 40-pin flexible jumper wire ribbon. Selectable male-to-male or male-to-female contacts.',
            'full_desc' => 'These 20cm long jumper wires are perfect for breadboard connections and microcontrollers. They can be split into individual wires or kept as a ribbon. High-quality pins ensure secure electrical contact.',
            'specs' => [
                'Count' => '40 wires per ribbon',
                'Length' => '20 cm',
                'Connectors' => 'Male to Male (also available in Female-to-Female and Male-to-Female)',
                'Conductors' => 'Standard copper-clad aluminum wires'
            ],
            'age' => 'All Ages',
            'in_stock' => true,
            'is_featured' => false
        ]
    ];

    public static function get_all_products() {
        return self::$products;
    }

    public static function get_product_by_id($id) {
        foreach (self::$products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    public static function get_featured_products() {
        return array_filter(self::$products, function($p) {
            return $p['is_featured'];
        });
    }

    public static function get_related_products($category, $exclude_id, $limit = 4) {
        $filtered = array_filter(self::$products, function($p) use ($category, $exclude_id) {
            return $p['category'] === $category && $p['id'] != $exclude_id;
        });
        return array_slice($filtered, 0, $limit);
    }

    public static function get_categories() {
        return [
            'steam-kits' => 'STEAM & Robotics Kits',
            'electronics' => 'Electronic Components',
            'puzzles' => 'Educational Toys',
            'tools' => 'Tools & Prototyping'
        ];
    }
}
?>
