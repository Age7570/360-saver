<?php
// policies.php - Unified policy pages (Privacy, Terms, Disclaimer, DMCA, Cookies)
// This file renders different policy pages based on the `?page=` query param.
// Example: policies.php?page=privacy | terms | disclaimer | dmca | cookies

include_once __DIR__ . '/config.php';

// Whitelist and page metadata
$pages = [
  'privacy' => [
    'title' => 'Privacy Policy',
    'desc'  => 'Learn how we collect, use, and protect your information.',
  ],
  'terms' => [
    'title' => 'Terms & Conditions',
    'desc'  => 'Read the terms that govern your use of this website.',
  ],
  'disclaimer' => [
    'title' => 'Disclaimer',
    'desc'  => 'Important legal disclaimers regarding the use of this website.',
  ],
  'dmca' => [
    'title' => 'DMCA Policy',
    'desc'  => 'Procedure for submitting a copyright infringement notice.',
  ],
  'cookies' => [
    'title' => 'Cookie Policy',
    'desc'  => 'Information about cookies and how we use them.',
  ],
];

$key = isset($_GET['page']) ? strtolower($_GET['page']) : 'privacy';
$key = preg_replace('/[^a-z]/', '', $key); // sanitize (letters only)
if (!isset($pages[$key])) {
  http_response_code(404);
  $key = 'privacy'; // fallback to privacy
}

$pageTitle = $pages[$key]['title'];
$pageDesc  = $pages[$key]['desc'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8'); ?>">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> - Instagram Video Downloader</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="content/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="content/css/landing-page.css">
  <?php echo $config['ga']; ?>
  <?php
    $slugs = [
      'privacy' => 'privacy-policy',
      'terms' => 'terms',
      'disclaimer' => 'disclaimer',
      'dmca' => 'dmca',
      'cookies' => 'cookie-policy',
    ];
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    $scheme = $isHttps ? 'https' : 'http';
    $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $canonicalPath = $baseDir . '/' . $slugs[$key];
    $canonicalUrl = $scheme . '://' . $_SERVER['HTTP_HOST'] . $canonicalPath;
  ?>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
  <style>
    .policy-header { padding: 110px 0 40px; background: linear-gradient(135deg,#4f5bd5,#962fbf,#d62976,#fa7e1e,#feda75); color: #fff; }
    .policy-header .title { font-weight: 700; }
    .policy-card { border-radius: 16px; }
    .policy-card h2 { font-size: 1.4rem; margin-top: 1.25rem; }
    .policy-card p { color: #555; }
    .breadcrumb-compact a { color: #fff; opacity: .9; }
    .breadcrumb-compact a:hover { opacity: 1; text-decoration: underline; }
  </style>
</head>
<body>
  <?php include __DIR__ . '/nav.php'; ?>

  <header class="policy-header text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="breadcrumb-compact mb-2">
            <a href="index.php"><i class="fa fa-home"></i> Home</a> <span class="mx-2">/</span>
            <span><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
          <h1 class="title mb-2"><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
          <p class="mb-0" style="opacity:.95"><?php echo htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      </div>
    </div>
  </header>

  <main class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card policy-card p-4 p-md-5 shadow-sm">
            <?php if ($key === 'privacy'): ?>
              <h2>Introduction</h2>
              <p>We value your privacy. This Privacy Policy describes how information is collected, used, and safeguarded when you use this website (the "Service"). We do not require account creation or login to use the Service.</p>

              <h2>Information We Collect</h2>
              <p>We aim to collect as little information as possible:
              <ul>
                <li>Technical data: IP address, browser type, device information, and pages visited (via standard web server logs and analytics).</li>
                <li>Usage data: Download requests you initiate (URL inputs are processed transiently and not stored beyond what is technically necessary).</li>
              </ul>
              </p>

              <h2>How We Use Information</h2>
              <p>We use information to operate, maintain, and improve the Service, ensure security and prevent abuse, measure performance, and comply with applicable laws.</p>

              <h2>Cookies</h2>
              <p>We may use cookies or similar technologies to enhance functionality and analytics. See our Cookie Policy for details and controls.</p>

              <h2>Data Retention</h2>
              <p>We do not store downloaded media on our servers. Minimal technical logs may be retained for security and diagnostic purposes and are periodically purged.</p>

              <h2>Third-Party Services</h2>
              <p>We may use third-party analytics and performance tools. These providers may set their own cookies and collect information per their privacy policies.</p>

              <h2>Your Choices</h2>
              <p>You can disable cookies via your browser settings. If you are a resident of a jurisdiction with additional rights (e.g., GDPR/CCPA), you may have rights to access or delete certain data. To exercise rights, contact us using the information on this site.</p>

              <h2>Children's Privacy</h2>
              <p>The Service is not directed to children under 13. We do not knowingly collect personal information from children.</p>

              <h2>Changes to This Policy</h2>
              <p>We may update this Privacy Policy from time to time. Updates will be posted on this page with an updated effective date.</p>

              <h2>Contact</h2>
              <p>If you have questions about this Privacy Policy, please reach out via the contact/FAQ section on this site.</p>

            <?php elseif ($key === 'terms'): ?>
              <h2>Acceptance of Terms</h2>
              <p>By accessing or using this website (the "Service"), you agree to these Terms & Conditions. If you do not agree, do not use the Service.</p>

              <h2>Permitted Use</h2>
              <p>The Service enables you to download publicly accessible Instagram content for personal, lawful use only. You must respect copyright and the terms of third-party platforms. You are solely responsible for how you use downloaded content.</p>

              <h2>Prohibited Activities</h2>
              <ul>
                <li>Violating any applicable law or regulation;</li>
                <li>Infringing intellectual property or privacy rights;</li>
                <li>Attempting to reverse engineer, disrupt, or burden the Service;</li>
                <li>Using the Service to collect personal data without consent.</li>
              </ul>

              <h2>Intellectual Property</h2>
              <p>All trademarks, logos, and brand names are the property of their respective owners. This site is not affiliated with or endorsed by Instagram.</p>

              <h2>Disclaimer of Warranties</h2>
              <p>The Service is provided "as is" and "as available" without warranties of any kind, express or implied, including fitness for a particular purpose, non-infringement, and availability.</p>

              <h2>Limitation of Liability</h2>
              <p>To the fullest extent permitted by law, we shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from or related to your use of the Service.</p>

              <h2>Changes to the Service</h2>
              <p>We may modify or discontinue the Service at any time without notice.</p>

              <h2>Governing Law</h2>
              <p>These Terms are governed by applicable local laws. Any disputes shall be resolved in the courts of the applicable jurisdiction.</p>

            <?php elseif ($key === 'disclaimer'): ?>
              <h2>General Information</h2>
              <p>This website provides tools for downloading media from Instagram for convenience and personal use. We do not host or store copyrighted content and do not endorse any unauthorized distribution.</p>

              <h2>No Affiliation</h2>
              <p>We are not affiliated, associated, authorized, endorsed by, or in any way officially connected with Instagram or Meta Platforms, Inc.</p>

              <h2>No Legal Advice</h2>
              <p>Nothing on this site constitutes legal advice. Users are responsible for complying with applicable laws and platform terms.</p>

              <h2>Liability</h2>
              <p>Use the Service at your own risk. We disclaim all liability for misuse of content by users.</p>

            <?php elseif ($key === 'dmca'): ?>
              <h2>Digital Millennium Copyright Act (DMCA) Notice</h2>
              <p>We respect the intellectual property rights of others and comply with the DMCA. If you believe that content accessible via this Service infringes your copyright, you may submit a written notice that includes the following information:</p>
              <ul>
                <li>Your physical or electronic signature;</li>
                <li>Identification of the copyrighted work claimed to have been infringed;</li>
                <li>Identification of the material that is claimed to be infringing, and information reasonably sufficient to permit us to locate the material;</li>
                <li>Your contact information (name, address, telephone number, email);</li>
                <li>A statement that you have a good-faith belief that use of the material is not authorized by the copyright owner, its agent, or the law;</li>
                <li>A statement that the information in the notification is accurate, and under penalty of perjury, that you are authorized to act on behalf of the owner.</li>
              </ul>
              <p>Upon receiving a valid notice, we will investigate and take appropriate action as required by law.</p>

              <h2>Counter-Notification</h2>
              <p>If you believe material was removed or disabled by mistake or misidentification, you may send a counter-notice containing the information required by the DMCA. Upon receiving a valid counter-notice, we may restore the material in accordance with the law.</p>

              <h2>Submission</h2>
              <p>To submit a DMCA notice or counter-notice, please contact us using the contact information provided on this website.</p>

            <?php elseif ($key === 'cookies'): ?>
              <h2>What Are Cookies?</h2>
              <p>Cookies are small text files placed on your device to store data that can be recalled by a web server in the domain that placed the cookie.</p>

              <h2>How We Use Cookies</h2>
              <ul>
                <li>Essential cookies: Required for basic site functionality and security.</li>
                <li>Analytics cookies: Help us understand how visitors interact with the site and improve performance.</li>
              </ul>

              <h2>Managing Cookies</h2>
              <p>You can control and delete cookies via your browser settings. Disabling certain cookies may impact site functionality.</p>

              <h2>Third-Party Cookies</h2>
              <p>Third-party services we use may set their own cookies, governed by their respective policies.</p>

            <?php endif; ?>

            <hr>
            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-light btn-sm mr-2 mb-2" href="policies.php?page=privacy">Privacy Policy</a>
              <a class="btn btn-light btn-sm mr-2 mb-2" href="policies.php?page=terms">Terms & Conditions</a>
              <a class="btn btn-light btn-sm mr-2 mb-2" href="policies.php?page=disclaimer">Disclaimer</a>
              <a class="btn btn-light btn-sm mr-2 mb-2" href="policies.php?page=dmca">DMCA Policy</a>
              <a class="btn btn-light btn-sm mr-2 mb-2" href="policies.php?page=cookies">Cookie Policy</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
