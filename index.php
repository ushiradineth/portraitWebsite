<?php session_start();
   if(isset($_SESSION["username"])){
      header('Location:home.php');
   }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome!</title>
<link rel="stylesheet" type="text/css" href="styling/base.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body>
<div class="bg-img"> 
	<div class="darkBox">
		<div class="mode">
			<p>Dark mode:<span class="change">OFF</span></p>	
		</div>
	</div>
	<div class="container" style="width: auto;">
  	<h1>Poloroid Media</h1>
	<a href="login.php"><input type="submit" value="Login" class="submitbtnbig"/></button></a>
	<br>
	<a href="signup.php"><input type="submit" value="Sign up" class="submitbtnbig"/></button></a>
</div>
<script>
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "on"){
				$( "body" ).addClass( "dark" );
				$( ".change" ).text( "ON" );
			} else if (this.responseText == "off") {
				if( $( "body" ).hasClass( "dark" )) {
					$( "body" ).removeClass( "dark" );
					$( ".change" ).text( "OFF" );
				}
			}
		}				
	};
	xmlhttp.open("GET", "darkMode.php?get=1", true);
	xmlhttp.send();

	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function() {};
	
	$( ".change" ).on("click", function() {
		if( $( "body" ).hasClass( "dark" )) {
			$( "body" ).removeClass( "dark" );
			$( ".change" ).text( "OFF" );
			xmlhttp2.open("GET", "darkMode.php?mode=" + 'off', true);
			xmlhttp2.send();
		} else {
			$( "body" ).addClass( "dark" );
			$( ".change" ).text( "ON" );
			xmlhttp2.open("GET", "darkMode.php?mode=" + 'on', true);
			xmlhttp2.send();
		}
	});
</script>
</body>
</html>
