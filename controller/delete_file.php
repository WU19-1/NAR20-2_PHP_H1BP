<?php
    $path = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
    $_POST['path'] = preg_replace("/\./","",$_POST['path'],1);
    $full_path = $path . $_POST['path'];
    
    // echo "$full_path<br>";
    // $type = mime_content_type($full_path);
    
    // echo $type;

    delete_files($full_path);
    header('Location:' . $_SERVER['HTTP_REFERER']);

    function delete_files($path){
        $type = mime_content_type($path);
        if(strcmp($type,"directory") == 0){
            $files = glob($path . '*', GLOB_MARK);
            foreach ( $files as $key ) {
                delete_files( $key );
            }
            rmdir($path);
        }else {
            unlink($path);
        }
    }

?>