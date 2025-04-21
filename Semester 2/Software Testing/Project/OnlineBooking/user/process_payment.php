<?php
session_start();
require_once '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if booking session exists
if (!isset($_SESSION['booking'])) {
    die("Invalid request. No booking found.");
}

// Simulate payment processing (no actual payment logic)
$booking = $_SESSION['booking'];
$user_id = $_SESSION['user_id'];
$movie_id = $booking['movie_id'];
$title = htmlspecialchars($booking['title']);
$show_time = htmlspecialchars($booking['show_time']);
$theater_id = $booking['theater_id'];
$ticket_count = (int)$booking['ticket_count'];
$total_price = (float)$booking['total_price'];
$payment_method = $_POST['payment_method'] ?? 'unknown';
$purchase_date = $_POST['purchase_date'] ?? date('Y-m-d H:i:s');

// Insert booking into database (assuming `bookings` table exists)
$sql = "INSERT INTO bookings (user_id, movie_id, theater_id, ticket_count, total_price, payment_method, booking_time, purchase_date)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiidss", $user_id, $movie_id, $theater_id, $ticket_count, $total_price, $payment_method, $purchase_date);
$stmt->execute();

// Remove booking session after storing
unset($_SESSION['booking']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .success-container {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #28a745;
            font-size: 24px;
        }

        p {
            font-size: 18px;
            color: #333;
        }

        .redirect {
            font-size: 16px;
            color: #777;
            margin-top: 20px;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "dashboard.php";
        }, 3000); // Redirect after 3 seconds
    </script>
</head>
<body>
    <div class="success-container">
        <h2>✅ Payment Successful!</h2>
        <p>Your booking for <strong><?php echo $title; ?></strong> has been confirmed.</p>
        <p>Show Time: <strong><?php echo $show_time; ?></strong></p>
        <p>Tickets: <strong><?php echo $ticket_count; ?></strong></p>
        <p>Total Price: <strong>₹<?php echo number_format($total_price, 2); ?></strong></p>
        <p>Payment Method: <strong><?php echo ucfirst($payment_method); ?></strong></p>

        <p class="redirect">Redirecting to your dashboard...</p>
    </div>
</body>
</html>
