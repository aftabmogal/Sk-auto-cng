// Counter animation when visible
function animateCounters(){
  document.querySelectorAll('.counter').forEach(el=>{
    const target = +el.dataset.target;
    let cur = 0;
    const step = Math.max(1, Math.floor(target / 120));
    const t = setInterval(()=>{
      cur += step;
      if(cur >= target){ el.textContent = target; clearInterval(t); }
      else el.textContent = cur;
    }, 12);
  });
}

function isElementInViewport(el){
  const rect = el.getBoundingClientRect();
  return rect.top < (window.innerHeight || document.documentElement.clientHeight) - 50;
}

function onScroll(){
  const stats = document.querySelector('.hero-stats');
  if(stats && !stats.dataset.animated && isElementInViewport(stats)){
    animateCounters();
    stats.dataset.animated = "true";
  }
}
document.addEventListener('scroll', onScroll);
window.addEventListener('load', onScroll);

// Gallery lightbox
document.querySelectorAll('.gallery-link').forEach(a=>{
  a.addEventListener('click', function(e){
    e.preventDefault();
    const src = this.getAttribute('href');
    const img = document.getElementById('lightboxImage');
    img.src = src;
    const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
    modal.show();
  });
});

// Smooth scroll for nav links
document.querySelectorAll('a.nav-link').forEach(a=>{
  a.addEventListener('click', function(e){
    const href = this.getAttribute('href');
    if(href && href.startsWith('#')){
      e.preventDefault();
      document.querySelector(href).scrollIntoView({behavior:'smooth', block:'start'});
    }
  });
});
