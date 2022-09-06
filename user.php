<?php session_start();
if(!isset($_SESSION["username"])){
    header('Location:index.php');
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title ><?php print_r("{$_GET["username"]}'s profile"); ?></title>
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
	
    <div class="bg-img" style="overflow: hidden;">
        <div class="darkBox">
            <div class="mode">
                <p>Dark mode:<span class="change">OFF</span></p>	
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="styling/base.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		

        <form id="form1" name="form1" method="post" action="" class="" style="position: absolute; top: 50%; left: 50%; margin-right: -50%; transform: translate(-50%, -50%); height: auto; max-height: 800px; overflow-y: scroll; overflow-x: hidden;"> 
        <div>
			<?php 
				$con = mysqli_connect("localhost", "root", "", "wadWebsite");
                $username = $_GET["username"];
				$sql ="SELECT * FROM `posts` WHERE username = '".$username."' ORDER BY `itemID` desc;";
				$result = $con->query($sql);
                ?>
                <div class="pad" style="border-radius: 10px 10px 0px 0px;">
                    <a href="user.php?username=<?php echo $_GET['username']; ?>" style="text-decoration: none;">
                    <?php 
                        $con = mysqli_connect("localhost", "root", "", "wadWebsite");
                        $username = $_GET["username"];
                        $sql = "SELECT * FROM `users` WHERE `username` = '".$username."'";  
                        $rs = mysqli_query($con,$sql);
                        while($rr = $rs->fetch_assoc()){
                            echo "<img src='".$rr["pfpPath"]."' style='border-radius: 50%; height: 75px; width: 75px; overflow: hidden; float:left;'>";
                            echo "<p style='font-family: Helvetica; font-size: 20px; margin-top: 0%; position: relative; top: 2px; overflow-wrap: break-word; padding-top: 12px; padding-bottom: 0px; font-weight: bold;' class='dn'>&nbsp;&nbsp;".$username."</p></a>";
                            echo "<p style='font-family: Helvetica; font-size: 15px; position: relative; bottom: 18px; left: 12px; overflow-wrap: break-word;' class='dn'>".$rr["bio"]."</p>";
                        }?>
                    
                </div>
                <?php
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
        </div>

        <div class="pad" style="background: white; margin-top: -4px; width:800px; padding: 15px 10px; border-radius: 0px 0px 10px 10px;">
            <input type="submit" name="homebtn" id="homebtn" value="Home" class="submitbtnbig" style="margin-left: 0%; width: 360px;"/>
            <input type="submit" name="profilebtn" id="profilebtn" value="My profile" class="submitbtnbig" style="margin-left: 7%; width: 360px;"/>
        </div>
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
    if(isset($_POST["profilebtn"])){?>
        <script>document.location.href = "account.php";</script><?php 
    }
    if(isset($_POST["homebtn"])){?>
        <script>document.location.href = "home.php";</script><?php 
    }
?>