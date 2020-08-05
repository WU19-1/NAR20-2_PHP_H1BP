<?php
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time','0');
    $path = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
    $_POST['path'] = preg_replace("/\./","",$_POST['path'],1);
    $full_path = $path . $_POST['path'];
    
    // echo $full_path;
    $type = mime_content_type($full_path);
    
    // echo $type;

    delete_files($full_path, $type);
    header('Location:' . $_SERVER['HTTP_REFERER']);
    echo "<script>";
    echo "</script>";

    function delete_files($path, $type){
        if(strcmp($type,"directory") == 0){
            $files = glob($path . '*', GLOB_MARK);
            var_dump($files);
            // echo '<br>';
            foreach ( $files as $key ) {
                delete_files($key, $type);
            }
            echo $path . '<br>';
            if(is_dir($path)){
                rmdir($path);
            }
        }else {
            unlink($path);
        }
    }

?>