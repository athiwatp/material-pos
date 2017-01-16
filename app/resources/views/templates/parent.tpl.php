<!DOCTYPE html>
<html lang="en" ng-app="ordillosInventoryApp">

<head>
	<base href="/">
	<meta http-equiv="Content-Type" content="text/html; charset={{$__charset__}}">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-tap-highlight" content="no">
	<title>Ordillos Inventory - {{block:title}}{{endblock}}</title>
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
	<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
	<link href="assets/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="assets/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection"> {{block:styles}}{{endblock}}
</head>

<body ng-controller="parentCtrl">
	<!-- Start Page Loading -->
	<!--<div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>-->
	<!-- End Page Loading -->
	<!-- //////////////////////////////////////////////////////////////////////////// -->
	<!-- START HEADER -->
	<header id="header" class="page-topbar">
		<!-- start header nav-->
		<div class="navbar-fixed">
			<nav class="navbar-color">
				<div class="nav-wrapper">
					<ul class="left">
						<li>
							<h1 class="logo-wrapper">
								<a href="/" class="brand-logo darken-1"><img src="assets/images/logo.png" alt="materialize logo"></a>
								<span class="logo-text">Inventory</span>
							</h1>
						</li>
					</ul>
					<div class="header-search-wrapper hide-on-med-and-down">
						<i class="mdi-action-search"></i>
						<input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Type anything here..." />
					</div>
					<a href="#" id="sidemenu" data-activates="chat-out" class=" chat-collapse"></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
						</li>
						<li>
							<a ng-click="logNavOut()" class="waves-effect waves-block waves-light"><i class="mdi-communication-chat"></i></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<!-- end header nav-->
	</header>
	<!-- END HEADER -->
	<!-- //////////////////////////////////////////////////////////////////////////// -->
	<!-- START MAIN -->
	<div id="main">
		<!-- START WRAPPER -->
		<div class="wrapper">
			<!-- START LEFT SIDEBAR NAV-->
			<aside id="left-sidebar-nav">
				<ul id="slide-out" class="side-nav fixed leftside-navigation">
					<li class="user-details cyan darken-2">
						<div class="row">
							<div class="col col s4 m4 l4">
								<img src="assets/images/displaypic.jpg" alt="" class="circle responsive-img valign profile-image">
							</div>
							<div class="col col s8 m8 l8">
								<ul id="profile-dropdown" class="dropdown-content">
									<li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
									</li>
									<li class="divider"></li>
									<li><a href="/auth/logout"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
									</li>
								</ul>
								<a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">Profile <i class="mdi-navigation-arrow-drop-down right"></i></a>
								<p class="user-roal">Administrator</p>
							</div>
						</div>
					</li>
					<li class="bold"><a href="/app/dashboard" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Dashboard</a>
					<li class="bold"><a href="/app/sales" class="waves-effect waves-cyan"><i class="mdi-action-shopping-cart"></i> Sales</a>
				    <li class="bold"><a href="/app/customers" class="waves-effect waves-cyan"><i class="mdi-social-people"></i> Customers</a>
					<li class="bold"><a href="/app/products" class="waves-effect waves-cyan"><i class="mdi-action-shopping-cart"></i> Products</a>
                    <li class="no-padding">
						<ul class="collapsible collapsible-accordion">
							<li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-description"></i> Reports</a>
								<div class="collapsible-body">
									<ul>
										<li><a href="/app/reports/sales">Sales</a>
										</li>
										<li><a href="/app/reports/returns-from-dealer">Returns from Dealer</a>
										</li>
										<li><a href="/app/reports/returns-to-company">Returns to Company</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				<a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
			</aside>
			<!-- END LEFT SIDEBAR NAV-->
			<!-- //////////////////////////////////////////////////////////////////////////// -->
			<!-- START CONTENT -->
			<section id="content">
				<!--breadcrumbs start-->
				<div id="breadcrumbs-wrapper">
					<!-- Search for small screen -->
					<div class="header-search-wrapper grey hide-on-large-only">
						<i class="mdi-action-search active"></i>
						<input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
					</div>
					<div class="container">
						<div class="row">
							<div class="col s12 m12 l12">
								<h5 class="breadcrumbs-title">{{block:pageTitle}}{{endblock}}</h5>
							</div>
						</div>
					</div>
				</div>
				<!--breadcrumbs end-->
				<!--start container-->
				<div class="container z-depth-1">
					<div class="section">
						<p class="caption">{{block:pageCaption}}{{endblock}}</p>
						{{block:content}}{{endblock}}
						<div class="divider"></div>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</div>
				</div>
				<!--end container-->
			</section>
			<!-- END CONTENT -->
			<!-- //////////////////////////////////////////////////////////////////////////// -->
			<!-- START RIGHT SIDEBAR NAV-->
			<aside id="right-sidebar-nav">
				<ul id="chat-out" class="side-nav rightside-navigation">
					<li class="li-hover">
						<a data-activates="chat-out" class="chat-close-collapse right"><i class="mdi-navigation-close"></i></a>
						<div id="right-search" class="row">
							<form class="col s12">
								<div class="input-field">
									<i class="mdi-action-search prefix"></i>
									<input id="icon_prefix" type="text" class="validate" ng-model="searchLog">
									<label for="icon_prefix">Search</label>
								</div>
							</form>
						</div>
					</li>
					<li class="li-hover">
						<ul class="chat-collapsible" data-collapsible="expandable">
							<li>
								<div class="collapsible-header teal white-text active"><i class="mdi-social-whatshot"></i>Recent Activity</div>
								<div class="collapsible-body recent-activity">
									<div class="recent-activity-list chat-out-list row" ng-repeat="l in logs | filter:searchLog | limitTo:10 | orderBy:'-created_at' ">
										<div class="col s3 recent-activity-list-icon"><i class="mdi-action-add-shopping-cart"></i>
										</div>
										<div class="col s9 recent-activity-list-text">
											<a ng-bind="l.created_at"></a>
											<p ng-bind="l.action"></p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="collapsible-header light-blue white-text active"><i class="mdi-editor-attach-money"></i>Sales Repoart</div>
								<div class="collapsible-body sales-repoart">
									<div class="sales-repoart-list  chat-out-list row">
										<div class="col s8">Target Salse</div>
										<div class="col s4"><span id="sales-line-1"></span>
										</div>
									</div>
									<div class="sales-repoart-list chat-out-list row">
										<div class="col s8">Payment Due</div>
										<div class="col s4"><span id="sales-bar-1"></span>
										</div>
									</div>
									<div class="sales-repoart-list chat-out-list row">
										<div class="col s8">Total Delivery</div>
										<div class="col s4"><span id="sales-line-2"></span>
										</div>
									</div>
									<div class="sales-repoart-list chat-out-list row">
										<div class="col s8">Total Progress</div>
										<div class="col s4"><span id="sales-bar-2"></span>
										</div>
									</div>
								</div>
							</li>
							<li>
							</li>
						</ul>
					</li>
				</ul>
			</aside>
			<!-- LEFT RIGHT SIDEBAR NAV-->
		</div>
		<!-- END WRAPPER -->
	</div>
	<!-- END MAIN -->
	<!-- //////////////////////////////////////////////////////////////////////////// -->
	<!-- START FOOTER -->
	<footer class="page-footer">
		<div class="footer-copyright">
			<div class="container">
				<span>Copyright © 2016 <a class="grey-text text-lighten-4" href="#" target="_blank">Developer</a> All rights reserved.</span>
				<span class="right"> Design and Developed by <a class="grey-text text-lighten-4" href="#">Developer</a></span>
			</div>
		</div>
	</footer>
	<!-- END FOOTER -->
	<!-- ================================================
    Scripts
    ================================================ -->
	{{block:scripts}}
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
	<!-- Angular Files -->
	<script type="text/javascript" src="assets/js/angular.min.js"></script>
	<script type="text/javascript" src="assets/app/app.js"></script>
	<script type="text/javascript" src="assets/js/angular-datatables.min.js"></script>
	<script type="text/javascript" src="assets/app/controllers/ParentController.js"></script>
	<!--<script type="text/javascript" src="assets/js/plugins/annyang/annyang.min.js"></script>-->
	{{endblock}}
</body>

</html>