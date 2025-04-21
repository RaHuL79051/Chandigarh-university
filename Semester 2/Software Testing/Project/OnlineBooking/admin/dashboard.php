<?php
session_start();
include '../config.php';

// Fetch admin name
$adminName = "Admin";

if (isset($_SESSION['user_id'])) {

    $adminId = $_SESSION['user_id'];
    echo "Admin ID: $adminId"; 

    $adminQuery = "SELECT name FROM users WHERE id = ? AND role = 'admin'";
    $stmt = mysqli_prepare($conn, $adminQuery);
    mysqli_stmt_bind_param($stmt, "i", $adminId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $adminData = mysqli_fetch_assoc($result);
        $adminName = $adminData['name'] ?? "Admin";
    } else {
        error_log("Admin not found: ID = $adminId");
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Session admin_id is not set");
}


// Fetch total counts
$totalUsersQuery = "SELECT COUNT(*) AS total FROM users";
$totalMoviesQuery = "SELECT COUNT(*) AS total FROM movies";
$totalSalesQuery = "SELECT COUNT(*) AS total FROM bookings";

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, $totalUsersQuery))['total'];
$totalMovies = mysqli_fetch_assoc(mysqli_query($conn, $totalMoviesQuery))['total'];
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, $totalSalesQuery))['total'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            margin: 0;
            background-color: #ecf0f1;
        }
        .sidebar {
            width: 260px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
            position: fixed;
            transition: width 0.3s;
        }
        .sidebar:hover {
            width: 280px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 16px;
            transition: all 0.3s;
        }
        .sidebar ul li a:hover {
            background: #34495e;
            padding-left: 15px;
        }
        .main-content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            transition: margin-left 0.3s;
        }
        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .stats-card {
            background: #2980b9;
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 30%;
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card span {
            font-weight: bold;
            font-size: 26px;
        }
        .recent-activities {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }
        .recent-activities:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .recent-activities h2 {
            margin-top: 0;
        }
        .recent-activities ul {
            list-style: none;
            padding: 0;
        }
        .recent-activities ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background 0.3s;
        }
        .recent-activities ul li:hover {
            background: #f8f9fa;
        }
        .recent-activities ul li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>MENU</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_movies.php">Manage Movies</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="purchase_history.php">Purchase History</a></li>
            <li><a href="manage_messages.php">View Messages</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome, <?php echo $adminName; ?>!</h1>
        <div class="stats-container">
            <div class="stats-card">Total Users: <span><?php echo $totalUsers; ?></span></div>
            <div class="stats-card">Total Movies: <span><?php echo $totalMovies; ?></span></div>
            <div class="stats-card">Total Sales: <span><?php echo $totalSales; ?></span></div>
        </div>
        <div class="recent-activities">
            <h2>Recent Activities</h2>
            <ul>
                <li>New user registered</li>
                <li>Movie "Avengers" updated</li>
                <li>User "JohnDoe" was banned</li>
                <li>Movie "Inception" added</li>
                <li>Admin settings updated</li>
            </ul>
        </div>
    </div>
</body>
</html>