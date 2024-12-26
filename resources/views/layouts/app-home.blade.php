<!DOCTYPE html>
<html lang="en">

@include('layouts.app-heading')

<body>
  {{-- @include('layouts.app-header') --}}
  <!-- ======= Hero Section ======= -->
  <section class="d-flex align-items-center">
    <div class="container">
        
      <div class="row">
        <div class="col-lg-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Lorem Ipsum</h1>
          <h2>Lorem ipsum dolor sit amet.</h2>
          <div class="d-flex justify-content-between">
            <a href="/login" class="btn btn-primary rounded text-info" style="color: white!important; width: 50%!important;">login</a>
          </div>
        </div>
        <div class="col-lg-7 order-1 order-lg-2 hero-img rounded" style="text-align: center; margin-top: 10vh; background-color: transparant; height: 450px; justify-content: center;" data-aos="zoom-in" data-aos-delay="200">
          <div class="row" style="height: 100%; justify-content: flex-end; align-items: flex-end;">
            <img src="{{ asset('images/IllustrationHome.png') }}" alt="JasaMargaLogo" class="img-fluid animated" style="float: none; width: 800px; height: 340px;">
          </div>
        </div>
      </div>
    </div>
  </section>

  <main id="main">

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients section-bg">
      <div class="container">

        <div class="row" data-aos="zoom-in">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-1.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-2.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-3.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-4.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-5.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('arsha/img/clients/client-6.png') }}" class="img-fluid" alt="">
          </div>

        </div>

      </div>
    </section><!-- End Cliens Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>About Us</h2>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
              <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit</li>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <a href="#" class="btn-learn-more">Learn More</a>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->
  </main>

  <!-- ======= Footer ======= -->
  {{-- <footer id="footer">
    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>PT. Reka Cipta Solusi</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>
  </footer><!-- End Footer --> --}}

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('arsha/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('arsha/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('arsha/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('arsha/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('arsha/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('arsha/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('arsha/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('arsha/js/main.js') }}"></script>

</body>

</html>