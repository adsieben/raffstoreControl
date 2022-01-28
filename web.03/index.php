<?php
  require 'globals.php';
  require 'func.php';
  //create memory files
  system("if [ ! -d \"$memDirectory\" ];then mkdir $memDirectory; fi");
//  system("touch /dev/shm/raffStore/me");
?>

<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->

<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Raffstore Control at Schnu v0.2.202111</title>
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="./default.css">
  </head>
  <style>
  </style>

  <!-- javascript -->
  <script src="script.js"></script>

<!--     <body style="background-color: black;color: blue"> -->
<!--    <body style="background-color: black;color: blue;box-sizing: border-box;" > -->
  <body style="background-color: black;color: blue;box-sizing: border-box;" onresize="myFunction()" onload="myFunction()">
<!--     <body style="background-color: black;color: blue;" onresize="myFunction()" onload="myFunction()"> -->
      <div class="base">
        <?php
          $bc = ( $val_array[21][0] == 0? "#7F0000" : "#007F00" );
          echo("<div name=\"Power\" id=\"Power\" class=\"col six\" style=\"color:white;border-color:".$bc."\" onclick=\"Power(0)\">");
        ?>
          Power
        </div>
        <?php
//           makeButtonBox(99, "Power" );
          makeMeterBoxes(14, $val_array[14][0] + $val_array[15][0] );
          makeMeterBoxes(12, $val_array[12][0] + $val_array[13][0] );
          makeMeterBoxes(10, $val_array[10][0] + $val_array[11][0] );
          makeMeterBoxes( 8, $val_array[8 ][0] + $val_array[ 9][0] );
//           makeButtonBox(98, "Control" );
        ?>
        <?php
          $bc = ( $val_array[20][0] == 0? "#7F0000" : "#007F00" );
          echo("<div name=\"Control\" id=\"Control\" class=\"col six\" style=\"color:white;border-color:".$bc."\" onclick=\"Power(1)\">");
        ?>
<!--         <div name="Control" id="Control" class="col six" style="color:white" onclick="Power(1)" > -->
          Control
        </div>
        <div class="col stackSix">
          <?php
            makeMeterBoxes(16, $val_array[16][0]+$val_array[17][0] );
            makeMeterBoxes(18, $val_array[18][0]+$val_array[19][0] );
//             makeMeterBoxes(97, -1 );
//             makeMeterBoxes(96, -1 );
          ?>
          <div name="selectAll" id="selectAll" class="col six" style="color:white" onclick="selectAllMB(1)" >
            All
          </div>
          <div name="selectAll" id="selectAll" class="col six" style="color:white" onclick="selectAllMB(0)" >
            None
          </div>
        </div>
        <div class="col stackSixFourFour">
<!--           <form > -->
            <div class="slidecontainer">
              <input type="range" min="0" max="100" value="50" class="vertical"
                orient="vertical"  onchange="changeRange(0)" name="range0" id="range0">
            </div>
            <div class="slidecontainer">
              <input type="range" min="0" max="100" value="50" class="vertical"
                orient="vertical"  onchange="changeRange(1)" name="range1" id= "range1">
            </div>
            <div class="slidecontainer">
              <input type="number" id="quantity0" name="quantity0" min="1" max="100">
              <input type="number" id="quantity1" name="quantity1" min="1" max="100">
              <button class="btn submit2" onclick="submitting( 0 )">set</button>
              <button class="btn submit2" onclick="submitting( 1 )">submit</button>
              <div id="text1">
              </div>
            </div>
<!--           </form> -->

        </div>
        <div class="col stackSix">
          <?php
            makeMeterBoxes(  6, $val_array[6][0]+$val_array[7][0] );
            makeMeterBoxes(  4, $val_array[4][0]+$val_array[5][0] );
            makeMeterBoxes(  2, $val_array[2][0]+$val_array[3][0] );
            makeMeterBoxes(  0, $val_array[0][0]+$val_array[1][0] );
          ?>
        </div>
        <script>
          <?php
            for ($i = 0; $i < sizeof( $pin_array ) - 1; $i = $i + 2) {
              if( $i < 20 ){
                echo("raffStoreList.set(".$i.", new raffStore(".$i.",".$pin_array[$i].",".$pin_array[$i+1].","."0".","."0"."));");
              }
            }
          ?>
          fetchCurrentValues();
        </script>

      <div class="button-container">
<!-- https://www.w3schools.com/howto/howto_js_todolist.asp -->
<!--<div id="myDIV" class="header">
  <h2 style="margin:5px">My To Do List</h2>
  <input type="text" id="myInput" placeholder="Title...">
  <span onclick="newElement()" class="addBtn">Add</span>
</div>

<ul id="myUL">
  <li>Hit the gym</li>
  <li class="checked">Pay bills</li>
  <li onclick="newElement()">Meet George</li>
  <li>Buy eggs</li>
  <li>Read a book</li>
  <li>Organize office</li>
</ul>-->

<!-- https://www.w3schools.com/howto/howto_css_dropdown.asp -->
      <div class="dropdown">
            <button class="btn-loadConfig dropbtn" id="load-btn" name="load-btn" onclick="fetchConfigs(-1)">Load</button>
<!--             <button class="dropbtn">Dropdown</button> -->
            <div class="dropdown-content" id="ddconfig" name="ddconfig" >
              <span >no config found</span>
<!--               <a>no config found</a> -->
            </div>
          </div>
          <button class="btn-saveConfig" id="save-btn" name="save-btn" onclick="saveConfig()">Save</button>
        </div>
      </div>

      <script>
        fetchConfigs(-1);
      </script>

      <div style="height:200px; width:10%; border-style:solid; overflow: scroll; position:fixed" class="b0" >
        <div class="b1">
        </div>
      </div>


	<?php
//         //doesnot work, because php-script runs on server
//         //and has no idea, how big the screen is on the client device
//         $width = "<script>document.write(screen.width);</script>";
//         $nrCol = intdiv( intval($width), 190 );
//         echo ( ($width+0)." ".intval($width)."  -".$width."- ".$nrCol );
	//for loop to read the value
        $i =0;
        echo ("<div style=\"width: 100%\">");
        for ($i = 0; $i < sizeof( $pin_array ) - 1; $i = $i + 2) {
            echo ("<div style=\"width: 20%;float: left;\">");
            makeButton( $i,  $val_array[$i][0]  , 100, "" );
            makeButton( $i+1,$val_array[$i+1][0], 100, "" );
            echo ("</div>");
        }
        echo ("</div>");
	?>
        <p> screen.width=<script>document.write(screen.width);</script>
            screen.height=<script>document.write(screen.height);</script></p>

    </body>
</html>
