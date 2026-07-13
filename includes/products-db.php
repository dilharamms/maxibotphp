<?php
// Maxibot Database-Driven Product Database Helper

require_once __DIR__ . '/db.php';

class ProductsDB {
    
    public static function get_all_products() {
        global $db;
        try {
            $stmt = $db->query("SELECT * FROM products");
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                $row['specs'] = json_decode($row['specs'], true);
            }
            return $rows;
        } catch (Exception $e) {
            return [];
        }
    }

    public static function get_product_by_id($id) {
        global $db;
        try {
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                $row['specs'] = json_decode($row['specs'], true);
                return $row;
            }
        } catch (Exception $e) {}
        return null;
    }

    public static function get_featured_products() {
        global $db;
        try {
            $stmt = $db->query("SELECT * FROM products WHERE is_featured = 1");
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                $row['specs'] = json_decode($row['specs'], true);
            }
            return $rows;
        } catch (Exception $e) {
            return [];
        }
    }

    public static function get_related_products($category, $exclude_id, $limit = 4) {
        global $db;
        try {
            $stmt = $db->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT ?");
            $stmt->bindValue(1, $category, PDO::PARAM_STR);
            $stmt->bindValue(2, $exclude_id, PDO::PARAM_INT);
            $stmt->bindValue(3, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                $row['specs'] = json_decode($row['specs'], true);
            }
            return $rows;
        } catch (Exception $e) {
            return [];
        }
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
