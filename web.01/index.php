<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->

<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Raffstore Control at Schnu</title>
        <link rel="icon" href="data:,">

    </head>

<!--     <body style="background-color: black;color: blue"> -->
<!--    <body style="background-color: black;color: blue;box-sizing: border-box;" > -->
   <body style="background-color: black;color: blue;box-sizing: border-box;" onresize="myFunction()" onload="myFunction()">
<!--     <body style="background-color: black;color: blue;" onresize="myFunction()" onload="myFunction()"> -->
<!--    <!-- On/Off button's picture -->
	<?php
	//select pins
    require 'globals.php';
	echo ( "hi".sizeof($pin_array) );
	echo ( "hi" );
	//this php script generate the first page in function of the file
	for ( $i= 0; $i<sizeof( $pin_array ); $i++) {
//	for ( $i= 0; $i<8; $i++) {
		//set the pin's mode to output and read them
// 		system("gpio mode ".$i." out");
		system("gpio mode ".$pin_array[$i]." out");
		exec ("gpio read ".$pin_array[$i], $val_array[$i], $return );
	}
	//
	function makeButton(int $nr, int $pinStatus, int $buttonWidth) : int {
//             //if off
//             if ($pinStatus == 0 ) {
//                 $buttonColor="red";
//             }
//             //if on
//             if ($pinStatus == 1 ) {
//                 $buttonColor="green";
//             }
            $buttonColor = ( $pinStatus == 1 ? "green" : "red" );

            echo ("<img id='button_".$nr."' src='data/img/".$buttonColor."Button".".png' width=".$buttonWidth."% onclick='change_pin (".$nr.");' />");
//            echo ("<img id='button_".$nr."' src='data/img/".$buttonColor."/".$buttonColor.".jpg' width=".$buttonWidth."% onmousedown='change_pin (".$nr.");' onmouseup='change_pin (".$nr.");'/>");
//            echo ("<img id='button_".$nr."' src='data/img/".$buttonColor."/".$buttonColor."_".$nr.".jpg' width=".$buttonWidth."% onmousedown='change_pin (".$nr.");' onmouseup='change_pin (".$nr.");'/>");
            return 1;
            }
        $width = "<script>document.write(screen.width);</script>";
        $nrCol = intdiv( intval( $width), 190 );
        echo ( ($width+0)." ".intval( $width)." ".$width." ".$nrCol );
	//for loop to read the value
        $i =0;
        echo ("<div style=\"width: 100%\">");
            for ($i = 0; $i < sizeof( $pin_array ) - 1; $i = $i + 2) {
            echo ("<div style=\"width: 20%;float: left;\">");
            makeButton( $i, $val_array[$i][0], 100 );
            makeButton( $i+1, $val_array[$i][0], 100 );
            echo ("</div>");
//              echo ("<h2> hi".$i." </h2>");
//                 echo (" hi ");
            }
        echo ("</div>".$nrCol);

// 	for ($i = 0; $i < 8; $i++) {
// 		//if off
// 		if ($val_array[$i][0] == 0 ) {
// // 			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' onclick='change_pin (".$i.");'/>");
// 			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' width=20% onmousedown='change_pin (".$i.");' onmouseup='change_pin (".$i.");'/>");
// 		}
// 		//if on
// 		if ($val_array[$i][0] == 1 ) {
// // 			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' onclick='change_pin (".$i.");'/>");
// 			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' width=20% onmouseup='change_pin (".$i.");' onmousedown='change_pin (".$i.");'/>");
// 		}
// //                 echo ("<h2> hi </h2>");
// //                 echo (" hi ");
// 	}
	$i=8;
        if ($val_array[$i][0] == 0 ) {
// 			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' onclick='change_pin (".$i.");'/>");
                echo ("<meter id='meter_01' onclick='change_meter ();' value=10 />");
        }
        //if on
        if ($val_array[$i][0] == 1 ) {
// 			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' onclick='change_pin (".$i.");'/>");
                echo ("<meter id='meter_01' onclick='change_meter ();' value=90 />");
        }
	?>
	<!-- javascript -->
	<script src="script.js"></script>

    </body>
</html>
