<?php
require '../../vendor/autoload.php';
session_start();
if(!isset($_SESSION['access'])){
  header('Location: /admin/login.php');
  exit;
}

require '../auth/db.php';
require __DIR__ . '/query.php';
require __DIR__ . '/escape.php';
$id = $_SESSION['access'];
$user_stmt = db_run($db_connect, 'SELECT * FROM users WHERE id = ?', 'i', [$id]);
$select_fetch = $user_stmt ? $user_stmt->get_result()->fetch_assoc() : null;
if (!$select_fetch) {
    echo 'This record could not be loaded.';
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Rushad Razib Panel</title>
	<!-- core:css -->
	<link rel="stylesheet" href="/admin/assets/vendors/core/core.css">
	<!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="/admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<!-- end plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="/admin/assets/fonts/feather-font/css/iconfont.css">
	<!-- endinject -->
  <!-- Layout styles -->  
	<link rel="stylesheet" href="/admin/assets/css/demo_1/style.css">
	<link rel="stylesheet" href="/admin/assets/css/admin.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="/admin/assets/images/favicon.png" />
</head>
<body class="sidebar-dark">
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
		<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          Rushad<span>Razib</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="/admin/dashboard/admin_dashboard.php" class="nav-link">
              <i class="link-icon" data-feather="layout"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">User Panel</li>
          <li class="nav-item">
            <a href="/admin/user/profile.php" class="nav-link">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Profile</span>
            </a>
          </li>
          <li class="nav-item nav-category">Sections</li>
          <li class="nav-item">
            <a href="/admin/banner/banner.php" class="nav-link">
              <i class="link-icon" data-feather="image"></i>
              <span class="link-title">Banner</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/expertise/expertise.php" class="nav-link">
              <i class="link-icon" data-feather="award"></i>
              <span class="link-title">Expertise</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/service/service.php" class="nav-link">
              <i class="link-icon" data-feather="briefcase"></i>
              <span class="link-title">Service</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/portfolio/portfolio.php" class="nav-link">
              <i class="link-icon" data-feather="folder"></i>
              <span class="link-title">Portfolio</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
		<!-- partial -->
	
		<div class="page-wrapper">
					
			<!-- partial:partials/_navbar.html -->
			<nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<ul class="navbar-nav">
						<li class="nav-item dropdown nav-profile">
							<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if($select_fetch['photo'] == ''){?>
								  <img src="https://via.placeholder.com/30x30" alt="profile">
                <?php }else{ ?>
                    <img src="/admin/uploads/user/<?= e($select_fetch['photo']) ?>" width="30" height="30" alt="">
                <?php } ?>
							</a>
							<div class="dropdown-menu" aria-labelledby="profileDropdown">
								<div class="dropdown-header d-flex flex-column align-items-center">
									<div class="figure mb-3">
                    <?php if($select_fetch['photo'] == ''){?>
										<img src="https://via.placeholder.com/80x80" alt="">
                    <?php }else{ ?>
                      <img src="/admin/uploads/user/<?= e($select_fetch['photo']) ?>" width="80" height="80" alt="">
                    <?php } ?>
									</div>
									<div class="info text-center">
										<p class="name font-weight-bold mb-0"><?= e($select_fetch['name']) ?></p>
										<p class="email text-muted mb-3"><?= e($select_fetch['email']) ?></p>
									</div>
								</div>
								<div class="dropdown-body">
									<ul class="profile-nav p-0 pt-3">
										<li class="nav-item">
											<a href="/admin/user/profile.php" class="nav-link">
												<i data-feather="user"></i>
												<span>Profile</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="javascript:;" class="nav-link">
												<i data-feather="edit"></i>
												<span>Edit Profile</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="javascript:;" class="nav-link">
												<i data-feather="repeat"></i>
												<span>Switch User</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="/admin/auth/logout.php" class="nav-link">
												<i data-feather="log-out"></i>
												<span>Log Out</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<!-- partial -->

            <div class="page-content">
            <?php if(isset($_SESSION['db_error'])){ ?>
                <div class="alert alert-danger"><?= e($_SESSION['db_error']) ?></div>
            <?php }unset($_SESSION['db_error']) ?>