<?php
session_start();
require_once '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Validate POST data
if (!isset($_POST['movie_id'], $_POST['title'], $_POST['price'], $_POST['show_time'], $_POST['theater_id'], $_POST['ticket_count'])) {
    die("Invalid booking request.");
}

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];
$title = $_POST['title'];
$price = $_POST['price'];
$show_time = $_POST['show_time'];
$theater_id = $_POST['theater_id'];
$ticket_count = intval($_POST['ticket_count']);
$total_price = $ticket_count * $price;

// Store booking in session before payment
$_SESSION['booking'] = [
    "user_id" => $user_id,
    "movie_id" => $movie_id,
    "title" => $title,
    "show_time" => $show_time,
    "theater_id" => $theater_id,
    "ticket_count" => $ticket_count,
    "total_price" => $total_price
];

header("Location: payment.php");
exit;
