<?php
/**
 * Detailed Service View Page - Private Feedback for Salon Management
 */
$this->assign('title', h($service->name) . ' - Glamora');
$isOpen = $parlour ? (bool)$parlour->is_open : true;
?>

<div class="row g-4 mb-5">
  <div class="col-md-6">
    <div class="glamora-card overflow-hidden rounded-4 position-relative shadow-sm">
      <img src="<?= $this->Url->build('/img/' . ($service->image ?: 'service_default.jpg')) ?>" alt="<?= h($service->name) ?>" class="w-100" style="max-height: 420px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=600&q=80'">
      
      <button class="card-btn-heart shadow <?= $isLiked ? 'active' : '' ?>" id="view-heart-btn" onclick="toggleFav(<?= $service->id ?>)" style="top: 20px; right: 20px; width: 44px; height: 44px; font-size: 1.2rem;">
        <i class="bi bi-heart<?= $isLiked ? '-fill text-pink' : '' ?>"></i>
      </button>
    </div>
  </div>

  <div class="col-md-6">
    <div class="ps-md-3">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge bg-light text-wine border border-pink rounded-pill px-3 py-2 fw-semibold">
          <?= h($service->service_category ? $service->service_category->name : 'Salon Service') ?>
        </span>

        <?php if ($isOpen): ?>
          <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-2 fw-semibold small">
            🟢 Open Now
          </span>
        <?php else: ?>
          <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-2 fw-semibold small">
            🔴 Closed
          </span>
        <?php endif; ?>
      </div>
      
      <h1 class="brand-font text-wine display-6 mb-2"><?= h($service->name) ?></h1>

      <div class="d-flex align-items-center gap-4 mb-4 text-muted small">
        <span class="fs-4 fw-bold text-wine">Rs. <?= number_format((float)$service->price, 2) ?></span>
        <span><i class="bi bi-clock me-1 text-pink"></i> <?= (int)$service->duration_minutes ?> Mins</span>
        <span><i class="bi bi-heart-fill text-pink me-1"></i> <strong id="likes-count"><?= (int)$totalLikes ?></strong> Likes</span>
      </div>

      <p class="text-muted mb-4 lead" style="font-size: 0.95rem;">
        <?= h($service->description ?: 'Enjoy our tailored luxury experience designed to make you glow.') ?>
      </p>

      <div class="p-3 bg-light rounded-4 border mb-4">
        <h6 class="fw-bold text-wine mb-2"><i class="bi bi-shield-check text-success me-2"></i>What's Included:</h6>
        <ul class="list-unstyled small mb-0 text-muted">
          <li class="mb-1"><i class="bi bi-check-circle-fill text-pink me-2"></i> Consultation with certified master beautician</li>
          <li class="mb-1"><i class="bi bi-check-circle-fill text-pink me-2"></i> Organic dermatologically-tested luxury products</li>
          <li class="mb-1"><i class="bi bi-check-circle-fill text-pink me-2"></i> Scalp/shoulder massage session</li>
        </ul>
      </div>

      <div class="d-flex gap-3 flex-wrap">
        <?php if ($isOpen): ?>
          <a href="<?= $this->Url->build(['controller' => 'Appointments', 'action' => 'book', '?' => ['service_id' => $service->id]]) ?>" class="btn btn-book-gradient-pill btn-lg px-4 py-3 fw-bold">
            <i class="bi bi-calendar-plus me-2"></i> Book This Service ✨
          </a>
        <?php else: ?>
          <button class="btn btn-secondary btn-lg px-4 py-3 rounded-pill fw-bold" disabled>
            Closed - Bookings Offline
          </button>
        <?php endif; ?>

        <a href="<?= $this->Url->build('/services') ?>" class="btn btn-outline-dark-pill btn-lg px-4 py-3 fw-semibold">
          Back to Catalog
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Private Feedback Section for Salon Management -->
<div class="p-4 bg-white rounded-4 border shadow-sm mb-5" style="border-color: #F2E4E8 !important;">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h5 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-shield-lock text-pink me-2"></i>Salon Feedback & Reviews</h5>
      <p class="text-muted small mb-0">Customer reviews are sent directly to parlour management for service quality control.</p>
    </div>

    <?php if ($canReview && $completedAppointment): ?>
      <button class="btn btn-book-gradient-pill px-4 py-2 fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
        <i class="bi bi-pencil-square me-1"></i> Submit Feedback to Parlour
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- Modal: Submit Feedback (Only for Customers with Completed Booking) -->
<?php if ($canReview && $completedAppointment): ?>
<div class="modal fade" id="reviewModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title brand-font text-wine"><i class="bi bi-chat-heart text-pink me-2"></i>Submit Feedback to Parlour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <?= $this->Form->create(null, ['url' => ['controller' => 'Reviews', 'action' => 'add']]) ?>
        <input type="hidden" name="service_id" value="<?= $service->id ?>">
        <input type="hidden" name="appointment_id" value="<?= $completedAppointment->id ?>">

        <div class="modal-body">
          <p class="text-muted small mb-3">Your feedback will be sent directly to salon management.</p>

          <div class="mb-3">
            <label class="form-label fw-semibold">Service Score (1 to 5 Stars)</label>
            <select name="rating" class="form-select fw-bold text-wine">
              <option value="5" selected>⭐⭐⭐⭐⭐ (5/5 Exceptional)</option>
              <option value="4">⭐⭐⭐⭐ (4/5 Very Good)</option>
              <option value="3">⭐⭐⭐ (3/5 Good)</option>
              <option value="2">⭐⭐ (2/5 Average)</option>
              <option value="1">⭐ (1/5 Needs Improvement)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Title (Optional)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Great treatment experience">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Feedback Message</label>
            <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience for salon management..." required></textarea>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-book-gradient-pill px-4 py-2 fw-bold">Submit Feedback</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
function toggleFav(serviceId) {
  fetch('<?= $this->Url->build('/services/toggle-favorite') ?>', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
    },
    body: 'service_id=' + serviceId
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const btn = document.getElementById('view-heart-btn');
      const likesCount = document.getElementById('likes-count');
      if (data.status === 'liked') {
        btn.classList.add('active');
        btn.innerHTML = '<i class="bi bi-heart-fill text-pink"></i>';
      } else {
        btn.classList.remove('active');
        btn.innerHTML = '<i class="bi bi-heart"></i>';
      }
      if (likesCount) {
        likesCount.textContent = data.total_likes;
      }
    }
  });
}
</script>
