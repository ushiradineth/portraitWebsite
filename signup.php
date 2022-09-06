<?php session_start();
   if(isset($_SESSION["username"])){
      header('Location:home.php');
   }
?>

<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign up page</title>
<link rel="stylesheet" type="text/css" href="styling/base.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
	function validateEmail(){
		var email = document.getElementById("email").value;
		var emailAt = email.indexOf("@");
		var emailDot = email.lastIndexOf(".");
		var emailLength = email.length;
		if (emailAt >= 2 && (emailDot - emailAt) >= 2 && (emailLength - emailAt) >= 2){
			return true;
		} else {
			alert("Enter a valid email")
			return false;
		}
	}
	
	function validateUsername(){
		var username = document.getElementById("username").value;
		if (username.length < 6 || username.length > 20) {
			alert("Username can only have from 6 to 20 characters");
			return false;
		} else {
			return true;
		}				
	}
	
	function validatePassword(){
		var password = document.getElementById("password").value;
		var confirmPassword = document.getElementById("passwordRE").value;
		if (password.length < 6){
			alert("Password should have more than 6 characters");
			return false;
		}
		if (password != confirmPassword){
			alert("Password does not match");
			return false;
		}
		return true;
	}
	
    function validateAge() {
        var birth = new Date(document.getElementById("bdate").value);
        var year = birth.getFullYear();
        var month = birth.getMonth();
        var day = birth.getDate();
        if (new Date(year+18, month-1, day) > new Date()){
			alert("Age should be more than 18 years, please enter a valid Date of Birth");
            return false;
		}
		return true;
    }
	
	function validateGender(){
		var value = document.getElementById("gender").value;
		if (value == "-----") {
			alert("Choose a gender from the list");
			return false;
		} else {
			return true;
		}				
	}

	function validateAll(){
		if (validateEmail() && validateUsername() && validatePassword() && validateAge() && validateGender()){
			alert("Account has been created");
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
<form id="form1" name="form1" method="post" action="" class="container" onsubmit="validateAll()" style="width: 450px;">
  <h1>Polaroid Media Sign Up</h1>
  <table width="736" height="151" border="0" align="center">
	<tr>
      	<td width="167">E-mail</td>
      	<td width="197"><input type="text" name="email" id="email" required placeholder="Enter a valid email address"/></td>
    </tr>  
    <tr>
      	<td width="167">User Name</td>
      	<td width="197"><input type="text" name="username" id="username" required placeholder="Enter Username"/></td>
    </tr>
	<tr>
      	<td width="167">Password</td>
      	<td width="197"><input type="password" name="password" id="password" required placeholder="Enter password"/></td>
    </tr>
	<tr>
      	<td width="167">Repeat Password</td>
      	<td width="197"><input type="password" name="passwordRE" id="passwordRE" required placeholder="Repeat password"/></td>
    </tr>
	<tr>
      	<td width="167">Birth date</td>
      	<td width="197"><input type="date" id="bdate" name="bdate" required/></td>
    </tr>
	<tr>
		<td><label for="gender" required>Gender</label>
			<td><select name="gender" id="gender" required>
				<option value="-----">-----</option>
				<option value="other">Other</option>
  				<option value="male">Male</option>
  				<option value="female">Female</option>
			</select></td>
		</td>
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="submit" name="btn" id="btn" value="Submit" class="submitbtnbig"/>
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
	if(isset($_POST["btn"])){
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$dob = $_POST["bdate"];
		$gender = $_POST["gender"];
		$displayName = $_POST["username"];
		$bio = "default bio";
		$pfpPath = "styling/user.jpg";

		$con = mysqli_connect("localhost", "root", "", "wadWebsite");
	
		$sql = "INSERT INTO `users` (`email`, `username`, `password`, `dob`, `gender`, `display`, `bio`, `pfpPath`) VALUES ('".$email."', '".$username."', '".$password."', '".$dob."', '".$gender."', '".$displayName."', '".$bio."', '".$pfpPath."');";
		
		$con->query($sql);

		echo "<script> window.location.href = 'login.php'; </script>";
	}
?>