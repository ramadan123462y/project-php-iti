<?php
require __DIR__ . '/../components/AdminNavbar.php';
@require __DIR__ . "/../components/bootstrap.php";

?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <div>
      <h1><?= $product["name"] ?></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= url("products") ?>">products</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $product["name"] ?></li>
  </ol>
</nav>


    </div>
    <a class="btn btn-primary" href="<?= url("products/edit/{$product['id']}") ?>">Edit</a>
  </div>

  <div class="row mt-4">
  <div class="col-md-4">
    <img
      src="<?= url("assets/images/products/{$product['image']}")?>"
      class="img-fluid rounded shadow-sm"
      alt="<?= $product['name'] ?>"
    >
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-body">


        <p class="mb-2">
          <strong>Price:</strong> $<?= $product["price"] ?>
        </p>

        <p class="mb-2">
          <strong>Category:</strong> <?= $product["category_name"] ?>
        </p>

        <p class="mb-2">
          <strong>Status:</strong>
          <span class="badge <?= $product["is_available"] ? 'bg-success' : 'bg-secondary' ?>">
            <?= $product["is_available"] ? 'Available' : 'Unavailable' ?>
          </span>
        </p>

      </div>
    </div>
  </div>
</div>
</div>
