<?php
require __DIR__ . '/../components/AdminNavbar.php';
@require __DIR__ . "/../components/bootstrap.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);


?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <div>

      <h1>New Product</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= url("products") ?>">products</a></li>
          <li class="breadcrumb-item active" aria-current="page">New</li>
        </ol>
      </nav>
    </div>

  </div>

  <form action="<?= url('products/store') ?>" method="POST" enctype="multipart/form-data" class="mt-4">

  <div class="mb-3">
    <label class="form-label">Product Name</label>
    <input
      type="text"
      name="name"
      class="form-control"
      placeholder="Enter product name"
      value="<?= $old['name'] ?? '' ?>"
      required
    >
    <!-- <?php if (isset($errors['name'])): ?> -->
      <div class="error"><?= $errors['name'] ?></div>
    <!-- <?php endif; ?> -->
  </div>

  <div class="mb-3">
    <label class="form-label">Price</label>
    <input
      type="number"
      name="price"
      class="form-control"
      step="0.1"
      value="<?= $old['price'] ?? '' ?>"

      placeholder="Enter product price"
      required
    >
    <?php if (isset($errors['price'])): ?>
      <div class="error"><?= $errors['price'] ?></div>
    <?php endif; ?>

  </div>

  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <option value="">Select Category</option>

      <?php foreach ($categories as $category): ?>
        <option value="<?= $category['id'] ?>"
        <?= (isset($old['category_id']) && $old['category_id'] == $category['id']) ? 'selected' : '' ?>>
          <?= $category['name'] ?>
        </option>
      <?php endforeach; ?>

    </select>

    <?php if (isset($errors['category_id'])): ?>
      <div class="error"><?= $errors['category_id'] ?></div>
    <?php endif; ?>

  </div>

  <div class="mb-3">
    <label class="form-label">Product Image</label>
    <input
      type="file"
      name="image"
      id="imageInput"
      class="form-control"
      accept="image/*"
    >

    <?php if (isset($errors['image'])): ?>
      <div class="error"><?= $errors['image'] ?></div>
    <?php endif; ?>
    <img id="imagePreview" style="display:none; max-width:200px; margin-top:10px;">

  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
      Create Product
    </button>

    <input type="reset" id="reset" class="btn btn-secondary" value="Reset" />
  </div>

</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const imageInput = document.getElementById('imageInput');
  const imagePreview = document.getElementById('imagePreview');
  const resetButton = document.getElementById('reset');

  imageInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      imagePreview.style.display = 'none';
      imagePreview.src = '';
    }
  });

  resetButton.addEventListener('click', function() {
      imagePreview.style.display = 'none';
      imagePreview.src = '';
  })

});
</script>