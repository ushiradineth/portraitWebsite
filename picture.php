<?php session_start();
if(!isset($_SESSION["username"])){
    header('Location:index.php');
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title ><?php print_r("{$_GET['username']}'s picture"); ?></title>
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
		

        <form id="form1" name="form1" method="post" action="" class="" style="position: absolute; border-radius: 5px; top: 50%; left: 50%; margin-right: -50%; transform: translate(-50%, -50%); height: auto; max-height: 900px; overflow-y: scroll; overflow-x: hidden;"> 
        <div>
			<?php 
				$con = mysqli_connect("localhost", "root", "", "wadWebsite");
                $itemID = $_GET['itemID'];
				$sql ="SELECT * FROM `posts` WHERE `itemID` = '".$itemID."';";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					$c = 0;
					while($row = $result->fetch_assoc()) {?>
						    <div class="pad" style="border-radius: 10px 10px 0px 0px;">
								<a href="user.php?username=<?php echo $row['username']; ?>" style="text-decoration: none;">
                				<img src="<?php 
									$con = mysqli_connect("localhost", "root", "", "wadWebsite");
									$username = $row["username"];
									$sql = "SELECT `pfpPath` FROM `users` WHERE `username` = '".$username."'";  
									$rs = mysqli_query($con,$sql);
									while($rr = $rs->fetch_assoc()){
										echo $rr["pfpPath"];
									}?>" style="border-radius: 50%; height: 50px; width: 50px; overflow: hidden; float:left;"> 
                				<p style="font-family: Helvetica; font-size: 20px; margin-top: 0%; overflow-wrap: break-word; padding-top: 12px; padding-bottom: 0px;" class="dn">&nbsp;&nbsp;<?php echo $row['username'] ?></p>
								</a>
            				</div>
							<img src="<?php echo $row["path"] ?>" style="width: 800px; height: auto;">
							<div class="pad" style="font-family: Helvetica; text-align: left; margin-top: -4px; width:800px; margin-bottom: 100px; padding: 15px 10px; border-radius: 0px 0px 10px 10px;">
								<?php echo "<span style='font-weight: bold; white-space: nowrap;' class='dn'>".$row["username"]."</span>&nbsp;".$row["caption"]."<br><span style='font-size: 10px; white-space: nowrap;' class='dn'>".$row["date"]."</span>";?>
								<?php $c++; ?>
								</div><?php
					}
				}
			?>
		</div>
 

		<div class="pad" style="background: white; width:800px; height: auto; padding: 15px 10px; border-radius: 10px 10px 10px 10px; margin-top: -100px; padding-top: 0px;">
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
    if(isset($_POST["homebtn"])){?>
        <script>document.location.href = "home.php";</script><?php 
    }
    if(isset($_POST["profilebtn"])){?>
        <script>document.location.href = "account.php";</script><?php 
    }
?>