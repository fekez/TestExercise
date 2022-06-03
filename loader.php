<?php
if(file_exists("Controllers/LoaderController.php"))
{
    include_once("Controllers/LoaderController.php");
}

if(true){
    $loaderController = new LoaderController();
    $loaderController->loader("2022-06-03");
}