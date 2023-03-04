<?php

shell_exec( 'cd /home/ec2-user/recipesub.ngagnon.com' );
$res = shell_exec( 'git pull' );

echo "<pre>";
echo $res;
