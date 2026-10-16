function toggleMenu() {
  document.getElementById('menu')?.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', () => {
  if (!window.gsap) return;
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);
  for (const [selector, offset] of [['.texto p', 40], ['.projeto-card', 60], ['.pub-card', 60]]) {
    if (!document.querySelector(selector)) continue;
    gsap.from(selector, {
      scrollTrigger: window.ScrollTrigger ? { trigger: selector, start: 'top 85%' } : undefined,
      opacity: 0, y: offset, duration: 0.8, stagger: 0.12
    });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const carousel = document.querySelector('.roleta');
  if (!carousel || carousel.children.length < 2) return;

  const slides = Array.from(carousel.children);
  const section = carousel.closest('.depoimento');
  const previousButton = section?.querySelector('.depoimento-anterior');
  const nextButton = section?.querySelector('.depoimento-proximo');
  let current = 0;
  let timer;

  const showSlide = (index) => {
    current = index;
    carousel.scrollTo({ left: carousel.clientWidth * current, behavior: 'smooth' });
  };

  const start = () => {
    if (timer) return;
    timer = window.setInterval(() => showSlide((current + 1) % slides.length), 3500);
  };
  const stop = () => {
    window.clearInterval(timer);
    timer = undefined;
  };
  const previous = () => showSlide((current - 1 + slides.length) % slides.length);
  const next = () => showSlide((current + 1) % slides.length);

  previousButton?.addEventListener('click', previous);
  nextButton?.addEventListener('click', next);
  carousel.addEventListener('mouseenter', stop);
  carousel.addEventListener('mouseleave', start);
  carousel.addEventListener('focusin', stop);
  carousel.addEventListener('focusout', start);
  window.addEventListener('resize', () => showSlide(current));
  start();
});
