<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

// Fetch Applications
$apps = $pdo->query("SELECT * FROM applications ORDER BY applied_at DESC")->fetchAll();

// Fetch Gallery
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | St. Luke's</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    :root {
      --primary: #6B1A2C;
      --light: #f8f9fa;
    }
    body { background: var(--light); font-family: 'Segoe UI', sans-serif; }
    
    /* Sidebar */
    .sidebar {
      width: 260px; background: var(--primary); min-height: 100vh; padding: 1.5rem;
      position: fixed; top: 0; left: 0; z-index: 1000; color: white;
    }
    .sidebar h4 { font-weight: 600; }
    .sidebar .nav-link {
      color: rgba(255,255,255,0.9); border-radius: 10px; margin-bottom: 0.5rem;
      padding: 0.75rem 1rem; display: flex; align-items: center; gap: 12px;
      transition: all 0.2s;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background: rgba(255,255,255,0.2); color: white; font-weight: 500;
    }
    .sidebar .nav-link.text-danger:hover { background: rgba(255,0,0,0.2); }

    /* Main Content */
    .main-content { margin-left: 260px; padding: 2rem; }
    .section { scroll-margin-top: 80px; }

    /* Cards */
    .card { border: none; border-radius: 15px; overflow: hidden; }
    .card-header { background: var(--primary); color: white; font-weight: 600; }
    .table th { background: var(--primary); color: white; font-weight: 500; }

    /* Gallery */
    .gallery-img { height: 130px; object-fit: cover; border-radius: 8px; }
    .caption-view { white-space: pre-wrap; font-size: 0.9rem; }
    .caption-edit { display: none; }
    .img-card { transition: transform 0.2s; }
    .img-card:hover { transform: translateY(-5px); }

    /* Upload Form */
    .upload-box { background: white; border: 2px dashed #ccc; border-radius: 12px; padding: 1.5rem; text-align: center; }
    .upload-box.dragover { border-color: var(--primary); background: #f0e6e8; }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar { left: -260px; transition: left 0.3s ease; }
      .sidebar.show { left: 0; }
      .main-content { margin-left: 0; padding: 1rem; }
      .toggle-btn { display: block !important; }
    }
    .toggle-btn {
      display: none; position: fixed; top: 1rem; left: 1rem; z-index: 1100;
      background: var(--primary); border: none; color: white; width: 50px; height: 50px;
      border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<!-- Mobile Toggle -->
<button class="btn toggle-btn" onclick="document.querySelector('.sidebar').classList.toggle('show')">
  <i class="bi bi-list fs-4"></i>
</button>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-center mb-4">Admin Panel</h4>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="#applications" class="nav-link active" data-section="applications">
        <i class="bi bi-file-earmark-text"></i> Applications
      </a>
    </li>
    <li class="nav-item">
      <a href="#gallery" class="nav-link" data-section="gallery">
        <i class="bi bi-images"></i> Gallery
      </a>
    </li>
    <li class="nav-item mt-auto">
      <a href="../logout.php" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div class="main-content">

  <!-- Applications Section -->
  <section id="applications" class="section">
    <div class="card shadow mb-5">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="bi bi-people"></i> Applications (<?= count($apps) ?>)
        </h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Student</th>
                <th>KCPE</th>
                <th>Marks</th>
                <th>County</th>
                <th>Guardian</th>
                <th>Phone</th>
                <th>Applied</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($apps as $a): ?>
              <tr>
                <td><strong>#<?= $a['id'] ?></strong></td>
                <td><?= htmlspecialchars($a['student_name']) ?></td>
                <td><?= htmlspecialchars($a['kcpe_index']) ?></td>
                <td><span class="badge bg-success"><?= $a['kcpe_marks'] ?></span></td>
                <td><?= htmlspecialchars($a['county']) ?></td>
                <td><?= htmlspecialchars($a['guardian_name']) ?></td>
                <td><?= htmlspecialchars($a['guardian_phone']) ?></td>
                <td><?= date('M j, Y', strtotime($a['applied_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery" class="section">
    <div class="card shadow">
      <div class="card-header">
        <h5 class="mb-0">
          <i class="bi bi-camera"></i> Gallery Management (<?= count($gallery) ?> images)
        </h5>
      </div>
      <div class="card-body">

        <!-- Upload Form -->
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-5">
          <div class="upload-box" id="dropzone">
            <i class="bi bi-cloud-upload fs-1 text-muted mb-3"></i>
            <p class="mb-2"><strong>Drop images here or click to select</strong></p>
            <input type="file" name="images[]" id="file-input" class="d-none" multiple accept="image/*" required>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('file-input').click()">
              Choose Files
            </button>
          </div>

          <div class="row g-3 mt-3" id="upload-controls" style="display:none;">
            <div class="col-md-6">
              <label class="form-label">Category</label>
              <select name="category" class="form-select" required>
                <option value="All">All</option>
                <option value="Campus">Campus</option>
                <option value="Events">Events</option>
                <option value="Sports">Sports</option>
                <option value="Academics">Academics</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Selected: <span id="file-count">0</span> files</label>
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-upload"></i> Upload
              </button>
            </div>
          </div>
          <div id="caption-container" class="mt-3"></div>
        </form>

        <!-- Gallery Grid -->
        <div class="row g-4">
          <?php foreach ($gallery as $img): ?>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card img-card h-100 shadow-sm">
              <img src="../uploads/<?= htmlspecialchars($img['filename']) ?>" class="card-img-top gallery-img" alt="">
              <div class="card-body p-3">
                <small class="text-muted d-block mb-2">
                  <strong><?= htmlspecialchars($img['category']) ?></strong>
                  <span class="text-secondary">· <?= date('M j', strtotime($img['uploaded_at'])) ?></span>
                </small>

                <p class="caption-view small text-dark mb-2">
                  <?= nl2br(htmlspecialchars($img['caption'] ?: '<em>No caption</em>')) ?>
                </p>

                <form action="edit_caption.php" method="POST" class="caption-edit">
                  <input type="hidden" name="id" value="<?= $img['id'] ?>">
                  <textarea name="caption" class="form-control form-control-sm mb-2" rows="2" placeholder="Edit caption..."><?= htmlspecialchars($img['caption']) ?></textarea>
                  <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-edit">Cancel</button>
                  </div>
                </form>

                <div class="mt-3 d-flex gap-1">
                  <button class="btn btn-outline-primary btn-sm edit-btn flex-fill">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                  <a href="delete_photo.php?id=<?= $img['id'] ?>"
                     class="btn btn-outline-danger btn-sm"
                     onclick="return confirm('Delete this photo permanently?')">
                    <i class="bi bi-trash"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?php if (empty($gallery)): ?>
          <div class="text-center py-5 text-muted">
            <i class="bi bi-image fs-1"></i>
            <p>No images uploaded yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</div>

<script>
// Sidebar Active State
document.querySelectorAll('.sidebar a[data-section]').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    target.scrollIntoView({ behavior: 'smooth' });
    
    document.querySelectorAll('.sidebar a').forEach(l => l.classList.remove('active'));
    this.classList.add('active');
  });
});

// File Upload UI
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('file-input');
const controls = document.getElementById('upload-controls');
const fileCount = document.getElementById('file-count');
const captionContainer = document.getElementById('caption-container');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
  dropzone.addEventListener(event, e => e.preventDefault());
});

['dragenter', 'dragover'].forEach(event => {
  dropzone.addEventListener(event, () => dropzone.classList.add('dragover'));
});
['dragleave', 'drop'].forEach(event => {
  dropzone.addEventListener(event, () => dropzone.classList.remove('dragover'));
});

dropzone.addEventListener('drop', e => {
  const files = e.dataTransfer.files;
  if (files.length) handleFiles(files);
});
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

function handleFiles(files) {
  fileInput.files = files;
  fileCount.textContent = files.length;
  controls.style.display = 'flex';
  
  captionContainer.innerHTML = '';
  for (let i = 0; i < files.length; i++) {
    captionContainer.innerHTML += `
      <div class="mt-2">
        <label class="form-label small">Caption for <strong>${files[i].name}</strong></label>
        <input type="text" name="captions[]" class="form-control form-control-sm" placeholder="Optional caption">
      </div>`;
  }
}

// Edit Caption Toggle
document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.card');
    card.querySelector('.caption-view').style.display = 'none';
    card.querySelector('.caption-edit').style.display = 'block';
    btn.style.display = 'none';
  });
});
document.querySelectorAll('.cancel-edit').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.card');
    card.querySelector('.caption-view').style.display = 'block';
    card.querySelector('.caption-edit').style.display = 'none';
    card.querySelector('.edit-btn').style.display = 'block';
  });
});
</script>

</body>
</html>