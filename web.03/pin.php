<?php
require 'globals.php';
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
if (isset ( $_GET["action"] )) {
  $action = strip_tags ($_GET["action"]);
  if ( $action=="getCurrentValues" ) {
    $output=null;
    $retval=null;
//     exec("cat /dev/shm/raffStore.ad7/currentvalues.dat | grep -v -E '^#|^-' | awk '{ print $1\" \"$6 }'", $output, $retval);
//     exec("cat /dev/shm/raffStore.ad7/currentvalues.dat | awk '{ print $1\" \"$6 }'", $output, $retval);
//     exec("sleep 1;cat /dev/shm/raffStore.ad7/currentvalues.dat | grep -v -E '^#|^-' ", $output, $retval);
//     system("echo setRSPerc"." > /dev/shm/a.txt");
    exec("cat ".$memDirectory."currentvalues.dat | grep -v -E '^#|^-' ", $output, $retval);
//     echo "Returned with status $retval and output:\n";
//     print_r($output);
    echo json_encode($output);
//     echo $action;
  } elseif ( $action=="setRSPerc" ) {
    $rsID=strip_tags ($_GET["rsId"]);
    $hVal=strip_tags ($_GET["hVal"]);
    $aVal=strip_tags ($_GET["aVal"]);
    $output=null;
    $retval=null;
    exec("cd ./bin; ./setPinPerc.sh ".$rsID." ".$hVal." ".$aVal, $output, $retval);
    echo $retval;
//     system("echo ".$rsID." ".$hVal." ".$aVal." > /dev/shm/a.txt");
//     echo (json_encode("Got you ".$rsID." ".$hVal." ".$aVal));
//     echo ("Got ".$rsID." ".$hVal." ".$aVal);
  } elseif ( $action=="getConfig" ) {
    $fileName=strip_tags ($_GET["name"]);
//     $output=null;
//     $retval=null;
//     exec("ls -lh ".$configDir.$fileName, $output, $retval);
    $content = trim(file_get_contents($configDir.$fileName));
    echo json_encode($content);
  } elseif ( $action=="getConfigs" ) {
    $output=null;
    $retval=null;
    exec("ls -1 ".$configDir, $output, $retval);
    echo json_encode($output);
  } else {
    echo ("fail get");
  }
} else {
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  if ($contentType === "application/json") {
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    $decoded = json_decode($content, true);

    //If json_decode failed, the JSON is invalid.
    if(! is_array($decoded)) {
      echo json_encode([
        'value' => 0,
        'error' => 'Received JSON is improperly formatted' ,
        'data' => null,
      ]);
    } else {
      $action = $_POST['postaction'] ?? 'default';
      $action = $_GET['postaction'] ?? 'default';
//       $output=null;
//       $retval=null;
//     [11] => Array
//         (
//             [key] => name
//             [data] => schnuIstDerBeste
//         )
//       $myA=array();
//       foreach( $decoded as $x => $x_val ){
//         foreach( $x_val as $xx => $xx_val ){
//           $myA .= "  xkey is:".$xx." xxvalue is:".$xx_val."\n";
//         }
//         $myA .= "key is:".$x." value is:".$x_val."\n";
//       }
//       $myA=array();
//       function myFunc($value,$key)
//       {
//         echo "The key $key has the value $value<br>";
//       }
//       array_walk_recursive($decoded,"myFunc");
//       foreach( $decoded as $x => $x_val ){
//         foreach( $x_val as $xx => $xx_val ){
//           if( $xx_val == 'name' ) {
//             $fileName = $x_val['data'];
//           }
//         }
//       }

//       $file = $_SERVER['DOCUMENT_ROOT'] . '/association/data.txt';
//       $file = "./data/settings/initValues.txt";
//       $file = $configDir."tmp.txt";
      if( ! isset( $_GET['fileName'] ) ) {
        echo json_encode([
          'value' => 0,
          'error' => 'no file name' ,
          'data' => null,
        ]);
      } else {
//         $fileNamea = $_POST['fileName'];
//         $fileName = $_GET['fileName'];
        $fileName = $_REQUEST['fileName'];
        $file = $configDir.$fileName;
        file_put_contents($file,$content);
  //       file_put_contents($file,$decoded);
  //       $current = file_get_contents($file);

  //       exec("", $output, $retval);
  //       echo $retval;
  //       echo "got loadConfig";
//         $data = "wrote ".$fileName.$_POST['fileName'];
         $data = "wrote to ".$fileName.$_REQUEST['fileName'];
        echo json_encode([
          'value' => 1,
          'error' => null,
  //         'data' => $decoded['name'],
  //         'data' => $content['name'],
  //         'data' => $content,
//           'data' => $data,
          'data' => $_REQUEST,
  //         'data' => $current,
        ]);
      }
    }
  }
//   $json = file_get_contents('php://input');
// //     $data = json_decode($json);
//     echo $json;
// //   echo ("fail");
}


// $output=null;
// $retval=null;
// exec('whoami', $output, $retval);
// echo "Returned with status $retval and output:\n";
// print_r($output);


// /**
//  * receive_body___send_response.php
//  */
// <!-- https://stackoverflow.com/questions/33439030/how-to-grab-data-using-fetch-api-post-method-in-php -->
//
// /* Get content type */
// $contentType = trim($_SERVER["CONTENT_TYPE"] ?? ''); // PHP 8+
// // Otherwise:
// // $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//
// /* Send error to Fetch API, if unexpected content type */
// if ($contentType !== "application/json")
//   die(json_encode([
//     'value' => 0,
//     'error' => 'Content-Type is not set as "application/json"',
//     'data' => null,
//   ]));
//
// /* Receive the RAW post data. */
// $content = trim(file_get_contents("php://input"));
//
// /* $decoded can be used the same as you would use $_POST in $.ajax */
// $decoded = json_decode($content, true);
//
// /* Send error to Fetch API, if JSON is broken */
// if(! is_array($decoded))
//   die(json_encode([
//     'value' => 0,
//     'error' => 'Received JSON is improperly formatted',
//     'data' => null,
//   ]));
//
// /* NOTE: For some reason I had to add the next line as well at times, but it hadn't happen for a while now. Not sure what went on */
// // $decoded = json_decode($decoded, true);
//
// /* Do something with received data and include it in response */
// // dumb e.g.
// $response = $decoded['key2'] + 1; // 3
//
// /* Perhaps database manipulation here? */
// // query, etc.
//
// /* Send success to fetch API */
// die(json_encode([
//   'value' => 1,
//   'error' => null,
//   'data' => null, // or ?array of data ($response) you wish to send back to JS
// ]));
//
//
// <!-- https://codepen.io/dericksozo/post/fetch-api-json-php -->
// $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//
// if ($contentType === "application/json") {
//   //Receive the RAW post data.
//   $content = trim(file_get_contents("php://input"));
//
//   $decoded = json_decode($content, true);
//
//   //If json_decode failed, the JSON is invalid.
//   if(! is_array($decoded)) {
//
//   } else {
//     // Send error back to user.
//   }
// }

?>
