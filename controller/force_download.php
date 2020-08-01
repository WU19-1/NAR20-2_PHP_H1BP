<?php
    session_write_close();
    $file = "../" . $_POST['path'];
    $name = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']."/controller/downloader.php?path=".$file;
    // echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/controller/download.php?path=" . $file;
    echo "<script>";
    // echo "window.open(\"".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']."/controller/downloader.php?path=".$file."\");";
    echo "var http = require('http');";
    echo "var fs = require('fs');";
    echo "";
    echo "var html = fs.readFileSync(" . $name . ");";
    echo "";
    echo "http.createServer(function (req, res) {";
    echo "    res.writeHead(200, {'Content-Type': 'text/html'});";
    echo "    res.end(html);";
    echo "}).listen(process.env.PORT || 80);";
    echo "history.back();";
    echo "location.reload();";
    echo "</script>";
?>