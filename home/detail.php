<?php
session_start();
$id = $_GET['Id'];
include_once "../login/config.php";

$sql = "SELECT * FROM location WHERE Id = $id ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch();
$dogStore = $row['store_name'];
$lat = $row['latitude'];
$long = $row['longitude'];
$title = "Detail dan Lokasi : " . $dogStore;
?>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>

<script>
  function initialize() {
    var myLatlng = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
    var mapOptions = {
      zoom: 13,
      center: myLatlng
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var contentString = '<div id="content">' +
      '<div id="siteNotice">' +
      '</div>' +
      '<h1 id="firstHeading" class="firstHeading"><?php echo $dogStore ?></h1>' +
      '<div id="bodyContent">' +
      '<p><?php echo $dogStore ?></p>' +
      '</div>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });

    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Maps Info',
      icon: '../assets/img/markermap.png'
    });
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>

  <title>Detail</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <style>
		body {
			margin: 0;
			padding: 0;
		}

		#map {
			width: 100%;
			height: 480px;
		}
	</style>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
	<script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Guguk Aware</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block ps-2">
                <?php echo htmlspecialchars($_SESSION['firstname']); ?>
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>
                <?php echo htmlspecialchars($_SESSION['firstname']); ?>
              </h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../login/logout_action.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Detail Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Action</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="all-data.php">
              <i class="bi bi-circle"></i><span>Display All Data</span>
            </a>
          </li>
          <li>
            <a href="add-data.php">
              <i class="bi bi-circle"></i><span>Add Data</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Detail</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="Detail.html">Home</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section Detail">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4><?php echo $dogStore; ?></h4>
              <div id="map"></div>
              <script>
              mapboxgl.accessToken = 'pk.eyJ1Ijoic2F0cmlhdGFtYSIsImEiOiJjbTVqZHFsNWcwNXV6Mmpxb3pnamNzaWY2In0.ylMzK18K0t4JCjn3AH8U7A';

              const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [<?php echo (float)$long; ?>, <?php echo (float)$lat; ?>],
                zoom: 13
              });
              const destination = [<?php echo (float)$long; ?>, <?php echo (float)$lat; ?>]; // Titik B yang sudah ditentukan

              // Get user's current location and calculate route
              if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                  const userLocation = [position.coords.longitude, position.coords.latitude]; // Lokasi saat ini

                  // Call the API to get route
                  getRoute(userLocation, destination);

                  // Optionally zoom the map to the user's location

                  map.flyTo({
                    center: userLocation,
                    zoom: 11
                  });
                });
              } else {
                alert("Geolocation is not supported by this browser.");
              }

              // Function to get the route from point A to point B
              async function getRoute(start, end) {
                const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=pk.eyJ1Ijoic2F0cmlhdGFtYSIsImEiOiJjbTF3Zmh6ZmwwbWx3MmtwZjQ5b25waTV5In0.2WgL12lJPTY2nbcYPP-49g`;
                const response = await fetch(url);
                console.log(response);
                const data = await response.json();
                const route = data.routes[0].geometry.coordinates;

                // Add the route as a new layer to the map
                map.addLayer({
                  id: 'route',
                  type: 'line',
                  source: {
                    type: 'geojson',
                    data: {
                      type: 'Feature',
                      properties: {},
                      geometry: {
                        type: 'LineString',
                        coordinates: route
                      }
                    }
                  },
                  layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                  },
                  paint: {
                    'line-color': '#1DB954',
                    'line-width': 5
                  }
                });

                // Add markers for start and end points
                addMarkers(start, end);
              }

              // Function to add markers for the start and end points
              function addMarkers(start, end) {
                // Add start point marker (User's current location)
                new mapboxgl.Marker({
                    color: 'blue'
                  })
                  .setLngLat(start)
                  .addTo(map);

                // Add end point marker (Destination)
                new mapboxgl.Marker({
                    color: 'red'
                  })
                  .setLngLat(end)
                  .addTo(map)
                  .setPopup(popup);
              }

              const popup = new mapboxgl.Popup({
                offset: 25
              }).setText(
                'Pasar Ir Soekarno Sukoharjo. Jl. Ir. Soekarno, Sukoharjo, Kabupaten Sukoharjo, Jawa Tengah 57511'
              );
            </script>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Pipit</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->
  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  

</body>

</html>