<?php
require 'config.php';

// Get category from URL
$category = $_GET['cat'] ?? 'All';

// Validate category
$valid_categories = ['All', 'Campus', 'Events', 'Sports', 'Academics', 'Other'];
if (!in_array($category, $valid_categories)) {
    $category = 'All';
}

// Build query
if ($category === 'All') {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY uploaded_at DESC");
    $stmt->execute([$category]);
}

$images = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gallery | St. Luke's Boys</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .gallery-img { height: auto; object-fit: cover; }
    .filter-btn { margin: 5px; }
    .active { background: #6B1A2C !important; color: white !important; }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
  <a href="index.html"><h2 class="text-center mb-4" style="color:#6B1A2C;">School Gallery</h2></a>

  <!-- Filters -->
  <div class="text-center mb-4">
    <?php foreach ($valid_categories as $cat): ?>
      <a href="?cat=<?= urlencode($cat) ?>" 
         class="btn btn-outline-primary filter-btn <?= $category === $cat ? 'active' : '' ?>">
        <?= $cat ?>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Gallery Grid -->
  <div class="row g-3">
    <?php if (empty($images)): ?>
      <div class="col-12 text-center py-5">
        <p class="text-muted">No images in this category yet.</p>
      </div>
    <?php else: ?>
      <?php foreach ($images as $img): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="uploads/<?= htmlspecialchars($img['filename']) ?>" 
                 class="card-img-top gallery-img" alt="<?= htmlspecialchars($img['caption']) ?>">
            <div class="card-body">
              <p class="card-text small text-muted"><strong><?= htmlspecialchars($img['category']) ?></strong></p>
              <p class="card-text"><?= nl2br(htmlspecialchars($img['caption'] ?: 'No caption')) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>