<div class="container-fluid bg-white shadow-sm py-3 mb-4 " style="top: 60px; z-index: 800;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <form method="GET" action="<?= url($currentPagePath ?? '/Order') ?>">
                    <?php if (!empty($selectedUserId)) : ?>
                        <input type="hidden" name="user" value="<?= e($selectedUserId) ?>">
                    <?php endif; ?>
                    
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-lg border-end-0"
                            placeholder="Search for products..."
                            value="<?= e($_GET['search'] ?? '') ?>"
                            style="background: #f8f9fa;">

                        <?php if (!empty($_GET['search'])) : ?>
                            <a href="<?= url($redirectTo ?? ($currentPagePath ?? '/Order')) ?>" 
                               class="btn btn-outline-secondary border-start-0 bg-white">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>