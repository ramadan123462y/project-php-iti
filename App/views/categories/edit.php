<?php
@require __DIR__ . "/../components/bootstrap.php";

session_start();

$old = $_SESSION['old'] ?? $category ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);


?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <div>

      <h1>Edit Category <?= $category['name'] ?></h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= url("categories") ?>">categories</a></li>
          <li class="breadcrumb-item"><a href="<?= url("categories/show/".$category['id']) ?>"><?= $category['name'] ?></a></li>
          <li class="breadcrumb-item">Edit</li>
        </ol>
      </nav>
    </div>

  </div>

  <form action="<?= url('categories/update/'.$category['id']) ?>" method="POST" enctype="multipart/form-data" class="mt-4">

  <div class="mb-3">
    <label class="form-label">Category Name</label>
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <input
      type="text"
      name="name"
      class="form-control"
      placeholder="Enter category name"
      value="<?= $old['name'] ?? '' ?>"
      required
    >
    <!-- <?php if (isset($errors['name'])): ?> -->
      <div class="error"><?= $errors['name'] ?></div>
    <!-- <?php endif; ?> -->
  </div>


  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
      Edit
    </button>

    <input type="reset" id="reset" class="btn btn-secondary" value="Reset" />
  </div>

</form>
</div>

