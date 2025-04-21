<?php
session_start();
require_once '../config.php'; // Database connection


$admin_id = $_SESSION['user_id'];

// Fetch admin details
$query_admin = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query_admin);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin_result = $stmt->get_result();
$admin = $admin_result->fetch_assoc();

// Fetch site settings
$query_settings = "SELECT * FROM settings WHERE id = 1";
$settings_result = $conn->query($query_settings);
$settings = $settings_result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Updating site settings
    if (isset($_POST['update_site'])) {
        $site_title = $_POST['site_title'];
        $contact_email = $_POST['contact_email'];
        $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0;

        $updateSiteQuery = "UPDATE settings SET site_title = ?, contact_email = ?, maintenance_mode = ? WHERE id = 1";
        $stmt = $conn->prepare($updateSiteQuery);
        $stmt->bind_param("ssi", $site_title, $contact_email, $maintenance_mode);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Site settings updated!";
        } else {
            $_SESSION['error'] = "Failed to update site settings.";
        }
    }

    // Updating admin profile
    if (isset($_POST['update_profile'])) {
        $admin_name = $_POST['admin_name'];
        $admin_username = $_POST['admin_username'];
        $admin_email = $_POST['admin_email'];
        $admin_phone = $_POST['admin_phone'];
        $admin_role = $_POST['admin_role'];
        $admin_password = !empty($_POST['admin_password']) ? password_hash($_POST['admin_password'], PASSWORD_DEFAULT) : $admin['password'];

        // Check if username is unique
        $checkUsername = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $checkUsername->bind_param("si", $admin_username, $admin_id);
        $checkUsername->execute();
        $checkUsername->store_result();
        if ($checkUsername->num_rows > 0) {
            $_SESSION['error'] = "Username already exists!";
            header("Location: settings.php");
            exit();
        }

        // Check if email is unique
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkEmail->bind_param("si", $admin_email, $admin_id);
        $checkEmail->execute();
        $checkEmail->store_result();
        if ($checkEmail->num_rows > 0) {
            $_SESSION['error'] = "Email already exists!";
            header("Location: settings.php");
            exit();
        }

        // Update admin details
        $updateAdminQuery = "UPDATE users SET name = ?, username = ?, email = ?, phone = ?, password = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($updateAdminQuery);
        $stmt->bind_param("ssssssi", $admin_name, $admin_username, $admin_email, $admin_phone, $admin_password, $admin_role, $admin_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile updated successfully!";
            header("Location: ../form.php");
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }
    }

    header("Location: settings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1c1c1c;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #2a2a2a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            width: 400px;
            text-align: left;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background: crimson;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover {
            background: darkred;
        }
        label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }
        .success {
            color: #4CAF50;
        }
        .error {
            color: #FF5722;
        }
        .switch-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .switch-buttons button {
            width: 48%;
            background: #444;
        }
        .switch-buttons button.active {
            background: crimson;
        }
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }

        .maintenance{
          text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Settings</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <p class="success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <div class="switch-buttons">
        <button id="site-settings-btn" class="active" onclick="toggleForm('site-settings')">Site Settings</button>
        <button id="profile-settings-btn" onclick="toggleForm('profile-settings')">Profile Settings</button>
    </div>

    <div id="site-settings" class="form-container active">
        <form method="POST">
            <label>Site Title:</label>
            <input type="text" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>

            <label>Contact Email:</label>
            <input type="email" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email']); ?>" required>

            <label class="maintenance"><input type="checkbox" name="maintenance_mode" <?php echo ($settings['maintenance_mode'] == 1) ? 'checked' : ''; ?>> Enable Maintenance Mode</label>

            <button type="submit" name="update_site">Save Changes</button>
        </form>
    </div>

    <div id="profile-settings" class="form-container">
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="admin_name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>

            <label>Username:</label>
            <input type="text" name="admin_username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>

            <label>Email:</label>
            <input type="email" name="admin_email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

            <label>Phone:</label>
            <input type="text" name="admin_phone" value="<?php echo htmlspecialchars($admin['phone']); ?>" required>

            <label>New Password:</label>
            <input type="password" name="admin_password">

            <label>Role:</label>
            <select name="admin_role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>
</div>

<script>
    function toggleForm(formId) {
        document.getElementById('site-settings').classList.remove('active');
        document.getElementById('profile-settings').classList.remove('active');
        document.getElementById(formId).classList.add('active');

        document.getElementById('site-settings-btn').classList.remove('active');
        document.getElementById('profile-settings-btn').classList.remove('active');
        document.getElementById(formId + '-btn').classList.add('active');
    }
</script>

</body>
</html>
