<?php
/*while($this->getFileToAccess($dateConverted) != 1){
			echo $date ." - ".$dateConverted." - ".$this->getFileToAccess($dateConverted)."\n";
			//if($this->getFileToAccess($dateConverted)!=0) break;
			$date = $this->getFileDate($passedDate);
			$dateConverted = $this->convertDate($date);
			echo $this->getFileToAccess($dateConverted)." == 0".($this->getFileToAccess($dateConverted)==0)."data \n"; 
		if($this->getFileToAccess($dateConverted) != 0){
			echo "file gotten";exit;
		break;
        }
        */
        echo getFileName();
        function oldWorkingGetFilename(){
            $date = $_GET['date'];
        //echo convertDate($date);exit;
        // echo $date;exit;
        $file = "/var/www/html/covid19/data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports/".$date.".csv";
        $newDate = $date;
        while( $date == date("Y-m-d") && file_exists($file) == 0){
            echo $newDate."-".(file_exists($file)==0?"0":"1")."<br>";
            $newDate = removeDay($newDate);
        $file = "/var/www/html/covid19/data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports/".convertDate($newDate).".csv";
            //$i--;
        }
        }
        function getFileName(){
            $date = $_GET['date'];
            $newDate = $date;
            $file = "/var/www/html/covid19/data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports/".convertDate($date).".csv";    
            
            while( $date == date("Y-m-d") && file_exists($file) == 0){
                //echo $newDate."-".(file_exists($file)==0?"0":"1")."<br>";
                $newDate = removeDay($newDate);
                $file = "/var/www/html/covid19/data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports/".convertDate($newDate).".csv";    

                //$i--;
            }
            if($date != date("Y-m-d") && file_exists($file) == 0) return json_encode(array("file"=>"not exist"));
            return $file;
        }
    function removeDay($date){
        // echo $date;exit;
        return date('Y-m-d',strtotime($date)-(3600*24));
    } 
    function convertDate($date){
        return date("m-d-Y",strtotime($date));
    }
?>