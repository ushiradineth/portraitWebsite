<?php session_start();
if(!isset($_SESSION["username"])){
    header('Location:index.php');
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title >Upload</title>
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
		

        <form id="form1" name="form1" method="post" action="upload.php" class="container" enctype="multipart/form-data" style="width: 445px;  height: auto;"> 
            <input type="file" name="fileName" style="margin-left: 22%;">
            <input type="text" id="caption" name="caption" placeholder=" <?php print_r("Caption"); ?>" minlength=1 maxlength=200><br><br>
		<input type="submit" name="homebtn" id="homebtn" value="Home" class="submitbtnbig" style="width: 400px;"/>
    	<input type="submit" name="uploadbtn" id="uploadbtn" value="Upload" class="submitbtnbig" style="width: 400px;"/>
        </form>
    </div>

<script>
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "on"){
				$( "body" ).addClass( "dark" );w
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
    if(isset($_POST["homebtn"])){
        header('Location:home.php');
    }
    if(isset($_POST["uploadbtn"])){
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
                $date = date("m-d-Y-H-i-s");
                move_uploaded_file($tempName, $location.$date.".".$extension);
                $con = mysqli_connect("localhost", "root", "", "wadWebsite");
                $caption = $_POST["caption"];
                $sql = "INSERT INTO `posts` (`itemID`, `username`, `caption`, `date`, `path`) VALUES (NULL, '".$username."', '".$caption."', current_timestamp(), 'userUploads\\\\\\\\".$username."\\\\\\\\".date('m-d-Y-H-i-s').".".$extension."');";
                $con->query($sql);
                header('Location:account.php');            
            }
        } 
    }
?>