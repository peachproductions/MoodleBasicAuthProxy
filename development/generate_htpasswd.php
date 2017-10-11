<?php

$username = 'u';
$start = 0;
$count = 100;
$password = 'password';

for ($i = $start; $i < $count; $i++) {
    $uname = "u$i";
   echo `htpasswd -nbm ${uname} ${password}`;
}
