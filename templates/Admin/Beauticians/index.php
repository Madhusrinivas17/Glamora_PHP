<?php
/**
 * Admin Beautician Roster Management Page - Photo-Free Clean List View
 */
$this->assign('title', 'Beauticians Management');
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h3 class="brand-font text-wine mb-1"><i class="bi bi-people-fill me-2 text-pink"></i>Beauticians & Master Stylists</h3>
    <p class="text-muted small mb-0">Manage staff details and leave availability</p>
  </div>
  <a href="<?= $this->Url->build('/admin/beauticians/add') ?>" class="btn btn-book-gradient-pill px-4 py-2 btn-sm fw-bold">
    <i class="bi bi-person-plus me-1"></i> Add Beautician
  </a>
</div>

<!-- Photo-Free Clean Table List View -->
<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Beautician Name</th>
          <th>Specialization</th>
          <th>Experience</th>
          <th>Rating</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($beauticians as $b): ?>
          <tr>
            <td><strong><?= $b->id ?></strong></td>
            <td>
              <div class="fw-bold text-wine fs-6"><?= h($b->name) ?></div>
            </td>
            <td>
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.82rem;">
                <?= h($b->specialization ?: 'General Stylist') ?>
              </span>
            </td>
            <td>
              <span class="small text-muted"><i class="bi bi-briefcase me-1 text-pink"></i> <?= (int)$b->experience_years ?> Years</span>
            </td>
            <td>
              <span class="fw-semibold text-warning"><i class="bi bi-star-fill me-1"></i> <?= number_format((float)$b->rating, 2) ?></span>
            </td>
            <td>
              <?php if ($b->leave_status): ?>
                <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill small fw-bold">🔴 ON LEAVE</span>
              <?php else: ?>
                <span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill small fw-bold">🟢 AVAILABLE</span>
              <?php endif; ?>
            </td>
            <td class="text-end">
              <a href="<?= $this->Url->build(['action' => 'edit', $b->id]) ?>" class="btn btn-outline-secondary btn-sm me-1 rounded-pill px-3">
                <i class="bi bi-pencil me-1"></i> Edit
              </a>

              <?= $this->Form->postLink(
                $b->leave_status ? '<i class="bi bi-person-check me-1"></i> Back to Duty' : '<i class="bi bi-person-x me-1"></i> Mark Leave',
                ['action' => 'toggleLeave', $b->id],
                ['escape' => false, 'class' => 'btn btn-outline-warning btn-sm me-1 rounded-pill px-3']
              ) ?>

              <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i>',
                ['action' => 'delete', $b->id],
                ['escape' => false, 'confirm' => __('Delete beautician {0}?', $b->name), 'class' => 'btn btn-outline-danger btn-sm rounded-circle']
              ) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
