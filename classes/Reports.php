<?php
include_once "../classes/Database.php";
class Reports {
	private $encoders;
	function __construct(){
		$db=new Database();
		$this->conn=$db->getInstance();
	}
	function save($datas,$attachment){
		$feed='ok';
		$qy0=$this->conn->prepare("SELECT * FROM reports WHERE source_link=:link and reportd_date =:reportdate");
		$qy0->execute(array("link"=>$datas['link'],"reportdate"=>$datas['report_date']));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO reports SET source_description=:descr,source_link=:link,report_date=:repdate");
				$qy->execute(array("descr"=>$datas['source_description'],"link"=>$datas['link'],"repdate"=>$datas['report_date']));
			//echo $this->conn->lastInsertId()." - ".json_encode($qy->errorInfo());exit;
				$this->saveAttachment($this->conn->lastInsertId(),$attachment);
				if($qy->rowCount()!=1){
					$feed='fail';
				}
			} else $feed = "exist";
				return $feed;
	}
	
	function saveAttachment($id,$attachment){
		$feed='ok';
		//move files to uplaoded folder
		$attach = $attachment['attachment'];
		$attachmentName = $attach['name']; 
		move_uploaded_file($attach['tmp_name'],"/var/www/html/covid19/uploaded/reports/".$attachmentName);
		//process excel files return array of columns and data

		//update cols for application
		$qy=$this->conn->prepare("UPDATE reports SET attachment=:attachment WHERE company_id=:id");
			$qy->execute(array("id"=>$id,"attachment"=>$attachmentName));
			if($qy->rowCount()!=1){
					$feed='fail';
				}
				return $feed;
	}
	
	function processCSVFileToArray($datas){
		$passedDate = $datas['date'];
		$date = $passedDate;
		$dateConverted = $this->convertDate($date);
		
		$fileArr = $this->getFileName($passedDate);
		$filename = $fileArr['file'];
		$fileDate = $fileArr['date'];
		$fileSource = $fileArr['source'];
		$the_big_array = [];
		$dataArray = []; 

		// Open the file for reading
		if (($h = fopen("{$filename}", "r")) !== FALSE) 
		{
		// Each line in the file is converted into an individual array that we call $data
		// The items of the array are comma separated
		while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
		{
			if($fileSource == "jhu")//johns hopkins
				$dataArray = $this->setLoadedJHUData($data);
			else //worldometer data
				$dataArray = $this->setLoadedWorldOmeterData($data);

				if(trim($dataArray['country']) == '') continue;//skip empty country data
			// Each individual array is being pushed into the nested array
			if($dataArray['country']!="Rwanda")
				$the_big_array[] = $dataArray;		
			else {
				array_unshift($the_big_array,$dataArray);
				$the_big_array[0] = $the_big_array[1];
				$the_big_array[1] = $dataArray;//exchange headers with rwanda data;
				
			}
		}

		// Close the file
		fclose($h);
		}

		// Display the code in a readable format
		//echo "<pre>";
		echo json_encode(["response"=>$the_big_array,"date"=>$fileDate,"source"=>$fileSource]);
		//echo "</pre
		//>";
	}
	function setLoadedWorldOmeterData($data){
		$newArray = array("region"=>$data[0],"country"=>$data[0],"confirmed"=>$data[1].($data[2] != '' ? " (+".$data[2].") ":''),"deaths"=>($data[3] != ''? $data[3]:'0').($data[4] != '' ? " (+".$data[4].") ":''),"recovered"=>($data[5] != ''? $data[5]:'0'),"last_update"=>$data[10],"latitude"=>"0.0","longitude"=>"1.1");
			return $newArray;
	}
	function setLoadedJHUData($data){
		$newArray = array("region"=>$data[0],"country"=>$data[1],"last_update"=>$data[2],"confirmed"=>$data[3],"deaths"=>$data[4],"recovered"=>$data[5],"latitude"=>$data[6],"longitude"=>$data[7]);
		return $newArray;
	}
	function getDataSource($date){
		$dataSource = array("source"=>'jhu',"path"=>'./');
		if($date < "2020-03-24"){//where we changed from JHU to World ometers on 24/03/2020
			$dataSource['path'] = "/var/www/html/covid19/data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports/";    
			$dataSource['source'] = 'jhu';	
		} else {
				$dataSource['path'] = "/var/www/html/covid19/data/COVID-19/worldometers/";    
				$dataSource['source'] = 'worldometers';
			}
			return $dataSource; 
	}
	//get file information to fetch the data
	function getFileName(){
		$date = $_GET['date'];
		$feed = array();
		$newDate = $date;
		$fileArr = $this->getDataSource($date);
		$file = $fileArr['path'].$this->convertDate($newDate).".csv";
		
		while( $date >= date("Y-m-d") && file_exists($file) == 0){
			//echo $newDate."-".(file_exists($file)==0?"0":"1")."<br>";
			$newDate = $this->removeDay($newDate);
			$fileArr = $this->getDataSource($newDate);
			$file = $fileArr['path'].$this->convertDate($newDate).".csv";    
			//$i--;
		}
		if($date != date("Y-m-d") && file_exists($file) == 0){
			echo json_encode(array("response"=>[],"date"=>$date));exit;
		}
		$feed['file'] = $file;
		$feed['date'] = $newDate;
		$feed['source'] = $fileArr['source'];
		return $feed;
	}
	function convertDate($date){
		return date("m-d-Y",strtotime($date));
	}
	function removeDay($date){
		$newDate = date('Y-m-d',strtotime($date)-(3600*24));
		return $newDate;
	}
	function checkCountryExistance($name,$region,$lat,$long){
		$feed = array("country"=>0,"region"=>0);
		$qy0=$this->conn->prepare("SELECT * FROM countries WHERE name=:countryName");
		$qy0->execute(array("countryName"=>$name));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO countries SET name=:name,latitude=:lat,longitude=:long");
				$qy->execute(array("name"=>$name,"lat"=>$lat,"long"=>$long));
			//echo $this->conn->lastInsertId()." - ".json_encode($qy->errorInfo());exit;
			$countryId = $this->conn->lastInsertId();
			$feed['country'] = $countryId;
			if($region!="") $feed['region'] = checkRegionExistance($countryId,$region);
				
			} else {
				$fetch = $qy0->fetchAll("PDO::FETCH_ASSOC");
				$feed['country'] = $fetch[0]['id'];
			if($region!="") $feed['region'] = checkRegionExistance($feed['country'],$region);
			}
	}
	function checkRegionExistance($countryId,$region){
		$feed = 0;
		$qy0=$this->conn->prepare("SELECT * FROM countries WHERE name=:countryName");
		$qy0->execute(array("countryName"=>$name));
		if($qy0->rowCount()==0){
		$qy=$this->conn->prepare("INSERT INTO countries SET name=:name,country_id=:country");
				$qy->execute(array("name"=>$name,"country"=>$countryId));
			//echo $this->conn->lastInsertId()." - ".json_encode($qy->errorInfo());exit;
				$feed = $this->conn->lastInsertId();
			} else {
				$fetch = $qy0->fetchAll(PDO::FETCH_ASSOC);
				$feed = $fetch[0]['id'];

			};
			return $feed;
	}
	function get($datas){
		$qy=$this->conn->prepare("SELECT * FROM reports order by  report_date desc ");
				$qy->execute(array());
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
    function getByDate($datas){
        $qy=$this->conn->prepare("SELECT * FROM reports WHERE report_date=:reportdate");
				$qy->execute(array("reportdate"=>$datas['date']));
				$data=$qy->fetchAll(PDO::FETCH_ASSOC);
				return json_encode($data);
    }
}
?>