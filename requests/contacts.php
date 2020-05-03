<?php
include_once "../classes/Contacts.php";
$contact = new Contacts();
//echo json_encode($_POST)." - ".json_encode($_FILES);exit;
switch($_SERVER['REQUEST_METHOD']){
    case'POST':
        switch($_POST['cate']){
            case 'register':
                echo $contact->save($_POST);break;
            case 'update':
                echo $contact->update($_POST);break;
        }
        break;
        case'GET':
            header("Content-Type:application/json");
            switch($_GET['cate']){
                case 'load':
                    echo $contact->get($_GET);break;
                case 'loadbyid':
                    echo $contact->getById($_GET);break;
                    case 'list':
                        echo $contact->processList($_GET);break;
            }
        break;
            default: echo "uknown request method";break;
}

?>