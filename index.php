<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $config['description']; ?>">
  <meta name="author" content="">
  <title>Instagram Video Downloader</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link href="content/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Site Styles -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="content/css/landing-page.css"><!-- keep legacy styles to avoid breaking -->
  <?php echo $config["ga"]; ?>
  <script>
    // Smooth-scroll to section if ?section= is present (mapped from pretty URLs)
    document.addEventListener('DOMContentLoaded', function () {
      try {
        var params = new URLSearchParams(window.location.search);
        var section = params.get('section');
        if (section) {
          var el = document.getElementById(section);
          if (el) {
            // Delay to allow layout and fixed nav offset
            setTimeout(function(){ el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 300);
          }
        }
      } catch (e) {}
    });
  </script>
</head>



<style>
  /* Form Container */
  .download-form {
    display: flex;
    justify-content: center;
    margin: 20px auto;
    max-width: 700px;
    width: 100%;
  }

  /* Group wrapper */
  .form-group {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 10px;
  }

  /* Input Wrapper (icon + field) */
  .input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 10px;
    padding: 0 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid black 

  }

  .input-wrapper i {
    color: #aaa;
    font-size: 16px;
    margin-right: 8px;
  }

  /* Input Field */
  .form-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 14px 10px;
    font-size: 15px;
    border-radius: 10px;
  }

  /* Gradient Button */
  .form-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(45deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5);
    border: none;
    border-radius: 10px;
    padding: 14px 22px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    background-size: 200% 200%;
    animation: gradientShift 6s ease infinite;
    box-shadow: 0px 6px 18px rgba(214, 41, 118, 0.4);
  }

  .form-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0px 8px 22px rgba(214, 41, 118, 0.6);
  }

  .form-btn i {
    font-size: 16px;
  }

  /* Animated Gradient Shift */
  @keyframes gradientShift {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }





  /* Center & Card Styling */



  /* Image Styling */
  .col-md-8 .image {
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 18px;
  }

  .col-md-8 .image img {
    width: 80%;
    height: auto !important;
    object-fit: cover;
    border-radius: 12px;
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.4s ease;
  }

  .col-md-8 .image img:hover {
    transform: scale(1.05);
  }

  /* Download Button */
  .col-md-8 .btn-red {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(45deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5);
    color: #fff !important;
    font-weight: 600;
    font-size: 15px;
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0px 6px 18px rgba(214, 41, 118, 0.4);
    background-size: 200% 200%;
    animation: gradientShift 6s ease infinite;
    transition: all 0.3s ease;
  }

  .col-md-8 .btn-red:hover {
    transform: translateY(-2px);
    box-shadow: 0px 10px 25px rgba(214, 41, 118, 0.6);
  }

  .col-md-8 .btn-red i {
    font-size: 16px;
  }

  /* Gradient Animation */
  @keyframes gradientShift {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }
  
  
   /* Responsive styles */
  @media (max-width: 768px) {
    .form-group {
      flex-direction: column;
    }

    .form-btn, .input-wrapper {
      width: 100%;
      justify-content: center;
    }
  }
</style>




<body>
  <?php include 'nav.php'; ?>
  <?php include 'body.php'; ?>
  <?php include 'footer.php'; ?>

  <!-- Core tool script (must stay) -->
  <script src="content/js/ajax.js"></script>
</body>

</html>
