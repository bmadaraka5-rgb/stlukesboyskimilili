<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    exit('Unauthorized');
}

if (!isset($_GET['id'])) {
    exit('No ID');
}

$id = (int)$_GET['id'];

// Get filename
$stmt = $pdo->prepare("SELECT filename FROM gallery WHERE id = ?");
$stmt->execute([$id]);
$img = $stmt->fetch();

if ($img) {
    // Delete from DB
    $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
    
    // Delete file
    $filePath = "../uploads/" . $img['filename'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

header("Location: dashboard.php#gallery");
exit;
?>