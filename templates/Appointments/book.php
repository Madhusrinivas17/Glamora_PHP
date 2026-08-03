<?php
/**
 * Glamora Ultra-Luxury Interactive 5-Step Salon Appointment Booking Wizard with Parlour Selection
 */
$this->assign('title', 'Book Salon Appointment - Glamora');
$promoParam = $this->request->getQuery('promo');
?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      
      <!-- Wizard Progress Header -->
      <div class="text-center mb-4">
        <span class="badge px-4 py-2 rounded-pill fw-bold small text-uppercase mb-2" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90;">
          <i class="bi bi-sparkles me-1 text-pink"></i> ONLINE SALON RESERVATION
        </span>
        <h1 class="brand-font text-wine display-5 fw-bold mb-2">Book Your Glamora Experience</h1>
        <p class="text-muted small mx-auto mb-0" style="max-width: 540px;">
          Select your salon parlour branch, desired service, master beautician, date, and preferred time slot to confirm your appointment.
        </p>
      </div>

      <!-- Interactive Stepper Progress Bar (5 Steps) -->
      <div class="d-flex justify-content-between align-items-center mb-5 p-2 bg-white rounded-pill border shadow-sm flex-wrap gap-2 text-center" style="border-color: #F2E4E8 !important;">
        <button type="button" class="step-nav-btn flex-fill py-2 px-2 rounded-pill border-0 fw-bold small transition-all active" id="step-btn-1" onclick="showStep(1)">
          <span class="badge rounded-circle me-1 step-num-badge">1</span> 1. Select Salon
        </button>
        <button type="button" class="step-nav-btn flex-fill py-2 px-2 rounded-pill border-0 fw-bold small transition-all" id="step-btn-2" onclick="showStep(2)">
          <span class="badge rounded-circle me-1 step-num-badge">2</span> 2. Select Service
        </button>
        <button type="button" class="step-nav-btn flex-fill py-2 px-2 rounded-pill border-0 fw-bold small transition-all" id="step-btn-3" onclick="showStep(3)">
          <span class="badge rounded-circle me-1 step-num-badge">3</span> 3. Pick Stylist
        </button>
        <button type="button" class="step-nav-btn flex-fill py-2 px-2 rounded-pill border-0 fw-bold small transition-all" id="step-btn-4" onclick="showStep(4)">
          <span class="badge rounded-circle me-1 step-num-badge">4</span> 4. Date & Time
        </button>
        <button type="button" class="step-nav-btn flex-fill py-2 px-2 rounded-pill border-0 fw-bold small transition-all" id="step-btn-5" onclick="showStep(5)">
          <span class="badge rounded-circle me-1 step-num-badge">5</span> 5. Confirm
        </button>
      </div>

      <!-- Booking Form -->
      <?= $this->Form->create(null, ['url' => ['action' => 'book'], 'id' => 'booking-form']) ?>

        <!-- STEP 1: Select Salon / Parlour -->
        <div class="booking-wizard-step active" id="step-content-1">
          <div class="mb-4">
            <h4 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-shop text-pink me-2"></i>Step 1: Select Salon / Parlour Branch</h4>
            <p class="text-muted small mb-0">Choose your preferred Glamora salon location before selecting services</p>
          </div>

          <!-- Hidden Input for Selected Parlour ID -->
          <input type="hidden" name="parlour_id" id="parlour_id_input" value="<?= !empty($parlours) ? $parlours->first()->id : '' ?>" required>

          <!-- Visual Parlour Cards Grid -->
          <div class="row g-3 mb-4">
            <?php if (empty($parlours) || count($parlours) === 0): ?>
              <div class="col-12">
                <div class="parlour-select-card p-4 rounded-4 bg-white border selected cursor-pointer" id="parlour-card-default" onclick="selectParlourCard('', 'Glamora Main Parlour', 'Vizag')">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold">🟢 Open Now</span>
                  </div>
                  <h5 class="brand-font text-wine mb-1 fw-bold fs-6">Glamora Main Salon</h5>
                  <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-pink"></i> Vizag Main Branch</p>
                </div>
              </div>
            <?php else: ?>
              <?php foreach ($parlours as $index => $p): ?>
                <?php
                  $isOpen = (bool)$p->is_open;
                  $isSelected = ($index === 0);
                ?>
                <div class="col-md-6">
                  <div class="parlour-select-card p-4 rounded-4 bg-white border cursor-pointer h-100 transition-all <?= $isSelected ? 'selected' : '' ?>"
                       id="parlour-card-<?= $p->id ?>"
                       onclick="selectParlourCard(<?= $p->id ?>, '<?= h($p->name) ?>', '<?= h($p->city ?: 'Vizag') ?>')">
                    
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <?php if ($isOpen): ?>
                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold small">🟢 Open Now</span>
                      <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-1 fw-bold small">🔴 Closed</span>
                      <?php endif; ?>
                    </div>

                    <h5 class="brand-font text-wine mb-1 fw-bold fs-6"><?= h($p->name) ?></h5>
                    <p class="text-muted small mb-2" style="font-size:0.83rem;">
                      <i class="bi bi-geo-alt me-1 text-pink"></i> <?= h($p->address ?: ($p->city ?: 'Vizag Branch')) ?>
                    </p>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                      <span class="small text-muted" style="font-size:0.78rem;"><i class="bi bi-telephone text-pink me-1"></i><?= h($p->phone ?: '+91 9491398697') ?></span>
                      <span class="badge rounded-circle p-1 check-badge" style="background: #F2E4E8; color: #7A2E44;"><i class="bi bi-check-lg"></i></span>
                    </div>

                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-book-gradient-pill px-4 py-2 fw-bold" onclick="showStep(2)">
              Next: Select Service <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>

        <!-- STEP 2: Select Service (Visual Cards Grid) -->
        <div class="booking-wizard-step" id="step-content-2">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
              <h4 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-scissors text-pink me-2"></i>Step 2: Choose Your Salon Service</h4>
              <p class="text-muted small mb-0">Select from our signature hair, skin, bridal, and beauty treatments</p>
            </div>
            
            <div class="px-4 py-2 bg-white rounded-pill border shadow-sm">
              <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.65rem;">SELECTED PRICE</small>
              <strong class="fs-5 text-pink" id="top-preview-price">Rs. --</strong>
            </div>
          </div>

          <!-- Hidden Input for Selected Service ID -->
          <input type="hidden" name="service_id" id="service_id_input" value="<?= $selectedService ? $selectedService->id : '' ?>" required>

          <!-- Visual Service Cards Grid -->
          <div class="row g-3 mb-4">
            <?php foreach ($services as $srv): ?>
              <?php
                $isSelected = ($selectedService && $selectedService->id == $srv->id);
                $catName = h($srv->service_category ? $srv->service_category->name : 'Salon Care');
              ?>
              <div class="col-md-6">
                <div class="service-select-card p-3 rounded-4 bg-white border cursor-pointer h-100 transition-all <?= $isSelected ? 'selected' : '' ?>"
                     id="service-card-<?= $srv->id ?>"
                     onclick="selectServiceCard(<?= $srv->id ?>, '<?= h($srv->name) ?>', '<?= number_format((float)$srv->price, 2) ?>', <?= (int)$srv->duration_minutes ?>)">
                  
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge px-3 py-1 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90; font-size: 0.72rem;">
                      <?= $catName ?>
                    </span>
                    <strong class="fs-5 text-wine">Rs. <?= number_format((float)$srv->price, 2) ?></strong>
                  </div>

                  <h5 class="brand-font text-wine mb-1 fw-bold fs-6"><?= h($srv->name) ?></h5>
                  <p class="text-muted small mb-2 text-truncate" style="font-size: 0.82rem;">
                    <?= h($srv->description ?: 'Enjoy our tailored luxury salon treatment.') ?>
                  </p>

                  <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small text-muted" style="font-size:0.78rem;"><i class="bi bi-clock text-pink me-1"></i><?= (int)$srv->duration_minutes ?> Minutes Session</span>
                    <span class="badge rounded-circle p-1 check-badge" style="background: #F2E4E8; color: #7A2E44;"><i class="bi bi-check-lg"></i></span>
                  </div>

                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-dark-pill px-4 py-2 fw-semibold" onclick="showStep(1)">
              <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-book-gradient-pill px-4 py-2 fw-bold" onclick="showStep(3)">
              Next: Pick Stylist <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>

        <!-- STEP 3: Pick Stylist / Beautician -->
        <div class="booking-wizard-step" id="step-content-3">
          <div class="mb-4">
            <h4 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-person-badge text-pink me-2"></i>Step 3: Choose Your Stylist / Beautician</h4>
            <p class="text-muted small mb-0">Select your preferred beauty specialist or allow us to auto-assign the first available expert</p>
          </div>

          <!-- Hidden Input for Beautician ID -->
          <input type="hidden" name="beautician_id" id="beautician_id_input" value="">

          <!-- Auto Assignment Option -->
          <div class="beautician-select-card p-3 rounded-4 bg-white border cursor-pointer mb-3 selected" 
               id="beautician-card-auto"
               onclick="selectBeauticianCard('', 'Automatic Assignment')">
            <div class="d-flex align-items-center gap-3">
              <div class="avatar-circle-sm rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px; background: linear-gradient(135deg, #7A2E44 0%, #36111C 100%); color:#FFF; font-size:1.3rem;">
                <i class="bi bi-stars"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="brand-font text-wine mb-0 fw-bold fs-6">✨ Automatic System Assignment</h6>
                <small class="text-muted">First available master beautician assigned automatically</small>
              </div>
              <span class="badge px-3 py-1 rounded-pill fw-bold" style="background: #FDF0F3; color: #7A2E44; border: 1px solid #E87A90;">RECOMMENDED</span>
            </div>
          </div>

          <!-- Beauticians Cards Grid -->
          <div class="row g-3 mb-4">
            <?php foreach ($beauticians as $b): ?>
              <div class="col-md-6">
                <div class="beautician-select-card p-3 rounded-4 bg-white border cursor-pointer h-100 transition-all" 
                     id="beautician-card-<?= $b->id ?>"
                     onclick="selectBeauticianCard(<?= $b->id ?>, '<?= h($b->name) ?>')">
                  <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle-sm rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:44px; height:44px; background:#FDE8EF; color:#E87A90;">
                      <?= strtoupper(substr($b->name, 0, 1)) ?>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="brand-font text-wine mb-0 fw-bold fs-6"><?= h($b->name) ?></h6>
                      <small class="text-muted d-block"><?= h($b->specialization ?: 'Beauty Specialist') ?></small>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-dark-pill px-4 py-2 fw-semibold" onclick="showStep(2)">
              <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-book-gradient-pill px-4 py-2 fw-bold" onclick="showStep(4)">
              Next: Select Date & Time <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>

        <!-- STEP 4: Select Date & Time Slot -->
        <div class="booking-wizard-step" id="step-content-4">
          <div class="mb-4">
            <h4 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-calendar-event text-pink me-2"></i>Step 4: Select Appointment Date & Time Slot</h4>
            <p class="text-muted small mb-0">Choose your preferred salon visit date and available slot</p>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold text-wine small">Appointment Date</label>
              <input type="date" name="appointment_date" class="form-control form-control-lg rounded-4 border-pink" id="appointment-date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required onchange="fetchAvailableSlots()">
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <div class="d-flex gap-2 w-100">
                <button type="button" class="btn btn-outline-pink-pill flex-fill py-2 small fw-bold" onclick="setDateShortcut('<?= date('Y-m-d') ?>')">Today</button>
                <button type="button" class="btn btn-outline-pink-pill flex-fill py-2 small fw-bold" onclick="setDateShortcut('<?= date('Y-m-d', strtotime('+1 day')) ?>')">Tomorrow</button>
              </div>
            </div>
          </div>

          <!-- Dynamic Interactive Time Slot Pills Container -->
          <label class="form-label fw-semibold text-wine d-block mb-2">Available Time Slots</label>
          <div id="slots-container" class="p-4 bg-white rounded-4 border shadow-sm mb-4 min-height-100" style="border-color: #F2E4E8 !important;">
            <span class="text-muted small">Loading available salon slots...</span>
          </div>

          <input type="hidden" name="slot_id" id="selected-slot-id">
          <input type="hidden" name="appointment_time" id="selected-appointment-time">

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-dark-pill px-4 py-2 fw-semibold" onclick="showStep(3)">
              <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-book-gradient-pill px-4 py-2 fw-bold" onclick="showStep(5)">
              Next: Review & Confirm <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>

        <!-- STEP 5: Review Summary & Confirm -->
        <div class="booking-wizard-step" id="step-content-5">
          <div class="mb-4">
            <h4 class="brand-font text-wine mb-1 fw-bold"><i class="bi bi-shield-check text-pink me-2"></i>Step 5: Review Summary & Confirm Booking</h4>
            <p class="text-muted small mb-0">Verify your appointment summary and select your payment method</p>
          </div>

          <!-- Booking Summary Receipt Card -->
          <div class="p-4 rounded-4 bg-white border shadow-sm mb-4" style="border-color: #F2E4E8 !important;">
            <h6 class="brand-font text-wine fw-bold mb-3 border-bottom pb-2"><i class="bi bi-receipt me-2 text-pink"></i>Booking Summary Receipt</h6>
            
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">SELECTED SALON PARLOUR</small>
                <strong class="text-wine fs-6" id="summary-parlour-name">Glamora Main Salon</strong>
                <small class="text-muted d-block" id="summary-parlour-city">Vizag Branch</small>
              </div>

              <div class="col-md-6">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">SELECTED SERVICE</small>
                <strong class="text-wine fs-6" id="summary-service-name">-- Select Service --</strong>
                <small class="text-muted d-block" id="summary-service-duration">0 mins session</small>
              </div>

              <div class="col-md-6">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">ASSIGNED STYLIST</small>
                <strong class="text-wine fs-6" id="summary-beautician-name">Automatic Assignment</strong>
              </div>

              <div class="col-md-6">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">DATE & TIME SLOT</small>
                <strong class="text-wine fs-6" id="summary-datetime"><?= date('Y-m-d') ?> (Select Slot)</strong>
              </div>

              <div class="col-md-12 pt-2 border-top text-end">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">TOTAL PAYABLE</small>
                <strong class="text-pink fs-3" id="summary-total-price">Rs. --</strong>
              </div>
            </div>

            <?php if (!empty($promoParam)): ?>
              <div class="p-2 bg-light rounded-3 border mb-3">
                <small class="text-muted d-block text-xs">PROMO CODE APPLIED</small>
                <strong class="text-pink font-monospace fs-6"><i class="bi bi-tag-fill me-1"></i> <?= h($promoParam) ?></strong>
              </div>
            <?php endif; ?>

            <div class="mb-3 pt-3 border-top">
              <label class="form-label fw-semibold text-wine small">Special Notes / Requests (Optional)</label>
              <textarea name="notes" class="form-control rounded-3 border-pink" rows="2" placeholder="Mention skin sensitivities, preferred hair products, or styling requests..."></textarea>
            </div>

            <div>
              <label class="form-label fw-semibold text-wine small d-block mb-2">Select Payment Method</label>
              <div class="row g-2">
                <div class="col-md-6">
                  <div class="form-check p-3 bg-light border rounded-4 cursor-pointer">
                    <input class="form-check-input ms-0 me-2" type="radio" name="payment_method" id="pay1" value="Pay at Salon" checked>
                    <label class="form-check-label fw-bold text-wine cursor-pointer small" for="pay1">
                      <i class="bi bi-shop text-pink me-1"></i> Pay at Salon (Cash / Card)
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check p-3 bg-light border rounded-4 cursor-pointer">
                    <input class="form-check-input ms-0 me-2" type="radio" name="payment_method" id="pay2" value="Credit/Debit Card">
                    <label class="form-check-label fw-bold text-wine cursor-pointer small" for="pay2">
                      <i class="bi bi-credit-card text-gold me-1"></i> Online Payment
                    </label>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-dark-pill px-4 py-2 fw-semibold" onclick="showStep(4)">
              <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="submit" class="btn btn-book-gradient-pill px-5 py-3 fw-bold fs-6 shadow-lg">
              <i class="bi bi-check-circle-fill me-2"></i> Confirm & Book Appointment ✨
            </button>
          </div>
        </div>

      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<style>
.booking-wizard-step {
  display: none;
}
.booking-wizard-step.active {
  display: block;
}
.step-nav-btn {
  background: transparent;
  color: #7E6571;
}
.step-nav-btn.active {
  background: linear-gradient(135deg, #7A2E44 0%, #36111C 100%) !important;
  color: #FFFFFF !important;
  box-shadow: 0 4px 14px rgba(54, 17, 28, 0.25);
}
.step-num-badge {
  background: rgba(255,255,255,0.25);
  color: inherit;
}
.parlour-select-card, .service-select-card, .beautician-select-card {
  border-color: #F2E4E8 !important;
  transition: all 0.25s ease;
}
.parlour-select-card:hover, .service-select-card:hover, .beautician-select-card:hover {
  border-color: #E87A90 !important;
  transform: translateY(-2px);
}
.parlour-select-card.selected, .service-select-card.selected, .beautician-select-card.selected {
  border: 2px solid #7A2E44 !important;
  background: #FDF0F3 !important;
  box-shadow: 0 6px 18px rgba(122, 46, 68, 0.12);
}
.parlour-select-card.selected .check-badge, .service-select-card.selected .check-badge {
  background: #7A2E44 !important;
  color: #FFFFFF !important;
}
.btn-slot-pill {
  border: 1px solid #E87A90;
  background: #FFFFFF;
  color: #2B151F;
  border-radius: 50px;
  padding: 8px 18px;
  font-weight: 600;
  font-size: 0.88rem;
  transition: all 0.2s ease;
  cursor: pointer;
}
.btn-slot-pill:hover {
  background: #FDF0F3;
  color: #7A2E44;
}
.btn-slot-pill.active {
  background: linear-gradient(135deg, #7A2E44 0%, #36111C 100%) !important;
  color: #FFFFFF !important;
  box-shadow: 0 4px 14px rgba(54, 17, 28, 0.25);
  border-color: #36111C !important;
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

<script>
let selectedParlourData = { id: '', name: 'Glamora Main Salon', city: 'Vizag' };
let selectedServiceData = { id: '', name: '', price: '0.00', duration: 0 };
let selectedBeauticianData = { id: '', name: 'Automatic Assignment' };

document.addEventListener('DOMContentLoaded', function() {
  const firstParlourCard = document.querySelector('.parlour-select-card');
  if (firstParlourCard) firstParlourCard.click();

  <?php if ($selectedService): ?>
    selectServiceCard(<?= $selectedService->id ?>, '<?= h($selectedService->name) ?>', '<?= number_format((float)$selectedService->price, 2) ?>', <?= (int)$selectedService->duration_minutes ?>);
  <?php else: ?>
    const firstServiceCard = document.querySelector('.service-select-card');
    if (firstServiceCard) firstServiceCard.click();
  <?php endif; ?>

  fetchAvailableSlots();
});

function showStep(stepNum) {
  for (let i = 1; i <= 5; i++) {
    const stepBtn = document.getElementById('step-btn-' + i);
    const stepContent = document.getElementById('step-content-' + i);
    
    if (i === stepNum) {
      stepBtn.classList.add('active');
      stepContent.classList.add('active');
    } else {
      stepBtn.classList.remove('active');
      stepContent.classList.remove('active');
    }
  }

  updateSummaryReceipt();
}

function selectParlourCard(id, name, city) {
  document.getElementById('parlour_id_input').value = id;
  selectedParlourData = { id, name, city };

  document.querySelectorAll('.parlour-select-card').forEach(c => c.classList.remove('selected'));
  
  if (!id) {
    const defaultCard = document.getElementById('parlour-card-default');
    if (defaultCard) defaultCard.classList.add('selected');
  } else {
    const targetCard = document.getElementById('parlour-card-' + id);
    if (targetCard) targetCard.classList.add('selected');
  }

  updateSummaryReceipt();
}

function selectServiceCard(id, name, price, duration) {
  document.getElementById('service_id_input').value = id;
  selectedServiceData = { id, name, price, duration };

  document.querySelectorAll('.service-select-card').forEach(c => c.classList.remove('selected'));
  const targetCard = document.getElementById('service-card-' + id);
  if (targetCard) targetCard.classList.add('selected');

  document.getElementById('top-preview-price').textContent = 'Rs. ' + price;
  updateSummaryReceipt();
}

function selectBeauticianCard(id, name) {
  document.getElementById('beautician_id_input').value = id;
  selectedBeauticianData = { id, name };

  document.querySelectorAll('.beautician-select-card').forEach(c => c.classList.remove('selected'));
  
  if (!id) {
    document.getElementById('beautician-card-auto').classList.add('selected');
  } else {
    const targetCard = document.getElementById('beautician-card-' + id);
    if (targetCard) targetCard.classList.add('selected');
  }

  updateSummaryReceipt();
  fetchAvailableSlots();
}

function setDateShortcut(dateStr) {
  document.getElementById('appointment-date').value = dateStr;
  fetchAvailableSlots();
}

function fetchAvailableSlots() {
  const dateInput = document.getElementById('appointment-date');
  const beauticianId = selectedBeauticianData.id;
  const container = document.getElementById('slots-container');

  const date = dateInput.value;

  if (!date) {
    container.innerHTML = '<span class="text-muted small">Please select an appointment date.</span>';
    return;
  }

  container.innerHTML = '<div class="spinner-border spinner-border-sm text-pink me-2" role="status"></div><span class="text-muted small">Fetching available slots...</span>';

  fetch('<?= $this->Url->build('/appointments/get-slots') ?>?date=' + date + '&beautician_id=' + beauticianId)
    .then(res => res.json())
    .then(data => {
      if (data.status === 'holiday') {
        container.innerHTML = '<div class="alert alert-danger m-0 py-2 rounded-3 small"><i class="bi bi-calendar-x me-2"></i>' + data.message + '</div>';
        return;
      }

      if (data.status === 'success' && data.slots && data.slots.length > 0) {
        let html = '<div class="d-flex flex-wrap gap-2">';
        data.slots.forEach(slot => {
          html += '<button type="button" class="btn-slot-pill" onclick="selectSlot(' + slot.id + ', \'' + slot.time + '\', this)">' +
                    '<i class="bi bi-clock me-1"></i>' + slot.time + 
                  '</button>';
        });
        html += '</div>';
        container.innerHTML = html;
      } else {
        container.innerHTML = '<div class="alert alert-light border m-0 py-2 rounded-3 small text-muted"><i class="bi bi-info-circle me-2 text-pink"></i>No custom slots found for this date. Defaulting to standard salon operating hours (10:00 AM - 6:00 PM).</div>';
      }
    })
    .catch(err => {
      container.innerHTML = '<span class="text-muted small">Select your preferred date & time.</span>';
    });
}

function selectSlot(slotId, time, btn) {
  document.getElementById('selected-slot-id').value = slotId;
  document.getElementById('selected-appointment-time').value = time;

  const allBtns = document.querySelectorAll('.btn-slot-pill');
  allBtns.forEach(b => b.classList.remove('active'));

  btn.classList.add('active');
  updateSummaryReceipt();
}

function updateSummaryReceipt() {
  document.getElementById('summary-parlour-name').textContent = selectedParlourData.name || 'Glamora Main Salon';
  document.getElementById('summary-parlour-city').textContent = (selectedParlourData.city || 'Vizag') + ' Branch';
  document.getElementById('summary-service-name').textContent = selectedServiceData.name || '-- Select Service --';
  document.getElementById('summary-service-duration').textContent = (selectedServiceData.duration || 0) + ' Mins Session';
  document.getElementById('summary-beautician-name').textContent = selectedBeauticianData.name || 'Automatic Assignment';
  
  const dateVal = document.getElementById('appointment-date').value;
  const timeVal = document.getElementById('selected-appointment-time').value || '(Select Time Slot)';
  document.getElementById('summary-datetime').textContent = dateVal + ' at ' + timeVal;
  
  document.getElementById('summary-total-price').textContent = 'Rs. ' + (selectedServiceData.price || '0.00');
}
</script>
