<?php
/**
 * Glamora Luxury Services Showcase Page
 */
$this->assign('title', 'Browse Services');
?>

<!-- Page Header Title -->
<div class="mb-4">
  <h1 class="brand-font display-5 fw-bold text-wine mb-2">Browse Luxury Services</h1>
  <p class="text-muted lead fs-6 mb-0">Explore our signature salon treatments, hair styling, skin therapies, and spa sessions.</p>
</div>

<!-- Search Banner Pill -->
<div class="mb-5">
  <form action="<?= $this->Url->build('/services') ?>" method="get">
    <div class="search-banner-pill p-2 bg-white rounded-pill border shadow-sm d-flex align-items-center">
      <div class="d-flex align-items-center flex-grow-1 px-3">
        <i class="bi bi-search me-2 fs-5" style="color: #E87A90;"></i>
        <input type="text" name="q" class="form-control border-0 shadow-none bg-transparent" placeholder="Search service name, treatment, or location..." value="<?= h($search ?? '') ?>">
      </div>
      <div class="me-2">
        <select name="category" class="form-select border-0 shadow-none bg-light rounded-pill px-4 fw-semibold text-wine" style="width: 170px;">
          <option value="">All Categories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= h($cat->slug) ?>" <?= ($categorySlug === $cat->slug) ? 'selected' : '' ?>>
              <?= h($cat->name) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-glamora-dark rounded-pill px-4 py-2 text-white fw-bold">
        Search
      </button>
    </div>
  </form>
</div>

<!-- Services Grid -->
<?php if ($services->isEmpty()): ?>
  <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
    <i class="bi bi-search fs-2 mb-2 d-block text-pink"></i>
    <h5 class="brand-font text-wine">No Services Found</h5>
    <p class="text-muted small mb-3">We couldn't find any services matching your search criteria.</p>
    <a href="<?= $this->Url->build('/services') ?>" class="btn btn-outline-dark-pill px-4 py-2 btn-sm fw-semibold">Clear Filters</a>
  </div>
<?php else: ?>
  <div class="row g-4">
    <?php foreach ($services as $srv): ?>
      <?php
        $categoryName = strtolower($srv->service_category ? $srv->service_category->name : 'beauty');
        $locationTag = strtolower(($srv->parlour ? $srv->parlour->name : 'fairy_tales') . ' • ' . ($srv->parlour ? $srv->parlour->city : 'vizag'));
        $isFav = in_array($srv->id, $userFavoriteIds ?? []);
      ?>
      <div class="col-lg-4 col-md-6">
        <div class="glamora-service-card card h-100 border-0 rounded-4 shadow-sm bg-white overflow-hidden d-flex flex-column">
          <!-- Image Header -->
          <div class="card-img-wrapper position-relative">
            <img src="<?= $this->Url->build('/img/' . ($srv->image ?: 'service_default.jpg')) ?>" alt="<?= h($srv->name) ?>" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=600&q=80'">
            <span class="card-badge-category"><?= h($categoryName) ?></span>
            
            <button class="card-btn-heart <?= $isFav ? 'active' : '' ?>" title="<?= $isFav ? 'Remove from Favourites' : 'Add to Favourites' ?>" onclick="toggleFav(<?= $srv->id ?>, this)">
              <i class="bi bi-heart<?= $isFav ? '-fill text-pink' : '' ?>"></i>
            </button>
          </div>

          <!-- Card Content Body -->
          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h4 class="brand-font h5 text-wine mb-0 fw-bold"><?= h($srv->name) ?></h4>
            </div>

            <div class="text-pink small fw-semibold mb-2" style="color: #E87A90; font-size: 0.8rem;"><?= h($locationTag) ?></div>

            <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.85rem; line-height: 1.5;">
              <?= h($srv->description ?: 'Enjoy our tailored luxury experience designed to make you glow.') ?>
            </p>

            <hr class="dotted-divider my-3">

            <!-- Details Row (3 Columns: Price, Duration, Status) -->
            <div class="row text-center g-2 mb-3">
              <div class="col-4 text-start">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Price</small>
                <strong class="fs-6 text-wine" style="font-weight: 700;">Rs. <?= number_format((float)$srv->price, 2) ?></strong>
              </div>
              <div class="col-4 text-center">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Duration</small>
                <span class="small text-muted" style="font-size: 0.78rem;"><i class="bi bi-clock me-1"></i><?= (int)$srv->duration_minutes ?> mins</span>
              </div>
              <div class="col-4 text-end">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Status</small>
                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2 py-1 small fw-bold" style="font-size: 0.65rem;">AVAILABLE</span>
              </div>
            </div>

            <!-- Action Buttons Row -->
            <div class="row g-2 mt-auto">
              <div class="col-6">
                <a href="<?= $this->Url->build(['action' => 'view', $srv->id]) ?>" class="btn btn-outline-dark-pill w-100 py-2 btn-sm fw-semibold" style="font-size: 0.82rem;">
                  View Details
                </a>
              </div>
              <div class="col-6">
                <a href="<?= $this->Url->build(['controller' => 'Appointments', 'action' => 'book', '?' => ['service_id' => $srv->id]]) ?>" class="btn btn-book-gradient-pill w-100 py-2 btn-sm fw-bold" style="font-size: 0.82rem;">
                  Book Now ✨
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<script>
function toggleFav(serviceId, btnElement) {
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
      if (data.status === 'liked') {
        btnElement.classList.add('active');
        btnElement.innerHTML = '<i class="bi bi-heart-fill text-pink"></i>';
      } else {
        btnElement.classList.remove('active');
        btnElement.innerHTML = '<i class="bi bi-heart"></i>';
      }
    } else {
      window.location.href = '<?= $this->Url->build('/login') ?>';
    }
  });
}
</script>
