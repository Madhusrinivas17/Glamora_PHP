<?php
/**
 * Glamora Customer Favorites Page
 */
$this->assign('title', 'My Favourite Services');
?>

<div class="mb-4">
  <h2 class="brand-font text-wine mb-1"><i class="bi bi-heart-fill me-2 text-pink"></i>My Favourite Services</h2>
  <p class="text-muted small mb-0">Your saved luxury salon treatments, hair spa sessions, and beauty therapies</p>
</div>

<?php if (empty($favs) || count($favs) === 0): ?>
  <div class="glamora-card p-5 text-center rounded-4 shadow-sm bg-white">
    <i class="bi bi-heartbreak display-3 text-pink mb-3 d-block"></i>
    <h4 class="brand-font text-wine">No Favorites Saved Yet</h4>
    <p class="text-muted mb-4">Click the heart icon on any service card to add it to your personal favorites collection.</p>
    <a href="<?= $this->Url->build('/services') ?>" class="btn btn-book-gradient-pill px-4 py-2">Explore Services Catalog</a>
  </div>
<?php else: ?>
  <div class="row g-4">
    <?php foreach ($favs as $fav): ?>
      <?php $srv = $fav->service; ?>
      <?php if (!$srv) continue; ?>
      <?php
        $categoryName = strtolower($srv->service_category ? $srv->service_category->name : 'beauty');
      ?>
      <div class="col-lg-4 col-md-6" id="fav-card-<?= $srv->id ?>">
        <div class="glamora-service-card card h-100 border-0 rounded-4 shadow-sm bg-white overflow-hidden d-flex flex-column">
          <div class="card-img-wrapper position-relative">
            <img src="<?= $this->Url->build('/img/' . ($srv->image ?: 'service_default.jpg')) ?>" alt="<?= h($srv->name) ?>" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=600&q=80'">
            <span class="card-badge-category"><?= h($categoryName) ?></span>
            <button class="card-btn-heart active" onclick="toggleFav(<?= $srv->id ?>, this)" title="Remove from Favourites">
              <i class="bi bi-heart-fill text-pink"></i>
            </button>
          </div>

          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h4 class="brand-font h5 text-wine mb-0 fw-bold"><?= h($srv->name) ?></h4>
            </div>

            <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.85rem;">
              <?= h($srv->description ?: 'Luxury session designed to make you glow.') ?>
            </p>

            <hr class="dotted-divider my-3">

            <div class="row text-center g-2 mb-3">
              <div class="col-6 text-start">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem;">Price</small>
                <strong class="fs-6 text-wine">Rs. <?= number_format((float)$srv->price, 2) ?></strong>
              </div>
              <div class="col-6 text-end">
                <small class="text-muted d-block text-uppercase" style="font-size: 0.68rem;">Duration</small>
                <span class="small text-muted"><i class="bi bi-clock me-1"></i><?= (int)$srv->duration_minutes ?> mins</span>
              </div>
            </div>

            <div class="row g-2 mt-auto">
              <div class="col-6">
                <a href="<?= $this->Url->build(['action' => 'view', $srv->id]) ?>" class="btn btn-outline-dark-pill w-100 py-2 btn-sm fw-semibold">
                  View Details
                </a>
              </div>
              <div class="col-6">
                <a href="<?= $this->Url->build(['controller' => 'Appointments', 'action' => 'book', '?' => ['service_id' => $srv->id]]) ?>" class="btn btn-book-gradient-pill w-100 py-2 btn-sm fw-bold">
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
function toggleFav(serviceId, btn) {
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
      const card = document.getElementById('fav-card-' + serviceId);
      if (card && data.status === 'unliked') {
        card.style.opacity = '0';
        setTimeout(() => card.remove(), 300);
      }
    }
  });
}
</script>
