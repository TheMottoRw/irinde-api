<?php
include_once "../classes/UrgentLocation.php";
$urgent = new UrgentLocation();

switch($_SERVER['REQUEST_METHOD']){
    case'POST':
        switch($_POST['cate']){
            case 'register':
                echo $urgent->save($_POST,$_FILES);break;
            case 'update':
                echo $urgent->update($_POST);break;
            case 'status':
                echo $urgent->changeStatus($_POST);break;
        }
        break;
        case'GET':
		header("Content-Type:application/json");
		switch($_GET['cate']){
                case 'load':
                    echo $urgent->get($_GET);break;
                case 'loadbyid':
                    echo $urgent->getById($_GET);break;
                    case 'loadbystatus':
                        echo $urgent->getByStatus($_GET);break;
            }
        break;
            default: echo "uknown request method";
}

?>
