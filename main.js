// =============================================
// SEMBARANG STORE - Main JavaScript
// =============================================

document.addEventListener('DOMContentLoaded', function () {

  // ---- Hamburger Menu (Public) ----
  const hamburger = document.getElementById('hamburger');
  const navMenu   = document.getElementById('navMenu');

  if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
      navMenu.classList.toggle('open');
    });
    document.addEventListener('click', (e) => {
      if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove('open');
      }
    });
  }

  // ---- Sidebar Toggle (Dashboard) ----
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar       = document.getElementById('sidebar');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }

  // ---- Auto-dismiss Alerts ----
  document.querySelectorAll('.alert[data-autodismiss]').forEach(el => {
    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transition = 'opacity .4s';
      setTimeout(() => el.remove(), 400);
    }, 3500);
  });

  // ---- Quantity Controls ----
  document.querySelectorAll('.qty-control').forEach(ctrl => {
    const minus = ctrl.querySelector('.qty-minus');
    const plus  = ctrl.querySelector('.qty-plus');
    const val   = ctrl.querySelector('.qty-value');
    const max   = parseInt(ctrl.dataset.max || 99);

    if (minus && plus && val) {
      minus.addEventListener('click', () => {
        let v = parseInt(val.value);
        if (v > 1) val.value = v - 1;
        triggerQtyChange(ctrl);
      });
      plus.addEventListener('click', () => {
        let v = parseInt(val.value);
        if (v < max) val.value = v + 1;
        triggerQtyChange(ctrl);
      });
    }
  });

  function triggerQtyChange(ctrl) {
    const event = new Event('change', { bubbles: true });
    const val = ctrl.querySelector('.qty-value');
    if (val) val.dispatchEvent(event);
  }

  // ---- Confirm Delete ----
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', function (e) {
      const msg = this.dataset.confirm || 'Yakin ingin menghapus data ini?';
      if (!confirm(msg)) e.preventDefault();
    });
  });

  // ---- Modal System ----
  document.querySelectorAll('[data-modal-open]').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = document.getElementById(btn.dataset.modalOpen);
      if (target) target.classList.add('open');
    });
  });

  document.querySelectorAll('[data-modal-close], .modal-overlay').forEach(el => {
    el.addEventListener('click', function (e) {
      if (e.target === this || this.dataset.modalClose !== undefined) {
        this.closest('.modal-overlay')?.classList.remove('open');
        const id = this.dataset.modalClose;
        if (id) document.getElementById(id)?.classList.remove('open');
      }
    });
  });

  document.querySelectorAll('.modal').forEach(m => {
    m.addEventListener('click', e => e.stopPropagation());
  });

  // ---- Animate on scroll ----
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.animate-on-scroll').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity .5s ease, transform .5s ease';
    observer.observe(el);
  });

  // ---- Active Nav Link Highlight ----
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link, .sidebar-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && currentPath.includes(href) && href !== '/') {
      link.classList.add('active');
    }
  });

  // ---- Live Search Filter (product listing) ----
  const searchInput = document.getElementById('liveSearch');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const query = this.value.toLowerCase().trim();
      document.querySelectorAll('.product-card').forEach(card => {
        const name  = card.dataset.name  || '';
        const brand = card.dataset.brand || '';
        const match = name.includes(query) || brand.includes(query);
        card.style.display = match ? '' : 'none';
      });
    });
  }

  // ---- Toast Notification ----
  window.showToast = function (message, type = 'info') {
    let container = document.getElementById('toastContainer');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toastContainer';
      container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
      document.body.appendChild(container);
    }
    const colors = {
      success: '#00e5a0', danger: '#ff4d6d', warning: '#f5c518', info: '#7dd3fc'
    };
    const toast = document.createElement('div');
    toast.style.cssText = `
      background: rgba(12,0,30,.95);
      border: 1px solid ${colors[type]};
      color: ${colors[type]};
      padding: 12px 20px;
      border-radius: 10px;
      font-family: Poppins, sans-serif;
      font-size: .875rem;
      backdrop-filter: blur(16px);
      animation: fadeInUp .3s ease;
      box-shadow: 0 4px 20px rgba(0,0,0,.3);
    `;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity .4s';
      setTimeout(() => toast.remove(), 400);
    }, 3000);
  };

});
