<?php
session_start();
require 'admin/auth/db.php';
require 'admin/includes/escape.php';

// CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// banner
$select_banner = "SELECT * FROM banners ORDER BY id LIMIT 1";
$banner_exec = mysqli_query($db_connect, $select_banner);
$banner_fetch = mysqli_fetch_assoc($banner_exec);

// expertise
$select_expert = "SELECT * FROM expertise where status=1";
$expert_exec = mysqli_query($db_connect, $select_expert);

// service
$select_service = "SELECT * FROM services";
$service_exec = mysqli_query($db_connect, $select_service);

// portfolio
$select_port = "SELECT * FROM portfolios";
$select_port_exec = mysqli_query($db_connect, $select_port);

?>

<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="portfolio">
  
  <meta name="author" content="rushadrazib.com">

  <title>Rushad Razib | Web Dev</title>
  <link rel="icon" href="/favicon.png" type="image/png">

  <!-- Mobile Specific Meta-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Themeify Icon Css -->
  <link rel="stylesheet" href="plugins/themify/css/themify-icons.css">
  <!-- animate.css -->
  <link rel="stylesheet" href="plugins/animate-css/animate.css">
  <link rel="stylesheet" href="plugins/aos/aos.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body class="portfolio" id="top">


<!-- Navigation start -->
<!-- Header Start --> 

<nav class="navbar navbar-expand-lg bg-transprent py-4 fixed-top navigation" id="navbar">
	<div class="container">
	  <a class="navbar-brand" href="index.html">
	  	<h2 class="logo">RushadRazib</h2>
	  </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
		<span class="ti-view-list"></span>
	  </button>
  
	  <div class="collapse navbar-collapse text-center" id="navbarsExample09">
			<ul class="navbar-nav ml-auto">
			   <li class="nav-item"><a class="nav-link" href="#banner">Home</a></li>
			   <li class="nav-item"><a class="nav-link smoth-scroll" href="#skillbar">Expertise</a></li>
			   <li class="nav-item"><a class="nav-link smoth-scroll" href="#service">Services</a></li>
			   <li class="nav-item"><a class="nav-link smoth-scroll" href="#portfolio">Portfolio</a></li>
			   <li class="nav-item"><a class="nav-link smoth-scroll" href="#contact">Contact</a></li>
			</ul>
			<?php if (isset($_SESSION['access'])) { ?>
			<a class="btn btn-warning px-4 py-2 rounded" href="/admin/dashboard/admin_dashboard.php">Dashboard</a>
			<?php } else { ?>
			<a class="btn btn-warning px-4 py-2 rounded" href="/admin/login.php">Login</a>
			<?php } ?>
	  </div>
	</div>
</nav>


<!-- Navigation End -->

<!-- Banner start -->

<!-- Slider Start -->
<section class="slider py-7" id="banner" data-aos="fade-up">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5 col-sm-12 col-12 col-md-5">
				<div class="slider-img position-relative">
					<img src="uploads/banner/<?= e($banner_fetch['photo']) ?>" alt="" class="img-fluid w-100">
				</div>
			</div>

			<div class="col-lg-6 col-12 col-md-7">
				<div class="ml-5 banner-text position-relative mt-5 mt-lg-0">
					<span class="head-trans"><?= e($banner_fetch['watermark']) ?></span>
					<h1 class="font-weight-normal text-color text-md"><i class="ti-minus mr-2"></i><?= e($banner_fetch['sub_title']) ?></h1>
					<h2 class="mt-3 text-lg mb-3 text-capitalize"><?= e($banner_fetch['title']) ?></h2>
					<p class="animated fadeInUp lead mt-4 mb-5 text-white-50 lh-35"><?= e($banner_fetch['description']) ?></p>
					<a href="#contact" class="btn btn-solid-border"><?= e($banner_fetch['butn_text']) ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Banner End -->

<!-- Skills start -->
<section class="section bg-gray" id="skillbar" data-aos="fade-up">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="section-title text-center">
					<span class="text-color mb-0 text-uppercase letter-spacing text-sm"><i class="ti-minus mr-2"></i>Skills Set</span>
					<h2 class="title">Expertise</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php foreach($expert_exec as $expertise){?>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="skill-bar mb-4 mb-lg-0">
						<div class="mb-4 text-right"><h4 class="text-uppercase font-weight-normal"><?= e($expertise['name']) ?></h4></div>
						<div class="progress">
							<div class="progress-bar" data-percent="<?= e((string) $expertise['perc']) ?>">
								<span class="percent-text"><span class="count"><?= e((string) $expertise['perc']) ?></span>%</span>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>	

<!-- Skills End -->

<!-- Service start -->
<section class="section bg-gray" id="service" data-aos="fade-up">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="section-title text-center">
					<span class="text-color mb-0 text-uppercase letter-spacing text-sm"><i class="ti-minus mr-2"></i>What i do</span>
					<h2 class="title">Services</h2>
				</div>
			</div>
		</div>

		<div class="row no-gutters">
			<?php foreach($service_exec as $service){ ?>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="service card p-5 rounded-0">
						<h3 class="my-4 text-capitalize"><?= e($service['name']) ?></h3>
						<p><?= e($service["desp"]) ?></p>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<!-- Service End -->

<!-- Portfolio start -->
<section class="section" id="portfolio" data-aos="fade-up">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="section-title text-center">
					<span class="text-color mb-0 text-uppercase letter-spacing text-sm"><i class="ti-minus"></i>Some of my previous works</span>
					<h2 class="title">Portfolio</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 d-flex flex-wrap space-2">
				<?php foreach($select_port_exec as $portfolio){?>
				<div class="col-lg-3 p-1">
					<div class="portfolio-item position-relative">
						<img style="height:200px!important;" src="/admin/uploads/portfolio/<?= e($portfolio['photo']) ?>" alt="" class="img-fluid">

						<a target="_blank" href="<?= safe_href($portfolio['link']) ?>">Visit Site</a>
					</div>
					<div class="text text-center mt-3">
						<h4 class="mb-1 text-capitalize"><?= e($portfolio['name']) ?></h4>
						<p class="text-uppercase letter-spacing text-sm"><?= e($portfolio['sub']) ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
			<!-- <div class="post_gallery owl-carousel owl-theme">
				<?php foreach($select_port_exec as $portfolio){?>
				<div class="item">
					<div class="portfolio-item position-relative">
						<img style="height:300px!important;" src="/admin/uploads/portfolio/<?= e($portfolio['photo']) ?>" alt="" class="img-fluid">

						<a href="<?= safe_href($portfolio['link']) ?>">Visit Site</a>
					</div>
					<div class="text mt-3">
						<h4 class="mb-1 text-capitalize"><?= e($portfolio['name']) ?></h4>
						<p class="text-uppercase letter-spacing text-sm"><?= e($portfolio['sub']) ?></p>
					</div>
				</div>
				<?php } ?>
			</div> -->
		</div>
	</div>
</section>
<!-- Portfolio End

<!-- Contact start -->
<section class="section pt-0" id="contact" data-aos="fade-up">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="section-title text-center">
					<span class="text-color mb-0 text-uppercase letter-spacing text-sm"> <i class="ti-minus mr-2"></i>Contact</span>
					<h1 class="title">Get in Touch</h1>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-8">
					<form class="contact__form form-row contact-form" method="post" action="contact_post.php" id="contactForm">
					<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
					 <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success contact__msg" style="display: none" role="alert">
                                Your message was sent successfully.
                            </div>
                        </div>
                    </div>
					<div class="form-group col-lg-6 mb-5">
						<input type="text" id="name" name="name" class="form-control bg-transparent" placeholder="Your Name *" required>
					</div>
					<div class="form-group col-lg-6 mb-5">
						<input type="text" name="email" id="email" class="form-control bg-transparent" placeholder="Your Email *" required>
					</div>
					<div class="form-group col-lg-12 mb-5">
						<input type="text" name="subject" id="subject" class="form-control bg-transparent" placeholder="Your Subject *" required>
					</div>
					
					<div class="form-group col-lg-12 mb-5">
						<textarea id="message" name="message" cols="30" rows="6" class="form-control bg-transparent" placeholder="Your Message *" required></textarea>
						
						<div class="text-center">
							 <input class="btn btn-main text-white mt-5" id="submit" name="submit" type="submit" class="btn btn-hero" value="Send Message">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- Contact End -->

<!-- Footer start -->
<footer class="footer border-top-1">
	<div class="container">
		<div class="row align-items-center text-center text-lg-left">
			<div class="col-lg-12">
				<div class="text-right">
					<p class="lead"><span class="text-color">Rushad Razib</span> © 2025 All Right Reserved</p>
					<a href="#top" class="backtop smoth-scroll"><i class="ti-angle-up"></i></a>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer End -->

    <!-- Essential Scripts =====================================-->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<!-- Sweetalert -->
	<?php if(isset($_SESSION['success'])){ ?>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			Swal.fire({
			position: "bottom-end",
			icon: "success",
			title: <?= json_encode($_SESSION['success'])?>,
			showConfirmButton: false,
			timer: 1500,
			});
		</script>
	<?php }unset($_SESSION['success']) ?>
	<?php if(isset($_SESSION['contact_err'])){ ?>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			Swal.fire({
			position: "bottom-end",
			icon: "error",
			title: <?= json_encode($_SESSION['contact_err'])?>,
			showConfirmButton: false,
			timer: 2500,
			});
		</script>
	<?php }unset($_SESSION['contact_err']) ?>


	
    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Skill COunt -->
    <script src="plugins/counto/apear.js"></script>
    <script src="plugins/counto/counTo.js"></script>
    <!-- AOS Animation -->
    <script src="plugins/aos/aos.js"></script>
    
    <script src="js/script.js"></script>
	
  </body>
</html>
   