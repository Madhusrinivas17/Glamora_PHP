<?php
/**
 * Admin Add Offer Form
 */
$this->assign('title', 'Add Offer');
?>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="p-4 bg-white rounded-4 border shadow-sm">
      <h3 class="brand-font text-wine mb-4"><i class="bi bi-percent me-2 text-pink"></i>Create New Offer</h3>

      <?= $this->Form->create($offer, ['type' => 'file']) ?>
        <div class="mb-3">
          <label class="form-label fw-semibold">Offer Title</label>
          <input type="text" name="title" class="form-control" placeholder="e.g., Grand Opening Special - 20% Off" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Discount Percentage (%)</label>
            <input type="number" step="0.5" name="discount_percentage" class="form-control" placeholder="20.00" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Promo Code (Optional)</label>
            <input type="text" name="promo_code" class="form-control" placeholder="GLAMORA20">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Terms & conditions or deal details..."></textarea>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-glamora">Save Offer</button>
          <a href="<?= $this->Url->build('/admin/offers') ?>" class="btn btn-light">Cancel</a>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
