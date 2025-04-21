<?php
session_start();
require_once '../config.php';

// Ensure session booking exists
if (!isset($_SESSION['booking'])) {
    die("Invalid request. No booking found.");
}

// Retrieve booking details from session
$booking = $_SESSION['booking'];
$movie_id = $booking['movie_id'];
$title = htmlspecialchars($booking['title']);
$price = (float)$booking['total_price'] / (int)$booking['ticket_count']; // Restore per ticket price
$show_time = htmlspecialchars($booking['show_time']);
$theater_id = $booking['theater_id'];
$ticket_count = (int)$booking['ticket_count'];
$total_price = (float)$booking['total_price'];

// Fetch theater details
$sql = "SELECT name, city FROM theaters WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $theater_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid theater selection.");
}

$theater = $result->fetch_assoc();
$theater_name = htmlspecialchars($theater['name']);
$theater_city = htmlspecialchars($theater['city']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #ff5733;
            padding: 15px;
            text-align: center;
        }

        .logo {
            color: white;
            font-size: 22px;
            text-decoration: none;
            font-weight: bold;
        }

        .payment-container {
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .details p {
            font-size: 16px;
            color: #555;
            text-align: center;
            margin: 5px 0;
        }

        .details strong {
            color: #ff5733;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            cursor: pointer;
        }

        button {
            background-color: #ff5733;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    <nav>
        <div class="movies-container">
            <a href="#" class="logo">🎬 MovieZone</a>
        </div>
    </nav>

    <div class="payment-container">
        <h2>Payment for: <span><?php echo $title; ?></span></h2>
        
        <div class="details">
            <p><strong>Show Time:</strong> <?php echo $show_time; ?></p>
            <p><strong>Theater:</strong> <?php echo $theater_name . " - " . $theater_city; ?></p>
            <p><strong>Tickets:</strong> <?php echo $ticket_count; ?></p>
            <p><strong>Total Price:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
        </div>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="show_time" value="<?php echo $show_time; ?>">
            <input type="hidden" name="theater_id" value="<?php echo $theater_id; ?>">
            <input type="hidden" name="ticket_count" value="<?php echo $ticket_count; ?>">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="purchase_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <label for="payment_method">Choose Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="credit_card">Credit/Debit Card</option>
                <option value="upi">UPI</option>
                <option value="wallet">Wallet Balance</option>
            </select>

            <label for="card_number">Card/UPI ID:</label>
            <input type="text" name="payment_details" id="card_number" placeholder="Enter Card Number or UPI ID" required>

            <button type="submit">Make Payment</button>
        </form>
    </div>
</body>
</html>
