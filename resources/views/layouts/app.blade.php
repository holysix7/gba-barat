<!DOCTYPE html>
<html lang="en">
<style>
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@yield('style')
@include('layouts.includes.header')

<body class="hold-transition sidebar-mini layout-fixed accent-primary">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ url('images/logo.jpeg') }}" alt="JMTOLogo" height="60" width="60">
    </div>
    <!-- Navbar -->
    @include('layouts.includes.navbar')
    <!-- /.navbar -->

    @include('layouts.includes.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="pt-2 px-2" id="flash-message">
        @include('layouts.flash-message')
      </div>

      {{-- <div class="container pt-2"> --}}
      <div id="overlay">
        <div class="cv-spinner">
          <span class="spinner"></span>
        </div>
      </div>
      @yield('content')
      {{-- </div> --}}
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.includes.footer')
    <!-- /.control-sidebar -->
  </div>

  <script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
  {{-- <script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script> --}}
  <script src="{{ url('jquery.mask.min.js') }}"></script>

  <script src="{{ url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/sparklines/sparkline.js') }}"></script>
  <script src="{{ url('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <script src="{{ url('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ url('adminlte/dist/js/adminlte.js') }}"></script>
  {{-- <script src="{{ url('adminlte/dist/js/demo.js') }}"></script>
  <script src="{{ url('adminlte/dist/js/pages/dashboard.js') }}"></script> --}}
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> --}}
  <link rel="stylesheet" href="{{ url('bootstrap-icons.css') }}">
  <script src="{{ url('app.js') }} "></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $( '.uangMasking' ).mask('0.000.000.000.000.000.000.000', {reverse: true});
      $('.number-only').on('keypress', function(evt){
        if(evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57){
          evt.preventDefault()
        }
      })
      $(".currency-format").on('keyup', function(){
        formatNumber($(this).val())
      })
    })
    function formatNumber(s) {
      var parts   = s.split(/,/)
      var spaced  = parts[0]
      .split('').reverse().join('')
      .match(/\d{1,3}/g).join(' ')
      .split('').reverse().join('')
      return spaced + (parts[1] ? ','+parts[1] : '')
    }

    function maskingInput(){
      $( '.uangMasking' ).mask('0.000.000.000.000.000.000.000', {reverse: true});
    }

    function validateSymbol(){
      $('.number-only-keydown').on("keydown", function(e) {
        var invalidChars = [
          "-",
          "+",
          "e",
        ]
        if (invalidChars.includes(e.key)) {
          e.preventDefault();
        }
      })
    }
  </script>
  
  <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
  <script src="{{ url('js/utils.js') }} "></script>
  @yield('script')
  @stack('script')

</body>

</html>