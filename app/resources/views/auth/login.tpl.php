<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-tap-highlight" content="no">
	<title>Login Page | Ordillos Fashion House</title>
	<!-- Favicons-->
	<link rel="icon" href="assets/images/favicon/favicon-32x32.png" sizes="32x32">
	<!-- Favicons-->
	<link rel="apple-touch-icon-precomposed" href="assets/images/favicon/apple-touch-icon-152x152.png">
	<!-- For iPhone -->
	<meta name="msapplication-TileColor" content="#00bcd4">
	<meta name="msapplication-TileImage" content="assets/images/favicon/mstile-144x144.png">
	<!-- For Windows Phone -->
	<!-- CORE CSS-->
	<link href="assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- Custome CSS-->
	<link href="assets/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
	<link href="assets/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>

<body class="cyan">
	<!-- End Page Loading -->
	<div id="login-page" class="row" ng-controller="UserCtrl">
		<div id="card-alert" class="card red">
        {% if($message) %}
			<div class="card-content white-text">
                <p>{{$message}}</p>
			</div>
			<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
        {% endif %}
		</div>
		<div class="col s12 z-depth-4 card-panel">
			<form class="login-form" method="POST" action="/auth/login">
				<div class="row">
					<div class="input-field col s12 center">
						<!--<img src="assets/images/login-logo.png" alt="" class="circle responsive-img valign profile-image-login">-->
						<p class="center login-form-text">Please Login</p>
					</div>
				</div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-social-person-outline prefix"></i>
						<input id="username" type="text" name="username">
						<label for="username" class="center-align">Username</label>
					</div>
				</div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-action-lock-outline prefix"></i>
						<input id="password" type="password" name="password">
						<label for="password">Password</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<button class="btn waves-effect waves-light col s12" type="submit">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- ================================================
    Scripts
    ================================================ -->
	<!-- jQuery Library -->
	<script type="text/javascript" src="assets/js/plugins/jquery-1.11.2.min.js"></script>
	<!--materialize js-->
	<script type="text/javascript" src="assets/js/materialize.min.js"></script>
	<!--prism
    <script type="text/javascript" src="assets/js/prism/prism.js"></script>-->
	<!--scrollbar-->
	<script type="text/javascript" src="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<!-- data-tables -->
	<script type="text/javascript" src="assets/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/data-tables/data-tables-script.js"></script>
	<!-- chartist -->
	<script type="text/javascript" src="assets/js/plugins/chartist-js/chartist.min.js"></script>
	<!--plugins.js - Some Specific JS codes for Plugin Settings-->
	<script type="text/javascript" src="assets/js/plugins.min.js"></script>
	<!--custom-script.js - Add your own theme custom JS-->
	<script type="text/javascript" src="assets/js/custom-script.js"></script>
</body>

</html>