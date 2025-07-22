<?php
$output = shell_exec('/bin/bash /home/nuralam/deploy.sh 2>&1');
echo "<pre>$output</pre>";
