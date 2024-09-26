<?php
// Define the commands to run the Python scripts
$command1 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\segmentation.py');
$command2 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\productrevLC.py');
$command3 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\churnrate.py');
$command4 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\revproduct.py');
$command5 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\review_analysis.py');
$command6 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\review_analysis_comments.py');
$command7 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\review_analysis_semantic.py');
$command8 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\make_presentation.py');
$command9 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\generate_report.py');

// Execute both commands
$output1 = shell_exec($command1);
$output2 = shell_exec($command2);
$output3 = shell_exec($command3);
$output4 = shell_exec($command4);
$output5 = shell_exec($command5);
$output6 = shell_exec($command6);
$output7 = shell_exec($command7);
$output8 = shell_exec($command8);
$output9 = shell_exec($command9);

// Output the results (if needed)
echo $output1;
echo $output2;
echo $output3;
echo $output4;
echo $output5;
echo $output6;
echo $output7;
echo $output8;
echo $output9;