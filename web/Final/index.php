<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ServACE: Hearts in Spades</title>

	<link rel="stylesheet" type="text/css" href="custom.css" />

	<!-- Bootstrap 3 includes -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>	
	<header>
		<img src="images/ace_table_pan.png" alt="images/hands_pan.png"/>
	</header>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"> </span>
					<span class="icon-bar"> </span>
					<span class="icon-bar"> </span>
				</button>
				<a class="navbar-brand servace-menu" href="#">ServACE: Hearts in Spades</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php?action=helpout">Help Out</a></li>					
					<li><a href="index.php?action=directions">Directions</a></li>					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Volunteers<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?action=current_events">ServACE Opportunities</a></li>
							<li><a href="index.php?action=vol_profile">ServACE Profiles</a></li>							
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Event Coordinators<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?action=venue_profile">Manage Venues</a></li>
							<li><a href="index.php?action=event_manage">Manage Events</a></li>
							<li><a href="index.php?action=rate_vols">Rate Volunteers</a></li>
						</ul>
					</li>										
					<li><a href="index.php?action=contact">Contact</a></li>					
				</ul>
			</div>
		</div> 
	</nav>
	<div id="mainContent" class="container">
		<?php  
			// Dynamically generate main content
			session_start();
			$action = null;
			if (isset($_REQUEST['action'])) {
				$action = $_REQUEST['action'];
				
				//direct pages
				if ($action === 'helpout') {
					include("servACE_intro.php");
				}
				else if ($action === 'directions') {
					include("servACE_directions.php");
				}				
				else if ($action === 'current_events') {
					include("current_events.php");
				}				
				else if ($action === 'vol_profile') {
					include("profile_vols.php");
				}
				else if ($action === 'venue_profile') {
					include("profile_venues.php");
				}
				else if ($action === 'event_manage') {
					include("manage_events.php");
				}				
				else if ($action === 'rate_vols') {
					include("rate_volunteers.php");
				}
				else if ($action === 'contact') {
					include("contact.php");
				}				
				
				// indirect pages
				else if ($action == 'create_venue') {
					include("func_venues.php");
				}
				else if ($action === 'signup') {
					include("signup.php");
				}
				else if ($action === 'bookings') {
					include("bookings.php");
				}
				else if ($action === 'postrate') {
					include("rate_volunteers_complete.php");
				}
				else if ($action === 'send_mail') {
					include("gmail.php");
				}
			}
			else {
				// start page
				include("servACE_intro.php");
			}
		?>
	</div><!-- content -->
	<footer class="navbar-inverse navbar-fixed-bottom">
		<div class="container">
			<p>All Contents &amp; All Rights reserved. &copy; Michael P Murphy (El-Pigadore Enterprises)</p>
		</div>
	</footer>
</body>

</html>