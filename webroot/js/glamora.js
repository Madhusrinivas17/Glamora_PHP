/* Glamora Interactive JavaScript */
document.addEventListener('DOMContentLoaded', function () {
  // Dynamic slot loading for booking page
  const dateInput = document.getElementById('appointment-date');
  const beauticianSelect = document.getElementById('beautician-select');
  const slotContainer = document.getElementById('slots-container');
  const slotIdInput = document.getElementById('selected-slot-id');

  if (dateInput && slotContainer) {
    function loadSlots() {
      const selectedDate = dateInput.value;
      const beauticianId = beauticianSelect ? beauticianSelect.value : '';

      if (!selectedDate) return;

      slotContainer.innerHTML = '<div class="text-muted"><i class="bi bi-hourglass-split me-1"></i> Checking available time slots...</div>';

      fetch(`/appointments/get-slots?date=${encodeURIComponent(selectedDate)}&beautician_id=${encodeURIComponent(beauticianId)}`)
        .then(res => res.json())
        .then(data => {
          if (data.status === 'holiday') {
            slotContainer.innerHTML = `<div class="alert alert-danger py-2 mb-0"><i class="bi bi-calendar-x me-1"></i> ${data.message}</div>`;
            return;
          }

          if (!data.slots || data.slots.length === 0) {
            slotContainer.innerHTML = '<div class="alert alert-warning py-2 mb-0"><i class="bi bi-exclamation-triangle me-1"></i> No available slots for this date/beautician. Please try another date.</div>';
            return;
          }

          let html = '<div class="d-flex flex-wrap gap-2">';
          data.slots.forEach(slot => {
            html += `
              <button type="button" class="btn btn-outline-secondary slot-btn btn-sm" data-slot-id="${slot.id}" data-time="${slot.start_time}">
                <i class="bi bi-clock me-1"></i> ${slot.time}
                ${slot.beautician ? `<small class="d-block text-xs text-muted">${slot.beautician}</small>` : ''}
              </button>
            `;
          });
          html += '</div>';
          slotContainer.innerHTML = html;

          // Attach slot click listener
          document.querySelectorAll('.slot-btn').forEach(btn => {
            btn.addEventListener('click', function () {
              document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('btn-primary', 'active'));
              this.classList.add('btn-primary', 'active');
              if (slotIdInput) {
                slotIdInput.value = this.getAttribute('data-slot-id');
              }
            });
          });
        })
        .catch(err => {
          slotContainer.innerHTML = '<div class="text-danger">Failed to load slots. Please refresh page.</div>';
        });
    }

    dateInput.addEventListener('change', loadSlots);
    if (beauticianSelect) {
      beauticianSelect.addEventListener('change', loadSlots);
    }

    // Trigger initial load if date pre-selected
    if (dateInput.value) {
      loadSlots();
    }
  }

  // Star rating interactive selector
  const starIcons = document.querySelectorAll('.interactive-stars i');
  const ratingInput = document.getElementById('rating-value');
  if (starIcons.length && ratingInput) {
    starIcons.forEach(star => {
      star.addEventListener('click', function () {
        const val = this.getAttribute('data-value');
        ratingInput.value = val;
        starIcons.forEach((s, idx) => {
          if (idx < val) {
            s.className = 'bi bi-star-fill text-warning';
          } else {
            s.className = 'bi bi-star text-muted';
          }
        });
      });
    });
  }
});
