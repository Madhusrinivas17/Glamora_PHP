<?php
/**
 * Admin Appointment Workbench Page
 */
$this->assign('title', 'Appointment Workbench & Bookings');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="brand-font text-wine mb-1">Appointment Management</h3>
    <p class="text-muted small mb-0">Accept, reject, cancel, complete, or reschedule salon customer bookings</p>
  </div>
</div>

<!-- Filter Tabs -->
<div class="mb-4">
  <div class="btn-group flex-wrap shadow-sm">
    <a href="<?= $this->Url->build('/admin/appointments') ?>" class="btn btn-outline-secondary <?= empty($statusFilter) ? 'active' : '' ?>">All Bookings</a>
    <a href="<?= $this->Url->build('/admin/appointments?status=Pending') ?>" class="btn btn-outline-warning <?= ($statusFilter === 'Pending') ? 'active' : '' ?>">Pending</a>
    <a href="<?= $this->Url->build('/admin/appointments?status=Confirmed') ?>" class="btn btn-outline-success <?= ($statusFilter === 'Confirmed') ? 'active' : '' ?>">Confirmed</a>
    <a href="<?= $this->Url->build('/admin/appointments?status=Completed') ?>" class="btn btn-outline-primary <?= ($statusFilter === 'Completed') ? 'active' : '' ?>">Completed</a>
    <a href="<?= $this->Url->build('/admin/appointments?status=Cancelled') ?>" class="btn btn-outline-danger <?= ($statusFilter === 'Cancelled') ? 'active' : '' ?>">Cancelled</a>
    <a href="<?= $this->Url->build('/admin/appointments?status=Rescheduled') ?>" class="btn btn-outline-info <?= ($statusFilter === 'Rescheduled') ? 'active' : '' ?>">Rescheduled</a>
  </div>
</div>

<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Service</th>
          <th>Stylist</th>
          <th>Date & Time</th>
          <th>Price & Payment</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointments as $app): ?>
          <tr>
            <td><strong>#<?= $app->id ?></strong></td>
            <td>
              <div class="fw-semibold text-wine"><?= h($app->user->full_name ?? 'Client') ?></div>
              <small class="text-muted"><?= h($app->user->phone ?? '') ?> | <?= h($app->user->email ?? '') ?></small>
            </td>
            <td>
              <span class="fw-bold d-block text-wine"><?= h($app->service->name ?? 'Salon Service') ?></span>
              <small class="text-muted"><?= (int)($app->service->duration_minutes ?? 45) ?> mins</small>
            </td>
            <td><?= h($app->beautician ? $app->beautician->name : 'Auto-assigned') ?></td>
            <td>
              <?php
                $appDateStr = is_object($app->appointment_date) ? $app->appointment_date->format('Y-m-d') : (string)$app->appointment_date;
                $rawTime = $app->appointment_time;
                $appTimeStr = is_object($rawTime) ? $rawTime->format('h:i A') : date('h:i A', strtotime((string)$rawTime));
              ?>
              <div><i class="bi bi-calendar-event me-1 text-pink"></i> <?= h($appDateStr) ?></div>
              <small class="text-muted"><i class="bi bi-clock me-1"></i> <?= h($appTimeStr) ?></small>
            </td>
            <td>
              <div class="fw-bold text-wine fs-6">Rs. <?= number_format((float)$app->total_price, 2) ?></div>
              <small class="text-muted"><?= h($app->payment ? $app->payment->payment_method : 'Pay at Salon') ?></small>
            </td>
            <td>
              <?php
                $statusClasses = [
                  'Pending' => 'status-pending',
                  'Confirmed' => 'status-confirmed',
                  'Completed' => 'status-completed',
                  'Cancelled' => 'status-cancelled',
                  'Rescheduled' => 'status-rescheduled',
                ];
                $sClass = $statusClasses[$app->status] ?? 'status-pending';
              ?>
              <span class="status-badge <?= $sClass ?>"><?= h($app->status) ?></span>
            </td>
            <td class="text-end">
              <div class="dropdown d-inline-block">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                  Actions
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                  <?php if ($app->status !== 'Confirmed'): ?>
                    <li>
                      <?= $this->Form->postLink(
                        '<i class="bi bi-check-circle text-success me-2"></i> Accept & Confirm',
                        ['action' => 'updateStatus', $app->id, 'Confirmed'],
                        ['escape' => false, 'class' => 'dropdown-item']
                      ) ?>
                    </li>
                  <?php endif; ?>

                  <?php if ($app->status !== 'Completed'): ?>
                    <li>
                      <?= $this->Form->postLink(
                        '<i class="bi bi-check2-all text-primary me-2"></i> Mark Completed',
                        ['action' => 'updateStatus', $app->id, 'Completed'],
                        ['escape' => false, 'class' => 'dropdown-item']
                      ) ?>
                    </li>
                  <?php endif; ?>

                  <li>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rescheduleModal<?= $app->id ?>">
                      <i class="bi bi-clock-history text-info me-2"></i> Reschedule
                    </button>
                  </li>

                  <?php if ($app->status !== 'Cancelled'): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <?= $this->Form->postLink(
                        '<i class="bi bi-x-circle text-danger me-2"></i> Cancel / Reject',
                        ['action' => 'updateStatus', $app->id, 'Cancelled'],
                        ['escape' => false, 'confirm' => __('Cancel appointment #{0}?', $app->id), 'class' => 'dropdown-item text-danger']
                      ) ?>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>

              <!-- Reschedule Modal per Appointment -->
              <div class="modal fade text-start" id="rescheduleModal<?= $app->id ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header border-0">
                      <h5 class="modal-title brand-font text-wine"><i class="bi bi-clock-history me-2 text-pink"></i>Reschedule Booking #<?= $app->id ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <?= $this->Form->create(null, ['url' => ['action' => 'reschedule', $app->id]]) ?>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label fw-semibold">New Date</label>
                          <input type="date" name="new_date" class="form-control" value="<?= h($app->appointment_date) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-semibold">New Time</label>
                          <input type="time" name="new_time" class="form-control" value="<?= h($app->appointment_time) ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-semibold">Assign Stylist</label>
                          <?= $this->Form->select('beautician_id', ['' => '-- Keep Current --'] + $beauticians, ['class' => 'form-select', 'value' => $app->beautician_id]) ?>
                        </div>
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-glamora">Save Reschedule</button>
                      </div>
                    <?= $this->Form->end() ?>
                  </div>
                </div>
              </div>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
