<?php
function trackVisits(){
    $count = 0;
    $file = "~/Music/traffic/vists/Visits-".date("Ymd");
    if(file_exists($file)){
        $count = file_get_contents($file);
    }  
  $fop = fopen($file,"w") or die("Error: can't create file");
  fwrite($fop,intval($count)+1);
  fclose($fop);
}
function trackDownloads(){
    $count = 0;
    $file = "~/Music/traffic/downloads/Downloads-".date("Ymd");
    if(file_exists($file)){
        $count = file_get_contents($file);
    }  
  $fop = fopen($file,"w") or die("Error: can't create file ".$file);
  fwrite($fop,intval($count)+1);
  fclose($fop);
}
function downloadApp(){
    header("location:webuse/Irinde.apk");
}
?>