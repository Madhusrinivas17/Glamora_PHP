<?php
/**
 * Admin Edit Beautician Form
 */
$this->assign('title', 'Edit Beautician - ' . h($beautician->name));
?>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="p-4 bg-white rounded-4 border shadow-sm">
      <h3 class="brand-font text-wine mb-4"><i class="bi bi-pencil-square me-2 text-pink"></i>Edit Beautician Profile</h3>

      <?= $this->Form->create($beautician, ['type' => 'file']) ?>
        <div class="mb-3">
          <label class="form-label fw-semibold">Beautician Name</label>
          <input type="text" name="name" class="form-control" value="<?= h($beautician->name) ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="<?= h($beautician->specialization) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Experience (Years)</label>
            <input type="number" name="experience_years" class="form-control" value="<?= h($beautician->experience_years) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Bio / Expertise Summary</label>
          <textarea name="bio" class="form-control" rows="3"><?= h($beautician->bio) ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Replace Profile Photo</label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-glamora"><i class="bi bi-save me-1"></i> Update Profile</button>
          <a href="<?= $this->Url->build('/admin/beauticians') ?>" class="btn btn-light">Cancel</a>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
