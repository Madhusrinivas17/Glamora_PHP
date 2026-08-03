<?php
/**
 * Admin Service Categories Management Page
 */
$this->assign('title', 'Service Categories Management');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="brand-font text-wine mb-1">Service Categories</h3>
    <p class="text-muted small mb-0">Manage beauty categories (Hair, Saree Draping, Makeup, Facial, Skin Care, Nails, Bridal, Packages)</p>
  </div>
  
  <button class="btn btn-glamora" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    <i class="bi bi-plus-circle me-1"></i> Add New Category
  </button>
</div>

<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Icon</th>
          <th>Category Name</th>
          <th>Slug</th>
          <th>Services Count</th>
          <th>Description</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td>
              <div class="avatar-circle rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px; background:#FDE8ED; color:#E87A90;">
                <i class="bi <?= h($cat->icon ?: 'bi-tag-fill') ?> fs-5"></i>
              </div>
            </td>
            <td><strong class="text-wine fs-6"><?= h($cat->name) ?></strong></td>
            <td><code class="text-pink fw-bold"><?= h($cat->slug) ?></code></td>
            <td>
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.8rem;">
                <?= count($cat->services ?? []) ?> Services
              </span>
            </td>
            <td><small class="text-muted"><?= h($cat->description ?: 'No description added') ?></small></td>
            <td class="text-end">
              <button class="btn btn-outline-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat->id ?>">
                <i class="bi bi-pencil"></i> Edit
              </button>

              <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i>',
                ['action' => 'delete', $cat->id],
                ['escape' => false, 'confirm' => __('Delete category {0}?', $cat->name), 'class' => 'btn btn-outline-danger btn-sm']
              ) ?>
            </td>
          </tr>

          <!-- Modal: Edit Category -->
          <div class="modal fade text-start" id="editCategoryModal<?= $cat->id ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header border-0">
                  <h5 class="modal-title brand-font text-wine"><i class="bi bi-pencil-square me-2 text-pink"></i>Edit Category - <?= h($cat->name) ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <?= $this->Form->create(null, ['url' => ['action' => 'edit', $cat->id]]) ?>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Category Name</label>
                      <input type="text" name="name" class="form-control" value="<?= h($cat->name) ?>" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Icon Class (Bootstrap Icons)</label>
                      <input type="text" name="icon" class="form-control" value="<?= h($cat->icon ?: 'bi-sparkles') ?>" placeholder="e.g. bi-scissors, bi-gem, bi-palette">
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Description</label>
                      <textarea name="description" class="form-control" rows="2"><?= h($cat->description) ?></textarea>
                    </div>
                  </div>

                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-glamora">Save Changes</button>
                  </div>
                <?= $this->Form->end() ?>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal: Add New Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title brand-font text-wine"><i class="bi bi-folder-plus me-2 text-pink"></i>Add New Service Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Hair, Saree Draping, Facial, Nails" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Bootstrap Icon Class</label>
            <input type="text" name="icon" class="form-control" placeholder="e.g. bi-scissors, bi-gem, bi-sparkles" value="bi-sparkles">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Category description..."></textarea>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-glamora"><i class="bi bi-plus-circle me-1"></i> Add Category</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
