<?php
for ( $i= 0; $i<sizeof( $pin_array ); $i++) {
    //set the pin's mode to output and read them
    system("gpio mode ".$pin_array[$i]." out");
    exec ("gpio read ".$pin_array[$i], $val_array[$i], $return );
}

function makeButton(int $nr, int $pinStatus, int $buttonWidth, $suffix) : int {
    $buttonColor = ( $pinStatus == 1 ? "green" : "red" );

    echo ("<img id='button".$suffix."_".$nr."' src='data/img/".$buttonColor."Button".".png' width=".$buttonWidth."% onclick='change_pin (".$nr.");stopEvent' />");
//            echo ("<img id='button_".$nr."' src='data/img/".$buttonColor."/".$buttonColor.".jpg' width=".$buttonWidth."% onmousedown='change_pin (".$nr.");' onmouseup='change_pin (".$nr.");'/>");
//            echo ("<img id='button_".$nr."' src='data/img/".$buttonColor."/".$buttonColor."_".$nr.".jpg' width=".$buttonWidth."% onmousedown='change_pin (".$nr.");' onmouseup='change_pin (".$nr.");'/>");
    return 1;
}

function makeButtonBox(int $nr, string $BCaption) : int {
  echo("<div name=\"meterBox".$nr."\" id=\"meterBox".$nr."\" class=\"col six\" >");

  echo("</div>");
  return 1;
}

function makeMeterBoxes(int $nr, int $Status) : int {
if( $Status >= 0 ) {
  $borderColor = ( $Status == 0 ? "#7F0000" : "#007F00" );
  echo("<div name=\"meterBox".$nr."\" id=\"meterBox".$nr."\" class=\"col six\" style=\"border-color:".$borderColor."\" data-selected=\"0\" data-active=\"".$Status."\" onclick=\"clickMeterBox(".$nr.");\">");
  for ($i = 0; $i < 2; $i = $i + 1) {
    echo("<div class=\"metercontainer\">");
      echo("<meter name=\"meterG".$nr.$i."\" id=\"meterG".$nr.$i."\" class=\"meter vertical\" value=\"0\" min=\"0\" max=\"100\"> </meter>");
    echo("</div>");
  }
  for ($i = 0; $i < 2; $i = $i + 1) {
    echo("<div class=\"metercontainer\">");
      echo("<meter name=\"meterC".$nr.$i."\" id=\"meterC".$nr.$i."\" class=\"meter vertical\" value=\"0\" min=\"0\" max=\"100\"> </meter>");
    echo("</div>");
  }
//   echo("<input type=\"checkbox\" value=\"1\" >");
//   makeButton( $nr, 0, 40, "2" );
//   makeButton( $nr+1, 0, 40, "2" );
} else {
  echo("<div name=\"meterBox".$nr."\" id=\"meterBox".$nr."\" class=\"col six\" >");
}
echo("</div>");
return 1;
}

?>
