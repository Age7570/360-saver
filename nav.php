<?php 
// Security Check
if(count(get_included_files()) == 1) exit('No direct script access allowed.');
?>
<nav class="navbar navbar-expand-lg navbar-dark nav-glass fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php" aria-label="Instagram Video Downloader">
      <span class="brand-icon mr-2"><i class="fa fa-instagram"></i></span>
      <span>InstaDownloader</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.php#features">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#guide">How It Works</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#seo">About</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#faq">FAQ</a></li>
        <li class="nav-item ml-lg-3 mt-2 mt-lg-0">
          <a class="btn btn-ig btn-sm" href="https://www.youtube.com/@Webpress-Hub" target="_blank" rel="noopener">YouTube</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
