<?php
session_start();
require_once '../config.php';

$username = $_SESSION['name'] ?? 'Admin';
// Fetch total movies
$totalMoviesQuery = $conn->query("SELECT COUNT(*) AS total FROM movies");
$totalMovies = $totalMoviesQuery->fetch_assoc()['total'];

// Fetch total users
$totalUsersQuery = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='user'");
$totalUsers = $totalUsersQuery->fetch_assoc()['total'];

// Fetch total earnings by month
$earningsByMonthQuery = $conn->query("
    SELECT MONTH(purchase_date) AS month, SUM(total_price) AS earnings 
    FROM bookings GROUP BY MONTH(purchase_date)
");
$earningsByMonth = [];
while ($row = $earningsByMonthQuery->fetch_assoc()) {
    $earningsByMonth[$row['month']] = $row['earnings'];
}

// Fetch user role distribution
$userRoleQuery = $conn->query("
    SELECT role, COUNT(*) AS total FROM users GROUP BY role
");
$userRoles = [];
while ($row = $userRoleQuery->fetch_assoc()) {
    $userRoles[$row['role']] = $row['total'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

            body {
                font-family: 'Arial', sans-serif;
                background: #1e1e2f;
                color: white;
                text-align: center;
                padding: 20px;
            }

            .dashboard-header {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .dashboard-container {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 30px;
            }

            .dashboard-card {
                background: #2c2c3e;
                padding: 20px;
                border-radius: 8px;
                width: 250px;
                text-align: center;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .dashboard-card:hover {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            }

            .dashboard-card h3 {
                margin: 0;
                font-size: 18px;
                color: #f1c40f;
            }

            .dashboard-card p {
                font-size: 28px;
                font-weight: bold;
                margin-top: 10px;
                color: #ffffff;
            }

            /* Chart Containers */
            .Maincontainer {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 20px;
            }

            .chart-container {
                width: 100%;
                max-width: 500px;
                background: #2c2c3e;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            }

            /* Buttons */
            .buttons {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            button {
                padding: 12px 20px;
                font-size: 16px;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                transition: 0.3s;
                margin-top: 20px;
            }

            .logout-btn {
                background: crimson;
                color: white;
            }

            .logout-btn:hover {
                background: darkred;
            }

            .back_btn {
                background: #2980b9;
                color: white;
            }

            .back_btn:hover {
                background: #1c5980;
            }
            .height{
            height: 100% !important;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .dashboard-container {
                    flex-direction: column;
                    align-items: center;
                }

                .dashboard-card {
                    width: 90%;
                }

                .Maincontainer {
                    flex-direction: column;
                    align-items: center;
                }
            }

    </style>
</head>
<body>

    <div class="dashboard-header">Welcome, <?php echo $username; ?></div>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <h3>Total Movies</h3>
            <p><?php echo $totalMovies; ?></p>
        </div>

        <div class="dashboard-card">
            <h3>Total Users</h3>
            <p><?php echo $totalUsers; ?></p>
        </div>
    </div>

    <!-- Bar Chart for Total Movies & Users -->
     <div class="Maincontainer">
     <div class="chart-container">
        <h3>Movies vs Users</h3>
        <canvas id="moviesUsersChart" class="height"></canvas>
    </div>

    <!-- Line Chart for Earnings -->
    <div class="chart-container">
        <h3>Monthly Earnings</h3>
        <canvas id="earningsChart" class="height"></canvas>
    </div>

    <!-- Pie Chart for User Role Distribution -->
    <div class="chart-container">
        <h3>User Role Distribution</h3>
        <canvas id="userRolesChart"></canvas>
    </div>
     </div>

    <button class="back_btn" onclick="window.location.href='dashboard.php'">Go Back</button>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

    <script>
        // Bar Chart for Movies vs Users
        const moviesUsersChart = new Chart(document.getElementById('moviesUsersChart'), {
            type: 'bar',
            data: {
                labels: ['Movies', 'Users'],
                datasets: [{
                    label: 'Total Count',
                    data: [<?php echo $totalMovies; ?>, <?php echo $totalUsers; ?>],
                    backgroundColor: ['#f1c40f', '#3498db']
                }]
            }
        });

        // Line Chart for Monthly Earnings
        const earningsChart = new Chart(document.getElementById('earningsChart'), {
            type: 'line',
            data: {
                labels: [<?php echo implode(',', array_keys($earningsByMonth)); ?>],
                datasets: [{
                    label: 'Earnings ($)',
                    data: [<?php echo implode(',', array_values($earningsByMonth)); ?>],
                    borderColor: '#2ecc71',
                    fill: false
                }]
            }
        });

        // Pie Chart for User Roles
        const userRolesChart = new Chart(document.getElementById('userRolesChart'), {
            type: 'pie',
            data: {
                labels: [<?php echo '"' . implode('","', array_keys($userRoles)) . '"'; ?>],
                datasets: [{
                    data: [<?php echo implode(',', array_values($userRoles)); ?>],
                    backgroundColor: ['#e74c3c', '#8e44ad', '#3498db']
                }]
            }
        });
    </script>

</body>
</html>
