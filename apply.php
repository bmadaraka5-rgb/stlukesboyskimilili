<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name   = trim($_POST['student_name']);
    $kcpe_index     = trim($_POST['kcpe_index']);
    $kcpe_marks     = (int)$_POST['kcpe_marks'];
    $county         = $_POST['county'];
    $is_orphan      = isset($_POST['is_orphan']) ? 1 : 0;
    $guardian_name  = trim($_POST['guardian_name']);
    $guardian_phone = trim($_POST['guardian_phone']);
    $email          = trim($_POST['email']);

    if (empty($student_name) || empty($kcpe_index) || $kcpe_marks < 0 || $kcpe_marks > 500 || empty($county) || empty($guardian_name) || empty($guardian_phone)) {
        die("All required fields must be filled correctly.");
    }

    try {
        $sql = "INSERT INTO applications 
                (student_name, kcpe_index, kcpe_marks, county, is_orphan, guardian_name, guardian_phone, email)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$student_name, $kcpe_index, $kcpe_marks, $county, $is_orphan, $guardian_name, $guardian_phone, $email]);

        $ref = $pdo->lastInsertId();
        echo "<!DOCTYPE html><html><head><title>Success</title>
              <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'/>
              </head><body class='bg-light'>
              <div class='container mt-5 text-center'>
                <div class='alert alert-success'>
                  <h4>Application Submitted!</h4>
                  <p>Reference ID: <strong>$ref</strong></p>
                  <a href='admissions.html' class='btn btn-primary'>Back to Form</a>
                </div>
              </div></body></html>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>