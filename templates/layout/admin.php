<!DOCTYPE html>
<html lang="en">
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->fetch('title', 'Admin Dashboard - Glamora Salon Management') ?></title>
  
  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Glamora Theme & Admin CSS -->
  <?= $this->Html->css(['glamora-theme', 'admin']) ?>
  
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
</head>
<body class="admin-body">

<?php
  $user = $this->request->getAttribute('identity');
  $userName = $user ? $user->full_name : 'Salon Owner';
  $userInit = $user ? strtoupper(substr($user->full_name, 0, 1)) : 'A';
?>

<div class="admin-wrapper">
  <!-- White Sidebar Matching Customer Portal -->
  <aside class="admin-sidebar">
    <div>
      <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a class="admin-sidebar-brand brand-font" href="<?= $this->Url->build('/admin/dashboard') ?>">
          glamora<span class="sparkle">*</span>
        </a>
        <span class="badge-admin-pill">ADMIN</span>
      </div>

      <ul class="sidebar-nav">
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Dashboard' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/dashboard') ?>">
            <i class="bi bi-grid"></i> Dashboard Overview
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Appointments' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/appointments') ?>">
            <i class="bi bi-calendar-check"></i> Appointments Hub
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Services' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/services') ?>">
            <i class="bi bi-scissors"></i> Service Catalog
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Categories' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/categories') ?>">
            <i class="bi bi-tags"></i> Service Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Beauticians' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/beauticians') ?>">
            <i class="bi bi-people"></i> Beauticians & Roster
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Slots' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/slots') ?>">
            <i class="bi bi-clock-history"></i> Time Slots & Slots
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Offers' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/offers') ?>">
            <i class="bi bi-percent"></i> Special Offers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Holidays' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/holidays') ?>">
            <i class="bi bi-calendar-x"></i> Holiday Calendar
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'CustomerHistory' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/customer-history') ?>">
            <i class="bi bi-journal-text"></i> Customer History
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Reviews' ? 'active' : '' ?>" href="<?= $this->Url->build('/admin/reviews') ?>">
            <i class="bi bi-chat-heart"></i> Customer Reviews
          </a>
        </li>
        <li class="nav-item border-top pt-2 mt-2">
          <a class="nav-link text-danger" href="<?= $this->Url->build('/logout') ?>">
            <i class="bi bi-box-arrow-left"></i> Logout
          </a>
        </li>
      </ul>
    </div>

    <!-- Admin User Profile Pill -->
    <div class="sidebar-user-pill">
      <div class="avatar-circle-sm"><?= h($userInit) ?></div>
      <div class="user-info">
        <div class="user-name"><?= h($userName) ?></div>
        <div class="user-role">Salon Owner</div>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
      <div>
        <h2 class="mb-0 brand-font text-wine"><?= $this->fetch('title', 'Admin Dashboard') ?></h2>
        <small class="text-muted">Welcome back, <?= h($userName) ?>!</small>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="<?= $this->Url->build('/') ?>" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill">
          <i class="bi bi-box-arrow-up-right me-1"></i> View Website
        </a>
        <a href="<?= $this->Url->build('/admin/appointments') ?>" class="btn btn-book-gradient-pill btn-sm px-3 py-2 fw-bold">
          <i class="bi bi-calendar-event me-1"></i> Manage Bookings
        </a>
      </div>
    </div>

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->Html->script('glamora') ?>
<?= $this->fetch('script') ?>
</body>
</html>
