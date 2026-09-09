/* Minimal interactivity: mobile enhancements, smooth show/hide, and FAQ UX tweaks */
(function(){
  // Smooth scroll for in-page nav links
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor){
    anchor.addEventListener('click', function(e){
      var id = this.getAttribute('href');
      if(id.length > 1 && document.querySelector(id)){
        e.preventDefault();
        window.scrollTo({top: document.querySelector(id).offsetTop - 70, behavior: 'smooth'});
      }
    });
  });

  // Auto-focus URL input when page loads
  var urlInput = document.getElementById('url');
  if(urlInput){ setTimeout(function(){ urlInput.focus(); }, 300); }

  // Accordion icons toggle (Bootstrap collapses already wired)
  var accordion = document.getElementById('faqAccordion');
  if(accordion){
    accordion.addEventListener('show.bs.collapse', function(e){
      var btn = e.target.parentElement.querySelector('button');
      if(btn){ btn.classList.add('open'); }
    });
    accordion.addEventListener('hide.bs.collapse', function(e){
      var btn = e.target.parentElement.querySelector('button');
      if(btn){ btn.classList.remove('open'); }
    });
  }
})();
