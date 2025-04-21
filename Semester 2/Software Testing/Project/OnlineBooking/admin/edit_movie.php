<?php
include '../config.php'; // Include database connection
session_start();


// Check if the movie ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p class='error'>Invalid Movie ID.</p>";
    exit();
}

$movie_id = $_GET['id'];

// Fetch movie details from the database
$query = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p class='error'>Movie not found.</p>";
    exit();
}

$movie = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $show_time = $_POST['show_time'];

    $update_query = "UPDATE movies SET title=?, description=?, price=?, show_time=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdsi", $title, $description, $price, $show_time, $movie_id);

    if ($stmt->execute()) {
        echo "<p class='success'>Movie updated successfully.</p>";
        header("Location: manage_movies.php");
        exit();
    } else {
        echo "<p class='error'>Error updating movie. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <style>
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
          width: 500px;
          text-align: center;
          animation: fadeIn 0.5s ease-in-out;
      }

      /* Heading */
      .container h2 {
          font-size: 22px;
          margin-bottom: 15px;
          color: #ff4757;
          border-bottom: 2px solid #ff4757;
          display: inline-block;
          padding-bottom: 5px;
      }

      /* Form Styling */
      form {
          display: flex;
          flex-direction: column;
      }

      label {
          text-align: left;
          font-size: 14px;
          margin: 5px 0;
          color: #ddd;
      }

      input, textarea {
          width: 95%;
          padding: 10px;
          margin: 5px 0;
          border: 1px solid #444;
          border-radius: 5px;
          background: #333;
          color: white;
          font-size: 14px;
          transition: all 0.3s ease-in-out;
      }

      input:focus, textarea:focus {
          border: 1px solid #ff4757;
          outline: none;
          box-shadow: 0px 0px 5px rgba(255, 71, 87, 0.5);
      }

      /* Submit Button */
      button {
          width: 100%;
          padding: 12px;
          margin-top: 15px;
          border: none;
          border-radius: 5px;
          background: #ff4757;
          color: white;
          font-weight: bold;
          cursor: pointer;
          transition: all 0.3s;
      }

      button:hover {
          background: #e84118;
          transform: translateY(-2px);
      }

      /* Back Button */
      .back-button {
          background: #555;
          color: white;
          margin-top: 10px;
      }

      .back-button:hover {
          background: #777;
      }

      /* Success & Error Messages */
      .success, .error {
          padding: 10px;
          border-radius: 5px;
          margin-bottom: 15px;
          text-align: center;
          font-weight: bold;
      }

      .success {
          color: #28a745;
          background: #1e3a2b;
      }

      .error {
          color: #dc3545;
          background: #3a1e1e;
      }

      /* Responsive Design */
      @media (max-width: 500px) {
          .container {
              width: 90%;
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
        <h2>Edit Movie</h2>
        <form method="POST">
            <label>Movie Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>

            <label>Description</label>
            <textarea name="description" required><?= htmlspecialchars($movie['description']) ?></textarea>

            <label>Price</label>
            <input type="number" name="price" value="<?= htmlspecialchars($movie['price']) ?>" required>

            <label>Show Time</label>
            <input type="datetime-local" name="show_time" value="<?= date('Y-m-d\TH:i', strtotime($movie['show_time'])) ?>" required>

            <button type="submit">Update Movie</button>
        </form>
        <a href="manage_movies.php"><button class="back-button">Back to Movies</button></a>
    </div>
</body>
</html>
