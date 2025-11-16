<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    exit('Unauthorized');
}

if ($_POST && isset($_POST['id'], $_POST['caption'])) {
    $id = (int)$_POST['id'];
    $caption = trim($_POST['caption']);

    $stmt = $pdo->prepare("UPDATE gallery SET caption = ? WHERE id = ?");
    $stmt->execute([$caption, $id]);
}

header("Location: dashboard.php#gallery");
exit;
?>