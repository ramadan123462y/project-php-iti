<?php
require __DIR__ . '/../components/AdminNavbar.php';
@require __DIR__ . "/../components/bootstrap.php";

?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <h1>Products</h1>
    <div class="hstack-wrap gap-2">
      <a class="btn btn-primary-subtle" href="<?= url('categories') ?>">Categories</a>

      <a class="btn btn-primary" href="<?= url('products/create') ?>">Add +</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-fixed-height">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Price</th>
          <th>Image</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>

          <tr class="<?= $product["is_available"] == 1 ? '' : 'table-secondary' ?>">
            <td> <?= $product["name"] ?></td>
            <td> <?= $product["price"] ?></td>
            <td>
              <div class="tableImageDiv"> <img src="../public/assets/images/products/<?= $product["image"] ?>" /> </div>
            </td>
            <td> <?= $product["category_name"] ?></td>
            <td>

              <a href="<?= url("products/show/{$product['id']}") ?>" class="btn btn-sm btn-primary-subtle">View</a>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-sm <?= $product["is_available"] == 1 ? 'btn-warning-subtle' : 'btn-success-subtle' ?>" data-bs-toggle="modal" data-bs-target="#enableModal<?= $product['id'] ?>">
                <?= $product["is_available"] == 1 ? 'Disable' : 'Enable' ?>
              </button>


              <!-- Modal -->
              <div class="modal fade" id="enableModal<?= $product['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel<?= $product['id'] ?>"><?= $product["is_available"] == 1 ? 'Disable' : 'Enable' ?> Product</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to <?= $product["is_available"] == 1 ? 'Disable' : 'Enable' ?> Product <?= $product['name'] ?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <form action="<?= url("products/toggle/{$product['id']}") ?>" method="POST">
                        <button type="submit" class="btn <?= $product["is_available"] == 1 ? 'btn-warning' : 'btn-success' ?>""><?= $product["is_available"] == 1 ? 'Disable' : 'Enable' ?></button>
            <input type=" hidden" name="page" value="<?= $currentPage ?>">
                      </form>

                    </div>
                  </div>
                </div>
              </div>
              <a href="<?= url('products/edit/' . $product['id']) ?>" class="btn btn-sm btn-dark-subtle">Edit</a>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-sm btn-danger-subtle" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $product['id'] ?>">
                Delete
              </button>


              <!-- Modal -->
              <div class="modal fade" id="deleteModal<?= $product['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel<?= $product['id'] ?>">Delete Product</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to Delete Product <?= $product['name'] ?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <form action="<?= url("products/delete/{$product['id']}") ?>" method="POST">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <input type="hidden" name="page" value="<?= $currentPage ?>">
                        <input type="hidden" name="image" value="<?= $product['image'] ?>">

                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </td>
          </tr>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>




  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('products?page=1') ?>"><i class="fa-solid fa-angles-left"></i>
        </a></li>
      <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('products?page=' . $currentPage - 1) ?>"><i class="fa-solid fa-angle-left"></i></a></li>

      <?php if ($currentPage > 2): ?>
        <li class="page-item"><a class="page-link" href="<?= url('products?page=' . $currentPage - 2) ?>"><?= $currentPage - 2 ?></a></li>
      <?php endif; ?>

      <?php if ($currentPage > 1): ?>
        <li class="page-item"><a class="page-link" href="<?= url('products?page=' . $currentPage - 1) ?>"><?= $currentPage - 1 ?></a></li>
      <?php endif; ?>

      <li class="page-item active"><a class="page-link" href="<?= url('products?page=' . $currentPage) ?>"><?= $currentPage ?></a></li>

      <?php if ($currentPage < $totalPages): ?>
        <li class="page-item"><a class="page-link" href="<?= url('products?page=' . $currentPage + 1) ?>"><?= $currentPage + 1 ?></a></li>
      <?php endif; ?>

      <?php if ($currentPage + 1 < $totalPages): ?>
        <li class="page-item"><a class="page-link" href="<?= url('products?page=' . $currentPage + 2) ?>"><?= $currentPage + 2 ?></a></li>
      <?php endif; ?>


      <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('products?page=' . $currentPage + 1) ?>"><i class="fa-solid fa-angle-right"></i></a></li>
      <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('products?page=' . $totalPages) ?>"><i class="fa-solid fa-angles-right"></i></a></li>

    </ul>
  </nav>

</div>