<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->

<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Schnu's Raffstore Development Playground</title>

<style>
* {
  box-sizing: border-box;
}

.row::after {
  content: "";
  clear: both;
  display: table;
}

[class*="col-"] {
  float: left;
  padding: 15px;
  border solid red;
}

.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}

html {
  font-family: "Ubuntu", sans-serif;
}

.header {
  background-color: #9933cc;
  color: #ffffff;
  padding: 15px;
}

.menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.menu li {
  padding: 8px;
  margin-bottom: 7px;
  background-color: #33b5e5;
  color: #ffffff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.menu li:hover {
  background-color: #0099cc;
}

.myDiv {
  border: 5px outset red;
  background-color: lightblue;
}
</style>

    </head>

<!--     <body style="background-color: black;color: blue"> -->
    <body style="background-color: black;color: blue" onresize="myFunction()" onload="myFunction()">

<div class="header">
  <h1>Chania</h1>
</div>


<div class="row">
    <div class="col-2 menu">
    <ul>
        <li>The Flight</li>
        <li>The City</li>
        <li>The Island</li>
        <li>The Food</li>
    </ul>
    </div>

    <div class="col-2 menu">
        <ul>
        <li>The light</li>
        <li>The City</li>
        <li>The Island</li>
        <li>The Food</li>
        </ul>
    </div>

    <div class="col-8">
        <h1>The City</h1>
        <p>Chania is the capital of the Chania region on the island of Crete. The city can be divided in two parts, the old town and the modern city.</p>
        <p>Resize the browser window to see how the content respond to the resizing.</p>
    </div>
</div>




<div class="myDiv" style="width: 10cm;" >
  <h2>1 This is a heading in a div element</h2>
  <p>This is some text in a div element.</p>
</div>
<div class="myDiv" style="width: 30vw;" >
  <h2>2 This is a heading in a div element</h2>
  <p>This is some text in a div element.</p>
</div>
<div class="myDiv" style="width: 30vw;" >
  <h2>3 This is a heading in a div element</h2>
  <p>This is some text in a div element.</p>
</div>

<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" style="width: 10cm; border: 5px outset white;" >
<!--   <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31"> -->
  <p> 1 Hello </p>
</div>
<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" style="width: 10cm; border: 5px outset white;" >
<!--   <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31"> -->
  <p> 2 Hello </p>
</div>
<div class="myDiv">
  <h2>This is a heading in a div element</h2>
  <p>This is some text in a div element.</p>
</div>
<?php
//-- you can modified it like you want

echo $width = "<script>document.write(screen.width);</script>"." ";
echo $height = "<script>document.write(screen.height);</script>"."</br>";
echo $devxwidth = "<script>document.write(screen.deviceXDPI);</script>"." ";
echo $devxwidth = "<script>document.write(screen.deviceYDPI);</script>";
echo "<h2>".$width." ist das Geil?</h2>";
?>
<?php
  $clientProps=array('screen.width','screen.height','window.innerWidth','window.innerHeight',
    'window.outerWidth','window.outerHeight','screen.colorDepth','screen.pixelDepth');

  if(! isset($_POST['screenheight'])){

    echo "Loading...<form method='POST' id='data' style='display:none'>";
    foreach($clientProps as $p) {  //create hidden form
      echo "<input type='text' id='".str_replace('.','',$p)."' name='".str_replace('.','',$p)."'>";
    }
    echo "<input type='submit'></form>";

    echo "<script>";
    foreach($clientProps as $p) {  //populate hidden form with screen/window info
      echo "document.getElementById('" . str_replace('.','',$p) . "').value = $p;";
    }
    echo "document.forms.namedItem('data').submit();"; //submit form
    echo "</script>";

  }else{

    echo "<table>";
    foreach($clientProps as $p) {   //create output table
      echo "<tr><td>".ucwords(str_replace('.',' ',$p)).":</td><td>".$_POST[str_replace('.','',$p)]."</td></tr>";
    }
    echo "</table>";
  }
?>
<script>
    window.history.replaceState(null,null); //avoid form warning if user clicks refresh
</script>
   <p style="color: white;">
    Try to resize the page.
   </p>
   <p id="demo">
    &nbsp;
   </p>
<!--    <!-- On/Off button's picture -->
	<?php
        require '../globals.php';
	$val_array = array(0,0,0,0,0,0,0,0,0);
	//this php script generate the first page in function of the file
	for ( $i= 0; $i<8; $i++) {
		//set the pin's mode to output and read them
// 		system("gpio mode ".$i." out");
		system("gpio mode ".$pin_array[$i]." out");
		exec ("gpio read ".$pin_array[$i], $val_array[$i], $return );
	}
	//for loop to read the value
	$i =0;
	for ($i = 0; $i < 8; $i++) {
		//if off
		if ($val_array[$i][0] == 0 ) {
// 			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' onclick='change_pin (".$i.");'/>");
			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' width=100vw onmousedown='change_pin (".$i.");' onmouseup='change_pin (".$i.");'/>");
		}
		//if on
		if ($val_array[$i][0] == 1 ) {
// 			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' onclick='change_pin (".$i.");'/>");
			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' width=100vw onmouseup='change_pin (".$i.");' onmousedown='change_pin (".$i.");'/>");
		}
//                 echo ("<h2> hi </h2>");
                echo (" hi ");
	}
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
	<script src="../script.js"></script>-->
	<script src="pg.js"></script>-->

    </body>
</html>
