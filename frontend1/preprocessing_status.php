<?php
session_start();

$command1 = escapeshellcmd('python C:\\xampp\\htdocs\\fyp0.3\\frontend1\\preprocessing.py');
$output1 = shell_exec($command1);
echo $output1;
// This file checks the status of the preprocessing
$progress_file = 'preprocessing_progress.txt';

if (file_exists($progress_file)) {
    $progress = file_get_contents($progress_file);
    if ($progress == 'done') {
        echo json_encode(['completed' => true]);
    } else {
        echo json_encode(['completed' => false, 'progress' => $progress]);
    }
} else {
    echo json_encode(['completed' => false, 'progress' => 0]);
}
