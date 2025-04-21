<?php
require_once '../config.php';

header('Content-Type: application/json');

// Validate city parameter
if (!isset($_GET['city']) || empty($_GET['city'])) {
    echo json_encode(["error" => "City not provided"]);
    exit;
}

$city = $conn->real_escape_string($_GET['city']);

// Fetch theaters from the database for the given city
$sql = "SELECT id, name, city FROM theaters WHERE city = '$city'";
$result = $conn->query($sql);

$theaters = [];
while ($row = $result->fetch_assoc()) {
    $theaters[] = $row;
}

// Return JSON response
echo json_encode($theaters);
exit;
?>
