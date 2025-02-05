<?php
header('Content-Type: application/json');

$command = escapeshellcmd("python get_products.py");
$output = shell_exec($command);
echo $output;
?>
