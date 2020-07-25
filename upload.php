<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPH1BP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="./script/script.js"></script>
</head>
<body>
    <nav class="navbar navbar-light" style="background-color: deepskyblue;">
        <a class="navbar-brand" href="/">
            <strong>File Manager</strong>
        </a>
        
        <div class="form-inline my-2 my-lg-0">
            <div style="padding: 0px 0.7em;">
                <a href="/upload.php" class="btn btn-light">Upload <i class="fa fa-cloud-upload" style="padding : 0;"></i></a>
            </div>
            <form action="">
                <input class="form-control mr-sm-2" type="search" placeholder="Search"></input>
                <button class="btn btn-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <form action="./controller/upload_files.php" class="choose-file" enctype='multipart/form-data' method="post">
        <div class="input-group mb-3 ">
            <div class="custom-file">
                <input type="hidden" name="path" value=<?php echo "\"" . $_SERVER['HTTP_REFERER'] . "\""?>>
                <input type="file" name="files[]" class="custom-file-input" id="upload" onchange="read(this)" multiple>
                <label class="custom-file-label" for="upload">Choose file</label>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width : 2%;">#</th>
                    <th>File name</th>
                    <th>File's size</th>
                </tr>
            </thead>
            <tbody id="file-viewer">
                
            </tbody>
        </table>

        <button type="submit" class="btn btn-success" style="float : right;">Upload</button>
    </form>
    
</body>
</html>