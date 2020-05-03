<?php
include_once "../classes/Database.php";
class UrgentLocation {
	private $encoders;
	function __construct(){
		$db=new Database();
		$this->conn=$db->getInstance();
	}
	function save($datas){
		$feed='ok';
		$qy0=$this->conn->prepare("SELECT * FROM urgent_reported_location WHERE names=:name and phone=:phone and latitude =:lat and longitude =:long and description=:descr");
		$qy0->execute(array("name"=>$datas['name'],"phone"=>$datas['phone'],"lat"=>$datas['latitude'],"long"=>$datas['lonitude'],"descr"=>$datas['description']));
		    if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO urgent_reported_location SET names=:name, phone=:phone,latitude =:lat, longitude =:long,description=:descr,status=:status");
		$qy->execute(array("name"=>$datas['name'],"phone"=>$datas['phone'],"lat"=>$datas['latitude'],"long"=>$datas['longitude'],"descr"=>$datas['description'],"status"=>"pending"));
				if($qy->rowCount()!=1){
					$feed='fail '.json_encode($qy0->errorInfo());
				}
			} else $feed = "exist ";
				    
				return $feed;
	}
	
	function get($datas){
		$qy=$this->conn->prepare("SELECT * FROM urgent_reported_location WHERE status=:status");
				$qy->execute(array("status"=>"pending"));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode(array("response"=>$data));
    }
    function getById($datas){
        $qy=$this->conn->prepare("SELECT * FROM urgent_reported_location WHERE id=:id");
				$qy->execute(array("id"=>$datas['id']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
    function getByStatus($datas){
        $qy=$this->conn->prepare("SELECT * FROM urgent_reported_location WHERE status=:status");
				$qy->execute(array("status"=>$datas['status']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }

	function changeStatus($datas){
		$feed='ok';
		$qy=$this->conn->prepare("UPDATE urgent_reported_location SET status=:status WHERE id=:id");
				$qy->execute(array("status"=>$datas['status'],"id"=>$datas['id']));
				    if  ($qy->rowCount()!=1){
						 echo json_encode($qy->errorInfo());
					$feed='fail';
				}
				return $feed;
	}
}
?>
