<?php
    if(isset($_FILES['files'])){
        $path = "";
        // var_dump($_FILES['files']);

        $full_path = parse_url($_POST['path']);

        if(!isset($full_path['query'])){
            $path = "../files/";
        }else{
            $splitted = explode('=',$full_path['query']);
            $path = "../" . $splitted[count($splitted) - 1];
        }

        for($i = 0 ; $i < count($_FILES['files']['name']) ; $i++){
            $filename = ($_FILES['files']['name'][$i]);
            // echo $path . $filename . '<br>';
            move_uploaded_file($_FILES['files']['tmp_name'][$i],$path . $filename);
        }
        header("Location:/index.php");
    }
    else{
        header("Location : " . $_SERVER['HTTP_REFERER']);
    }
    
?>