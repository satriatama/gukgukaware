<?php
session_start();
include '../login/config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

if (isset($_SESSION['error'])) {
    echo($_SESSION['error']);
}
// Query untuk mendapatkan data
$sql = "SELECT * FROM location";
$result = $pdo->query($sql);
$stmt = $pdo->query($sql);
$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <h1>All Data</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="all-data.html">Home</a></li>
          <li class="breadcrumb-item active">All Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">All Data List</h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Store Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Last Changed</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)) : ?>
                        <?php foreach ($result as $index => $row) : ?>
                            <tr>
                                <th onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo $index + 1; ?></th>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo htmlspecialchars($row['store_name']); ?></td>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo htmlspecialchars($row['location']); ?></td>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;">
                                    <?php if ($row['status'] == 'Opened') : ?>
                                    <span class='badge bg-success'>Opened</span>
                                    <?php elseif ($row['status'] == 'Closed') : ?>
                                    <span class='badge bg-danger'>Closed</span>
                                    <?php else : ?>
                                    <span class='badge bg-warning'>New Location</span>
                                    <?php endif; ?>
                                </td>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo htmlspecialchars($row['latitude']); ?></td>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo htmlspecialchars($row['longitude']); ?></td>
                                <td onclick="window.location.href='../home/detail.php?Id=<?php echo $row['Id']; ?>'" style="cursor: pointer;"><?php echo htmlspecialchars($row['last_changed']); ?></td>
                                <td>
                                    <div>
                                    <button type="button" class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?php echo $row['Id']; ?>"
                                        data-store-name="<?php echo $row['store_name']; ?>" 
                                        data-location="<?php echo $row['location']; ?>"
                                        data-status="<?php echo $row['status']; ?>"
                                        data-latitude="<?php echo $row['latitude']; ?>"
                                        data-longitude="<?php echo $row['longitude']; ?>">
                                        Edit
                                    <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                        data-id="<?php echo $row['Id']; ?>">
                                        Delete
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="8">No data available</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->
    </section>
 <!-- Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Store Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" action="edit-data.php" method="POST">
            <input type="hidden" id="storeId" name="id">
            <div class="mb-3">
              <label for="storeName" class="form-label">Store Name</label>
              <input
                type="text"
                class="form-control"
                id="storeName"
                name="store_name">
            </div>
            <div class="mb-3">
              <label for="location" class="form-label">Location</label>
              <input type="text" class="form-control" id="location" name="location">
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="Opened">Opened</option>
                <option value="Closed">Closed</option>
                <option value="New Location">New Location</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" class="form-control" id="latitude" name="latitude">
            </div>
            <div class="mb-3">
              <label for="longitude" class="form-label">Longitude</label>
              <input type="text" class="form-control" id="longitude" name="longitude">
            </div>
            <?php
                // Cek apakah ada pesan error di session
                if (isset($_SESSION['error'])) {
                    echo "<div class='error text-red-500'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                }
            ?>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Store Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this store location?
        </div>
        <div class="modal-footer">
          <form id="deleteForm" action="delete-data.php" method="POST">
            <input hidden id="deleteId" name="id">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>
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
  <!-- Create Script For Modal -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const editButtons = document.querySelectorAll('.edit-btn');
      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          const modal = document.getElementById('editModal');
          const storeId = this.getAttribute('data-id');
          const storeName = this.getAttribute('data-store-name');
          const location = this.getAttribute('data-location');
          const status = this.getAttribute('data-status');
          const latitude = this.getAttribute('data-latitude');
          const longitude = this.getAttribute('data-longitude');

          // Populate modal form with data
          modal.querySelector('#storeId').value = storeId;
          modal.querySelector('#storeName').value = storeName;
          modal.querySelector('#location').value = location;
          modal.querySelector('#status').value = status;
          modal.querySelector('#latitude').value = latitude;
          modal.querySelector('#longitude').value = longitude;
        });
      });
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const deleteButtons = document.querySelectorAll('.delete-btn');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
          const modal = document.getElementById('deleteModal');
          const storeId = this.getAttribute('data-id');
          console.log(storeId);

          // Populate modal form with data
          modal.querySelector('#deleteId').value = storeId;
        });
      });
    });
  </script>

  

</body>

</html>