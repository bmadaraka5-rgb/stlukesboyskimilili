<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

$uploadDir = '../uploads/';
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$category = $_POST['category'] ?? 'All';
$captions = $_POST['captions'] ?? [];

if ($_FILES['images']['name'][0]) {
    foreach ($_FILES['images']['name'] as $i => $name) {
        $tmp = $_FILES['images']['tmp_name'][$i];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $caption = trim($captions[$i] ?? '');

        if (in_array($ext, $allowed) && $_FILES['images']['size'][$i] <= 5*1024*1024) {
            $newName = uniqid('img_') . '.' . $ext;
            if (move_uploaded_file($tmp, $uploadDir . $newName)) {
                $pdo->prepare("INSERT INTO gallery (filename, caption, category) VALUES (?, ?, ?)")
                    ->execute([$newName, $caption, $category]);
            }
        }
    }
}

header("Location: dashboard.php#gallery");
exit;
?>