<?php
session_start();
header('Content-Type: application/json');
require_once '../config.php'; // Database connection

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if all required POST data is received
if (!isset($_POST['movie_id'], $_POST['price'], $_POST['ticket_count'])) {
    echo json_encode(["error" => "Invalid request parameters"]);
    exit;
}

$movie_id = intval($_POST['movie_id']);
$ticket_count = intval($_POST['ticket_count']);
$price = floatval($_POST['price']);
$total_price = $ticket_count * $price;

// Validate ticket count
if ($ticket_count <= 0) {
    echo json_encode(["error" => "Invalid ticket count"]);
    exit;
}

// Check if the movie exists
$sql = "SELECT id FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Movie not found"]);
    exit;
}

// Insert booking into purchases table
$insert_sql = "INSERT INTO purchases (user_id, movie_id, ticket_count, total_price) VALUES (?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("iiid", $user_id, $movie_id, $ticket_count, $total_price);

if ($insert_stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Ticket booked successfully"]);
} else {
    echo json_encode(["error" => "Failed to book ticket"]);
}

$insert_stmt->close();
$stmt->close();
$conn->close();
?>
  