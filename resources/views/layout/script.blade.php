<!-- Bootstrap core JavaScript-->
<script src="{{ asset('templates/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
{{-- <script src="{{ asset('templates/vendor/jquery-easing/jquery.easing.min.js') }}"></script> --}}

<!-- Custom scripts for all pages-->
<script src="{{ asset('templates/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('templates/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('templates/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('templates/js/demo/datatables-demo.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>

{{-- CDN Sweet Alert --}}

<!-- Styles -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" /> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<!-- Scripts -->
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
{{-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> --}}



<script>
    // $(document).ready(function() {
    //     $('.trainset').select2({
    //         theme: "bootstrap-5",
    //         dropdownParent: $('#modaltambah'),
    //         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //             'style'
    //     });

    //     <?php if (isset($iklan_trainset)) { ?>
    //     $('.trainset_select').select2({
    //         theme: "bootstrap-5",
    //         dropdownParent: $('#modaltambah'),
    //         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //             'style'
    //     });
    //     <?php } ?>

    //     // <?php if (isset($iklan_kereta)) { ?>
    //     // $('.kereta_select').select2({
    //     //     theme: "bootstrap-5",
    //     //     placeholder: "Pilih Kereta",
    //     //     allowClear: true,
    //     //     dropdownParent: $('#modaltambah'),
    //     //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //     //         'style'
    //     // });
    //     // <?php } ?>

    //     <?php if (isset($lokasi)) { ?>
    //     $('.lokasi').select2({
    //         theme: "bootstrap-5",
    //         dropdownParent: $('#modaltambah'),
    //         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //             'style'
    //     });
    //     <?php } ?>

    //     $(".kereta_select").select2({
    //         theme: "bootstrap-5",
    //         dropdownParent: $('#modaltambah'),
    //         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //             'style'
    //     });
    //     // $("#titik").select2({
    //     //     theme: "bootstrap-5",
    //     //     dropdownParent: $('#modaltambah'),
    //     //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
    //     //         'style'
    //     // });

    // });

    // <?php if (isset($kereta)) { ?>
    // @foreach ($kereta as $item)
    //     $(document).ready(function() {
    //         $('.trainset' + {{ $item->id_kereta }}).select2({
    //             theme: "bootstrap-5",
    //             dropdownParent: $('#modaledit' + {{ $item->id_kereta }}),
    //             width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
    //                 '100%' : 'style'
    //         });
    //     });
    // @endforeach
    // <?php } ?>

    // //lokasi
    // <?php if (isset($lokasi)) { ?>
    // @foreach ($lokasi as $item)
    //     $(document).ready(function() {
    //         $('.lokasi' + {{ $item->id_lokasi }}).select2({
    //             theme: "bootstrap-5",
    //             dropdownParent: $('#modaledit' + {{ $item->id_lokasi }}),
    //             width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
    //                 '100%' : 'style'
    //         });
    //     });
    // @endforeach
    // <?php } ?>
    // <?php if (isset($iklan)) { ?>
    // @foreach ($iklan as $item)
    //     $(document).ready(function() {
    //         $('.select2searchEdit' + {{ $item->id_iklan }}).select2({
    //             theme: "bootstrap-5",
    //             dropdownParent: $('#modaledit' + {{ $item->id_iklan }}),
    //             width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
    //                 '100%' : 'style'
    //         });
    //     });
    // @endforeach
    // <?php } ?>
</script>