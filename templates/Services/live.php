<?php
/**
 * Glamora Live Services Directory Page - Active Parlours & Active Services View
 */
$this->assign('title', 'Live Services & Active Parlours');
$hasOpenParlour = !empty($openParlours) && count($openParlours) > 0;
?>

<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
  <div>
    <h2 class="brand-font text-wine mb-1"><i class="bi bi-shop-window me-2 text-pink"></i>Live Parlour & Services Directory</h2>
    <p class="text-muted small mb-0">Select an active parlour below to view its available live services and book appointments</p>
  </div>

  <div>
    <?php if ($hasOpenParlour): ?>
      <span class="badge bg-success-subtle text-success border border-success px-4 py-2 rounded-pill fs-6 fw-bold">
        <i class="bi bi-circle-fill text-success me-2" style="font-size: 0.65rem;"></i> PARLOUR OPEN NOW
      </span>
    <?php else: ?>
      <span class="badge bg-danger-subtle text-danger border border-danger px-4 py-2 rounded-pill fs-6 fw-bold">
        <i class="bi bi-circle-fill text-danger me-2" style="font-size: 0.65rem;"></i> PARLOUR CURRENTLY CLOSED
      </span>
    <?php endif; ?>
  </div>
</div>

<!-- Only Active/Opened Parlours Display -->
<?php if ($hasOpenParlour): ?>
  <?php foreach ($openParlours as $index => $parlour): ?>
    <div class="p-4 bg-white rounded-4 border shadow-sm mb-4" style="border-color: #F2E4E8 !important;">
      <div class="row align-items-center g-4">
        <div class="col-md-4">
          <div class="position-relative rounded-4 overflow-hidden shadow-sm" style="height: 190px;">
            <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=600&q=80" alt="Glamora Salon" class="w-100 h-100" style="object-fit: cover;">
            <span class="badge bg-success position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill small fw-bold">🟢 OPEN NOW</span>
          </div>
        </div>
        <div class="col-md-8">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h3 class="brand-font text-wine mb-1 fw-bold"><?= h($parlour->name ?? 'More_fair Parlour') ?></h3>
              <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill text-pink me-1"></i> <?= h($parlour->address ?? 'Beverly Hills, CA') ?></p>
            </div>
          </div>

          <div class="d-flex flex-wrap align-items-center gap-4 my-3 text-muted small">
            <div><i class="bi bi-scissors text-pink me-1"></i> <strong><?= count($services) ?></strong> Active Services Available</div>
            <div><i class="bi bi-tag-fill text-pink me-1"></i> Starting from <strong>Rs. <?= number_format((float)$startingPrice, 2) ?></strong></div>
          </div>

          <div class="pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="text-muted small"><i class="bi bi-clock me-1 text-pink"></i> Salon Hours: 9:00 AM - 8:00 PM</span>
            
            <div class="d-flex gap-2">
              <button class="btn btn-outline-pink-pill btn-sm px-4 py-2 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#parlourServices<?= $parlour->id ?>" aria-expanded="true">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> View Active Services ✨
              </button>
              <a href="<?= $this->Url->build('/book') ?>" class="btn btn-book-gradient-pill px-4 py-2 text-white fw-bold btn-sm">
                Book Appointment ✨
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="alert alert-danger rounded-4 p-5 text-center shadow-sm mb-5">
    <i class="bi bi-shop-window display-3 mb-3 d-block text-danger"></i>
    <h4 class="brand-font text-wine fw-bold mb-2">No Active Parlours Currently Available</h4>
    <p class="text-muted mb-0">The salon is currently closed or offline. Please check back during open business hours!</p>
  </div>
<?php endif; ?>

<!-- Category Filter Tabs & Sorting Header -->
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div class="d-flex flex-wrap gap-2">
    <a href="<?= $this->Url->build('/live-services') ?>" class="btn btn-sm rounded-pill px-3 fw-bold <?= empty($categoryFilter) ? 'btn-pink-active' : 'btn-pink-outline' ?>">All Services</a>
    <?php foreach ($categories as $cat): ?>
      <a href="<?= $this->Url->build(['action' => 'live', '?' => ['category' => $cat->slug]]) ?>" 
         class="btn btn-sm rounded-pill px-3 fw-bold <?= ($categoryFilter === $cat->slug) ? 'btn-pink-active' : 'btn-pink-outline' ?>">
        <?= h($cat->name) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="dropdown">
    <button class="btn btn-outline-secondary rounded-pill dropdown-toggle btn-sm px-3 fw-semibold" type="button" data-bs-toggle="dropdown">
      Sort: <?= h(ucfirst(str_replace('_', ' ', $sort))) ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
      <li><a class="dropdown-item" href="<?= $this->Url->build(['action' => 'live', '?' => ['sort' => 'popular']]) ?>">Most Popular</a></li>
      <li><a class="dropdown-item" href="<?= $this->Url->build(['action' => 'live', '?' => ['sort' => 'price_low']]) ?>">Lowest Price</a></li>
    </ul>
  </div>
</div>

<!-- Active Services List Section (Shown when clicking Parlour or filtering) -->
<div class="collapse show" id="parlourServices1">
  <div class="row g-4">
    <?php foreach ($services as $srv): ?>
      <div class="col-lg-4 col-md-6">
        <div class="glamora-service-card card h-100 border-0 rounded-4 shadow-sm bg-white overflow-hidden d-flex flex-column" style="border: 1px solid #F2E4E8 !important;">
          <div class="card-img-wrapper position-relative" style="height: 200px;">
            <img src="<?= $this->Url->build('/img/' . ($srv->image ?: 'service_default.jpg')) ?>" alt="<?= h($srv->name) ?>" class="w-100 h-100" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=600&q=80'">
            
            <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill small fw-bold" style="background: rgba(43, 21, 31, 0.85); color: #FFF; backdrop-filter: blur(4px);">
              <?= h($srv->service_category ? strtolower($srv->service_category->name) : 'beauty') ?>
            </span>

            <span class="badge bg-success position-absolute bottom-0 end-0 m-3 px-3 py-1 rounded-pill small fw-bold">🟢 Active Service</span>
          </div>

          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h4 class="brand-font h5 text-wine mb-0 fw-bold"><?= h($srv->name) ?></h4>
            </div>

            <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.85rem;">
              <?= h($srv->description ?: 'Tailored salon treatment session.') ?>
            </p>

            <hr class="dotted-divider my-3">

            <div class="row text-center g-2 mb-3">
              <div class="col-6 text-start">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem;">PRICE</small>
                <strong class="fs-6 text-wine">Rs. <?= number_format((float)$srv->price, 2) ?></strong>
              </div>
              <div class="col-6 text-end">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem;">DURATION</small>
                <span class="small text-muted"><i class="bi bi-clock me-1 text-pink"></i><?= (int)$srv->duration_minutes ?> mins</span>
              </div>
            </div>

            <div class="row g-2 mt-auto">
              <div class="col-6">
                <a href="<?= $this->Url->build(['action' => 'view', $srv->id]) ?>" class="btn btn-outline-dark-pill w-100 py-2 btn-sm fw-semibold">View Details</a>
              </div>
              <div class="col-6">
                <a href="<?= $this->Url->build(['controller' => 'Appointments', 'action' => 'book', '?' => ['service_id' => $srv->id]]) ?>" class="btn btn-book-gradient-pill w-100 py-2 btn-sm fw-bold">Book Now ✨</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
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
