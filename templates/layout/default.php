<!DOCTYPE html>
<html lang="en">
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->fetch('title', 'Browse Services - Glamora Luxury Salon') ?></title>
  
  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Glamora Custom Theme CSS -->
  <?= $this->Html->css('glamora-theme') ?>
  
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
<?php
  $controller = $this->request->getParam('controller');
  $action = $this->request->getParam('action');
  $user = $this->request->getAttribute('identity');
  $userName = $user ? $user->full_name : 'Valued Client';
  $userInit = $user ? strtoupper(substr($user->full_name, 0, 1)) : 'U';
?>
</head>
<body class="<?= $user ? 'has-sidebar' : 'no-sidebar' ?>">

<?php if ($user): ?>
  <!-- LOGGED IN USER: Show Left Sidebar Layout -->
  <div class="client-layout-wrapper">
    <!-- Left Sidebar -->
    <aside class="client-sidebar">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-4 px-2">
          <a class="sidebar-brand brand-font" href="<?= $this->Url->build('/') ?>">
            glamora<span class="sparkle">*</span>
          </a>
          <span class="badge-client-pill"><?= ($user && $user->role === 'admin') ? 'ADMIN' : 'USER' ?></span>
        </div>

        <ul class="sidebar-menu">
          <li>
            <a href="<?= $this->Url->build('/my-appointments') ?>" class="<?= ($controller === 'Appointments' && $action === 'myAppointments') ? 'active' : '' ?>">
              <i class="bi bi-grid"></i> Dashboard
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/services') ?>" class="<?= ($controller === 'Services' && $action === 'index') ? 'active' : '' ?>">
              <i class="bi bi-search"></i> Browse Services
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/book') ?>" class="<?= ($controller === 'Appointments' && $action === 'book') ? 'active' : '' ?>">
              <i class="bi bi-calendar-plus"></i> Book Appointment
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/my-appointments') ?>" class="<?= ($controller === 'Appointments' && $action === 'myAppointments') ? 'active' : '' ?>">
              <i class="bi bi-calendar-event"></i> My Appointments
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/notifications') ?>" class="<?= ($controller === 'Notifications') ? 'active' : '' ?>">
              <i class="bi bi-bell"></i> Notifications
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/favourites') ?>" class="<?= ($controller === 'Services' && $action === 'favourites') ? 'active' : '' ?>">
              <i class="bi bi-heart"></i> Favourite Services
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/offers') ?>" class="<?= ($controller === 'Offers') ? 'active' : '' ?>">
              <i class="bi bi-star"></i> Offers & Promo
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/live-services') ?>" class="<?= ($controller === 'Services' && $action === 'live') ? 'active' : '' ?>">
              <i class="bi bi-shop-window"></i> Live Services
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/profile') ?>" class="<?= ($controller === 'Users' && $action === 'profile') ? 'active' : '' ?>">
              <i class="bi bi-gear"></i> Settings
            </a>
          </li>
          <li>
            <a href="<?= $this->Url->build('/logout') ?>" class="text-danger">
              <i class="bi bi-box-arrow-left"></i> Logout
            </a>
          </li>
        </ul>
      </div>

      <!-- User Profile Pill -->
      <div class="sidebar-user-pill">
        <div class="avatar-circle-sm"><?= h($userInit) ?></div>
        <div class="user-info">
          <div class="user-name"><?= h($userName) ?></div>
          <div class="user-role"><?= h(ucfirst($user->role)) ?></div>
        </div>
      </div>
    </aside>

    <!-- Right Main Content Area -->
    <div class="client-main-content">
      <!-- Top Header Bar -->
      <header class="client-header">
        <h2 class="header-page-title brand-font"><?= $this->fetch('title', 'Dashboard') ?></h2>
        <div class="d-flex align-items-center gap-3">
          <a href="<?= $this->Url->build('/book') ?>" class="btn-book-now-pill">
            <i class="bi bi-stars"></i> Book Now
          </a>
        </div>
      </header>

      <!-- Page Body Content -->
      <div class="client-body-padding">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
      </div>
    </div>
  </div>

<?php else: ?>
  <!-- UNAUTHENTICATED / GUEST: Full-Width Navbar Layout WITHOUT Sidebar -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 px-4 shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand brand-font fs-2 fw-bold text-wine m-0" href="<?= $this->Url->build('/') ?>">
        glamora<span class="text-pink" style="color: #E87A90;">*</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="publicNavbar">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-4">
          <li class="nav-item">
            <a class="nav-link fw-semibold text-wine" href="<?= $this->Url->build('/services') ?>">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold text-wine" href="<?= $this->Url->build('/offers') ?>">Offers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold text-wine" href="<?= $this->Url->build('/live-services') ?>">Live Services</a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <a href="<?= $this->Url->build('/login') ?>" class="btn btn-outline-dark-pill px-4 py-2 small fw-semibold">Sign in</a>
          <a href="<?= $this->Url->build('/register') ?>" class="btn btn-book-gradient-pill px-4 py-2 small fw-bold">Join Glamora ✨</a>
        </div>
      </div>
    </div>
  </nav>

  <?php if ($controller === 'Users' && in_array($action, ['login', 'register', 'registerAdmin', 'verifyOtp'])): ?>
    <?= $this->fetch('content') ?>
  <?php else: ?>
    <div class="container py-4">
      <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
    </div>
  <?php endif; ?>
<?php endif; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Glamora Custom JS -->
<?= $this->Html->script('glamora') ?>

<?= $this->fetch('script') ?>
</body>
</html>
