<?php
@require __DIR__ . "/../components/bootstrap.php";

?>

<div class="pageContainer">
  <div class="hstack-wrap mb-4">
    <h1>Categories</h1>
    <a class="btn btn-primary" href="<?= url('categories/create') ?>">Add +</a>
  </div>

  <div class="table-responsive">
    <table class="table table-fixed-height">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category): ?>


          <tr>
            <td> <?= $category["name"] ?></td>
            <td>

                <a href="<?= url("categories/show/{$category['id']}") ?>" class="btn btn-sm btn-primary-subtle">View</a>
        <!-- Button trigger modal -->


                <a href="<?= url('categories/edit/'.$category['id']) ?>" class="btn btn-sm btn-dark-subtle">Edit</a>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-sm btn-danger-subtle" data-bs-toggle="modal" data-bs-target="#deleteModal<?=$category['id']?>">
          Delete
        </button>


<!-- Modal -->
<div class="modal fade" id="deleteModal<?=$category['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel<?=$category['id']?>">Delete Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          Are you sure you want to Delete Category <?= $category['name'] ?>?
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form action="<?= url("categories/delete/{$category['id']}") ?>" method="POST">
            <button type="submit" class="btn btn-danger">Delete</button>
            <input type="hidden" name="page" value="<?= $currentPage ?>">
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
    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('categories?page=1') ?>"><i class="fa-solid fa-angles-left"></i>
</a></li>
    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('categories?page='.$currentPage - 1) ?>"><i class="fa-solid fa-angle-left"></i></a></li>

    <?php if($currentPage > 2): ?>
    <li class="page-item"><a class="page-link" href="<?= url('categories?page='.$currentPage - 2) ?>"><?= $currentPage - 2 ?></a></li>
    <?php endif; ?>

    <?php if($currentPage > 1): ?>
    <li class="page-item"><a class="page-link" href="<?= url('categories?page='.$currentPage - 1) ?>"><?= $currentPage - 1 ?></a></li>
    <?php endif; ?>

    <li class="page-item active"><a class="page-link" href="<?= url('categories?page='.$currentPage) ?>"><?= $currentPage ?></a></li>

    <?php if($currentPage < $totalPages): ?>
    <li class="page-item"><a class="page-link" href="<?= url('categories?page='.$currentPage + 1) ?>"><?= $currentPage + 1 ?></a></li>
    <?php endif; ?>

    <?php if($currentPage + 1 < $totalPages): ?>
    <li class="page-item"><a class="page-link" href="<?= url('categories?page='.$currentPage + 2) ?>"><?= $currentPage + 2 ?></a></li>
    <?php endif; ?>


    <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('categories?page='.$currentPage + 1) ?>"><i class="fa-solid fa-angle-right"></i></a></li>
    <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('categories?page='.$totalPages) ?>"><i class="fa-solid fa-angles-right"></i></a></li>

  </ul>
</nav>

</div>