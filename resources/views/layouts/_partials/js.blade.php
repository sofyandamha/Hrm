
  <!-- General JS Scripts -->
  <script src="{{ asset('/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
  <script src="{{ asset('/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('/assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('/assets/js/page/forms-advanced-forms.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('/assets/js/custom.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('/assets/modules/dropzonejs/min/dropzone.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('/assets/js/page/components-multiple-upload.js') }}"></script>

{{-- <script>
    $('#exampleModal').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget)
          var price = button.data('mytitle')
          var idtrans = button.data('idtrans')
          var itemname = button.data('itemname')

          var modal = $(this)
          modal.find('.modal-body #priceku').val(price)
          modal.find('.modal-body #idtrans').val(idtrans)
          modal.find('.modal-body #exampleModalLabel').val(itemname)
      })
</script> --}}
<script type="text/javascript">
    $("#datemonth").datepicker( {
    format: "mm-yyyy",
    startView: "months",
    minViewMode: "months"
});
</script>

