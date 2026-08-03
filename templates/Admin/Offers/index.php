<?php
/**
 * Admin Offers Management Page - Luxury Redesign
 */
$this->assign('title', 'Offers & Discount Management');
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h3 class="brand-font text-wine mb-1"><i class="bi bi-percent me-2 text-pink"></i>Offers & Promo Deals</h3>
    <p class="text-muted small mb-0">Create, edit, and toggle special offers, promo codes, and discount packages</p>
  </div>
  <a href="<?= $this->Url->build('/admin/offers/add') ?>" class="btn btn-book-gradient-pill px-4 py-2 btn-sm fw-bold">
    <i class="bi bi-plus-circle me-1"></i> Add New Offer
  </a>
</div>

<div class="row g-4">
  <?php foreach ($offers as $offer): ?>
    <div class="col-md-6">
      <div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column" style="border-color: #F2E4E8 !important;">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <span class="badge px-3 py-2 rounded-pill fw-bold text-white mb-2" style="background: linear-gradient(135deg, #E87A90 0%, #7A2E44 100%); font-size: 0.8rem;">
              DISCOUNT <?= (int)$offer->discount_percentage ?>% OFF
            </span>
            <h4 class="brand-font text-wine mb-1 fw-bold"><?= h($offer->title) ?></h4>
          </div>
          <?php if (!empty($offer->promo_code)): ?>
            <span class="badge px-3 py-2 rounded-pill fw-bold font-monospace" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.82rem;">
              CODE: <?= h($offer->promo_code) ?>
            </span>
          <?php endif; ?>
        </div>

        <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.9rem; line-height: 1.5;"><?= h($offer->description) ?></p>

        <div class="d-flex align-items-center justify-content-between pt-3 border-top flex-wrap gap-2">
          <small class="text-muted"><i class="bi bi-calendar-event me-1 text-pink"></i> <?= h($offer->start_date) ?> to <?= h($offer->end_date) ?></small>

          <div class="d-flex align-items-center gap-2">
            <?= $this->Form->postLink(
              $offer->is_active ? '🟢 Active' : '🔴 Disabled',
              ['action' => 'toggle', $offer->id],
              ['class' => 'btn btn-' . ($offer->is_active ? 'success' : 'secondary') . ' btn-sm rounded-pill px-3 fw-semibold']
            ) ?>

            <a href="<?= $this->Url->build(['action' => 'edit', $offer->id]) ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Edit</a>
            
            <?= $this->Form->postLink(
              '<i class="bi bi-trash"></i>',
              ['action' => 'delete', $offer->id],
              ['escape' => false, 'confirm' => __('Delete offer {0}?', $offer->title), 'class' => 'btn btn-outline-danger btn-sm rounded-circle']
            ) ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
