<?php
/**
 * Admin Service Management Page
 */
$this->assign('title', 'Service Management & Pricing');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="brand-font text-wine mb-1">Salon Services & Pricing</h3>
    <p class="text-muted small mb-0">Add, edit, or remove salon services, prices, and durations</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= $this->Url->build('/admin/categories') ?>" class="btn btn-glamora-outline">
      <i class="bi bi-tags me-1"></i> Manage Categories
    </a>
    <a href="<?= $this->Url->build('/admin/services/add') ?>" class="btn btn-glamora">
      <i class="bi bi-plus-circle me-1"></i> Add New Service
    </a>
  </div>
</div>

<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Image</th>
          <th>Service Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Duration</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $srv): ?>
          <tr>
            <td>
              <img src="<?= $this->Url->build('/img/' . ($srv->image ?: 'service_default.jpg')) ?>" alt="<?= h($srv->name) ?>" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=100&q=80'">
            </td>
            <td>
              <strong class="text-wine d-block"><?= h($srv->name) ?></strong>
              <small class="text-muted"><?= h(substr($srv->description ?? '', 0, 50)) ?>...</small>
            </td>
            <td>
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.8rem;">
                <?= h($srv->service_category ? $srv->service_category->name : 'General') ?>
              </span>
            </td>
            <td class="fw-bold text-wine fs-6">Rs. <?= number_format((float)$srv->price, 2) ?></td>
            <td><i class="bi bi-clock me-1 text-muted"></i> <?= (int)$srv->duration_minutes ?> mins</td>
            <td>
              <span class="badge bg-<?= $srv->is_active ? 'success' : 'secondary' ?>-subtle text-<?= $srv->is_active ? 'success' : 'secondary' ?> px-3 py-1">
                <?= $srv->is_active ? 'Active' : 'Inactive' ?>
              </span>
            </td>
            <td class="text-end">
              <a href="<?= $this->Url->build(['action' => 'edit', $srv->id]) ?>" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i> Delete',
                ['action' => 'delete', $srv->id],
                ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $srv->name), 'class' => 'btn btn-outline-danger btn-sm']
              ) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
