<?php
include_once "../classes/Notices.php";
$notice = new Notices();
switch($_SERVER['REQUEST_METHOD']){
    case'POST':
        switch($_POST['cate']){
            case 'register':
                echo $notice->save($_POST,$_FILES);break;
            case 'update':
                echo $notice->update($_POST,$_FILES);break;
            case'status':
                echo $notice->changeNoticeStatus($_POST);break;
        }
        break;
        case'GET':
		header("Content-Type:application/json");
		switch($_GET['cate']){
                case 'load':
                    echo $notice->get($_GET);break;
                case 'loadbyid':
                    echo $notice->getById($_GET);break;
            }
        break;
            default: echo "uknown request method";
}

?>
