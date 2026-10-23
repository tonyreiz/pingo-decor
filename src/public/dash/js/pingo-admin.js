document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('[data-admin-menu]');
  const close = document.querySelector('[data-admin-close]');
  button?.addEventListener('click', () => document.body.classList.toggle('admin-menu-open'));
  close?.addEventListener('click', () => document.body.classList.remove('admin-menu-open'));

  let activeModal = null;
  let activeTrigger = null;
  let legacyBackdrop = null;

  const focusableSelector = [
    'button:not([disabled])',
    'input:not([disabled])',
    'select:not([disabled])',
    'textarea:not([disabled])',
    'a[href]',
    '[tabindex]:not([tabindex="-1"])',
  ].join(',');

  const syncBodyScroll = () => {
    const hasOpenModal = document.querySelector('.admin-modal.is-open, .modal.show');
    document.body.classList.toggle('admin-modal-open', Boolean(hasOpenModal));
    document.body.classList.toggle('modal-open', Boolean(document.querySelector('.modal.show')));
  };

  const getFocusableElements = (modal) => [...modal.querySelectorAll(focusableSelector)]
    .filter((element) => !element.matches('.admin-modal-backdrop, .admin-modal-close'));

  const openAdminModal = (modal, trigger) => {
    if (!modal) return;

    if (activeModal && activeModal !== modal) {
      activeModal.classList.remove('is-open');
      activeModal.hidden = true;
      activeModal.setAttribute('aria-hidden', 'true');
      activeTrigger?.setAttribute('aria-expanded', 'false');
    }

    activeModal = modal;
    activeTrigger = trigger;
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    trigger?.setAttribute('aria-expanded', 'true');

    requestAnimationFrame(() => {
      modal.classList.add('is-open');
      syncBodyScroll();
      const focusTarget = modal.querySelector('[autofocus]')
        || getFocusableElements(modal)[0]
        || modal.querySelector('.admin-modal-dialog');
      focusTarget?.focus();
    });
  };

  const closeAdminModal = (modal = activeModal) => {
    if (!modal) return;

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    activeTrigger?.setAttribute('aria-expanded', 'false');

    window.setTimeout(() => {
      if (!modal.classList.contains('is-open')) modal.hidden = true;
    }, 180);

    const triggerToRestore = activeTrigger;
    activeModal = null;
    activeTrigger = null;
    syncBodyScroll();
    triggerToRestore?.focus();
  };

  const openLegacyModal = (modal, trigger) => {
    if (!modal) return;

    activeModal = modal;
    activeTrigger = trigger;
    modal.style.display = 'block';
    modal.removeAttribute('aria-hidden');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('role', 'dialog');
    modal.classList.add('show');

    legacyBackdrop?.remove();
    legacyBackdrop = document.createElement('div');
    legacyBackdrop.className = 'modal-backdrop fade show';
    document.body.append(legacyBackdrop);
    syncBodyScroll();

    const focusTarget = modal.querySelector('[autofocus]') || getFocusableElements(modal)[0];
    focusTarget?.focus();
  };

  const closeLegacyModal = (modal = activeModal) => {
    if (!modal?.classList.contains('modal')) return;

    modal.classList.remove('show');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    modal.removeAttribute('aria-modal');
    legacyBackdrop?.remove();
    legacyBackdrop = null;

    const triggerToRestore = activeTrigger;
    activeModal = null;
    activeTrigger = null;
    syncBodyScroll();
    triggerToRestore?.focus();
  };

  document.addEventListener('click', (event) => {
    const target = event.target;
    if (!(target instanceof Element)) return;

    const alertCloseButton = target.closest('[data-admin-alert-close]');
    if (alertCloseButton) {
      const alert = alertCloseButton.closest('.admin-alert');
      alert?.classList.add('is-leaving');
      window.setTimeout(() => alert?.remove(), 180);
      return;
    }

    const adminOpenButton = target.closest('[data-admin-modal-open]');
    if (adminOpenButton) {
      event.preventDefault();
      openAdminModal(document.getElementById(adminOpenButton.dataset.adminModalOpen), adminOpenButton);
      return;
    }

    const adminCloseButton = target.closest('[data-admin-modal-close]');
    if (adminCloseButton) {
      event.preventDefault();
      closeAdminModal(adminCloseButton.closest('.admin-modal'));
      return;
    }

    if (typeof window.bootstrap === 'undefined') {
      const legacyOpenButton = target.closest('[data-bs-toggle="modal"]');
      if (legacyOpenButton) {
        event.preventDefault();
        const modalId = legacyOpenButton.getAttribute('data-bs-target')?.replace(/^#/, '');
        openLegacyModal(modalId ? document.getElementById(modalId) : null, legacyOpenButton);
        return;
      }

      const legacyCloseButton = target.closest('[data-bs-dismiss="modal"]');
      if (legacyCloseButton) {
        event.preventDefault();
        closeLegacyModal(legacyCloseButton.closest('.modal'));
        return;
      }

      if (target.classList.contains('modal') && target.classList.contains('show')) {
        closeLegacyModal(target);
      }
    }
  });

  document.addEventListener('submit', (event) => {
    if (event.target instanceof HTMLFormElement && event.target.matches('.admin-form:not([action])')) {
      event.preventDefault();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (!activeModal) return;

    if (event.key === 'Escape') {
      activeModal.classList.contains('admin-modal')
        ? closeAdminModal(activeModal)
        : closeLegacyModal(activeModal);
      return;
    }

    if (event.key !== 'Tab') return;

    const focusableElements = getFocusableElements(activeModal);
    const firstElement = focusableElements[0];
    const lastElement = focusableElements.at(-1);
    if (!firstElement || !lastElement) return;

    if (event.shiftKey && document.activeElement === firstElement) {
      event.preventDefault();
      lastElement.focus();
    } else if (!event.shiftKey && document.activeElement === lastElement) {
      event.preventDefault();
      firstElement.focus();
    }
  });

  document.querySelectorAll('.admin-status, .badge').forEach((status) => {
    const label = status.textContent
      .trim()
      .toLocaleLowerCase('pt-BR')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '');

    if (label !== 'inativo') return;

    status.classList.remove('published', 'draft', 'review', 'text-bg-success', 'text-bg-warning', 'text-bg-secondary');
    status.classList.add('inactive');
  });
});
