<?php
    session_start();

    ini_set('session.use_cookies', '1');

    // Header material
    echo '
    <html>
    <head>
            <title>Gale-Fisher Auto Parts</title>
            <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>';

		include_once('navbar.php');
		echo '
			<div id="login-content-wrapper">';
				
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$dbHost = "68.191.214.214";
	$dbUsername = "galefisher";
	$dbPassword = "galefisher";       
	$dbTable = "galefisherautoparts";
	$dbPort = 3306;
	$con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
	if (!$con) {
		exit('Connect Error (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}

	mysqli_set_charset($con, 'utf-8');
	
	$sql = "select name, type, description, price from part";
	$sql .= " where " . $_POST['criteria'] . " like '%" . $_POST['search'] . "%'";
	$query = mysqli_query($con, $sql);
	
	// Build result table
	$rowCount = 0;
	echo '
		<p class="content-title">Part Search Results</p>
		<div id="rule"></div>
		<div id="cart-content-wrapper">
			<table>
				<tr class="first"><td>Name</td><td>Type</td><td>Description</td><td>Price</td></tr>';
	while (($row = mysqli_fetch_array($query)) != NULL) {
			echo '<tr';
				if ($rowCount % 2 == 0) {
					echo ' style="background-color:#e3e3e3"';
				}
			echo '>';
			echo '<td><a href="part.php?part=' . $row["name"] . '">' . $row["name"] . '</td>';
			echo '<td>' . $row["type"] . '</td>';
			echo '<td>' . $row["description"] . '</td>';
			echo '<td>' . $row["price"] . '</td>';
			echo '</tr>';
			$rowCount += 1;
	}
	echo '
			</table>
		</div>';
} else {
	echo '
	<div id="part-search-wrapper">
		<p class="content-title">Enter part search Keyword(s)</p>
		<div id="rule"></div>
		<form action="partSearch.php" method="POST">
		<select name="criteria" style="float:left;">
			<option value="name">Name</option>
			<option value="type">Type</option>
			<option value="description">Description</option>
		</select>
		<input type="text" name="search" size="35" value="" style="float:left;" />
		<br /><br />
		<input type="submit" value="Search" style="margin-left:auto; margin-right:auto;" />
		</form>
	</div>';
}
?>

<?php
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>



