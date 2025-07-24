<?php

require_once __DIR__ . '/db_connection.php';

// Just reset price, stock, and cost to 0
function resetDatabase($database) {
    try {
        $stmt = $database->prepare("UPDATE products SET price = 0, stock = 0, cost = 0");
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Database reset successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database reset failed: ' . $e->getMessage()]);
    }
}

resetDatabase($database);