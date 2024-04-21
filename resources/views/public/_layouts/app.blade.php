<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/jqvmap/jqvmap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/summernote/summernote-bs4.min.css') }}" />
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.css') }}" />

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" />
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}" />
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/bs-stepper/css/bs-stepper.min.css') }}" />
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/plugins/dropzone/min/dropzone.min.css') }}" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/AdminLTE/dist/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60" />
        </div> --}}

        <!-- Navbar -->
        @include('public/_components/navbar')

        <!-- Main Sidebar Container -->
        @include('public/_components/sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('public/_components/footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/AdminLTE/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('assets/AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ asset('assets/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <!-- Filterizr-->
    <script src="{{ asset('assets/AdminLTE/plugins/filterizr/jquery.filterizr.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/AdminLTE/dist/js/adminlte.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('assets/AdminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('assets/AdminLTE/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/AdminLTE/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('assets/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('assets/AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('assets/AdminLTE/plugins/dropzone/min/dropzone.min.js') }}"></script>

    <script>
        $(function() {
            $(document).on("click", '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true,
                });
            });

            $(".filter-container").filterizr({
                gutterPixels: 3
            });
            $(".btn[data-filter]").on("click", function() {
                $(".btn[data-filter]").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
</body>

</html>
