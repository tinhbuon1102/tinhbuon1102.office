<?php

$ret = shell_exec('/home/coreworking/opt/bin/git reset --soft HEAD 2>&1; /home/coreworking/opt/bin/git add -u ../. 2>&1; /home/coreworking/opt/bin/git add ../ 2>&1; /home/coreworking/opt/bin/git commit -m "Deploy files From Test Environment" 2>&1; /home/coreworking/opt/bin/git push origin master 2>&1;');
echo '<pre>';
print($ret);

?>