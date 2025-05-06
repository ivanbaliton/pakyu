<?php
require 'dbconnection.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
header("Content-Type: application/json");

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Parse the request
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET': // READ
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $items = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($items);
        } else {
            $stmt = $pdo->query("SELECT * FROM products");
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($items);
        }
        break;

    case 'POST': // CREATE
        $name = $input['name'];
        $description = $input['description'];
        $price = $input['price'];
        $quantity = $input['quantity'];
        $image_path = $input['image_path'];
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $quantity, $image_path]);
        echo json_encode(["message" => "Product created successfully"]);
        break;

    case 'PUT': // UPDATE
        $id = $input['id'];
        $name = $input['name'];
        $description = $input['description'];
        $price = $input['price'];
        $quantity = $input['quantity'];
        $image_path = $input['image_path'];
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $quantity, $image_path, $id]);
        echo json_encode(["message" => "Product updated successfully"]);
        break;

    case 'DELETE': // DELETE
        $id = $input['id'] ?? $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["error" => "ID is required for deletion"]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid Request"]);
        break;
}
?>
