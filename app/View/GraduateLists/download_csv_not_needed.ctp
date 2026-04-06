<?php
/* if (!empty($graduateLists)) {
    
    $line = $graduateLists[0]['GraduateList'];
    $this->CSV->addRow(array_keys($line));

    foreach ($graduateLists as $graduateList) {
        $line = $graduateList['GraduateList'];
        $this->CSV->addRow($line);
    }
    echo  $this->CSV->render($filename);
} */

if (!empty($graduateLists)) {
    // Get the keys from the first row to use as the CSV header
    $header = array_keys($graduateLists[0]['GraduateList']);
    $this->CSV->addRow($header);

    // Iterate through the graduate lists and add each row to the CSV
    foreach ($graduateLists as $graduateList) {
        $this->CSV->addRow($graduateList['GraduateList']);
    }

    // Generate the CSV content
    $csvContent = $this->CSV->render(false); // Pass `false` to prevent headers from being sent

    // Set headers to force download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output the CSV content
    echo $csvContent;
    exit; // Stop further execution
}
