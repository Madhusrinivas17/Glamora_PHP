<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Glamora - Your Beauty, Effortlessly Booked</title>
  
  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --wine-dark: #2B151F;
      --wine-plum: #4A1B29;
      --plum-gradient: linear-gradient(135deg, #7A2E44 0%, #36111C 100%);
      --pink-blush: #E87A90;
      --pink-soft: #FDE8EF;
      --bg-cream: #FFF7F9;
      --text-muted: #6E5662;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-cream);
      color: var(--wine-dark);
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .brand-font {
      font-family: 'Playfair Display', serif;
    }

    /* Top Navbar Header */
    .landing-header {
      padding: 1.25rem 4rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(255, 247, 249, 0.95);
      backdrop-filter: blur(10px);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid #F2E4E8;
    }

    .landing-brand {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--wine-dark);
      text-decoration: none;
      letter-spacing: -0.5px;
    }

    .landing-brand .sparkle {
      color: var(--pink-blush);
    }

    .landing-nav-links {
      display: flex;
      align-items: center;
      gap: 2.5rem;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .landing-nav-links a {
      color: var(--wine-dark);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: color 0.2s ease;
    }

    .landing-nav-links a:hover {
      color: var(--pink-blush);
    }

    .btn-sign-in {
      border: 1px solid #E87A90;
      color: var(--wine-dark);
      background: #FDF0F3;
      text-decoration: none;
      padding: 0.65rem 1.6rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .btn-sign-in:hover {
      background: #E87A90;
      color: #FFFFFF;
    }

    .btn-join-glamora {
      background: var(--plum-gradient);
      color: #FFFFFF !important;
      text-decoration: none;
      padding: 0.65rem 1.6rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.9rem;
      box-shadow: 0 4px 14px rgba(54, 17, 28, 0.25);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s ease;
    }

    .btn-join-glamora:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(54, 17, 28, 0.35);
    }

    /* Hero Section */
    .hero-container {
      padding: 4rem 4rem 5rem 4rem;
    }

    .hero-title-main {
      font-size: 3.8rem;
      font-weight: 700;
      line-height: 1.15;
      color: var(--wine-dark);
      margin-bottom: 0.2rem;
    }

    .hero-title-sub {
      font-size: 3.8rem;
      font-weight: 400;
      font-style: italic;
      line-height: 1.15;
      color: #C87A8F;
      margin-bottom: 1.8rem;
    }

    .hero-lead-text {
      font-size: 1.1rem;
      color: var(--text-muted);
      max-width: 480px;
      line-height: 1.6;
      margin-bottom: 2.5rem;
    }

    .btn-find-salon {
      background: var(--plum-gradient);
      color: #FFFFFF !important;
      text-decoration: none;
      padding: 0.9rem 2.4rem;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1rem;
      box-shadow: 0 6px 18px rgba(54, 17, 28, 0.25);
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.2s ease;
    }

    .btn-find-salon:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(54, 17, 28, 0.35);
    }

    .link-explore {
      color: var(--wine-dark);
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      border: 1px solid #E87A90;
      background: #FDF0F3;
      padding: 0.85rem 1.8rem;
      border-radius: 50px;
      margin-left: 1rem;
      transition: all 0.2s ease;
    }

    .link-explore:hover {
      background: #E87A90;
      color: #FFFFFF;
    }

    /* Right Hero Card Graphic */
    .hero-card-box {
      background: #FCE6EC;
      border-radius: 32px;
      padding: 2.5rem;
      position: relative;
      overflow: hidden;
      min-height: 480px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 12px 36px rgba(232, 122, 144, 0.15);
      border: 1px solid #F2E4E8;
    }

    .hero-card-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem;
      letter-spacing: 6px;
      color: var(--wine-dark);
      margin-bottom: 1rem;
      text-align: center;
    }

    .hero-art-img {
      width: 100%;
      height: 320px;
      border-radius: 20px;
      object-fit: cover;
      margin: 1rem 0;
      box-shadow: 0 10px 30px rgba(74, 21, 37, 0.15);
    }

    .pill-rating-badge {
      position: absolute;
      bottom: 30px;
      left: 30px;
      background: #FFFFFF;
      padding: 0.65rem 1.5rem;
      border-radius: 50px;
      box-shadow: 0 6px 18px rgba(74, 21, 37, 0.08);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--wine-dark);
    }

    /* Feature Category Cards */
    .category-feature-card {
      background: #FFFFFF;
      border-radius: 24px;
      padding: 2rem;
      border: 1px solid #F2E4E8;
      transition: all 0.3s ease;
    }

    .category-feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(122, 46, 68, 0.1);
      border-color: #E87A90;
    }

    .feature-icon-circle {
      width: 54px;
      height: 54px;
      border-radius: 18px;
      background: #FDF0F3;
      color: #7A2E44;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1.25rem;
    }

    @media (max-width: 991px) {
      .landing-header {
        padding: 1.2rem 1.5rem;
      }
      .hero-container {
        padding: 2rem 1.5rem;
      }
      .hero-title-main, .hero-title-sub {
        font-size: 2.8rem;
      }
    }
  </style>
</head>
<body>

  <!-- Top Navigation Header -->
  <header class="landing-header">
    <a href="/" class="landing-brand">
      glamora<span class="sparkle">*</span>
    </a>

    <ul class="landing-nav-links d-none d-md-flex">
      <li><a href="<?= $this->Url->build('/services') ?>">Services Catalog</a></li>
      <li><a href="<?= $this->Url->build('/offers') ?>">Special Offers</a></li>
      <li><a href="<?= $this->Url->build('/live-services') ?>">Live Parlours</a></li>
    </ul>

    <div class="d-flex align-items-center gap-3">
      <?php
        $identity = $this->request->getAttribute('identity');
        if ($identity):
      ?>
        <a href="<?= $this->Url->build('/my-appointments') ?>" class="btn-join-glamora">
          <i class="bi bi-person-fill"></i> My Dashboard
        </a>
      <?php else: ?>
        <a href="<?= $this->Url->build('/login') ?>" class="btn-sign-in">
          Sign in
        </a>
        <a href="<?= $this->Url->build('/register') ?>" class="btn-join-glamora">
          Join Glamora <i class="bi bi-stars"></i>
        </a>
      <?php endif; ?>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero-container">
    <div class="row align-items-center g-5">
      <!-- Left Column: Copy & Actions -->
      <div class="col-lg-6">
        <div class="mb-3">
          <span class="badge px-3 py-2 rounded-pill fw-bold small text-uppercase" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90;">
            <i class="bi bi-sparkles text-pink me-1"></i> YOUR BEAUTY, EFFORTLESSLY BOOKED
          </span>
        </div>

        <h1 class="brand-font hero-title-main">Feel beautiful.</h1>
        <h1 class="brand-font hero-title-sub">On your schedule.</h1>

        <p class="hero-lead-text">
          Discover exceptional luxury salons, certified master beauticians, hair styling, skin therapies, and spa sessions designed just for you.
        </p>

        <div class="d-flex align-items-center flex-wrap gap-2 mb-4">
          <a href="<?= $this->Url->build('/services') ?>" class="btn-find-salon">
            Find a Salon Branch <i class="bi bi-arrow-right"></i>
          </a>
          <a href="<?= $this->Url->build('/services') ?>" class="link-explore">
            Explore Catalog
          </a>
        </div>

        <!-- Trust Badges -->
        <div class="d-flex gap-4 pt-3 border-top flex-wrap text-muted small fw-semibold">
          <span><i class="bi bi-check-circle-fill text-pink me-1"></i> Real-Time Slots</span>
          <span><i class="bi bi-shield-check text-pink me-1"></i> Certified Stylists</span>
          <span><i class="bi bi-clock-history text-pink me-1"></i> 24/7 Online Booking</span>
        </div>
      </div>

      <!-- Right Column: Hero Art Card -->
      <div class="col-lg-6">
        <div class="hero-card-box">
          <div class="hero-card-title">G L A M O R A</div>

          <img src="<?= $this->Url->build('/img/glamora1.jpeg') ?>" alt="Glamora Beauty Art" class="hero-art-img shadow-sm" onerror="this.src='<?= $this->Url->build('/img/glamora1.jpeg') ?>'">

          <div class="pill-rating-badge">
            <i class="bi bi-heart-fill text-pink me-1"></i>
            <span>Loved by 10,000+ happy clients</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Beauty Categories Showcase -->
  <section class="py-5 bg-white border-top border-bottom" style="border-color: #F2E4E8 !important;">
    <div class="container py-3">
      <div class="text-center mb-5">
        <h2 class="brand-font text-wine display-6 fw-bold mb-2">Signature Beauty Categories</h2>
        <p class="text-muted small mb-0">Explore tailor-made treatments crafted by our master stylists</p>
      </div>

      <div class="row g-4">
        <div class="col-md-3 col-6">
          <div class="category-feature-card h-100 text-center">
            <div class="feature-icon-circle mx-auto"><i class="bi bi-scissors"></i></div>
            <h5 class="brand-font text-wine fw-bold fs-6 mb-1">Hair Styling & Spa</h5>
            <p class="text-muted small mb-0" style="font-size:0.8rem;">Scalp spa, blowdry, coloring & treatments</p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="category-feature-card h-100 text-center">
            <div class="feature-icon-circle mx-auto"><i class="bi bi-flower1"></i></div>
            <h5 class="brand-font text-wine fw-bold fs-6 mb-1">Facial & Skin Care</h5>
            <p class="text-muted small mb-0" style="font-size:0.8rem;">Gold facials, anti-aging & skin glow</p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="category-feature-card h-100 text-center">
            <div class="feature-icon-circle mx-auto"><i class="bi bi-heart-pulse"></i></div>
            <h5 class="brand-font text-wine fw-bold fs-6 mb-1">Bridal Makeover</h5>
            <p class="text-muted small mb-0" style="font-size:0.8rem;">HD bridal makeup & saree draping</p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="category-feature-card h-100 text-center">
            <div class="feature-icon-circle mx-auto"><i class="bi bi-droplet"></i></div>
            <h5 class="brand-font text-wine fw-bold fs-6 mb-1">Spa & Relaxation</h5>
            <p class="text-muted small mb-0" style="font-size:0.8rem;">Aroma spa, manicure & pedicure</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose Glamora Section -->
  <section class="py-5">
    <div class="container py-4">
      <div class="row align-items-center g-5">
        <div class="col-lg-5">
          <span class="badge px-3 py-2 rounded-pill fw-bold small text-uppercase mb-3" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90;">WHY GLAMORA</span>
          <h2 class="brand-font text-wine display-5 fw-bold mb-3">Elevating Your Salon Reservation Experience</h2>
          <p class="text-muted lead fs-6 mb-4">We bring together top-tier beauty parlours, transparent pricing, and instant slot reservations under one luxurious platform.</p>
          <a href="<?= $this->Url->build('/services') ?>" class="btn btn-book-gradient-pill px-4 py-3 fw-bold">
            Reserve Your Session Now ✨
          </a>
        </div>

        <div class="col-lg-7">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-4 bg-white rounded-4 border shadow-sm h-100" style="border-color: #F2E4E8 !important;">
                <div class="feature-icon-circle"><i class="bi bi-award-fill"></i></div>
                <h5 class="brand-font text-wine fw-bold fs-6 mb-2">Master Beauticians</h5>
                <p class="text-muted small mb-0">Certified beauty specialists dedicated to bringing out your best glow.</p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-4 bg-white rounded-4 border shadow-sm h-100" style="border-color: #F2E4E8 !important;">
                <div class="feature-icon-circle"><i class="bi bi-clock-history"></i></div>
                <h5 class="brand-font text-wine fw-bold fs-6 mb-2">Instant Real-Time Slots</h5>
                <p class="text-muted small mb-0">No waiting in line. Pick your date, available slot, and confirm instantly.</p>
              </div>
            </div>

            <div class="col-md-12">
              <div class="p-4 bg-white rounded-4 border shadow-sm" style="border-color: #F2E4E8 !important;">
                <div class="feature-icon-circle"><i class="bi bi-gift-fill"></i></div>
                <h5 class="brand-font text-wine fw-bold fs-6 mb-2">Exclusive Salon Promos & Packages</h5>
                <p class="text-muted small mb-0">Access limited-time salon packages, seasonal discounts, and click-to-copy promo codes.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-4 bg-white border-top" style="border-color: #F2E4E8 !important;">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
      <a href="/" class="brand-font text-wine fs-3 fw-bold text-decoration-none">glamora<span style="color:#E87A90;">*</span></a>
      <div class="text-muted small">© <?= date('Y') ?> Glamora Salon Management. All rights reserved.</div>
      <div class="d-flex gap-3 text-muted small">
        <a href="<?= $this->Url->build('/services') ?>" class="text-wine text-decoration-none fw-semibold">Services</a>
        <a href="<?= $this->Url->build('/offers') ?>" class="text-wine text-decoration-none fw-semibold">Offers</a>
        <a href="<?= $this->Url->build('/live-services') ?>" class="text-wine text-decoration-none fw-semibold">Live Parlours</a>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
