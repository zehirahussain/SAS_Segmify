<?php
// Define the commands to run the Python scripts
$command1 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\segmentation.py');
$command2 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\productrevLC.py');
$command3 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\churnrate.py');
$command4 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\revproduct.py');

// Execute both commands
$output1 = shell_exec($command1);
$output2 = shell_exec($command2);
$output3 = shell_exec($command3);
$output4 = shell_exec($command4);

// Output the results (if needed)
echo $output1;
echo $output2;
echo $output3;
echo $output4;

?>
