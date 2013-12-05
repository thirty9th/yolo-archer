<!-- Solution for Program 2 - Dillon Fisher -->

<?php

// Functions
function radioButtons($fieldName, $buttonValues, $defaultButton = '') {
	// Do some error checking
	if (!is_string($fieldName)) {
		return "<p style=\"color:red;\">Error! Parameter 1 (fieldName) must be a single string.</p>";
	}
	if (!is_array($buttonValues)) {
		return "<p style=\"color:red;\">Error! Parameter 2 (buttonValues) must be an array of scalars.</p>";
	}
	if (isset($defaultButton)) {
		if (!is_scalar($defaultButton)) {
			return "<p style=\"color:red;\">Error! Paramter 3 (defaultButton) must be a scalar value.</p>";
		}
	}

	// Build the string containing the radio button's HTML code
	$result = "";
	foreach($buttonValues as $buttonValue) {
		// Preliminary error-checking
		if (!is_scalar($buttonValue)) {
			return "<p style=\"color:red;\">Error! Parameter 2 (buttonValues) must be an array of scalars.</p>";
		}
		$result .= "<input type=\"radio\" name=\"{$fieldName}\" value=\"{$buttonValue}\" ";
		if ($buttonValue == $defaultButton) $result .= "checked=\"checked\" ";
		$result .= "/> {$buttonValue} ";
	}

	return $result;
};

function picklist($fieldName, $optionValues, $defaultValues ='', $size = '') {
	// Do some error checking
	if (!is_string($fieldName)) {
		return "<p style=\"color:red\">Error! Parameter 1 (fieldName) must contain a string.</p>";
	}
	if (!is_array($optionValues)) {
		return "<p style=\"color:red;\">Error! Parameter 2 (optionValues) must contain an array of scalars.</p>";
	}
	if ($defaultValues != '') {
		if (!is_scalar($defaultValues)) {
			foreach($defaultValues as $defaultValue) {
				if (!is_scalar($defaultValue)) {
					return "<p style=\"color:red;\">Error! Parameter 3 (defaultValues) must contain either a scalar values or an array of scalar values.</p>";
				}
			}
		}
	}
	if ($size != '') {
		if (!(is_numeric($size) && is_scalar($size))) {
			return "<p style=\"color:red;\">Error! Parameter 4 (size) must contain a number.</p>";
		}
	}

	// Build the string containing the picklist's HTML code
	$result = "<select multiple=\"multiple\" name=\"{$fieldName}\" ";

	// Figure out if we need to add the size flag
	if (isset($size) and $size >= 1) {
		$result .= "size=\"{$size}\"";
	}

	// Close opening tag
	$result .= ">\n";

	foreach($optionValues as $optionValue) {
		// Preliminary error checking
		if (!is_scalar($optionValue)) {
			return "<p style=\"color:red;\">Error! Parameter 2 ($optionValues) must contain an array of scalars.</p>";
		}

		// Open tag for each option
		$result .= "\t\t\t<option";

		// Figure out if we need to add its selected flag
		if (is_scalar($defaultValues)) {
			if ($optionValue == $defaultValues) {
				$result .= " selected=\"selected\"";
			}
		} else if (is_array($defaultValues)) {
			if (in_array($optionValue, $defaultValues)) {
				$result .= " selected=\"selected\"";
			}
		}

		// Close beginning tag and set it's value
		$result .= ">{$optionValue}</option>\n";
	}

	// Close the select tag
	$result .= "</select>";

	return $result;
};

// Header material
echo '
<html>
<head>
	<title>Gale-Fisher Auto Parts</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>';

// Body
echo '
<body>

	<div id="header">
		<div id="header-small-logo-wrapper">
			<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
		</div>
		<div class="login"><a href="customerRegistration.php">Register</a>&nbsp;&nbsp;&nbsp;<a href="login.php">Login</a></div>
	</div>
	<div id="logo-wrapper">
		<div id="logo-image">
			<img src="images/logo_large.png" alt="Logo" />
		</div>
		<div id="logo-title">
			<p>Gale-Fisher<br/>
			Auto Parts</p>
		</div>
	</div>
	<div id="navbar-wrapper">
		<div id="navbar-item">
			<a href="main.php"><img src="images/button_navbar_home.png" alt="Home" /></a>
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_parts.png" alt="Parts" />
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_about.png" alt="About Us" />
		</div>
	</div>
	<div id="content-wrapper">
		<div id="content-title">
			<p>Daily Deals</p>
		</div>
		<div id="four-square-wrapper">
			<div id="top-left">
			</div>
			<div id="top-right">
			</div>
			<div id="bottom-left">
			</div>
			<div id="bottom-right">
			</div>
		</div>
	</div>';
	
// Footer
echo '
	<div id="footer-wrapper">
		<div id="footer-content">
			<p class="footer-text">Site and database implementation created by:<br />
			James Gale and Dillon Fisher<br />
			Last updated: November 2013</p>
		</div>
	</div>
</body>
</html>';

?>
