
<?php
// Path to the Python script
$pythonScriptPath = 'generate_report.py';

// Execute the Python script
$command = escapeshellcmd("python $pythonScriptPath");
$output = shell_exec($command);

// Check if the report was generated
$reportPath = 'static/reports/monthly_report.pdf';
if (file_exists($reportPath)) {
    echo "Report generated successfully.";
} else {
    echo "Failed to generate report.";
}
?>

