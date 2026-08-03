<?php
/**
 * Admin Customer Reviews Page - Private Parlour Feedback Log
 */
$this->assign('title', 'Customer Reviews & Feedback');
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h3 class="brand-font text-wine mb-1"><i class="bi bi-chat-heart me-2 text-pink"></i>Parlour Customer Reviews</h3>
    <p class="text-muted small mb-0">Private customer feedback and service ratings for your salon parlour</p>
  </div>
</div>

<?php if (empty($reviews) || count($reviews) === 0): ?>
  <div class="p-5 bg-white rounded-4 border text-center shadow-sm" style="border-color: #F2E4E8 !important;">
    <i class="bi bi-chat-left-text text-pink display-4 mb-3 d-block"></i>
    <h5 class="brand-font text-wine">No Customer Reviews Yet</h5>
    <p class="text-muted small mb-0">Customer reviews submitted for completed appointments will appear here exclusively for your parlour.</p>
  </div>
<?php else: ?>
  <div class="row g-4">
    <?php foreach ($reviews as $rev): ?>
      <div class="col-md-6">
        <div class="p-4 bg-white rounded-4 border shadow-sm h-100 position-relative" style="border-color: #F2E4E8 !important;">
          
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center gap-3">
              <div class="avatar-circle-sm rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px; height:40px; background:#FDE8EF; color:#E87A90;">
                <?= strtoupper(substr($rev->user->full_name ?? 'C', 0, 1)) ?>
              </div>
              <div>
                <h6 class="brand-font text-wine mb-0 fw-bold fs-6"><?= h($rev->user->full_name ?? 'Customer') ?></h6>
                <small class="text-muted" style="font-size:0.78rem;">
                  <i class="bi bi-scissors me-1 text-pink"></i> <?= h($rev->service ? $rev->service->name : 'Salon Service') ?>
                </small>
              </div>
            </div>

            <span class="badge px-3 py-1 rounded-pill fw-bold" style="background: #FFF3CD; color: #856404; border: 1px solid #FFEEBA; font-size: 0.78rem;">
              ⭐ <?= (int)$rev->rating ?> / 5 Stars
            </span>
          </div>

          <?php if (!empty($rev->title)): ?>
            <h6 class="fw-bold text-wine mb-1 small"><?= h($rev->title) ?></h6>
          <?php endif; ?>

          <p class="text-muted small mb-3" style="font-size:0.88rem; line-height:1.5;">
            <?= h($rev->comment) ?>
          </p>

          <div class="pt-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted" style="font-size:0.75rem;">
              <i class="bi bi-calendar3 me-1"></i> Submitted on <?= h($rev->created ? $rev->created->format('M d, Y \a\t h:i A') : '') ?>
            </small>

            <?= $this->Form->postLink(
              '<i class="bi bi-trash"></i> Delete Review',
              ['action' => 'delete', $rev->id],
              ['escape' => false, 'confirm' => __('Are you sure you want to delete this review?'), 'class' => 'btn btn-outline-danger btn-sm rounded-pill px-3']
            ) ?>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
