<?php
/**
 * Admin Holiday & Blocked Dates Management Page
 */
$this->assign('title', 'Holiday Calendar & Blocked Dates');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="brand-font text-wine mb-1">Salon Holiday Calendar</h3>
    <p class="text-muted small mb-0">Set weekly rest days, festival closures, or emergency leave dates</p>
  </div>
  
  <button class="btn btn-glamora" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
    <i class="bi bi-calendar-plus me-1"></i> Add Holiday Date
  </button>
</div>

<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Date</th>
          <th>Holiday / Event Title</th>
          <th>Type</th>
          <th>Description</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($holidays as $h): ?>
          <tr>
            <td><strong class="text-wine"><i class="bi bi-calendar-x me-2 text-danger"></i><?= h($h->holiday_date) ?></strong></td>
            <td><span class="fw-bold text-wine"><?= h($h->title) ?></span></td>
            <td>
              <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill text-uppercase">
                <?= h($h->holiday_type) ?>
              </span>
            </td>
            <td><small class="text-muted"><?= h($h->description) ?></small></td>
            <td class="text-end">
              <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i> Remove Holiday',
                ['action' => 'delete', $h->id],
                ['escape' => false, 'confirm' => __('Remove holiday on {0}?', $h->holiday_date), 'class' => 'btn btn-outline-danger btn-sm']
              ) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal: Add Holiday -->
<div class="modal fade" id="addHolidayModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title brand-font text-wine"><i class="bi bi-calendar-x me-2 text-danger"></i>Add Salon Holiday</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Holiday Date</label>
            <input type="date" name="holiday_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Holiday Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Independence Day / Weekly Rest" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Holiday Type</label>
            <select name="holiday_type" class="form-select">
              <option value="festival">Festival Holiday</option>
              <option value="weekly">Weekly Rest Day</option>
              <option value="leave">Staff / Parlour Maintenance</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Notes / Details</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Closed all day for national festival..."></textarea>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-glamora">Save Holiday Date</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
