<?php
include_once "../classes/Users.php";
$users = new Users();
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        switch($_POST['cate']){
            case 'register':
                echo $users->save($_POST);break;
            case 'login':
                    echo $users->login($_POST);break;
            case 'update':
                echo $users->update($_POST);break;
            case 'deLete':
                echo $users->delete($_POST);break;
        }
        break;
        case'GET':switch($_GET['cate']){
                case 'load':
                    echo $users->get($_GET);break;
                case 'update':
                    echo $users->getById($_GET);break;
            }
        break;
            default: echo "uknown request method";
}

?>