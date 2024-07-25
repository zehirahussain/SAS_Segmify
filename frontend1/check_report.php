<?php
$filename = 'static/reports/monthly_report.pdf';
if (file_exists($filename)) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}
?>
