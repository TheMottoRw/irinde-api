<?php
include_once "../classes/Database.php";
class Contacts {
	private $encoders;
	function __construct(){
		$db=new Database();
		$this->conn=$db->getInstance();
	}
	function save($datas){
		$feed="ok";
		$qy0=$this->conn->prepare("SELECT emergency_contact.* FROM emergency_contact WHERE contact=:contact and name =:name");
		$qy0->execute(array("contact"=>$datas['contact'],"name"=>$datas['name']));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO emergency_contact SET description=:descr,contact=:contact,name=:name,source=:source");
				$qy->execute(array("descr"=>$datas['description'],"contact"=>$datas['contact'],"name"=>$datas['name'],"source"=>$datas['source']));
				if($qy->rowCount()!=1){
					$feed='fail';
				}
			} else $feed = "exist";
				
				return $feed;
	}
	function get($datas){
		$qy=$this->conn->prepare("SELECT * FROM emergency_contact");
				$qy->execute(array("status"=>$datas['deleted']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
    function getById($datas){
        $qy=$this->conn->prepare("SELECT * FROM emergency_contact WHERE id=:id");
				$qy->execute(array("id"=>$datas['id']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
	}
	function processList($datas){
		//echo $date;exit; 
		$filename = '/var/www/html/covid19/data/mohcontactlist.csv';
		$headers = array("name"=>"","contact"=>"","source"=>"");
		// The nested array to hold all the arrays
		if(!file_exists($filename)) {
			echo json_encode(array("response"=>[]));exit;
		}
		$the_big_array = []; 

		// Open the file for reading
		if (($h = fopen("{$filename}", "r")) !== FALSE) 
		{
		// Each line in the file is converted into an individual array that we call $data
		// The items of the array are comma separated
		while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
		{
			// Each individual array is being pushed into the nested array
			$the_big_array[] = array("name"=>$data[0],"contact"=>$data[1],"source"=>$data[2]);
			//$the_big_array = $data;		
			
		}

		// Close the file
		fclose($h);
		}

		// Display the code in a readable format
		//echo "<pre>";
		echo json_encode(["response"=>$the_big_array]);
	}
    function update($datas){
		$feed='ok';
		$qy0=$this->conn->prepare("SELECT emergency_contact.* FROM emergency_contact WHERE contact=:contact and name =:name");
		$qy0->execute(array("contact"=>$datas['contact'],"name"=>$datas['name']));
		if($qy0->rowCount()==1){
		$qy=$this->conn->prepare("UPDATE emergency_contact SET description=:descr,contact=:contact,name=:name,source=:source where id=:id");
				$qy->execute(array("descr"=>$datas['description'],"contact"=>$datas['contact'],"name"=>$datas['name'],"source"=>$datas['source'],"id"=>$datas['id']));
		        if($qy->rowCount()!=1){
					$feed='fail';
				}
			}else $feed = "notexist";
				return $feed;
	}
}
?>