<?php session_start();
if(!isset($_SESSION["username"])){
    header('Location:index.php');
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit your profile</title>
<script>

</script>
</head>
<body>
   <div class="bg-img">
   <div class="darkBox">
		<div class="mode">
			<p>Dark mode:<span class="change">OFF</span></p>	
		</div>
	</div>
    <link rel="stylesheet" type="text/css" href="styling/base.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <form id="form1" name="form1" method="post" action="editProfile.php" class="container" enctype="multipart/form-data">
    <h1>Edit your details</h1>   
    <img src="<?php echo $_SESSION['pfpPath']; ?>" style="border-radius: 50%;  width: 80px; height: 80px; margin: 20px; overflow: hidden; display: inline-block; float: left;"> 
    <div>
        <br><br>
        <input type="file" name="fileName" style="margin-left: 5%;">
        <input type="text" id="displayName" name="displayName" placeholder=" <?php print_r("Display name (currently: {$_SESSION["displayName"]})"); ?>" minlength=1 maxlength=50><br><br>
        <input type="text" id="bio" name="bio" placeholder=" <?php  print_r("Bio (currently: {$_SESSION["bio"]})"); ?>" minlength=1 maxlength=200 style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><br><br>
    </div>
    <div style="clear:both;"></div>
    <input type="submit" name="savechangesbtn" id="savechangesbtn" value="Save changes" class="submitbtnbig" style="width: 190px;"/>
    <input type="submit" name="deleteaccbtn" id="deleteaccbtn" value="Delete account" class="submitbtnbig" style="width: 190px;"/>
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
    if(isset($_POST["savechangesbtn"])){
        $fileName = $_FILES['fileName']['name'];
        $tempName = $_FILES['fileName']['tmp_name'];

        if(isset($fileName)){
            if(!empty($fileName)){
                $username = $_SESSION["username"];
                $location = "userUploads\\".$username."\\";
                if (!file_exists($location)) {
                    mkdir($location, 0777, true);
                }
                $original = explode('.', $fileName);
                $extension = array_pop($original);
                move_uploaded_file($tempName, $location."pfp".".".$extension);
                $con = mysqli_connect("localhost", "root", "", "wadWebsite");
                $sql = "UPDATE users SET pfpPath = 'userUploads\\\\\\\\".$username."\\\\\\\\pfp.".$extension."' WHERE username = '".$username."';";
                $con->query($sql);
                $_SESSION["pfpPath"] = "userUploads\\".$username."\\pfp.".$extension."";            
            }
        }
        
        if($_POST["displayName"] != ""){
            $value = $_POST["displayName"];
            $con = mysqli_connect("localhost", "root", "", "wadWebsite");
            $username = $_SESSION["username"];
            $sql = "UPDATE users SET display = '.$value.' WHERE username = '".$username."';";
            $con->query($sql);
            $_SESSION["displayName"] = $_POST["displayName"]; 
        }
        
        if($_POST["bio"] != ""){
            $value = $_POST["bio"];
            $con = mysqli_connect("localhost", "root", "", "wadWebsite");
            $username = $_SESSION["username"];
            $sql = "UPDATE users SET bio = '.$value.' WHERE username = '".$username."';";
            $con->query($sql);
            $_SESSION["bio"] = $_POST["bio"]; 
        }

        header('Location:account.php');
    }

    if(isset($_POST["deleteaccbtn"])){
        $con = mysqli_connect("localhost", "root", "", "wadWebsite");
        $username = $_SESSION["username"];
        $sql = "DELETE FROM users WHERE username = '".$username."';";
        $con->query($sql);
        $sql = "DELETE FROM posts WHERE username = '".$username."';";
        $con->query($sql);
        rmdir("userUploads\\".$username);
        header('Location:signout.php');
    }
?>