<?php
// Check to see there are posted variables coming into the script

// Initialize the $req variable and add CMD key value pair
$req = 'cmd=_notify-validate';
// Read the post from PayPal
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
	
    $req .= "$key => $value \n\n";
	
}

foreach ($_GET as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

print '<pre>';
print_r($req);
print '</pre>';
mail("iamjagseergill@gmail.com", "checkout complete verified", "$req", "From: you@youremail.com");

exit;