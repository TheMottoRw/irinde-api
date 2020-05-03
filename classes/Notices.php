<?php
include_once "../classes/Database.php";
class Notices {
	private $encoders;
	function __construct(){
		$db=new Database();
		$this->conn=$db->getInstance();
	}
	function save($datas,$files){
		$feed='ok';$atnid = 0;
	
				$qy0=$this->conn->prepare("SELECT * FROM notices WHERE source_description=:source and message=:msg");
		$qy0->execute(array("msg"=>$datas['message'],"source"=>$datas['source']));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO notices SET sender=:sender,source_description=:source,source_link=:link,message=:msg,attachment=:attachment");
				$qy->execute(array("sender"=>$datas['sender'],"source"=>$datas['source_description'],"link"=>$datas['link'],"msg"=>$datas['message'],"attachment"=>$datas['attachment']));
				//$this->saveNoticeAttachments($this->conn->lastInsertId(),$files);
				if($qy->rowCount()!=1){
					$feed='fail';
					echo $noticeId." - ".json_encode($qy->errorInfo());
				}
			} else $feed = "exist";
				
				return $feed;
	}
	function saveNoticeAttachments($id,$attachments){
		$feed='ok';
		//move files to uplaoded folder
		$photo = $attachments['attachment']; 
		move_uploaded_file($photo['tmp_name'],"uploaded/notices/",$photo['name']);

		//update cols for application
		$qy=$this->conn->prepare("UPDATE notices SET attachment=:photo WHERE notice_id=:id");
			$qy->execute(array("photo"=>stripslashes($photo['name']),"id"=>$id));
			if($qy->rowCount()!=1){
				echo json_encode($qy->errorInfo());
					$feed='fail';
				}
				return $feed;
	}
	
	function sendToEmail(){}

	function get($datas){
		$qy=$this->conn->prepare("SELECT * FROM notices order by notice_id desc");
				$qy->execute(array());
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode(array("response"=>$data));
    }
    function getById($datas){
        $qy=$this->conn->prepare("SELECT * FROM notices WHERE notice_id=:id");
				$qy->execute(array("id"=>$datas['id']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode(array("response"=>$data));
    }

	function changeNoticeStatus($datas){
		$feed='ok';
		$qy=$this->conn->prepare("UPDATE notices SET status=:status where notice_id=:id");
				$qy->execute(array("status"=>$datas['status'],"id"=>$datas['id']));
				if($qy->rowCount()!=1){
					$feed='fail';
				}
				return $feed;
	}
	function update($datas,$files){
		$feed='ok';$atnid = 0;
	
				$qy0=$this->conn->prepare("SELECT * FROM notices WHERE notice_id=:id");
		$qy0->execute(array("id"=>$datas['id']));
		if($qy0->rowCount()==1){
		$qy=$this->conn->prepare("UPDATE notices SET sender=:sender,source_description=:source,source_link=:link,message=:msg,attachment=:attach where notice_id=:id");
				$qy->execute(array("sender"=>$datas['sender'],"source"=>$datas['source_description'],"link"=>$datas['link'],"msg"=>$datas['message'],"attach"=>$datas['attachment'],"id"=>$datas['id']));
				//$this->saveNoticeAttachments($datas['id'],$files);
				if($qy->rowCount()!=1){
					$feed='fail';
					echo $noticeId." - ".json_encode($qy->errorInfo());
				}
			} else $feed = "notexist";
				
				return $feed;
	}
}
?>
