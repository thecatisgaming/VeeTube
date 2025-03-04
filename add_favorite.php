<?php
require 'config.php';
session_start();

if (!isset($_POST['username']) || !isset($_POST['video_id'])) {
    echo 'Error: Missing data';
    exit();
}

$user_id = $_POST['user_id'];
$video_id = $_POST['video_id'];


$query = "SELECT COUNT(*) FROM favorites WHERE user_id = :user_id AND video_id = :video_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->fetchColumn() > 0) {
    echo 'Error: Already favorited';
    exit();
}

$query = "INSERT INTO favorites (user_id, video_id) VALUES (:user_id, :video_id)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'Error: Could not add to favorites';
}
?>
