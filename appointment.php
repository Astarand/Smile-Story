<!DOCTYPE html>
<html lang="zxx">

<head>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Page Title -->
  <title>Book an Appointment - Smile Story Dental Care | Dentist in Kolkata</title>
  <!-- Meta Description -->
  <meta name="description" content="Schedule your dental appointment at Smile Story Dental Care in Kolkata. Book now for expert dental care, personalized treatments, and a healthier smile.">
  <!-- Meta Keywords -->
  <meta name="keywords" content="Book dentist appointment Kolkata, Smile Story Dental Care appointment, dental care Kolkata, schedule dental visit, expert dentist Kolkata, dentist near me, book dental treatment">
  <!-- Meta Author -->
  <meta name="author" content="Smile Story">
  <!-- Canonical Link -->
  <link rel="canonical" href="https://smilestory.online/appointment.php">
  <!-- Common Links -->
  <?php include('includes/common-link.php'); ?>
  <script src="https://www.google.com/recaptcha/api.js?render=6LePvakqAAAAAKaJGhKU2W3KkaJBXUQamdXKLTzg"></script>
</head>

<body>
  <?php include('includes/header.php'); ?>

  <!-- Page Header Start -->
  <div class="page-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <!-- Page Header Box Start -->
          <div class="page-header-box">
            <h1 class="text-anime-style-3" data-cursor="-opaque">Appointment</h1>
            <nav class="wow fadeInUp">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">home</a></li>
                <li class="breadcrumb-item active" aria-current="page">appointment</li>
              </ol>
            </nav>
          </div>
          <!-- Page Header Box End -->
        </div>
      </div>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Page Book Appointment Section Start -->
  <div class="page-book-appointment">
    <div class="container">
      <div class="row section-row align-items-center">
        <div class="col-lg-12">
          <!-- Section Title Start -->
          <div class="section-title">
            <h3 class="wow fadeInUp">Book Your Appointment</h3>
            <h2 class="text-anime-style-3" data-cursor="-opaque">Book your dental visit online with primecare</h2>
          </div>
          <!-- Section Title End -->
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <!-- Appointment Form Start -->
          <div class="appointment-form wow fadeInUp">
            <div class="appointment-form-content">
              <p>Fill out the form below to request your dental appointment. We'll confirm your time and send you a reminder.</p>
            </div>
            <!-- Form Start -->
            <form action="appointment-submit.php" method="POST">
              <div class="row">
                <div class="form-group col-lg-4 col-md-6 mb-4">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Your Name*" required>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group col-lg-4 col-md-6 mb-4">
                  <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email*" required>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group col-lg-4 col-md-6 mb-4">
                  <input type="number" name="location" class="form-control" id="location" placeholder="Enter Contact Number*" required>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group col-lg-4 col-md-6 mb-4">
                  <input type="date" name="date" class="form-control" id="date" required>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group col-lg-4 col-md-6 mb-4">
                  <select class="form-select form-control" name="reasonSelect" id="reasonSelect" aria-label="Reason">
                    <option value="" selected>Select</option>
                    <option value="1">Routine Checkup</option>
                    <option value="2">New Patient Visit</option>
                    <option value="3">Other Specific Reason</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-lg-4 col-md-6 mb-4" id="otherInput" style="display:none;">
                  <input type="text" name="otherReason" class="form-control" id="otherReason" placeholder="Specific Reason*">
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-12">
                  <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                </div>
                <div class="col-md-12">
                  <button type="submit" class="btn-default">book appointment</button>
                  <div id="msgSubmit" class="h3 hidden"></div>
                </div>
              </div>
            </form>
            <!-- Form End -->
          </div>
          <!-- Appointment Form End -->
        </div>
      </div>
    </div>
  </div>
  <!-- Book Appointment Section End -->


  <?php include('includes/footer.php'); ?>
<script>
  document.getElementById('reasonSelect').addEventListener('change', function() {
    var otherInput = document.getElementById('otherInput');
    if (this.value === "3") {
      otherInput.style.display = "block";
    } else {
      otherInput.style.display = "none";
    }
  });
</script>
  <script>
    grecaptcha.ready(function () {
      grecaptcha.execute('6LePvakqAAAAAKaJGhKU2W3KkaJBXUQamdXKLTzg', { action: 'submit' }).then(function (token) {
        document.getElementById('g-recaptcha-response').value = token;
      });
    });
  </script>
</body>

</html>