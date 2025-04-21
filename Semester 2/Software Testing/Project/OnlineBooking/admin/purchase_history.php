<?php
session_start();
require '../config.php'; // Database connection

// Fetch purchase history
$query = "SELECT p.id, u.name AS user_name, m.title AS movie_title, u.username AS username, 
                 p.ticket_count, p.total_price, p.purchase_date 
          FROM bookings p
          JOIN users u ON p.user_id = u.id
          JOIN movies m ON p.movie_id = m.id
          ORDER BY p.purchase_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container */
        .container {
            background: #1f1f1f;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.1);
            width: 85%;
            max-width: 900px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Heading */
        .container h2 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #ff4757;
            border-bottom: 3px solid #ff4757;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #2c2c2c;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        th {
            background: #ff4757;
        }

        td {
            background: #252525;
        }

        tr:hover {
            background: #353535;
        }

        /* Button Styling */
        .back-btn {
            margin-top: 20px;
            padding: 12px 18px;
            font-size: 16px;
            font-weight: bold;
            background: #ff4757;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #e84118;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }

            .back-btn {
                width: 100%;
                padding: 14px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Purchase History</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Username</th>
                    <th>Movie</th>
                    <th>Tickets</th>
                    <th>Total Price</th>
                    <th>Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['movie_title']); ?></td>
                        <td><?php echo (int)$row['ticket_count']; ?></td>
                        <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                        <td><?php echo date("d M Y, h:i A", strtotime($row['purchase_date'])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="back-btn" onclick="window.location.href='dashboard.php'">Back</button>
    </div>
</body>
</html>
