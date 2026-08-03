<?php
/**
 * Glamora Special Offers & Promo Packages View - Horizontal List
 */
$this->assign('title', 'Special Offers & Packages - Glamora');
?>

<div class="mb-5 text-center">
  <span class="badge px-4 py-2 rounded-pill fw-bold text-uppercase mb-2 d-inline-block" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.85rem;">
    <i class="bi bi-stars me-1 text-gold"></i> LIMITED TIME SALON DEALS
  </span>
  <h2 class="brand-font text-wine display-6 mb-2">Special Offers & Promo Packages</h2>
  <p class="text-muted small mx-auto mb-0" style="max-width: 540px;">
    Treat yourself to our signature beauty packages, seasonal hair spa discounts, and exclusive salon vouchers.
  </p>
</div>

<?php if (empty($offers) || count($offers) === 0): ?>
  <div class="glamora-card p-5 text-center rounded-4 shadow-sm bg-white">
    <i class="bi bi-tag display-3 text-pink mb-3 d-block"></i>
    <h4 class="brand-font text-wine">No Active Offers Currently</h4>
    <p class="text-muted mb-4">Check back soon for upcoming holiday discounts and bridal package deals!</p>
    <a href="<?= $this->Url->build('/services') ?>" class="btn btn-book-gradient-pill px-4 py-2">Explore Services</a>
  </div>
<?php else: ?>
  
  <div class="offers-horizontal-list">
    <?php foreach ($offers as $offer): ?>
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-3" style="border: 1px solid #F2E4E8 !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          
          <!-- 1. Discount Badge & Icon -->
          <div class="d-flex align-items-center gap-3" style="min-width: 180px;">
            <div class="rounded-4 d-flex flex-column align-items-center justify-content-center text-white text-center p-3 shadow-sm" 
                 style="width: 100px; height: 85px; background: linear-gradient(135deg, #E87A90 0%, #7A2E44 100%);">
              <span class="fs-4 fw-bold leading-none"><?= (int)$offer->discount_percentage ?>%</span>
              <span class="text-xs fw-bold text-uppercase" style="font-size:0.65rem;">OFF DEAL</span>
            </div>

            <div class="d-none d-sm-block">
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.8rem;">PROMO PACKAGE</span>
            </div>
          </div>

          <!-- 2. Offer Title, Description & Expiry -->
          <div class="flex-grow-1" style="min-width: 250px;">
            <div class="d-flex align-items-center gap-2 mb-1">
              <h4 class="brand-font text-wine mb-0 fw-bold"><?= h($offer->title) ?></h4>
              <?php if (!empty($offer->promo_code)): ?>
                <span class="badge px-3 py-1 rounded-pill font-monospace fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.75rem;">
                  CODE: <?= h($offer->promo_code) ?>
                </span>
              <?php endif; ?>
            </div>

            <p class="text-muted small mb-2" style="font-size: 0.88rem; line-height: 1.4;">
              <?= h($offer->description ?: 'Exclusive salon discount package session.') ?>
            </p>

            <span class="small text-muted" style="font-size: 0.8rem;">
              <i class="bi bi-calendar3 me-1 text-pink"></i> Valid through: <strong class="text-wine"><?= h($offer->end_date) ?></strong>
            </span>
          </div>

          <!-- 3. Copy Code & Claim Actions -->
          <div class="d-flex align-items-center gap-2 ms-auto">
            <?php if (!empty($offer->promo_code)): ?>
              <button type="button" class="btn btn-outline-dark-pill btn-sm px-3 py-2 fw-bold font-monospace" onclick="copyCode('<?= h($offer->promo_code) ?>', this)">
                <i class="bi bi-copy me-1"></i> Copy Code
              </button>
            <?php endif; ?>

            <a href="<?= $this->Url->build(['controller' => 'Appointments', 'action' => 'book', '?' => ['promo' => $offer->promo_code]]) ?>" class="btn btn-book-gradient-pill btn-sm px-4 py-2 fw-bold">
              Claim Deal ✨
            </a>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php endif; ?>

<script>
function copyCode(code, btn) {
  navigator.clipboard.writeText(code).then(() => {
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Copied!';
    setTimeout(() => {
      btn.innerHTML = originalText;
    }, 2000);
  });
}
</script>
