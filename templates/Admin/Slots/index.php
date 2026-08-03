<?php
/**
 * Admin Slot Management Page - Clean Aggregated Everyday Time Slots View
 */
$this->assign('title', 'Slot & Schedule Management');
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h3 class="brand-font text-wine mb-1"><i class="bi bi-clock-history me-2 text-pink"></i>Appointment Time Slots</h3>
    <p class="text-muted small mb-0">Master schedule of everyday operating time slots for salon beauticians</p>
  </div>
  
  <div class="d-flex gap-2 flex-wrap">
    <button class="btn btn-book-gradient-pill px-3 py-2 btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addSlotModal">
      <i class="bi bi-plus-circle me-1"></i> Add Everyday Slot
    </button>

    <button class="btn btn-outline-dark-pill px-3 py-2 btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#generateSlotsModal">
      <i class="bi bi-magic me-1"></i> Bulk Generate Slots
    </button>

    <?php if (!empty($slots) && count($slots) > 0): ?>
      <?= $this->Form->postLink(
        '<i class="bi bi-trash3-fill me-1"></i> Clear All Slots',
        ['action' => 'deleteAll', '?' => ['beautician_id' => $selectedBeautician]],
        ['escape' => false, 'confirm' => __('Are you SURE you want to clear ALL time slots? This action cannot be undone.'), 'class' => 'btn btn-danger btn-sm px-3 py-2 rounded-pill fw-bold shadow-sm']
      ) ?>
    <?php endif; ?>
  </div>
</div>

<!-- Beautician Filter Tabs Header -->
<div class="mb-4 d-flex align-items-center gap-2 flex-wrap">
  <a href="<?= $this->Url->build('/admin/slots') ?>" 
     class="btn btn-sm rounded-pill px-3 py-2 fw-bold <?= empty($selectedBeautician) ? 'btn-pink-active' : 'btn-pink-outline' ?>">
    <i class="bi bi-people-fill me-1"></i> All Beauticians
  </a>

  <a href="<?= $this->Url->build(['action' => 'index', '?' => ['beautician_id' => 'unassigned']]) ?>" 
     class="btn btn-sm rounded-pill px-3 py-2 fw-bold <?= ($selectedBeautician === 'unassigned') ? 'btn-pink-active' : 'btn-pink-outline' ?>">
    <i class="bi bi-dash-circle me-1"></i> Unassigned Slots
  </a>

  <?php foreach ($allBeauticians as $b): ?>
    <a href="<?= $this->Url->build(['action' => 'index', '?' => ['beautician_id' => $b->id]]) ?>" 
       class="btn btn-sm rounded-pill px-3 py-2 fw-bold <?= ((string)$selectedBeautician === (string)$b->id) ? 'btn-pink-active' : 'btn-pink-outline' ?>">
      <i class="bi bi-person-fill me-1"></i> <?= h($b->name) ?>
    </a>
  <?php endforeach; ?>
</div>

<!-- Separated Beautician Everyday Time Slots Sections -->
<?php if (empty($uniqueSlotsByBeautician) || count($uniqueSlotsByBeautician) === 0): ?>
  <div class="p-5 bg-white rounded-4 border text-center shadow-sm">
    <i class="bi bi-calendar-x text-pink display-4 mb-3 d-block"></i>
    <h5 class="brand-font text-wine">No Time Slots Found</h5>
    <p class="text-muted small mb-3">Click Add Everyday Slot or Bulk Generate Slots to create appointment time slots.</p>
  </div>
<?php else: ?>
  <?php foreach ($uniqueSlotsByBeautician as $beauticianName => $bTimings): ?>
    <div class="p-4 bg-white rounded-4 border shadow-sm mb-4" style="border-color: #F2E4E8 !important;">
      
      <!-- Beautician Group Header -->
      <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom flex-wrap gap-2">
        <h5 class="brand-font text-wine mb-0 fw-bold fs-5">
          <i class="bi bi-person-badge text-pink me-2"></i><?= h($beauticianName) ?>
          <span class="badge px-3 py-1 rounded-pill ms-2 fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.78rem;">
            <?= count($bTimings) ?> Everyday Slots
          </span>
        </h5>

        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm btn-outline-pink-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#addSlotModal">
            <i class="bi bi-plus-circle me-1"></i> Add Everyday Slot
          </button>
        </div>
      </div>

      <!-- Clean Aggregated Everyday Slots Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Recurrence</th>
              <th>Time Slot Timing</th>
              <th>Max Capacity</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($bTimings as $timeKey => $slotData): ?>
              <?php
                $sampleSlot = $slotData['sample_slot'];
                $rawStart = $slotData['start_time'];
                $rawEnd = $slotData['end_time'];
                $startStr = is_object($rawStart) ? $rawStart->format('h:i A') : date('h:i A', strtotime((string)$rawStart));
                $endStr = is_object($rawEnd) ? $rawEnd->format('h:i A') : date('h:i A', strtotime((string)$rawEnd));
              ?>
              <tr>
                <td>
                  <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.8rem;">
                    🔁 EVERYDAY
                  </span>
                </td>
                <td>
                  <strong class="text-wine fs-6"><i class="bi bi-clock me-1 text-pink"></i> <?= $startStr ?> - <?= $endStr ?></strong>
                </td>
                <td>
                  <span class="badge bg-light text-dark border px-3 py-1 rounded-pill small">
                    <?= (int)$slotData['max_capacity'] ?> Client / Session
                  </span>
                </td>
                <td>
                  <?php if ($slotData['is_blocked']): ?>
                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill small fw-bold"><i class="bi bi-slash-circle me-1"></i> Blocked</span>
                  <?php else: ?>
                    <span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill small fw-bold"><i class="bi bi-check-circle me-1"></i> Open & Active</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <?= $this->Form->postLink(
                    $slotData['is_blocked'] ? '<i class="bi bi-unlock me-1"></i> Unblock' : '<i class="bi bi-slash-circle me-1"></i> Block',
                    ['action' => 'toggleBlock', $sampleSlot->id],
                    ['escape' => false, 'class' => 'btn btn-outline-warning btn-sm me-1 rounded-pill px-3']
                  ) ?>

                  <!-- Delete Everyday Slot Action -->
                  <?= $this->Form->postLink(
                    '<i class="bi bi-trash"></i> Delete Slot',
                    ['action' => 'deleteTiming'],
                    [
                      'data' => [
                        'beautician_id' => $slotData['beautician_id'] ?? 'null',
                        'start_time' => is_object($rawStart) ? $rawStart->format('H:i:s') : (string)$rawStart
                      ],
                      'escape' => false,
                      'confirm' => __('Are you sure you want to delete this everyday time slot ({0} - {1})?', $startStr, $endStr),
                      'class' => 'btn btn-outline-danger btn-sm rounded-pill px-3'
                    ]
                  ) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  <?php endforeach; ?>
<?php endif; ?>

<!-- Modal 1: Add Everyday Time Slot -->
<div class="modal fade" id="addSlotModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title brand-font text-wine"><i class="bi bi-plus-circle me-2 text-pink"></i>Add Everyday Time Slot</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
        <div class="modal-body">
          <p class="text-muted small mb-3">This time slot will apply automatically for <strong>everyday salon operations</strong>.</p>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Start Time</label>
              <input type="time" name="start_time" class="form-control" value="10:00" required>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">End Time</label>
              <input type="time" name="end_time" class="form-control" value="11:15" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Assigned Beautician</label>
            <?= $this->Form->select('beautician_id', ['' => '-- Any / Unassigned Beautician --'] + $beauticians, ['class' => 'form-select']) ?>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Max Client Capacity</label>
            <input type="number" name="max_capacity" class="form-control" value="1" min="1" max="10" required>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-book-gradient-pill px-4 py-2 fw-bold"><i class="bi bi-plus-circle me-1"></i> Add Everyday Slot</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<!-- Modal 2: Bulk Slot Generator -->
<div class="modal fade" id="generateSlotsModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title brand-font text-wine"><i class="bi bi-magic me-2 text-pink"></i>Bulk Slot Generator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <?= $this->Form->create(null, ['url' => ['action' => 'generate']]) ?>
        <div class="modal-body">
          <p class="text-muted small mb-3">Auto-generate standard daily salon slots for a date range.</p>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Start Date</label>
              <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">End Date</label>
              <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Assign Beautician</label>
            <?= $this->Form->select('beautician_id', ['' => '-- All / Any Beautician --'] + $beauticians, ['class' => 'form-select']) ?>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-book-gradient-pill px-4 py-2 fw-bold"><i class="bi bi-magic me-1"></i> Generate Slots Now</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<style>
.btn-pink-active {
  background: linear-gradient(135deg, #7A2E44 0%, #36111C 100%) !important;
  color: #FFFFFF !important;
  border: 1px solid #36111C !important;
}
.btn-pink-outline {
  background: #FDF0F3 !important;
  color: #7A2E44 !important;
  border: 1px solid #E87A90 !important;
}
.btn-pink-outline:hover {
  background: #F8EDF1 !important;
}
.btn-outline-pink-pill {
  border: 1px solid #E87A90;
  color: #7A2E44;
  background: #FDF0F3;
  border-radius: 50px;
}
.btn-outline-pink-pill:hover {
  background: #E87A90;
  color: #FFFFFF;
}
</style>
