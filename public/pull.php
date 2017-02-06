<?php

$ret = exec("/home/coreworking/opt/bin/git pull origin master", $out, $err);
if ($err) {
	echo ('Error : <br />');
	echo '<pre>'; 
	print($err);
}
else {
	echo '<pre>'; 
	print_r($out);die;
}

?>