<!DOCTYPE html>
<?php
include_once "counter.php";
trackVisits();
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta keyword="Kunoza service,amakuru ku mukiriya,Mbwira app,customer service delivery,nayombi" name="description" content="mbwira.rw igufasha kongera services nziza mu buryo bw'ikoranabuhanga wakira amakuru y'uko abakiliye bishimiye service wabahaye">
  <meta name="author" content="Mbwira">


  <title>Mbwira-Landing page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/business-frontpage.css" rel="stylesheet">

</head>
<body>
<style>
/*  h1,h2,p,div{
    font-family:'Times New Roman', Times, serif, 'Arial Narrow Bold', sans-serif;
  }
*/
  h1,h2,p,div{
    font-family:'Lucida Sans';
  }
  h2{
    font-weight: bold;
    margin-top: 10px;
  }
  p,div{
    font-size: 25px;
  }
  ul li a{
    font-weight: bold;
  }
</style>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg fixed-top" style='background-color:#E99521;'>
    <div class="container">
      <a class="navbar-brand" href="#" style='color:white;font-size: 30px;'><img src='webuse/App icon.png' class='img img-thumbnail' style='height:70px;width:80px;'>&nbsp;&nbsp;&nbsp;<b>IRINDE</b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <!--li class="nav-item active">
            <a class="nav-link" href="#" style='color:white'>Home
              <span class="sr-only">(current)</span>
            </a>
          </li-->
          <li class="nav-item">
            <a class="nav-link" href="#aboutservice" style='color:white'>Igitekerezo n'inyunganizi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#aboutservice" style='color:white'>0784634118</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mailto:" style='color:white'>mnzroger@gmail.com</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-successs" style='background-color:#E99521;'><br>
    <div class="container h-100">
      <div class="row h-100 align-items-center" >
        <div class="col-sm-12 col-xs-12">
        </div>
        <div class="col-lg-4">
          <h1 class="display-4 text-white mt-5 mb-2">Irinde App</h1>
          <p class="lead mb-5 text-white" style="font-size: 25px;">Iyi app iragufasha kubona amakuru ajyanye na COVID-19. Uko yandura uko yirindwa nuko wakwitwara igihe wafashwe nayo.</p>
          <a href="https://play.google.com/store/apps/details?id=com.app.mbwira" class="btn btn-success col-lg-12" style="font-weight:bold;font-size:30px"><i class="fa fa-download"></i>Download App</a>
        <div class='alert alert-danger'>NB:Mugihe uyishyira muri telefone emeza install from uknown source</div>
        </div>
        <div class="col-lg-8">
          <img src='webuse/feature banner.png' class='img img-thumbnail' style="height:450px;width:800px">
        </div>
        </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container" id='aboutservice'>

    <div class="row">
      <div class="col-md-6 mb-5" >
        <h2>Uko wakwirinda COVID-19</h2>
        <hr>
        <ul> 
          <li>Irinde kujya ahantu hahurira abantu benshi</li>
          <li>Karaba intoki kenshi umare hagati y'amasegonda 40 na 60 uzikaraba</li>
          <li>Irinde gusuhuzanya muhana ibiganza</li>
            <li>Siga intera ya metero 1 hagati yawe n'abandi</li>
          <a href="http://rbc.gov.rw" class="btn btn-success btn-lg" >Kubindi bisobanuro >> </a>
        </ul>
        </div><div class="col-md-6 mb-5" >
          <h2>Ibimenyetso bya COVID-19 </h2>
          <hr>
          <ul> 
            <li>Kugira Inkorora n'ibicurane</li>
            <li>Guhumeka bigoranye</li>
            <li>Kugira ibicurane</li>
            <li>Kugira Umusonga</li>
            <li> hamagara <b>114</b> igihe wumvise utameze neza</li>
            <a href="http://rbc.gov.rw"  target="_blank" class="btn btn-success btn-lg" >Kubindi bisobanuro >> </a>
          </ul>
          </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-3" style='background-color:#E99521; margin-top: -40px;'>
    <div class="container">
      <p class="m-0 text-center text-white">&copy; KayKen ltd</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.min.js"></script>
  <script src="bootstrap4/js/bootstrap.bundle.min.js"></script>

</body>

</html>
