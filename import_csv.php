<?php

header('Content-Type: application/json');

require_once __DIR__ . '/db_connection.php';

// Handle importing csv file
function importCsv($database) {
    if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload error.']);
        return;
    }

    $fileTmpPath = $_FILES['csvFile']['tmp_name'];
    $rowsProcessed = 0;
    $rowsUpdated = 0;

    $updateStatement = $database->prepare(
        "UPDATE products SET cost = :cost, price = :price, stock = stock + :stock WHERE mpn LIKE :item_concat OR mpn LIKE :item"
    );

    if (($fileHandle = fopen($fileTmpPath, 'r')) !== false) {
        $header = fgetcsv($fileHandle, 1000, ",", '"', "\\");
        if ($header === false) {
            echo json_encode(['success' => false, 'message' => 'Cannot read header from empty CSV file.']);
            return;
        }

        while (($data = fgetcsv($fileHandle, 1000, ",", '"', "\\")) !== false) {

            $rowsProcessed++; 
            $row = array_combine($header, $data);
            
            $params = [
                ':cost'        => (float)trim($row['Cost']),
                ':stock'       => (int)trim($row['Stock']),
                ':price'       => (int)trim($row['Price']),
                ':item_concat' => trim($row['Item']) . '-' . trim($row['Volume']),
                ':item'        => trim($row['Item'])
            ];
            
            $updateStatement->execute($params);
            
            if ($updateStatement->rowCount() > 0) {
                $rowsUpdated++;
            }
        }
        
        fclose($fileHandle);

        echo json_encode([
            'success'       => true,
            'rowsProcessed' => $rowsProcessed,
            'rowsUpdated'   => $rowsUpdated,
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not open the uploaded CSV file.']);
    }
}

importCsv($database);