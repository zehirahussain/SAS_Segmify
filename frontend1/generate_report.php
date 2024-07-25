<?php
//exec("python3 generate_report.py");
//echo "Report generated";
?>

<?php
// Path to the Python executable
//$pythonPath = 'python'; // or 'python3' depending on your setup
//$scriptPath = 'generate_report.py';

// Call the Python script
//exec("$pythonPath $scriptPath", $output, $return_var);

//if ($return_var === 0) {
    // Report generated successfully
  //  echo "Report generated successfully.";
//} else {
    // Error generating report
  //  echo "Error generating report.";
//}
?>

<?php
// Path to the Python script
$pythonScriptPath = 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\generate_report.py';

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

