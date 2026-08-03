<?php
/**
 * Admin Edit Offer Form
 */
$this->assign('title', 'Edit Offer');
?>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="p-4 bg-white rounded-4 border shadow-sm">
      <h3 class="brand-font text-wine mb-4"><i class="bi bi-pencil-square me-2 text-pink"></i>Edit Offer</h3>

      <?= $this->Form->create($offer, ['type' => 'file']) ?>
        <div class="mb-3">
          <label class="form-label fw-semibold">Offer Title</label>
          <input type="text" name="title" class="form-control" value="<?= h($offer->title) ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Discount Percentage (%)</label>
            <input type="number" step="0.5" name="discount_percentage" class="form-control" value="<?= h($offer->discount_percentage) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Promo Code</label>
            <input type="text" name="promo_code" class="form-control" value="<?= h($offer->promo_code) ?>">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= h($offer->start_date) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= h($offer->end_date) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3"><?= h($offer->description) ?></textarea>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-glamora">Update Offer</button>
          <a href="<?= $this->Url->build('/admin/offers') ?>" class="btn btn-light">Cancel</a>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
