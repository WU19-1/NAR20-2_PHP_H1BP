<?php
    session_write_close();
    set_time_limit(0);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $file = $_GET['path'];
    header("Content-Description: File Transfer"); 
    header("Content-Type: application/force-download"); 
    header("Content-Transfer-Encoding: Binary");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header("Content-Disposition: attachment; filename=\"". basename($file) ."\"");
    
    $download_rate = 85;

    flush();
    $fp = fopen($file, "r");
    while (!feof($fp))
    {
        print fread($fp, round($download_rate * 1024));
        flush();
        sleep(1);
    }
    fclose($fp);
    // header("Location : " . $_SERVER['HTTP_REFERER']);
        
?>