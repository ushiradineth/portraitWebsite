<?php session_start();
   if(isset($_SESSION["username"])){
      header('Location:home.php');
   }
?>

<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login page</title>
<link rel="stylesheet" type="text/css" href="styling/base.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
   function validateUsername(){
      var username = document.getElementById("username").value;
      if (username.length < 6 || username.length > 20) {
         alert("Username can only have from 6 to 20 characters");
         return false;
      } 
      return true;				
   }
   
   function validatePassword(){
      var password = document.getElementById("password").value;
      if (password.length < 6){
         alert("Password should have more than 6 characters");
         return false;
      }
      return true;
   }

   function validateAll(){
      if (validateUsername() && validatePassword()){
      } else {
         event.preventDefault();
      }
   }
</script>
</head>
<body>
<div class="bg-img">
<div class="darkBox">
		<div class="mode">
			<p>Dark mode:<span class="change">OFF</span></p>	
		</div>
	</div>
<form id="form1" name="form1" method="post" action="login.php" class="container" onsubmit="validateAll()" style="width: 450px;">
   <h1>Polaroid Media Login</h1>
   <table width="736" height="151" border="0" align="center">
      <tr>
         <td width="167">User Name</td>
         <td width="197"><input type="text" name="username" id="username" required placeholder="Enter Username"/></td>
      </tr>
   <tr>
         <td width="167">Password</td>
         <td width="197"><input type="password" name="password" id="password" required placeholder="Enter password"/></td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
   </table><input type="submit" name="button" id="button" value="Submit" class="submitbtnbig"/>
</form>
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

<?php 
    if(isset($_POST["button"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];

      $con = mysqli_connect("localhost", "root", "", "wadWebsite");

      $sql = "SELECT * FROM `users` WHERE `username` = '".$username."' and `password` = '".$password."'";  

      $result = mysqli_query($con,$sql);
        
      if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();

         $_SESSION["email"] = $row["email"];
         $_SESSION["username"] = $row["username"];
         $_SESSION["password"] = $row["password"];
         $_SESSION["bdate"] = $row["dob"];
         $_SESSION["gender"] = $row["gender"];
         $_SESSION["displayName"] = $row["display"];
         $_SESSION["bio"] = $row["bio"];
         $_SESSION["pfpPath"] = $row["pfpPath"];

         header('Location:home.php');
      } else {
         echo "<script>alert('Invalid credentials');</script>";
      }
   }
?>