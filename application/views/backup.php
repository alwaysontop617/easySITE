<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_POST["ok"])) {
    //form has been submitted
    if (file_exists("bkup.zip")) unlink("bkup.zip");
    // Get real path for our folder
$rootPath = realpath('data');

// Initialize archive object
$zip = new ZipArchive();
$zip->open('bkup.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();

    // or however you get the path
    $yourfile = "bkup.zip";

    $file_name = basename($yourfile);

    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: " . filesize($yourfile));

    readfile($yourfile); 
die();
    
}
?>

<h1>Backups keep your website safe</h1>
Backups are great because the keep your website safe and copied.<br><br>
<form method="post" action="#">
<center><button type="submit" name="ok" class="btn btn-primary"><?php echo $this->lang->line('submit'); ?></button></center>
</form>