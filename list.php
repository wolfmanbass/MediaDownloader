<!DOCTYPE html>
<?php //Variables
    $mainPage   = "index.php"; //Rename it only if you change index.php to downloader.php for example 
    $folder     = "youtube/"; // Directory where you videos are downloaded
    $listPage   = 'list.php';
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Youtube-dl WebUI - List of videos</title>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.min.css">
    </head>
    <body >
        <div class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $mainPage; ?>">Youtube-dl WebUI</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo $mainPage; ?>">Download</a></li>
                    <li class="active"><a href="<?php echo $listPage; ?>">List of videos</a></li>
                </ul>
            </div>
        </div>
        <div class="container">
<?php

    //Delete file : 
    if(isset($_GET['fileToDel']))
    {
        $fileToDel = $_GET['fileToDel'];

        if(file_exists($folder.$fileToDel))
        {
            if(unlink($folder.$fileToDel))
            {
                echo '<div class="panel panel-success">';
                echo '<div class="panel-heading"><h3 class="panel-title">Fichier à supprimer : '.$fileToDel.'</h3></div>';
                echo '<div class="panel-body">Le fichier '.$fileToDel.' a été supprimé !</div>';
                echo '</div>';
                echo '<p><a href="'.$listPage.'">Go back</a></p>';
            }
            else{
                echo '<div class="panel panel-danger">';
                echo '<div class="panel-heading"><h3 class="panel-title">Fichier à supprimer : '.$fileToDel.'</h3></div>';
                echo '<div class="panel-body">Le fichier '.$fileToDel.' n\'a pas pu être supprimé !</div>';
                echo '</div>';
                echo '<p><a href="'.$listPage.'">Go back</a></p>';
            }
        }
        else{
            echo '<div class="panel panel-danger">';
            echo '<div class="panel-heading"><h3 class="panel-title">Fichier à supprimer : '.$fileToDel.'</h3></div>';
            echo '<div class="panel-body">Le fichier '.$fileToDel.' ne peut pas être supprimé car il est introuvable !</div>';
            echo '</div>';
            echo '<p><a href="'.$listPage.'">Go back</a></p>';
        }
    }
    else{   ?>
            <h2>List of available videos :</h2>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th style="min-width:800px; height:35px">Title</th>
                        <th style="min-width:80px">Size</th>
                        <th style="min-width:110px">Remove link</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
<?php
        foreach(glob($folder."*") as $file)
        {
            $filename = str_replace($folder, "", $file); // Need to fix accent problem with something like this : utf8_encode
            echo "<tr>"; //New line
            echo "<td height=\"30px\"><a href=\"$folder$filename\">$filename</a></td>"; //1st col
            echo "<td>".human_filesize(filesize($folder.$filename))."</td>"; //2nd col
            echo "<td><a href=\"".$listPage."?fileToDel=$filename\" class=\"text-danger\">Delete</a></td>"; //3rd col
            echo "</tr>"; //End line
        }
    }
?>
                    </tr>
                </tbody>
            </table>
            <br/>
<?php if(!isset($_GET['fileToDel'])) echo "<a href=".$mainPage.">Back to download page</a>"; ?>
        </div>
    </body>
</html>

<?php
    function human_filesize($bytes, $decimals = 0)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
?>
