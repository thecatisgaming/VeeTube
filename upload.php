<?php
include("header.php");
require 'config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    echo "User ID is not set. Please log in again.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maxFileSize = 1 * 1024 * 1024 * 1024; // 1 GB in bytes
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $type = $_POST['type'];
    $uploadDir = 'uploads/';
    $thumbnailDir = 'thumbnails/';
    
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    if (!is_dir($thumbnailDir)) mkdir($thumbnailDir, 0777, true);
    
    $file = $_FILES['video'];
    
    if ($file['size'] > $maxFileSize) {
        echo "File size exceeds 1 GB. Please upload a smaller file.";
        exit();
    }

    // Generate a unique filename for the video
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $filePath = $uploadDir . $filename;
    
    // Move the uploaded file to the correct directory
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        echo "Failed to upload the video. Please try again.";
        exit();
    }
    
    $ffmpegPath = '~/bin/ffmpeg'; // Adjust path to FFmpeg on your server
    $command = "$ffmpegPath -i $filePath 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
    $duration = trim(shell_exec($command));
    
    list($hours, $minutes, $seconds) = explode(":", $duration);
    $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    
    // Choose a random time in the video for the thumbnail
    $randomTime = rand(0, $totalSeconds);
    
    $thumbnailPath = $thumbnailDir . uniqid() . '.jpg';
    $thumbnailCommand = "$ffmpegPath -i $filePath -ss $randomTime -vframes 1 -q:v 2 $thumbnailPath 2>&1";
    shell_exec($thumbnailCommand);
    
    $outputFile = $uploadDir . uniqid() . '_480p.mp4';
    $videoCommand = "$ffmpegPath -i $filePath -vf scale=854:480 -r 24 -c:v libx264 -preset fast -crf 23 -c:a aac -b:a 128k $outputFile 2>&1";
    shell_exec($videoCommand);
    
    unlink($filePath);
    
    $stmt = $pdo->prepare("INSERT INTO videos (user_id, title, description, tags, type, file_path, thumbnail_path, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['id'], $title, $description, $tags, $type, $outputFile, $thumbnailPath]);
    
    echo "Upload successful!";
}
?>

<img src="veetube.png" width="120" height="48" alt="VeeTube" border="0" hspace="5" vspace="8">

<div class="formTitle">Sign Up</div>
<div class="formTable">
    <div class="formIntro"><h3>Upload a Video!</h3></div>

<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="text" name="tags" placeholder="Tags (separated by spaces)" required>
    <input type="text" name="type" placeholder="Video Type" required>
    <input type="file" name="video" accept="video/*" required>
    <p>There is a 1GB limit!!</p>
    <button type="submit">Upload</button>
</form>
