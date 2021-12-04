<?php
$f = "visit.php";
if(!file_exists($f)){
	touch($f);
	$handle =  fopen($f, "w" ) ;
	fwrite($handle,0) ;
	fclose ($handle);
}
 
include('libs/phpqrcode/qrlib.php'); 

function getUsernameFromEmail($email) {
	$find = '@';
	$pos = strpos($email, $find);
	$username = substr($email, 0, $pos);
	return $username;
}

if(isset($_POST['submit']) ) {
	$tempDir = 'temp/'; 
	$email = $_POST['mail'];
	$subject =  $_POST['subject'];
	$filename = getUsernameFromEmail($email);
	$body =  $_POST['msg'];
	$codeContents = 'mail:'.$email.
	               'Nom='.urlencode($subject).
	               'Contact='.urlencode($body); 
	QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
	<title>(QR) Code Generator</title>
	<link rel="stylesheet" href="libs/css/bootstrap.min.css">
	<link rel="stylesheet" href="libs/style.css">
	<script src="libs/navbarclock.js"></script>
	</head>
	<body onLoad="startTime()">
		<nav class="navbar-inverse" style="background-color: blue" role="navigation">
			<a href="index.php"><h1 style="color:white; font-weight:bold; text-align:center;">QR Code Generator</h1></a>
			<div id="clockdate">
				<div class="clockdate-wrapper">
					<div id="clock"></div>
					<div id="date"><?php echo date('l, F j, Y'); ?></div>
				</div>
			</div>
		</nav>
		<div class="myoutput">
			<h3 style="color:white;"><strong>(QR) Code Generator</strong></h3>
			<div class="input-field">
				<h3 style="color:white;">Remplissez tout les champs</h3>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="mail" style="width:20em;" placeholder="Entrez votre Email" value="<?php echo @$email; ?>"  />
					</div>
					<div class="form-group">
						<label>Nom</label>
						<input type="text" class="form-control" name="subject" style="width:20em;" placeholder="Entez le sujet de votre Email" value="<?php echo @$subject; ?>" required pattern="[a-zA-Z .]+" />
					</div>
					<div class="form-group">
						<label>Contact</label>
						<input type="tel" class="form-control" name="msg" style="width:20em;" value="<?php echo @$body; ?>" required  placeholder="Entez votre contact"></textarea>
					</div>
					<div class="form-group">
					  <input type="submit" name="submit" class="btn-btn-primary-submitBtn" style="width:20em; margin:0; color: #36F;" />
					</div>
				</form>
			</div>
			<?php
			if(!isset($filename)){
				$filename = "author";
			}
			?>
			<div class="qr-field">
				<h2 style="text-align:center; color:white;">QR Code Result: </h2>
				<center>
					<div class="qrframe" style="border:2px solid black; width:210px; height:210px;">
							<?php echo '<img src="temp/'. @$filename.'.png" style="width:200px; height:200px;"><br>'; ?>
					</div>
					<button><a class="btn-btn-primary-submitBtn" style="width:210px; margin:5px 0; font-weight=bold;" href="download.php?file=<?php echo $filename; ?>.png ">Telechargez le Code QR</a></button>
				</center>
			</div>
			<div class = "dllink" style="text-align:center;margin:-100px 0px 50px 0px;">
				<h4 style="font-family:fantasy; color:white;">Made by KICE</h4>
			</div>
		</div>
	</body>
	<footer></footer>
</html>