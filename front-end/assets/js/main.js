
document.addEventListener('DOMContentLoaded', function(){
  const path = window.location.pathname.replace(/\/+$/,'') || '/';
  document.querySelectorAll('.navbar .nav-link').forEach(link=>{
    const href=link.getAttribute('href');
    if(href && href.startsWith('#')) return;
    if(href && path.endsWith(href.replace('./',''))) link.classList.add('active');
  });
});
