
  <!-- General JS Scripts -->
  <script src="{{ asset('/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/js/bootstrap-datepicker.min.js"></script> --}}


  <!-- Template JS File -->
  <script src="{{ asset('/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('/assets/js/custom.js') }}"></script>


<script type="text/javascript">
    $("#datemonth").datepicker( {
    format: "mm-yyyy",
    startView: "months",
    minViewMode: "months"
    });

    // function rangeDate() {
        $("#start_leave").datepicker( {
            changeYear: true,
            changeMonth: true,
            setDate: new Date(),
            startDate:'+1d',
            format: "dd-mm-yyyy",
        });
        $("#end_leave").datepicker( {
            setDate: new Date(),
            dateFormat: "dd-mm-yyyy",
            minDate: '0',
        });
    // }
</script>

