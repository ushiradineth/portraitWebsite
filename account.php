<?php session_start();
if(!isset($_SESSION["username"])){
    header('Location:index.php');
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title ><?php print_r("{$_SESSION['displayName']}'s profile"); ?></title>
<style>     
    ::-webkit-scrollbar {
        width: 20px;
    }
    ::-webkit-scrollbar-thumb:window-inactive {
        background: none;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #FCA5A5;
    }
    ::-webkit-scrollbar-thumb {
        background: #FECACA;
        border-radius: 10px;
    }
	.dark ::-webkit-scrollbar-thumb {
        background: #aaa;
        border-radius: 10px;
    }
    ::-webkit-input-placeholder {
        text-align: center;
    }
	.span{
		font-family: monospace;
	}
	</style>
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
		<form id="form1" name="form1" method="post" action="" class="container" style="height: auto; max-height: 800px; overflow-y: scroll; overflow-x: hidden;">  
			<div style="text-align: center;">
				<img src="<?php echo $_SESSION['pfpPath'] ?>" style="border-radius: 50%; height: 100px; width: 100px; overflow: hidden;"> 
				<p style="font-family: Helvetica; font-size: 40px; margin-top: 0%; overflow-wrap: break-word;"><?php echo $_SESSION['displayName'] ?></p>
				<p style="font-family: Helvetica; font-size: 15px; position: relative; bottom: 30px; overflow-wrap: break-word;"><?php echo $_SESSION['bio'] ?></p>
			</div>
			<div style="clear:both;"></div>
			<input type="submit" name="homebtn" id="homebtn" value="Home" class="submitbtnbig" style="width: 250px; margin-left: 10px;"/>
			<input type="submit" name="editprofilebtn" id="editprofilebtn" value="Edit profile" class="submitbtnbig" style="width: 250px; margin-left: 10px;"/>
			<input type="submit" name="signoutbtn" id="signoutbtn" value="Sign out" class="submitbtnbig" style="width: 250px; margin-left: 10px;"/>

			<div>
				<?php 
					$con = mysqli_connect("localhost", "root", "", "wadWebsite");
					$username = $_SESSION["username"];
					$sql ="SELECT * FROM `posts` WHERE username = '".$username."' ORDER BY `itemID` desc;";
					$result = $con->query($sql);
					if ($result->num_rows > 0) {
						$c = 0;
						?><div style="background: white; height: auto; width: auto;"> <?php
						while($row = $result->fetch_assoc()) {
							?><a href="picture.php?itemID=<?php echo $row['itemID']; ?>&username=<?php echo $row['username']; ?>"><img src="<?php echo $row["path"] ?>" style="max-width:266px; width: 266px; height: 266px; max-height:266px; padding: 10px; object-fit: cover;"></a><?php
							$c++;
							if ($c == 3) {
								echo "<br>";
								$c = 0;
							}
						}
					}
				?>
			</div>
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
    if(isset($_POST["homebtn"])){?>
        <script>document.location.href = "home.php";</script><?php 
    }
    if(isset($_POST["editprofilebtn"])){?>
        <script>document.location.href = "editProfile.php";</script><?php 
    }
    if(isset($_POST["signoutbtn"])){?>
        <script>document.location.href = "signout.php";</script><?php 
    }
?>