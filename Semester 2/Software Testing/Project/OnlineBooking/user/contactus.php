<?php
session_start();
require_once '../config.php';

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Save to database
        $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $success = "Message sent successfully! We will contact you soon.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff5733, #ff8c42);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 500px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h2 {
            color: #333;
            font-weight: 600;
        }

        .contact-info {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #ff5733;
            outline: none;
            box-shadow: 0px 0px 8px rgba(255, 87, 51, 0.3);
        }

        textarea {
            height: 100px;
            resize: none;
        }

        .btn {
            width: 100%;
            background: #ff5733;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn:hover {
            background: #e64a19;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #555;
        }

        .btn-secondary:hover {
            background: #333;
        }

        .message {
            font-size: 14px;
            margin-top: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Contact Us</h2>

        <?php if ($error): ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="message success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="contactus.php" method="POST">
            <div class="contact-info">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="contact-info">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="contact-info">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit" class="btn">Send Message</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='dashboard.php'">Return Home</button>
        </form>
    </div>

</body>
</html>
