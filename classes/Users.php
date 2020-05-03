<?php
include_once "../classes/Database.php";
class Users {
	private $encoders;
	function __construct(){
		$db=new Database();
		$this->conn=$db->getInstance();
    }
    function adminExistance(){
        $feed='ok';
		$qy0=$this->conn->prepare("SELECT * FROM administration WHERE username=:info");
		$qy0->execute(array("info"=>'appcovidrw'));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO administration SET names=:name,username=:uname,password=:pwd,status=:status");
				$qy->execute(array("name"=>"Rwanda Covid-19 broadcast","uname"=>"appcovidrw","pwd"=>base64_encode("RwCovid19"),"status"=>"enabled"));
			if($qy->rowCount()!=1){
				$feed='fail';
				echo json_encode($qy->errorInfo());
			}
			} else $feed = "exist";
				return $feed;
    }
    function login($datas){
		$this->adminExistance();
        $feed=array("category"=>"none","status"=>"fail","sessid"=>"0");

		$qy=$this->conn->prepare("SELECT * FROM administration WHERE username=:uname and password=:pwd");
		$qy->execute(array("uname"=>$datas['username'],"pwd"=>base64_encode($datas['password'])));
		
		//check admin login
		if($qy->rowCount()==1){//admin login
					$fetch = $qy->fetchAll(PDO::FETCH_ASSOC);
					$feed=array("category"=>"admin",'status'=>"success","sessid"=>$fetch[0]['id']);
                }
				return json_encode($feed);
    }
	function save($datas){
		$feed='ok';
		$qy0=$this->conn->prepare("SELECT * FROM administration WHERE username=:username");
		$qy0->execute(array("username"=>$datas['username']));
		if($qy0->rowCount()==0){
			$qy=$this->conn->prepare("INSERT INTO administration SET names=:name,username=:uname,password=:pwd,status=:status");
			$qy->execute(array("name"=>$datas['names'],"uname"=>$datas['username'],"pwd"=>base64_encode($datas['password']),"status"=>"enabled"));
			} else $feed = "exist";
				if($qy->rowCount()!=1){
					$feed='fail';
				}
				return $feed;
	}
	
	function saveAttachment($id,$attachment){
		
	}

	function get($datas){
		$qy=$this->conn->prepare("SELECT * FROM administration");
				$qy->execute(array());
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
    function getById($datas){
        $qy=$this->conn->prepare("SELECT * FROM administration WHERE id=:id and status!=:status");
				$qy->execute(array("id"=>$datas['userid'],"status"=>'deleted'));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
    function update($datas){
		$feed='ok';
        $qy=$this->conn->prepare("UPDATE administration SET names=:name,username=:uname,password=:pwd,status=:status WHERE id=:id");
			$qy->execute(array("name"=>$datas['names'],"uname"=>$datas['username'],"pwd"=>base64_encode($datas['password']),"status"=>"enabled","id"=>$datas['id']));
	        if($qy->rowCount()!=1){
					$feed='fail';
				}
				return $feed;
	}

	function delete($datas){
		$feed='ok';
		$qy=$this->conn->prepare("UPDATE administration SET status=:status WHERE id=:id'");
				$qy->execute(array("status"=>'deleted',"id"=>$datas['id']));
				if($qy->rowCount()!=1){
					$feed='fail';
				}
				return $feed;
	}
}
?>