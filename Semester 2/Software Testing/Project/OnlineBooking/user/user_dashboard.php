<?php
header('Content-Type: application/json');
require_once '../config.php'; // Ensure this file exists and connects properly

define('TMDB_API_KEY', '15d2ea6d0dc1d476efbca3eba2b9bbfb');
define('TMDB_SEARCH_URL', 'https://api.themoviedb.org/3/search/movie?api_key=' . TMDB_API_KEY . '&query=');
define('TMDB_IMAGE_URL', 'https://image.tmdb.org/t/p/w500'); // TMDb Image base URL

// Check database connection
if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Fetch movies from the database
$sql = "SELECT id, title, description, price, show_time FROM movies";
$result = $conn->query($sql);

// Handle database query errors
if (!$result) {
    echo json_encode(["error" => "Failed to fetch movies"]);
    exit;
}

$movies = [];

while ($row = $result->fetch_assoc()) {
    $movie_title = urlencode($row['title']);
    $api_url = TMDB_SEARCH_URL . $movie_title;

    // Fetch movie data from TMDb API
    $api_response = @file_get_contents($api_url);
    
    // Handle API failure
    if (!$api_response) {
        $poster_url = "https://via.placeholder.com/200x300?text=" . urlencode($row['title']);
    } else {
        $api_data = json_decode($api_response, true);

        // Check if TMDb API returned a valid poster
        if ($api_data && isset($api_data['results'][0]['poster_path'])) {
            $poster_url = TMDB_IMAGE_URL . $api_data['results'][0]['poster_path'];
        } else {
            $poster_url = "https://via.placeholder.com/200x300?text=" . urlencode($row['title']);
        }
    }

    // Add movie data to the array
    $movies[] = [
        "id"          => $row['id'],
        "name"        => $row['title'],
        "description" => $row['description'],
        "price"       => $row['price'],
        "show_time"   => $row['show_time'],
        "poster"      => $poster_url
    ];
}

// Ensure JSON is always returned
echo json_encode($movies);
exit;
?>
