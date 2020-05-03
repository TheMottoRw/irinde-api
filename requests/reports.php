<?php
include_once "../classes/Reports.php";
$report = new Reports();
switch($_SERVER['REQUEST_METHOD']){
    case'POST':
        switch($_POST['cate']){
            case 'register':
                echo $report->save($_POST,$_FILES);break;
            case 'process':
                echo $report->processCSVFile($_POST);break;
            case 'processtoarray':
                header("Content-Type:application/json");
                echo $report->processCSVFileToArray($_POST);break;
        }
        break;
        case'GET':
		header("Content-Type:application/json");
		switch($_GET['cate']){
                case 'load':
                    echo $report->get($_GET);break;
                case 'loadbyid':
                    echo $report->getById($_GET);break;
                case 'date':
                    echo $report->getFileDate($_GET['date']);break;
                case 'file':
                    echo $report->getFileToAccess($_GET['date']);break;
                case 'filename':
                    echo $report->getFileName($_GET);break;
                case 'process':
                    echo $report->processCSVFile($_GET);break;
                case 'processtoarray':
                    echo $report->processCSVFileToArray($_GET);break;
                case 'treatment':
                    echo json_encode(["response"=>[array("testing"=>"Gusuzuma biri gukorwa muri Laboratwari \n za leta n’ibikoresho bikoreshwa mu kuyipima","treatment"=>"Ntarukingo cyangwa umuti biraboneka mu kurinda \n cyangwa kuvura COVID-19.\nAbarwayi bitabwaho harwanywa ibimenyetso bagaragaza (gufashwa kuzanzamuka)")]]);break;
            }
        break;
            default: echo "uknown request method";
}

?>
