<?php
/**
 * Glamora Navigation Header Element
 */
?>
<nav class="navbar navbar-expand-lg glamora-navbar">
  <div class="container">
    <a class="navbar-brand brand-font" href="<?= $this->Url->build('/') ?>">
      <i class="bi bi-flower1 me-2 text-pink"></i>Glam<span>ora</span>
    </a>
    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#glamoraNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="glamoraNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Services' && $this->request->getParam('action') === 'index' ? 'active' : '' ?>" href="<?= $this->Url->build('/services') ?>">
            <i class="bi bi-grid-fill me-1"></i> Services Catalog
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $this->request->getParam('controller') === 'Offers' ? 'active' : '' ?>" href="<?= $this->Url->build('/offers') ?>">
            <i class="bi bi-percent me-1"></i> Offers & Deals
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $this->Url->build('/book') ?>">
            <i class="bi bi-calendar-plus-fill me-1"></i> Book Appointment
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center">
        <?php if (!empty($authUser)): ?>
          <li class="nav-item">
            <a class="nav-link position-relative me-2" href="<?= $this->Url->build('/notifications') ?>">
              <i class="bi bi-bell-fill fs-5 text-wine"></i>
            </a>
          </li>
          
          <?php if (!empty($isAdmin)): ?>
            <li class="nav-item me-2">
              <a class="btn btn-gold btn-sm px-3" href="<?= $this->Url->build('/admin/dashboard') ?>">
                <i class="bi bi-speedometer2 me-1"></i> Admin Portal
              </a>
            </li>
          <?php endif; ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
              <div class="avatar-circle bg-pink text-white rounded-circle d-flex align-items-center justify-content-center" style="width:34px; height:34px; background:#E87A90;">
                <?= strtoupper(substr($authUser->full_name, 0, 1)) ?>
              </div>
              <span><?= h($authUser->full_name) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius:14px;">
              <li><a class="dropdown-item py-2" href="<?= $this->Url->build('/my-appointments') ?>"><i class="bi bi-calendar-check me-2"></i> My Appointments</a></li>
              <li><a class="dropdown-item py-2" href="<?= $this->Url->build('/notifications') ?>"><i class="bi bi-bell me-2"></i> Notifications</a></li>
              <li><a class="dropdown-item py-2" href="<?= $this->Url->build('/profile') ?>"><i class="bi bi-person-gear me-2"></i> Account Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item py-2 text-danger" href="<?= $this->Url->build('/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item me-2">
            <a class="btn btn-glamora-outline" href="<?= $this->Url->build('/login') ?>">
              <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-glamora" href="<?= $this->Url->build('/register') ?>">
              <i class="bi bi-person-plus-fill me-1"></i> Register
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
