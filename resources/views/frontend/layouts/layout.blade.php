<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MEBF-PLAN D'AFFAIRE</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('/favicon.png') }}" rel="icon">
  <link href="{{ asset('/frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('/frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('/frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('/frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('/frontend/assets/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Sailor
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  @include('frontend.layouts.header')

  <main class="main">

    @yield('content')

  </main>

  @include('frontend.layouts.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="{{ asset('/frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('/frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('/frontend/assets/js/main.js') }}"></script>
  <script src="{{ asset('/script.js') }}"></script>
  <script>



    // Sauvegarder les activités dans localStorage
    /*function saveActivities() {
        const rows = Array.from(document.querySelectorAll("#activities-table tr"));
        const activities = rows.map(row => {
            const etape = row.querySelector('input[name="etapes_activites[]"]').value;
            const date = row.querySelector('input[name="dates_indicatives[]"]').value;
            return { etape, date };
        });
        localStorage.setItem("activities", JSON.stringify(activities));
    }*/

    // Charger les activités depuis localStorage
    /*function loadActivities() {
        const table = document.getElementById("activities-table");
        const activities = JSON.parse(localStorage.getItem("activities")) || [];
        activities.forEach((activity, index) => {
            const newRow = `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité" value="${activity.etape}" ></td>
                    <td><input type="date" name="dates_indicatives[]" class="form-control" value="${activity.date}" placeholder="jj/mm/aaaa"></td>
                </tr>`;
            table.insertAdjacentHTML("beforeend", newRow);
        });
    }*/
  </script>

</body>

</html>
