<?php
/**
 * Admin Add Service Form
 */
$this->assign('title', 'Add New Service');
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="p-4 bg-white rounded-4 border shadow-sm">
      <h3 class="brand-font text-wine mb-4"><i class="bi bi-scissors me-2 text-pink"></i>Add Salon Service</h3>

      <?= $this->Form->create($service, ['type' => 'file']) ?>
        <div class="row g-3 mb-3">
          <div class="col-md-8">
            <label class="form-label fw-semibold">Service Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Gold Radiance Skin Ritual" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Category</label>
            <?= $this->Form->select('category_id', $categories, ['class' => 'form-select', 'required' => true]) ?>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Price ($)</label>
            <input type="number" step="0.01" name="price" class="form-control" placeholder="85.00" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Duration (Minutes)</label>
            <input type="number" name="duration_minutes" class="form-control" value="60" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Describe the treatment steps, benefits, products used..."></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Service Image Upload</label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-glamora"><i class="bi bi-check-circle me-1"></i> Save Service</button>
          <a href="<?= $this->Url->build('/admin/services') ?>" class="btn btn-light">Cancel</a>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
