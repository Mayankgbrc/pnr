<?php
    session_start();
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Xsonic PNR Status | PNR Status of Indian Railway</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
<body >
    <header class="w3-container w3-teal w3-center">
      <h1>Xsonic PNR Status</h1>
    </header>
    <div class="w3-container">
        <?php
            if($_SESSION['err']){
                echo "<h6 class=w3-text-red>Wrong PNR</h6>";
            }
            else if($_SESSION['err2']){
                echo "<h6 class=w3-text-red>".$_SESSION['err2']."</h6>";
        }
        ?>
        <h3>Enter PNR Number: </h3>
        <form method="get" action="buffer.php">
            <input type="text" name="pnr" //>
    		<button type="submit">Enter</button>
        </form>
    </div>
    <footer class="w3-container w3-teal w3-center" style="position:fixed;bottom:0;left:0;width:100%;">
      <h4>Developed with <span class="w3-text-red">&hearts;</span> by <a href="https://www.facebook.com/mayankgbrc" target="_blank">Mayank Gupta</a> </h4>
    </footer>
</body>
</html>
<?php
    session_unset();
?>