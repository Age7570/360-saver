<?php 
// Security Check
if(count(get_included_files()) == 1) exit('No direct script access allowed.');
?>
<footer class="footer gradient-footer text-white">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="d-flex align-items-center mb-2">
          <span class="brand-icon mr-2"><i class="fa fa-instagram"></i></span>
          <strong>InstaDownloader</strong>
        </div>
        <p class="small mb-2">Download Instagram videos instantly in the highest quality. 100% free, no login required.</p>
        <p class="small mb-2 text-white-50">InstaDownloader helps you save Instagram videos, Reels, and Stories in HD. Fast, free, and privacy-friendly — we don't store your downloads.</p>
        <div class="small text-white-50">© <?php echo date('Y'); ?> InstaDownloader. All rights reserved.</div>
      </div>
      <div class="col-6 col-md-3 mb-3">
        <h6 class="footer-title">Quick Links</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="index.php#seo">About Us</a></li>
          <li><a href="policies.php?page=privacy">Privacy Policy</a></li>
          <li><a href="policies.php?page=terms">Terms & Condition</a></li>
          <li><a href="policies.php?page=disclaimer">Disclaimer</a></li>
          <li><a href="policies.php?page=dmca">DMCA</a></li>
          <li><a href="index.php#faq">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-3 mb-3">
        <h6 class="footer-title">Resources</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="index.php#features">Features</a></li>
          <li><a href="index.php#guide">How to Use</a></li>
          <li><a href="index.php#faq">FAQ</a></li>
        </ul>
      </div>
    </div>

    <div class="security-box mt-2">
      <div class="security-icon"><i class="fa fa-lock"></i></div>
      <div class="text">We prioritize your privacy and security. All downloads are processed securely and never stored on our servers.</div>
    </div>

    <div class="footer-meta small d-flex flex-wrap justify-content-between pt-3 text-white-50">
      <div><i class="fa fa-globe"></i> Available Worldwide</div>
      <div><i class="fa fa-signal"></i> 99.9% Uptime</div>
      <div><i class="fa fa-shield"></i> SSL Secured</div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="content/js/jquery.min.js"></script>
  <script src="content/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
  <script src="content/js/ajax.js"></script>
</footer>
