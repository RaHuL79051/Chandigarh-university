<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Movie Addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_movie'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $show_time = $_POST['show_time'];

    $query = "INSERT INTO movies (title, description, price, show_time) VALUES ('$title', '$description', '$price', '$show_time')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Movie added successfully!";
    } else {
        $_SESSION['error'] = "Error adding movie: " . mysqli_error($conn);
    }
}

// Handle Movie Deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM movies WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Movie deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting movie: " . mysqli_error($conn);
    }
}

// Fetch All Movies
$result = mysqli_query($conn, "SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <style>
      /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* Container */
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        /* Headings */
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #2a2a2a;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
        }

        /* Input Fields */
        input, textarea {
            width: 97%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        input::placeholder, textarea::placeholder {
            color: #aaa;
        }

        /* Button */
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: crimson;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: darkred;
        }

        /* Success & Error Messages */
        .success, .error {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            background: #28a745;
            color: white;
        }

        .error {
            background: #dc3545;
            color: white;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #444;
            text-align: center;
        }

        th {
            background: #444;
            color: white;
        }

        td {
            background: #222;
            width: fit-content;
        }

        /* Action Links */
        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        a[href*="edit"] {
            background: #007bff;
            color: white;
        }

        a[href*="delete"] {
            background: #dc3545;
            color: white;
        }

        a:hover {
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                flex-direction: column;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }

        #edit{
          width: 25%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Movies</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="title" placeholder="Movie Title" required>
            <textarea name="description" placeholder="Movie Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Ticket Price" required>
            <input type="datetime-local" name="show_time" required>
            <button type="submit" name="add_movie">Add Movie</button>
        </form>

        <h3>Movie List</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Show Time</th>
                <th>Actions</th>
            </tr>
            <?php while ($movie = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $movie['title']; ?></td>
                    <td><?php echo $movie['description']; ?></td>
                    <td><?php echo $movie['price']; ?></td>
                    <td><?php echo $movie['show_time']; ?></td>
                    <td id="edit">
                        <a href="edit_movie.php?id=<?php echo $movie['id']; ?>">Edit</a>
                        <a href="manage_movies.php?delete=<?php echo $movie['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
