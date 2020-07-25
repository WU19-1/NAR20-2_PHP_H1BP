<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <?php
        $count = 2;
        $path = "http://" . $_SERVER['HTTP_HOST'];
        $_POST['path'] = preg_replace("/\./","",$_POST['path'],1);
        $full_path = $path . $_POST['path'];
        
        // echo $full_path;
        $ch = curl_init($full_path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);

        $response_curl = explode(' ',$response);

        $ct = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if (strstr($ct,"image")){
            echo "<style>";
            echo "    body {";
            echo "        margin:0;";
            echo "        padding:0;";
            echo "        display:flex;";
            echo "        justify-content:center;";
            echo "    }";
            echo "</style>";
        }
        // echo $full_path;
    ?>
</head>
<body>
    <?php
        ini_set('memory_limit',-1);
        
        if (strstr($ct,"image")){
            echo "<img src=\"" . $full_path . "\" />";
        }else if(strstr($ct,"text")){
            $file = readfile($full_path);
            echo $file;
        }
        // else if(strcmp($ct,"directory")){
        //     // tambahin dari http referer
        // }
    ?>
</body>
</html>
