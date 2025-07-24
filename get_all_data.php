<?php

header('Content-Type: application/json');

require_once __DIR__ . '/db_connection.php';

// Get all data from db and return to the datatable
function getProducts($database) {
    try {
        $stmt = $database->query("SELECT id, mpn, price, cost, stock FROM products");
        $products = $stmt->fetchAll();
        echo json_encode(['data' => $products]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

getProducts($database);