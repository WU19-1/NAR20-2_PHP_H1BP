<?php
    include "./controller/directory_func.php";
    $path = '';
    if(!isset($_GET['path']) || strcmp($_GET['path'],"./files/") == 0 || 
        strcmp($_GET['path'],"") == 0){
        $path = "./files/";
    }else{
        $path = $_GET['path'] . "/";
    }

    //directory traversal
    echo $_SERVER['DOCUMENT_ROOT'] . "/files<br>";
    // echo $_SERVER['DOCUMENT_ROOT'] . $path . "<br>";
    $realpath = realpath($_SERVER['DOCUMENT_ROOT']. "/" . $path);
    echo "$realpath<br>";
    echo realpath($path) . "<br>";
    if(strstr($path,"../") !== false){
        $path = "./files/";
    }
    else if(strcmp(basename($path),"") == 0){
        echo "masuk";
        $path = "./files/";
    }
    else if(strpos(realpath($path),$realpath) === false){
        echo "masukv";
        $path = "./files/";
    }


    if((isset($_GET['filter']) && strcmp($_GET['filter'],"") != 0) && (isset($_GET['search']) && strcmp($_GET['search'],"") != 0) ){
        // echo '1';
        $arr = get_directory_with_filter_and_search($path,$_GET['filter'],$_GET['search']);
    }else if((isset($_GET['filter']) && strcmp($_GET['filter'],"") == 0) && (isset($_GET['search']) && strcmp($_GET['search'],"") != 0) ){
        // echo '2';
        $arr = get_directory_with_search($path,$_GET['search']);
    }else if( (isset($_GET['filter']) && strcmp($_GET['filter'],"") != 0) ){
        // echo '3';
        $arr = get_directory_with_filter($path,$_GET['filter']);
    }else{
        // echo '4';
        $arr = get_directory($path);
    }

    // if(!isset($_GET['filter']) || strcmp($_GET['filter'],"") == 0){
    //     $arr = get_directory($path);
    // }if(isset($_GET['filter']) && strcmp($_GET['filter'],"") != 0 && 
    //     (!isset($_GET['search']) || strcmp($_GET['search'],"") == 0 )
    // ){
    //     $arr = get_directory_with_filter($path,$_GET['filter']);
    // }else{
        // $filter = '';
        // if(!isset($_GET['filter'])){
        //     $filter = '';
        // }else{
        //     $filter = $_GET['filter'];
        // }
    //     $arr = get_directory_with_filter_and_search($path,$filter,$_GET['search']);
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPH1BP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        if(isset($_GET)){
            $params = $_GET;
        }
    ?>
    <nav class="navbar navbar-light" style="background-color: deepskyblue;">
        <a class="navbar-brand" href="/">
            <strong>File Manager</strong>
        </a>
        
        <div class="form-inline my-2 my-lg-0">
            <div style="padding: 0px 0.7em;">
                <a href="/upload.php" class="btn btn-light">Upload <i class="fa fa-cloud-upload" style="padding : 0;"></i></a>
            </div>
            <form action="/" method="get">
                <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search"></input>
                <input type="hidden" name="path" value="<?= $path ?>">
                <input type="hidden" name="filter" value="<?= ((isset($_GET['filter'])) ? $_GET['filter'] : '') ?>">
                <button class="btn btn-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="btn-group" style="margin: 1vh 2vw;">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter files by extension
        </button>
        <div class="dropdown-menu" style="padding:0;">
            <?php
                
                $params['filter'] = '';
                $dropdown_href = "http://" . $_SERVER['HTTP_HOST'] . '?' . http_build_query($params);
                echo "<a class=\"dropdown-item\" href=\"" . $dropdown_href . "\">Clear filter</a>";
                echo "<div class=\"dropdown-divider\"></div>";
                foreach ($filetypes as $key) {
                    $params['filter'] = $key;
                    $dropdown_href = "http://" . $_SERVER['HTTP_HOST'] . '?' . http_build_query($params);
                    echo "<a class=\"dropdown-item\" href=\"" . $dropdown_href . "\">" . $key . "</a>";
                }
                $params['filter'] = '';
                "http://" . $_SERVER['HTTP_HOST'] . '?' . http_build_query($params);
                
            ?>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width : 2%;">#</th>
                <th>Name</th>
                <th>Size</th>
                <th>Modified</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $index = 1;
                for ($i = 0 ; $i < count($arr) ; $i++){
                    if(strcmp($arr[$i],".") == 0){
                        continue;
                    }
                    else if(strcmp($path,"./files/") == 0 && strcmp($arr[$i],"..") == 0){
                        continue;
                    }
                    echo "<tr>";
                    echo "    <td>" . ($index) . "</td>";
                    echo "    <td><i class=\"";
                    if(strcmp(mime_content_type($path . $arr[$i]),"text/plain") == 0){
                        echo "fa fa-file-o";
                    }else if(strstr(mime_content_type($path . $arr[$i]),"image")){
                        echo "fa fa-file-photo-o";
                    }else if(strcmp(mime_content_type($path . $arr[$i]),"text/html") == 0){
                        echo "fa fa-file-code-o";
                    }else if(strcmp(mime_content_type($path . $arr[$i]),"directory") == 0){
                        echo "fa fa-folder-o";
                    }else if(strcmp(mime_content_type($path . $arr[$i]),"application/zip") == 0){
                        echo "fa fa-file-zip-o";
                    }

                    if(strcmp($arr[$i],"..") == 0){
                        $new_path = "";
                        $dir_arr = explode( "/",$path );
                        for($j = 0; $j < count( $dir_arr ) - 2; $j++){
                            if($j == count( $dir_arr ) - 3){
                                $new_path = $new_path . $dir_arr[$j];
                            }else{
                                $new_path = $new_path . $dir_arr[$j] . "/";
                            }
                        }
                        echo "\"></i><a id=\"files\" href=\"/?path=" . $new_path . "\">" . $arr[$i] . "</a></td>";
                    }
                    else if(strcmp(mime_content_type($path . $arr[$i]),"directory") == 0){
                        echo "\"></i><a id=\"files\" href=\"/?path=" . $path . $arr[$i] . "\">" . $arr[$i] . "</a></td>";
                    }
                    else{
                        echo "\"></i><span id=\"files\" href=\"/?path=" . $path . $arr[$i] . "\">" . $arr[$i] . "</span></td>";
                    }

                    $full_path = $path . $arr[$i];
                    echo "    <td>" . filesize($full_path) . " bytes</td>";
                    echo "    <td>" .date("d F Y H:i",filemtime($full_path) ) . "</td>";
                    echo "    <td>";
                    echo "        <table class=\"table table-borderless\" style=\"margin:0px;\">";
                    echo "            <thead style=\"float:left;margin:0px;\">";
                    
                    echo "                <th style=\"padding: 0.2em\">";
                    echo "                    <form action=\"./controller/delete_file.php\" class=\"form form-inline\" style=\"width:33%;\" method=\"post\">";
                    echo "                        <input type=\"hidden\" name=\"path\" value=\"" . $full_path . "\">";
                    echo "                        <button class=\"btn btn-outline-danger\" style=\"padding : 0;\"><i class=\"fa fa-remove\"></i></button>";
                    echo "                    </form>";
                    echo "                </th>";
                    
                    if(strcmp(mime_content_type($full_path),"directory") != 0 || strcmp(mime_content_type($full_path),"application/zip") == 0){
                        echo "                <th style=\"padding: 0.2em\">";
                        echo "                    <form action=\"./controller/open_file.php\" class=\"form form-inline\" style=\"width:33%;\" method=\"post\">";
                        echo "                        <input type=\"hidden\" name=\"path\" value=\"" . $full_path . "\">";
                        echo "                        <button class=\"btn btn-outline-secondary\" style=\"padding : 0;\"><i class=\"fa fa-folder-open\"></i></button>";
                        echo "                    </form>";
                        echo "                </th>";
                        $mypath = '../' . $full_path;
                        $name = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https:\/\/" : "http://") . $_SERVER['HTTP_HOST']."/controller/downloader.php?path=".$mypath;
                        echo "                <th style=\"padding: 0.2em\">";
                        echo "                    <a class=\"btn btn-outline-success download\" href=\"$name\" target=\"_blank\" style=\"padding : 0;\"><i class=\"fa fa-download\"></i></a>";
                        echo "                </th>";
                    }
                    
                    echo "            </thead>";
                    echo "        </table>";
                    echo "    </td>";
                    echo "</tr>";
                    $index = $index + 1;
                }
            ?>
        </tbody>
    </table>

</body>
    <script>
        var clicked = false;
        document.getElementsByClassName('dropdown-toggle')[0].addEventListener('click',() => {
            document.getElementsByClassName('dropdown-menu')[0].classList.toggle('show')
            clicked = true
        });
        document.getElementsByTagName('body')[0].addEventListener('click', () => {
            clicked = !clicked
            if(document.getElementsByClassName('dropdown-menu')[0].classList.contains('show') && clicked == true){
                document.getElementsByClassName('dropdown-menu')[0].classList.toggle('show')
                clicked = false
            }
        })
        
    </script>
</html>