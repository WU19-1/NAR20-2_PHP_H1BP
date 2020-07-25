<?php
    $arr = array();
    $filetypes = array();
    function get_directory($path){
        global $filetypes,$arr;
        $d = dir($path);
        while (false !== ($entry = $d->read() ) ){
            array_push($arr,$entry);
            if(strcmp($entry,".") != 0 && strcmp($entry,"..") != 0){
                $splitted = explode('.',$entry);
                if(strcmp(mime_content_type(($path . $entry)),"directory") != 0){
                    array_push($filetypes,$splitted[count($splitted) - 1]);
                }
                // array_push($filetypes,$splitted[count($splitted) - 1]);   
            }
        }
        $d->close();
        return $arr;
    }
    function get_directory_with_filter($path,$filter){
        global $filetypes,$arr;
        $d = dir($path);
        while (false !== ($entry = $d->read() ) ){
            if(strcmp($entry,".") != 0 && strcmp($entry,"..") != 0){
                // echo ($path . $entry) . '<br>';
                // echo mime_content_type($path . $entry) . '<br>';
                if(strcmp(mime_content_type(($path . $entry)),"directory") == 0){
                    continue;
                }

                $splitted = explode('.',$entry);
                if(count($splitted) == 1){
                    continue;
                }

                array_push($filetypes,$splitted[count($splitted) - 1]);
                
                if(strcmp(strtolower($splitted[count($splitted) - 1]),strtolower($filter)) == 0){
                    array_push($arr,$entry);
                }
            }
        }
        $d->close();
        return $arr;
    }
    function get_directory_with_search($path,$search){
        global $filetypes,$arr;
        $d = dir($path);
        while (false !== ($entry = $d->read() ) ){
            if(strcmp($entry,".") != 0 && strcmp($entry,"..") != 0){
                if(strcmp(mime_content_type(($path . $entry)),"directory") == 0){
                    continue;
                }

                $splitted = explode('.',$entry);

                if(count($splitted) == 1){
                    continue;
                }

                if(!in_array($splitted[count($splitted) - 1], $filetypes)){
                    array_push($filetypes,$splitted[count($splitted) - 1]);
                }
                
                if(strpos(strtolower($entry),strtolower($search)) !== false){
                    array_push($arr,$entry);
                }
            }
        }
        $d->close();
        return $arr;
    }
    function get_directory_with_filter_and_search($path,$filter,$search){
        global $filetypes,$arr;
        $d = dir($path);
        while (false !== ($entry = $d->read() ) ){
            if(strcmp($entry,".") != 0 && strcmp($entry,"..") != 0){   

                if(strcmp(mime_content_type(($path . $entry)),"directory") == 0){
                    continue;
                }

                $splitted = explode('.',$entry);

                if(count($splitted) == 1){
                    continue;
                }

                if(!in_array($splitted[count($splitted) - 1], $filetypes)){
                    array_push($filetypes,$splitted[count($splitted) - 1]);
                }
                // array_push($filetypes,$splitted[count($splitted) - 1]);
                
                if(strcmp(strtolower($splitted[count($splitted) - 1]),strtolower($filter)) == 0 && strpos(strtolower($entry),strtolower($search)) !== false){
                    array_push($arr,$entry);
                }
            }
        }
        $d->close();
        return $arr;
    }
?>