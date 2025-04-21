<?php
session_start();
require_once '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch recent bookings for the logged-in user
$sql = "SELECT b.id, m.title, t.name AS theater_name, t.city, b.show_time, 
               b.ticket_count, b.total_price, b.booking_time, b.payment_method, b.status
        FROM bookings b
        JOIN movies m ON b.movie_id = m.id
        JOIN theaters t ON b.theater_id = t.id
        WHERE b.user_id = ?
        ORDER BY b.booking_time DESC
        LIMIT 10"; // Show last 10 bookings

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Bookings</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1a1a2e;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #ff5733;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .logo {
            color: white;
            font-size: 22px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn {
            background: #ffdd57;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .btn:hover {
            background: #ffcc00;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.1);
        }
        h2 {
            text-align: center;
            color: #ff5733;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #ff5733;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #333;
        }
        tr:hover {
            background-color: #444;
        }
        .status {
            padding: 6px 10px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            display: inline-block;
        }
        .confirmed {
            background-color: #28a745;
            color: white;
        }
        .cancelled {
            background-color: #dc3545;
            color: white;
        }
        .pending {
            background-color: #ffc107;
            color: black;
        }
        @media (max-width: 768px) {
            table, th, td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <nav>
        <a href="#" class="logo">🎬 MovieZone</a>
        <button class="btn" onclick="window.location.href='dashboard.php'">🏠 Home</button>
    </nav>

    <div class="container">
        <h2>Your Recent Bookings</h2>
        <table>
            <tr>
                <th>Movie</th>
                <th>Theater</th>
                <th>Show Time</th>
                <th>Tickets</th>
                <th>Total Price</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Booked On</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['theater_name']) . " - " . htmlspecialchars($row['city']); ?></td>
                <td><?php echo date("d M Y, h:i A", strtotime($row['show_time'])); ?></td>
                <td><?php echo $row['ticket_count']; ?></td>
                <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo ucfirst($row['payment_method']); ?></td>
                <td>
                    <span class="status <?php echo strtolower($row['status']); ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </td>
                <td><?php echo date("d M Y, h:i A", strtotime($row['booking_time'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
