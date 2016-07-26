 <!DOCTYPE html>
<html>
    <head>
        
  
        <script>
var es;
  
function startTask() {
    es = new EventSource('installer/before.php');
      
    //a message is received
    es.addEventListener('message', function(e) {
        var result = JSON.parse( e.data );
          
             
       
          if (e.lastEventId == 'STOP') {
               addLog('Error occurred');
        es.close();
        }
        if(e.lastEventId == 'CLOSE') {
            
            es.close();
            var pBar = document.getElementById('progressor');
            pBar.value = pBar.max; //max out the progress bar
           
        }
        else {
            var pBar = document.getElementById('progressor');
            pBar.value = result.progress;
            var perc = document.getElementById('percentage');
            perc.innerHTML   = result.progress  + "%";
            perc.style.width = (Math.floor(pBar.clientWidth * (result.progress/100)) + 15) + 'px';
            
             if (pBar.value == "100") {
              pBar.value = "0";
            
            
              window.location = "index.php?dir";
            
            
          }
        }
    });
      
    es.addEventListener('error', function(e) {
        addLog('Error occurred');
        es.close();
    });
}
  
function stopTask() {
    es.close();
   
}
  
function addLog(message) {
    var r = document.getElementById('results');
    r.innerHTML += message + '<br>';
    r.scrollTop = r.scrollHeight;
}
startTask();
</script>
        <meta charset="utf-8" />
       <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
     
        <center>
           <div class="jumbotron">
  <h1>Your moments away</h1>
  <p>We are checking the installer and verifing everything works.</p>
  <p><span class="glyphicon glyphicon-off"></span>DO NOT EXIT THIS PAGE</p>
  <p>
        <div class="progress" style="width:50%">
        <progress class="progress-bar" id="progressor" role="progressbar"   value="0"  max='100' style="width:100%"></progress>  
        <input type="hidden" id="percentage" style="display:none;text-align:right; display:block; margin-top:5px;">
    </div>
      
  </p>
</div>
            <style>
                .box {
    height: 170px;
    padding: 5px;
}

.box div {
    float: left;
}

.box-image {
    height: 100%;
    position: relative;
    width: 15%;
}

.box-image img {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    position: absolute;
}

.box-image img, .box, .thumbnail img {
    border: 1px solid #d9dbdc;
}

.box-offer-description {
    width: 60%;
}

.box h1, .box h2, .box p {
    margin-top: 5px;
    margin-bottom: 5px;
}

.box-offer-type {
    float: left;
    width: 25%;
    height: 100%;
    padding: 10px;
    border-left: 1px solid #d9dbdc;
    position: relative;
}

.box-offer-type h1 {
    font-size: 2em;
}

.box-controls {
    position: absolute;
    top: 0;
    right: 5px;
}

.box-location-info, .box-contact-info {
    width: 39%;
}

.box-merch-controls {
    width: 5%;
    display: -webkit-box;
    -webkit-box-pack: center;
    -webkit-box-align: center;
    text-align: center;
}

.box-location-info, .box-contact-info, .box-offer-description, .box-offer-type {
    padding-left: 5%;
}

.box-merch-controls .btn {
    padding-top: 2px;
}

.box a {
    font-size: .95em;
}

// .Aligner {
//     display: flex;
//   justify-content: center;
//   align-items: center;
// }
// .Aligner-item {
//     -webkit-box-flex: 1;
//     -webkit-flex: 1;
//     -ms-flex: 1;
//     flex: 1
// }
// .Aligner-item--fixed {
//     -webkit-box-flex: 0;
//     -webkit-flex: none;
//     -ms-flex: none;
//     flex: none;
//     max-width: 50%;
// }

.col-xs-6 .box-offer-type {
    padding-left: 2%;
}

.col-xs-6 .box-controls {
    position: absolute;
    top: 73%;
    right: -12px;
    height: auto !important;
}

.col-xs-6 .box-image img {
    height: 100px;
}

.col-xs-6 .box-offer-type {
    padding: 0;
    padding-right: 5px;
    padding-left: 5px;
}

.col-xs-6 .flex-separate button {
    height: auto !important;
}

.col-xs-6 .box {
    padding-left: 5px;
    margin-top: 5px;
}
.col-xs-6 .box-offer-description{
    padding-left:1%;
}
.col-xs-6 .box-image{
    width:20%;
}
.col-xs-6 .box-offer-description {
  width: 55%;
padding-top:2%
}
.col-xs-6 .box{
    margin-top:10px;
    padding:0;
}
.col-xs-6 .box-offer-type{
padding-top:2%;

}

.col-xs-6 .flex-separate{
    margin:0!important;
}
            </style>
            <center>
            <div class="col-xs-6">
  <div class="box box-offer  ">
    <div class="box-image">
      
    </div>
    <div class="box-offer-description ">

      <h2 class="bold">Buy EasySite Now for $13</h2>
     <p>Unlimited Plugins<br>
     No Branding<br>
     Way Better then the Free</p>
      
    </div>
    
    <div class="box-offer-type">
     
      <h2 class="bold">Amount: <span class="text-active bold medium">$13</span></h2>

      <div class="flex-separate">
        <button type="button" class="btn btn-link btn-md"><i class="fa fa-pencil btn-edit fa-2x"></i></button>
        <button type="button" class="btn btn-link btn-md"><i class="fa fa-trash btn-delete fa-2x"></i></button>
      </div>
    </div>
  </div>
</div>
</center>
        <div id="results" style="border:0px solid #000;  overflow:auto; background:white;"></div>
        <br />
        
    </center>
    </body>
</html>
