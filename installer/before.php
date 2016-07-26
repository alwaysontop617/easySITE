<?php
session_start();
header('Content-Type: text/event-stream');
// recommended to prevent caching of event data.
header('Cache-Control: no-cache'); 
  
function send_message($id, $message, $progress) {
    $d = array('message' => $message , 'progress' => $progress);
      
    echo "id: $id" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;
      
    ob_flush();
    flush();
}
  
  
//LONG RUNNING TASK
for($i = 1; $i <= 10; $i++) {
    send_message($i, 'Step ' . $i . ' of 10' , $i*10); 
    send_message($i, 'The system will check for folders constantly, do not worry, the system should be done very soon.' , $i*10); 
 if (!file_exists("../data")) { 
send_message(STOP,'The system cannot access the data folder. Please reinstall the system');
} sleep(1);
  if (!file_exists("../system.php")) { 
send_message(STOP,'The system cannot access the data folder. Please reinstall the system');
 }  sleep(1);
   if (!file_exists("../installer")) { 
send_message(STOP,'The system cannot access the data folder. Please reinstall the system');
 } 
 sleep(1);
    if (!file_exists("../plugins")) { 
send_message(STOP,'The system cannot access the data folder. Please reinstall the system');
 } 
 $_SESSION["imokletmein"] = "lol";
  sleep(1);
}
  
send_message('CLOSE', 'Process complete');