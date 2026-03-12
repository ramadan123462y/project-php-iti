<?php
@require __DIR__ . "/../components/bootstrap.php";

?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <div>
      <h1><?= $category["name"] ?></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= url("categories") ?>">categories</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $category["name"] ?></li>
  </ol>
</nav>


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
