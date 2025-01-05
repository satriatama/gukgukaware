<?php
session_start();
include '../login/config.php';

// Cek apakah user sudah login
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../login/index.php");
//     exit();
// }

$sqlTotal = "SELECT COUNT(*) as total FROM location WHERE status = 'Opened' or status = 'New Location'";
$sqlIncrease = "SELECT COUNT(*) as increase FROM location WHERE status = 'Opened' or status = 'New Location' AND last_changed >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";

$totalResult = $pdo->query($sqlTotal)->fetch(PDO::FETCH_ASSOC);
$increaseResult = $pdo->query($sqlIncrease)->fetch(PDO::FETCH_ASSOC);

$total = $totalResult['total'];
$increase = $increaseResult['increase'];

// Hitung persentase peningkatan
$percentageIncrease = ($total > 0) ? ($increase / $total) * 100 : 0;


// Query untuk Closed Location
$sqlClosedTotal = "SELECT COUNT(*) as total FROM location WHERE status = 'Closed'";
$sqlClosedThisMonth = "SELECT COUNT(*) as increase FROM location WHERE status = 'Closed' AND last_changed >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$closedTotalResult = $pdo->query($sqlClosedTotal)->fetch(PDO::FETCH_ASSOC);
$closedThisMonthResult = $pdo->query($sqlClosedThisMonth)->fetch(PDO::FETCH_ASSOC);

$closedTotal = $closedTotalResult['total'];
$closedIncrease = $closedThisMonthResult['increase'];
$closedPercentageIncrease = ($closedTotal > 0) ? ($closedIncrease / $closedTotal) * 100 : 0;

// Query untuk All Location
$sqlAllTotal = "SELECT COUNT(*) as total FROM location";
$sqlAllThisYear = "SELECT COUNT(*) as increase FROM location WHERE last_changed >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
$allTotalResult = $pdo->query($sqlAllTotal)->fetch(PDO::FETCH_ASSOC);
$allThisYearResult = $pdo->query($sqlAllThisYear)->fetch(PDO::FETCH_ASSOC);

$allTotal = $allTotalResult['total'];
$allIncrease = $allThisYearResult['increase'];
$allPercentageIncrease = ($allTotal > 0) ? ($allIncrease / $allTotal) * 100 : 0;


// Query untuk Recent Activity hari ini
$sqlRecentActivity = "SELECT *, TIMESTAMPDIFF(MINUTE, last_changed, NOW()) AS minutes_diff 
                      FROM location 
                      ORDER BY last_changed DESC LIMIT 4";
$recentActivityResult = $pdo->query($sqlRecentActivity)->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT Id, latitude, longitude FROM location";
$stmt = $pdo->query($query);
$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
$features = [];
foreach ($result as $index => $row){
    $feature = [
        'type' => 'Feature',
        'geometry' => [
            'type' => 'Point',
            'coordinates' => [
                $row['longitude'],
                $row['latitude']
            ]
        ],
        'properties' => [
            'url' => 'detail.php?Id=' . $row['Id']

        ]
    ];
    $features[] = $feature;
}
// Susun GeoJSON
$geojson = [
    'type' => 'FeatureCollection',
    'features' => $features
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
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
      <a href="dashboard.php" class="logo d-flex align-items-center">
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
      </li><!-- End Dashboard Nav -->

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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Active Location <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="ps-3">
						<h6><?php echo $total; ?></h6>
						<span class="text-success small pt-1 fw-bold"><?php echo number_format($percentageIncrease, 2); ?>%</span>
						<span class="text-muted small pt-2 ps-1">increase</span>
					</div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

			  <div class="card-body">
				<h5 class="card-title">Closed Location <span>| This Month</span></h5>
				<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #f8d7da;">
							<i class="bi bi-graph-down text-danger"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $closedTotal; ?></h6>
							<span class="text-danger small pt-1 fw-bold"><?php echo number_format($closedPercentageIncrease, 2); ?>%</span>
							<span class="text-muted small pt-2 ps-1">increase</span>
						</div>
					</div>
				</div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

			  <div class="card-body">
					<h5 class="card-title">All Location <span>| This Year</span></h5>
					<div class="d-flex align-items-center">
						<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
							<i class="bi bi-people"></i>
						</div>
						<div class="ps-3">
							<h6><?php echo $allTotal; ?></h6>
							<span class="text-danger small pt-1 fw-bold"><?php echo number_format($allPercentageIncrease, 2); ?>%</span>
						</div>
					</div>
				</div>

              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
			<h5 class="card-title">Recent Activity <span>| Today</span></h5>

			<div class="activity">
				<?php foreach ($recentActivityResult as $activity): ?>
					<?php
					// Hitung waktu aktivitas dalam format human-readable
					$minutes_diff = $activity['minutes_diff'];
					if ($minutes_diff < 60) {
						$time_label = "{$minutes_diff} min";
					} elseif ($minutes_diff < 1440) {
						$hours_diff = floor($minutes_diff / 60);
						$time_label = "{$hours_diff} hrs";
					} else {
						$days_diff = floor($minutes_diff / 1440);
						$time_label = "{$days_diff} days";
					}

					// Tentukan warna badge berdasarkan status
					$badge_class = match (strtolower($activity['status'])) {
						'new location' => 'text-success',
						'closed' => 'text-danger',
						'opened' => 'text-primary',
						default => 'text-secondary',
					};
					?>
					<div class="activity-item d-flex">
						<div class="activite-label"><?= $time_label ?></div>
						<i class='bi bi-circle-fill activity-badge <?= $badge_class ?> align-self-start'></i>
						<div class="activity-content">
							<a href="#" class="fw-bold text-dark"><?= htmlspecialchars($activity['status']) ?></a>
							<?= htmlspecialchars($activity['store_name']) ?> | <?= htmlspecialchars($activity['location']) ?>
						</div>
					</div><!-- End activity item -->
				<?php endforeach; ?>
			</div>
		</div>
          </div><!-- End Recent Activity -->
          </div><!-- End Website Traffic -->

        </div><!-- End Right side columns -->
        
         
        <div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Maps All Location <span>/Today</span></h5>
                  <!-- Implement Mapbox -->
                    <div id="map"></div>
                </div>

              </div>
            </div><!-- End Reports -->

      </div>
    </section>

  </main><!-- End #main -->
  
  <script>
			mapboxgl.accessToken = 'pk.eyJ1Ijoic2F0cmlhdGFtYSIsImEiOiJjbTVqZHFsNWcwNXV6Mmpxb3pnamNzaWY2In0.ylMzK18K0t4JCjn3AH8U7A';
			const map = new mapboxgl.Map({
				container: 'map',
				style: 'mapbox://styles/mapbox/outdoors-v12',
				center: [110.82298043772305, -7.5527405771247205],
				zoom: 12
			});

			map.on('load', () => {
			map.addSource('national-park', {
				'type': 'geojson',
				'data': <?php echo json_encode($geojson); ?>
			});

			map.addLayer({
				'id': 'park-boundary',
				'type': 'fill',
				'source': 'national-park',
				'paint': {
					'fill-color': '#888888',
					'fill-opacity': 0.4
				},
				'filter': ['==', '$type', 'Polygon']
			});

			map.addLayer({
				'id': 'park-volcanoes',
				'type': 'circle',
				'source': 'national-park',
				'paint': {
					'circle-radius': 6,
					'circle-color': '#B42222'
				},
				'filter': ['==', '$type', 'Point']
			});

			map.on('click', 'park-volcanoes', (e) => {
				const url = e.features[0].properties.url;
				window.location.href = url;
			});

			map.on('mouseenter', 'park-volcanoes', () => {
				map.getCanvas().style.cursor = 'pointer';
			});
			map.on('mouseleave', 'park-volcanoes', () => {
				map.getCanvas().style.cursor = '';
			});
		});
		</script>

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