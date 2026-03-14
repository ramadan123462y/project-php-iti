         <h6 class="text-uppercase ls-wide fw-bold text-muted mb-3">Full Menu</h6>
                <div class="row row-cols-2 row-cols-md-4 g-4">
                    <?php foreach ($products as $product) : ?>
                        <div class="col">
                            <div class="card card-drink shadow-sm h-100 p-3 text-center border-0">
                                <div class="text-end mb-2">
                                    <span class="badge rounded-pill badge-price"><?= e($product['price']) ?></span>
                                </div>
                                <div class="mb-3">
                                    <?= $product['image'] ?> </div>
                                <h6 class="fw-bold"><?= e($product['name']) ?></h6>
                                <form method="POST" action="<?= url('/Order/addToCart') ?>">
                                    <input type="hidden" name="product_id" value="<?= e($product['id']) ?>">
                                    <input type="hidden" name="redirect_to" value="<?= e($redirectTo ?? '/Order') ?>">
                                    <button class="btn btn-confirm w-100 py-2 fw-bold shadow-sm">
                                        ADD +
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    
