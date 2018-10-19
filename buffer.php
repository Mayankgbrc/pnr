<?php
	session_start();
?>
<?php
    if(strlen($_GET['pnr'])!=10){
        header("location: index.php");
        $_SESSION['err']=1;
    }
    else{
?>
<html>
	<head>
		<title> Buffer </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	<body>
		<header class="w3-container w3-teal w3-center">
          <h1>Xsonic PNR Status</h1>
        </header>
        <div class="w3-row">
        	<div class="w3-col l3 s12"> &nbsp;</div>
        	<div class="w3-col l8 s12">	&nbsp;
				<?php
					$pnr= $_GET['pnr'];
					$_SESSION['err']=0;
					$url="https://api.railwayapi.com/v2/pnr-status/pnr/".$pnr."/apikey/zpa7xe2y3v/";
				    $data=file_get_contents($url);
				    $jssson = json_decode($data, true);
				    $response = array(200=>"Success", 210=>"Train doesn’t run on the date queried", 211=>"Train doesn’t have journey class queried", 220=>"Flushed PNR", 221=>"Invalid PNR", 230=> "Date chosen for the query is not valid for the chosen parameters", 404=>"Data couldn’t be loaded on our servers. No data available.", 405=> "Data couldn't be loaded on our servers. Request couldn't go through.", 500=> "Unauthorised API key", 501 =>"Contact mayankgbrc@gmail.com", 502=> "Invalid arguments passed");
				    $classes = array("1A"=>"First AC","2A"=>"Second AC","3A"=>"AC 3 Tier","3E"=>"AC 3 Tier Economy", "FC"=>"First Class", "CC"=>"AC chair Car",
				    	"SL"=>"Sleeper","2S","Second Sitting");

				    $res = $jssson["response_code"];
				    if ($res==200){
					    echo "<h5>Your PNR Number: ".$pnr."</h5>" ;
					    echo "<h5>About train : ".$jssson["train"]["number"]." - ".$jssson["train"]["name"]."</h5>";
				?>
				
				<table class="w3-table-all w3-hoverable w3-hide-small w3-centered">
					<tr class="w3-green w3-large">
						<td>Boarding date</td>
						<td>From</td>
						<td>To</td>
						<td>Boarding point</td>
						<td>Reserved upto</td>
						<td>Class</td>
					</tr>

				<?php
			    	echo "<tr><td>";
			    	echo ($jssson["doj"]);
			    	echo "</td><td>";
			      	echo ($jssson["from_station"]["code"]);
			      	echo "</td><td>";
			      	echo ($jssson["to_station"]["code"]);
			      	echo "</td><td>";
					echo ($jssson["boarding_point"]["code"]);
			      	echo "</td><td>";
			      	echo ($jssson["reservation_upto"]["code"]);
			      	echo "</td><td>";
			      	echo ($jssson["journey_class"]["code"]);
			      	echo "</td></tr>";
			    	echo "</table>";
			    ?>
			    <table class="w3-table-all w3-hoverable w3-hide-large w3-centered">
					<tr class="w3-green w3-large">
						<td>&nbsp;&nbsp;Boarding  &nbsp;&nbsp;date</td>
						<td>From / <h5>Boarding point</h5></td>
						<td>To / <h5>Reserved upto</h5></td>
						<td>Class</td>
					</tr>

			    <?php
			    	echo "<tr><td>";
			    	echo ($jssson["doj"]);
			    	echo "</td><td>";
			      	echo ($jssson["from_station"]["code"]." / ");
			      	echo ($jssson["boarding_point"]["code"]);
			      	echo "</td><td>";
			      	echo ($jssson["to_station"]["code"]." / ");
			      	echo ($jssson["reservation_upto"]["code"]);
			      	echo "</td><td>";
			      	echo ($classes[$jssson["journey_class"]["code"]]);
			      	echo "</td></tr>";
			    	echo "</table>";
			    	echo "<br>";
				
				?>

				<table class="w3-table-all w3-hoverable w3-centered">
					<tr class="w3-green w3-large">
						<td>S. No. </td>
						<td>Booking Status</td>
						<td>Current Status</td>
					</tr>

			    <?php
			    	$pass_num = $jssson["total_passengers"];
			    	for($j=0;$j<$pass_num;$j++){
						echo "<tr><td>";
				    	echo "Passenger ".($j+1);
				    	echo "</td><td>";
				      	echo ($jssson["passengers"][$j]["booking_status"]);
				      	echo "</td><td>";
				      	echo ($jssson["passengers"][$j]["current_status"]);
				      	echo "</td></tr>";
			      	}
			    	echo "</table>";
			    	echo "<h3 class=w3-container>Chart prepared: ";
			    	if($jssson["chart_prepared"]){
			    		echo "Yes</h3>";
			    	}
			    	else{
			    		echo "No</h3>";
			    	}
			    	?>
			    	<br>
			    	<table class="w3-table-all w3-hoverable w3-centered ">
			    		<tr class="w3-blue w3-large"><td colspan="2">legends</td></tr>
				    	<tr class="w3-blue w3-large"><td>Symbol</td><td>Description</td></tr>
						<tr><td>CAN / MOD</td><td>Cancelled or Modified Passenger</td></tr>
						<tr><td>CNF / Confirmed</td><td>Confirmed (Coach/Berth number will be available after chart preparation)</td></tr>
						<tr><td>RAC</td><td>Reservation Against Cancellation</td></tr>
						<tr><td>WL #</td><td>Waiting List Number</td></tr>
						<tr><td>RLWL</td><td>Remote Location Wait List</td></tr>
						<tr><td>GNWL</td><td>General Wait List</td></tr>
						<tr><td>PQWL</td><td>Pooled Quota Wait List</td></tr>
						<tr><td>REGRET/WL</td><td>No More Booking Permitted</td></tr>
						<tr><td>RELEASED</td><td>Ticket Not Cancelled but Alternative Accommodation Provided</td></tr>
						<tr><td>R# #</td><td>RAC Coach Number Berth Number</td></tr>
						<tr><td>WEBCAN</td><td>Railway Counter Ticket Passenger cancelled through internet and Refund not collected</td></tr>
						<tr><td>WEBCANRF</td><td>Railway Counter Ticket Passenger cancelled through internet and Refund collected</td></tr>
						<tr><td>RQWL</td><td>Roadside Quota Waitlist</td></tr>
						<tr><td>DPWL</td><td>Duty Pass Waitlist</td></tr>
						<tr><td>TQWL</td><td>Tatkal Quota Waitlist</td></tr>
					</table>
				</div>
			</div>
	    <?php
		}
		
		else{
			header("location: index.php");
        	$_SESSION['err2'] = $response[$res];
		}


    }
    
?>
<br><br><br>
	<footer class="w3-container w3-teal w3-center" style="position:fixed;bottom:0;left:0;width:100%;">
      <h4>Developed with <span class="w3-text-red">&hearts;</span> by <a href="https://www.facebook.com/mayankgbrc" target="_blank">Mayank Gupta</a> </h4>
    </footer>
</body>
</html>
