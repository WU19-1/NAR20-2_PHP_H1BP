<?php
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time','0');
    $path = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
    $_POST['path'] = preg_replace("/\./","",$_POST['path'],1);
    $full_path = $path . $_POST['path'];
    
    // echo "$full_path<br>";
    // $type = mime_content_type($full_path);
    
    // echo $type;

    delete_files($full_path);

    function delete_files($path){
        $type = mime_content_type($path);
        if(strcmp($type,"directory") == 0){
            $files = glob($path . './*', GLOB_MARK);
            foreach ( $files as $key ) {
                unlink($key);
            }
            if(is_dir($path)){
                rmdir($path);
                echo "masuk";
            }
            echo "done";
            // header('Location:' . $_SERVER['HTTP_REFERER']);
        }else {
            unlink($path);
            // header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

?>