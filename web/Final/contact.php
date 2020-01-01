<head>
	<link rel="stylesheet" type="text/css"  href="content.css" />
</head>
<body>
	<div class="row alert servace-alert">
		<div class="servace-banner">Contact</div>
		<form class="form-horizontal container" method="post" action="index.php?action=send_mail" >
			<!--<div class="jumbotron alert"> -->
				<div class="form-group">
					<label class="con-lbl control-label col-sm-2 col-xs-2" for="txtName">Name: </label>
					<div class="col-sm-9 col-xs-9" >
						<input class="form-control" type="text" id="txtName" name="txtName" placeholder="Enter sender's name" />
					</div>
				</div>
				<div class="form-group">
					<label class="con-lbl control-label col-sm-2 col-xs-2" for="txtName">Email Address: </label>
					<div class="col-sm-9 col-xs-9" >
						<input class="form-control" type="text" id="txtEmail" name="txtEmail" placeholder="Enter sender's email" />
					</div>
				</div>
				<div class="form-group">
					<label class="con-lbl control-label col-sm-2 col-xs-2" for="txtName">Subject: </label>
					<div class="col-sm-9 col-xs-9" >
						<input class="form-control" type="text" id="txtSubject" name="txtSubject" placeholder="Enter message subject" />
					</div>
				</div>
				<div class="form-group">
					<label class="con-lbl control-label col-sm-2 col-xs-2" for="txtName">Message: </label>
					<div class="col-sm-9 col-xs-9" >
						<textarea class="form-control" id="txtMessage" name="txtMessage" rows="6" placeholder="Enter message content"></textarea>
					</div>
				</div>
				<div class="form-group" >
					<div class="col-sm-offset-2">
						<input class="con-btn btn btn-primary col-sm-4" type="submit" id="submit" value="Submit" />
					</div>
				</div>
			<!--</div>-->
		</form>
</body>