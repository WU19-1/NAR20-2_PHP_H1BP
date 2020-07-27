<?php
    session_write_close();
    $file = "../" . $_POST['path'];
    // echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/controller/download.php?path=" . $file;
    echo "<script>";
    echo "window.open(\"".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']."/controller/downloader.php?path=".$file."\");";
//     echo "history.back();";
//     echo "location.reload();";
    echo "</script>";
    header('Location : ' . $_SERVER['HTTP_REFERER']);
?>
