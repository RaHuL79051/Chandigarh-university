<?php
session_start();
require '../config.php'; 


// Fetch users from database
$query = "SELECT id, name, username, email, phone, role, special_permission FROM users";
$result = mysqli_query($conn, $query);

// Ban User
if (isset($_POST['ban_user'])) {
    $user_id = $_POST['user_id'];
    $ban_query = "UPDATE users SET special_permission = 0 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $ban_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: manage_users.php");
}

// Delete User
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: manage_users.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
      /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #1c1c1c;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container */
        .container {
            background: #2a2a2a;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.1);
            width: 80%;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Heading */
        .container h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #ff4757;
            border-bottom: 2px solid #ff4757;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #333;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #555;
        }

        th {
            background: #444;
        }

        td {
            background: #222;
        }

        /* Buttons */
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .ban-btn {
            background: orange;
            color: white;
        }

        .ban-btn:hover {
            background: darkorange;
        }

        .delete-btn {
            background: crimson;
            color: white;
        }

        .delete-btn:hover {
            background: darkred;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
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
        .actions{
          width: 91%;
          display: flex;
          justify-content: space-evenly;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo ucfirst($row['role']); ?></td>
                        <td class="actions">
                            <?php if ($row['special_permission'] == 1) { ?>
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="ban_user" class="ban-btn">Ban</button>
                                </form>
                            <?php } ?>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
