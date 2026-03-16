<?php
require __DIR__ . '/../components/AdminNavbar.php';
@require __DIR__ . "/../components/bootstrap.php";

?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <div>
      <h1><?= $category["name"] ?></h1>


    </div>
    <a class="btn btn-primary" href="<?= url("categories/edit/{$category['id']}") ?>">Edit</a>
  </div>

  <div class="row mt-4">

  <div class="col-md-12">
    <div class="card">
      <div class="card-body">

        <p class="mb-2">
          <strong>Category:</strong> <?= $category["name"] ?>
        </p>

      </div>
    </div>
  </div>
</div>
</div>
