<?php

$ret = exec('/home/coreworking/opt/bin/git add -u .; /home/coreworking/opt/bin/git add .; /home/coreworking/opt/bin/git commit -m "Upload files"; /home/coreworking/opt/bin/git push origin master;');
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