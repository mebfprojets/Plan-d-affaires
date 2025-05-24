<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon.png') }}">
    <title>MEBF - Admin</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('/backend/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{ asset('/backend/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <!-- Select2 CSS -->
    <link href="{{ asset('/backend/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Morries chart CSS -->
    <link href="{{ asset('/backend/assets/plugins/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('/backend/css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('/backend/css/colors/megna.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('/backend/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-sidebar fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('backend.layouts.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('backend.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2017 Admin Press Admin by themedesigner.in
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('/backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('/backend/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('/backend/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('/backend/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('/backend/js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('/backend/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('/backend/js/custom.min.js') }}"></script>

    <!--Validation JavaScript -->
    <script src="{{ asset('/backend/js/validation.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ asset('/backend/assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('/backend/assets/plugins/morrisjs/morris.min.js') }}"></script>
    <!-- sparkline chart -->
    <script src="{{ asset('/backend/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('/backend/js/dashboard4.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <!-- jQuery peity -->
    <script src="{{ asset('/backend/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/plugins/peity/jquery.peity.init.js') }}"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('/backend/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('/backend/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <!-- This is select2 -->
    <script src="{{ asset('/backend/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- This is data table -->
    <script src="{{ asset('/backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('/backend/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/script.js') }}"></script>
    <!-- end - This is for export functionality only -->

    <script>
        window.onload = function() {
            getStat();
        }
        $(document).ready(function() {
            // For select 2
            $(".select2").select2();

            $('#example23').DataTable();

            $('#example22').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // For select 2
            $(".select2").select2();
        });

        ! function(window, document, $) {
            "use strict";

            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(), $(".skin-square input").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green"
            }), $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();
        }(window, document, jQuery);


        function deleteLinge(id_ligne, table_name, titre){
            swal({
                title: "Attention!",
                text: titre,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Non',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui",
                closeOnConfirm: false
            }, function(){
                $.ajax({
                    url: "{{ route('delete.ligne') }}",
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", id_ligne:id_ligne, table_name:table_name
                    },
                    error:function(){swal("Erreur:", "Erreur lors de la suppresion", "error");},
                    success: function () {
                        swal("Félicitations:", "Suppression effectuée avec succès", "success");
                        document.location.reload();
                    }
                });

            });
        }

        // Ajouter une nouvelle ligne d'activité
        function addObjectRow() {
            const table = document.getElementById("objectifs-table");
            const rowCount = table.rows.length + 1;
            const newRow = `
                <tr>
                    <th scope="row">${rowCount}</th>
                    <td><input type="text" name="objectifs_pack[]" class="form-control" placeholder="Objectif"></td>
                </tr>`;
            table.insertAdjacentHTML("beforeend", newRow);
        }

        // GET PA
        function getPA(id_plan_affaire){
            $.ajax({
                url: "{{ route('pa.get') }}",
                type: 'GET',
                data: {id_plan_affaire:id_plan_affaire},
                error:function(){alert("Erreur");},
                success: function (response) {
                    $("#id_plan_affaire").val(response.id_plan_affaire);
                    $("#imput-title").text(response.pack);
                    $("#imput-idea").text(response.business_idea);
                    $("#imput-object").text(response.business_object);
                }
            });
        }

        function saveImputation(){
            const id_plan_affaire = $("#id_plan_affaire").val();
            const id_conseiller = $("#id_conseiller").val();
            const date_imput = $("#date_imput").val();
            $.ajax({
                url: "{{ route('imput.save') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", id_plan_affaire:id_plan_affaire, id_conseiller:id_conseiller, date_imput:date_imput
                },
                error:function(){swal("Erreur:", "Erreur lors de la suppresion", "error");},
                success: function () {
                    document.location.reload();
                }
            });
        }

        function getStat(){
            var url_stat = "{{ route('data.stat') }}";
            $.ajax({
                    url: url_stat,
                    type: 'GET',
                    dataType: 'json',
                    error:function(data){
                        //alert("Erreur");
                    },
                    success: function (data) {

                        //Statistiques globales
                        $("#total_prom").text(data.data.total_prom.toLocaleString('fr-FR'));
                        $("#total_en").text(data.data.total_en.toLocaleString('fr-FR'));
                        $("#total_pa").text(data.data.total_pa.toLocaleString('fr-FR'));
                        $("#total_pay").text(data.data.total_pay.toLocaleString('fr-FR') + " FCFA");

                        //Statistiques status
                        $("#total_ins").text(data.data.total_pa.toLocaleString('fr-FR'));
                        $("#nombre_np").text(data.data.nombre_np.toLocaleString('fr-FR'));
                        $("#nombre_val").text(data.data.nombre_val.toLocaleString('fr-FR'));

                    }
            });

        }

    </script>
</body>

</html>
