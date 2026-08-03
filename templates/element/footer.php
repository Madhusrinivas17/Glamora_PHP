<footer class="glamora-footer">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-lg-4 col-md-6">
        <h4 class="brand-font text-white mb-3"><i class="bi bi-flower1 me-2" style="color:#E87A90;"></i>Glamora</h4>
        <p class="small text-pink-light">
          Glamora is a premier luxury salon & spa management platform offering personalized beauty therapies, high-end hair transformations, couture saree draping, and flawless bridal makeovers.
        </p>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5 class="mb-3">Salon Services</h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= $this->Url->build('/services?category=hair') ?>"><i class="bi bi-chevron-right me-1 small"></i> Hair Care & Blowouts</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/services?category=facial') ?>"><i class="bi bi-chevron-right me-1 small"></i> HydraFacial & Radiance</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/services?category=saree-draping') ?>"><i class="bi bi-chevron-right me-1 small"></i> Saree & Dupatta Draping</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/services?category=bridal-makeup') ?>"><i class="bi bi-chevron-right me-1 small"></i> Imperial Bridal Makeover</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6">
        <h5 class="mb-3">Quick Links</h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= $this->Url->build('/book') ?>">Book Appointment</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/offers') ?>">Special Offers</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/login') ?>">User / Admin Login</a></li>
          <li class="mb-2"><a href="<?= $this->Url->build('/register-admin') ?>">Become a Salon Partner</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5 class="mb-3">Salon Hours & Contact</h5>
        <p class="small mb-1"><i class="bi bi-geo-alt-fill me-2 text-pink"></i> 9454 Wilshire Blvd, Beverly Hills, CA</p>
        <p class="small mb-1"><i class="bi bi-telephone-fill me-2 text-pink"></i> +1 555-0192</p>
        <p class="small mb-3"><i class="bi bi-envelope-fill me-2 text-pink"></i> contact@glamora.com</p>
        <div class="d-flex gap-2">
          <span class="badge bg-danger px-3 py-2">Mon - Sat: 9:00 AM - 8:00 PM</span>
        </div>
      </div>
    </div>

    <hr style="border-color: rgba(255,255,255,0.15);">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-pink-light">
      <p class="mb-0">&copy; <?= date('Y') ?> Glamora Salon Management System. All Rights Reserved. Built with CakePHP 5.x.</p>
      <div>
        <a href="<?= $this->Url->build('/login?role=admin') ?>" class="text-white text-decoration-underline ms-2">Admin Portal</a>
      </div>
    </div>
  </div>
</footer>
