 <div class="col-lg-4 order-last order-lg-first">
     <div class="card card-drink shadow-sm p-4 sticky-sidebar">
         <?php if (!empty($_SESSION['errors'])): ?>
             <div class="alert alert-danger">
                 <ul class="mb-0">
                     <?php foreach ($_SESSION['errors'] as $messages): ?>
                         <?php foreach ($messages as $message): ?>
                             <li><?= e($message) ?></li>
                         <?php endforeach; ?>
                     <?php endforeach; ?>
                 </ul>
             </div>

             <?php unset($_SESSION['errors']); ?>
         <?php endif; ?>
         <?php if (!empty($_SESSION['success'])): ?>
             <div class="alert alert-success">
                 <?= $_SESSION['success']; ?>
             </div>
             <?php unset($_SESSION['success']); ?>
         <?php endif; ?>
         <h5 class="fw-bold mb-4 border-bottom pb-2">Your Cart</h5>

         <?php foreach ($cart as $item) : ?>
             <div class="d-flex align-items-center justify-content-between mb-3">
                 <div>
                     <p class="mb-0 fw-bold"><?= e($item['name']) ?></p>
                     <small class="text-muted"><?= e($item['price']) ?> EGP</small>
                 </div>
                 <div class="d-flex align-items-center gap-2">
                     <form method="POST" action="<?= url('/Order/addToCart') ?>">
                         <input type="hidden" name="product_id" value="<?= e($item['id']) ?>">
                         <input type="hidden" name="redirect_to" value="<?= e($redirectTo ?? '/Order') ?>">
                         <input type="number"
                             name="quantity"
                             min="1"
                             class="form-control form-control-sm"
                             style="width: 60px"
                             value="<?= e($item['quantity']) ?>"
                             onchange="this.form.submit()">
                     </form>
                     <span class="fw-bold text-nowrap"><?= e($item['price'] * $item['quantity']) ?></span>
                     <form method="POST" action="<?= url('/Order/remove') ?>">
                         <input type="hidden" name="product_id" value="<?= e($item['id']) ?>">
                         <input type="hidden" name="redirect_to" value="<?= e($redirectTo ?? '/Order') ?>">
                         <button class="btn btn-sm text-danger">
                             <i class="bi bi-trash"></i>
                         </button>
                     </form>
                 </div>
             </div>
         <?php endforeach; ?>

         <form method="POST" action="<?= url('/Order/store') ?>">
             <input type="hidden" name="redirect_to" value="<?= e($redirectTo ?? '/Order') ?>">
             <?php if (!empty($selectedUserId)) : ?>
                 <input type="hidden" name="user_id" value="<?= e($selectedUserId) ?>">
             <?php endif; ?>
             <div class="mb-3 mt-4">
                 <label class="form-label fw-semibold small">Notes</label>
                 <textarea name="notes" class="form-control bg-light border-0" rows="2" placeholder="e.g. Extra Sugar"><?= e($notes ?? '') ?></textarea>
             </div>

             <div class="mb-4">
                 <label class="form-label fw-semibold small">Delivery Room</label>
                 <select class="form-select bg-light border-0" name="room">
                     <?php foreach ($rooms as $room) : ?>
                         <option value="<?= e($room['id']) ?>"><?= e($room['name']) ?></option>
                     <?php endforeach; ?>
                 </select>
             </div>

             <div class="d-flex justify-content-between align-items-center py-3 border-top mt-auto">
                 <span class="h5 mb-0 fw-bold">Total</span>
                 <span class="h4 mb-0 fw-bold text-success"><?= e($total) ?></span>
             </div>

             <button class="btn btn-confirm w-100 py-2 fw-bold shadow-sm">
                 CONFIRM & SEND
             </button>
         </form>
     </div>
 </div>