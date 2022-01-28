//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi

//These are all the buttons
// var button_0 = document.getElementById("button_0");
// var button_1 = document.getElementById("button_1");
// var button_2 = document.getElementById("button_2");
// var button_3 = document.getElementById("button_3");
// var button_4 = document.getElementById("button_4");
// var button_5 = document.getElementById("button_5");
// var button_6 = document.getElementById("button_6");
// var button_7 = document.getElementById("button_7");
// var button_8 = document.getElementById("button_8");
// var button_9 = document.getElementById("button_9");
// var button_10 = document.getElementById("button_10");
// var button_11 = document.getElementById("button_11");
// var button_12 = document.getElementById("button_12");
// var button_13 = document.getElementById("button_13");
// var button_14 = document.getElementById("button_14");
// var button_15 = document.getElementById("button_15");
// var button_16 = document.getElementById("button_16");
// var button_17 = document.getElementById("button_17");
// var button_18 = document.getElementById("button_18");
// var button_19 = document.getElementById("button_19");
// var button_20 = document.getElementById("button_20");
// var button_21 = document.getElementById("button_21");

// //Create an array for easy access later
// var Buttons = [ button_0, button_1, button_2, button_3, button_4, button_5,
//     button_6, button_7, button_8, button_9, button_10, button_11, button_12,
//     button_13, button_14, button_15, button_16, button_17, button_18, button_19,
//     button_20, button_21 ];

function raffStore( rsId, upPinValue, downPinValue, heightValue, angleValue ) {
  this.Id = rsId;
  this.upPin = upPinValue;
  this.downPin = downPinValue;
  this.height = heightValue;
  this.angle = angleValue;
}

const raffStoreList = new Map();
// function raffStoreList( rsId, raffStoreObj ) {
//   this.Id = rsId;
//   this.raffStore = raffStoreObj;
// }

function rsSetting( rsSId, raffStoreListObj ) {
  this.Id = rsSId;
  this.raffStoreList = raffStoreListObj;
}

var rssCurrent = null;
var rssGoal = null;
var configs = new Map();

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_pin ( pic ) {
var data = 0;
//     preventDefault();
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "gpio.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			//update the index pic
			if ( !(data.localeCompare("0")) ){
				document.getElementById("button_" + pic).src = "data/img/redButton.png";
// 				document.getElementById("button2_" + pic).src = "data/img/redButton.png";
// 				Buttons[pic].src = "data/img/redButton.png";
//				Buttons[pic].src = "data/img/red/red_"+pic+".jpg";
			}
			else if ( !(data.localeCompare("1")) ) {
				document.getElementById("button_" + pic).src = "data/img/greenButton.png";
// 				document.getElementById("button2_" + pic).src = "data/img/greenButton.png";
// 				Buttons[pic].src = "data/img/greenButton.png";
//				Buttons[pic].src = "data/img/green/green_"+pic+".jpg";
			}
			else if ( !(data.localeCompare("fail"))) {
				alert ("Something went wrong! 1" );
				return ("fail");
			}
			else {
				alert ("Something went wrong! 2" );
				return ("fail");
			}
		}
		//test if fail
		else if (request.readyState == 4 && request.status == 500) {
			alert ("server error");
			return ("fail");
		}
		//else
		else if (request.readyState == 4 && request.status != 200 && request.status != 500 ) {
			alert ("Something went wrong! 3");
			return ("fail"); }
	}

return 0;
}

function selectAllMB ( status ) {
  for( i = 0 ; i < 20; i=i+2 ){
    let eMB = document.getElementById("meterBox"+i);
    if ( eMB== null ){
      console.log("aha, selectAllMB", i);
    }
    if( eMB.hasAttribute("data-selected") ) {
      eMB.setAttribute("data-selected", status );
      ( status == 1 ? eMB.style.backgroundColor = ( "#004F00" ):eMB.style.backgroundColor = ( "#4F0000" ));
    }

  }
}


function getViewportSize(w) {

    // Use the specified window or the current window if no argument
    w = w || window;

    // This works for all browsers except IE8 and before
    if (w.innerWidth != null) return { w: w.innerWidth, h: w.innerHeight };

    // For IE (or any browser) in Standards mode
    var d = w.document;
    if (document.compatMode == "CSS1Compat")
        return { w: d.documentElement.clientWidth,
           h: d.documentElement.clientHeight };

    // For browsers in Quirks mode
    return { w: d.body.clientWidth, h: d.body.clientHeight };

}

function stopEvent(ev) {
  ev.stopPropagation();
  ev.preventDefault();
}

function myFunction(){
  if(window.innerWidth !== undefined && window.innerHeight !== undefined) {
    var w = window.innerWidth;
    var h = window.innerHeight;
  } else {
    var w = document.documentElement.clientWidth;
    var h = document.documentElement.clientHeight;
  }
  var txt = "Page size: width=" + w + ", height=" + h;
  //document.getElementById("demo").innerHTML = txt;

}

function changeRange(wid) {
  var x = document.getElementById("range"+wid).value;
  document.getElementById("quantity"+wid).value = x;
}

function Power( task ){
  if( task == 0 ){
    //powerbutton pinid 21
    fetch("gpio.php/?"
      + new URLSearchParams({
          pic: '21',
      }))
      .then(response => response.json())
//       .then(response => console.log(response))
      .then(result => {
//           console.log('Result: ', result);
          let e= document.getElementById("Power");
          e.style.borderColor = ( result == 0 ? "#7F0000" : "#007F00" );

      } )
//       .then(data => { console.log(data) } );
  } else if ( task == 1) {
    //control button pinid 20
    fetch("gpio.php/?"
      + new URLSearchParams({
          pic: '20',
      }))
      .then(response => response.json())
//       .then(response => console.log(response))
      .then(result => {
//           console.log('Result: ', result);
          let e= document.getElementById("Control");
          e.style.borderColor = ( result == 0 ? "#7F0000" : "#007F00" );

      } )
  }
}


function setMeterBoxStatus( sId, sselected, sactive, sgHeigth, sgAngle, scHeight, scAngle ) {
  var eMB = document.getElementById("meterBox"+mbId);
}

function clickMeterBox( mbId ) {
  var eMB = document.getElementById("meterBox"+mbId);
  if( eMB.hasAttribute("data-selected") ) {
    var sel = eMB.getAttribute("data-selected");
    if( sel == 0 ) {
      var x = document.getElementById("meterG"+mbId+"0").value;
      var y = document.getElementById("meterG"+mbId+"1").value;
    //   var c = ( z == 0 ? "#007F00" : "#7F0000" );
      document.getElementById("range"+0).value = x;
      document.getElementById("range"+1).value = y;
      document.getElementById("quantity"+0).value = x;
      document.getElementById("quantity"+1).value = y;
      eMB.setAttribute("data-selected",1);
      eMB.style.backgroundColor = ( "#004F00" );
    } else {
      eMB.setAttribute("data-selected",0);
      eMB.style.backgroundColor = ( "#4F0000" );
    }
  //   eMB.setAttribute("data-active",(z==0?"1":"0") );
  //   eMB.style.borderColor = ( z == 0 ? "#007F00" : "#7F0000" );;
//     eMB.setAttribute("data-selected",(sel==0?"1":"0") );
//     eMB.style.backgroundColor = ( sel == 0 ? "#004F00" : "#4F0000" );;
  } else {
    var z = -1
  }
//   var t = document.getElementById("text1");
//   t.innerHTML=mbId+"clicked";
}

function submitToRS( sId, hValue, aValue ) {
//   fetch("pin.php/?action=setRSPerc&rsId="+sId+'&hVal='+hValue+'&aVal='+aValue )

  fetch("pin.php/?"
    + new URLSearchParams({
        action: 'setRSPerc',
        rsId: sId,
        hVal: hValue,
        aVal: aValue
    }))
    .then(response => response.json())
//     .then(response => console.log(response))
    .then(result => {
        console.log('Result: ', result);
        upDateRaffStoreMeter( sId, hValue, aValue, false );
        let eMB = document.getElementById("meterBox"+sId);
          eMB.setAttribute("data-active",1);
          eMB.style.borderColor="#7F0000";
    } )
//     .then(data => { console.log(data) } );
}


function submitting( task ) {
  var eMB;
  var eM;
//   var eRS;
//   eRS = raffStoreList.get(parseInt(sId));
  //set meterboxes
  if( task == 0 ){
    var mainValue = document.getElementById("range"+0).value;
    var childValue = document.getElementById("range"+1).value;
    for( i = 0 ; i < 20; i = i + 2 ) {
      eMB = document.getElementById("meterBox"+i);
      if( ( eMB.hasAttribute("data-selected") && eMB.getAttribute("data-selected") == 1 ) ) {
        eM = document.getElementById("meterG"+i+"0");
        eM.value = mainValue;
        eM = document.getElementById("meterG"+i+"1");
        eM.value = childValue;
      }
    }
  } else if( task == 1 ) {
    //start motors
    for( i = 0 ; i < 20; i = i + 2 ) {
      eMB = document.getElementById("meterBox"+i);
      if( ( eMB.hasAttribute("data-selected") && eMB.getAttribute("data-selected") == 1 ) ) {
        eMB.setAttribute("data-active",1);
        eMB.style.borderColor="#007F00";
        eM = document.getElementById("meterG"+i+"0");
        var mainValue = eM.value;
        eM = document.getElementById("meterG"+i+"1");
        var childValue = eM.value;
        submitToRS( i, mainValue, childValue );
      }
    }
  }
//   var t = document.getElementById("text1");
//   t.innerHTML=JSON.stringify(raffStoreList);
}

function upDateRaffStoreMeter( sId, pcHeight, pcAngle, changeAll=false ) {
  var rs;
  rs=raffStoreList.get(parseInt(sId));
  if ( rs==null ) return;
  rs.height=pcHeight;
  rs.angle=pcAngle;
  eMB = document.getElementById("meterBox"+sId);
  if( ( eMB.hasAttribute("data-selected") && eMB.getAttribute("data-selected") == 1 ) || changeAll ) {
//   if( true ) {
    var mb=document.getElementById("meterC"+sId+"0");
    mb.value=pcHeight;
    mb=document.getElementById("meterC"+sId+"1");
    mb.value=pcAngle;
    mb=document.getElementById("meterG"+sId+"0");
    mb.value=pcHeight;
    mb=document.getElementById("meterG"+sId+"1");
    mb.value=pcAngle;
  }
}

//data got from currentValues.txt
function upDateRaffStores( pdata ) {
//   var t = document.getElementById("text1");
//   t.innerHTML=pdata;
//   var lines = JSON.parse( pdata );
  var lines = pdata;
  var entry = null;
  var lline = null;
  for (lline of lines ) {
    entry = lline.split(' ');
//  #rsID PinUpId PinDownId MaxHeight MaxAngle CurrentHeight CurrentAngle
    upDateRaffStoreMeter( entry[0], entry[5], entry[6], true );
  }
}

function fetchCurrentValues() {
fetch('pin.php/?action=getCurrentValues')
  .then(response => response.json())
//   .then(result => { console.log('Result: ', result) } )
  .then(data => upDateRaffStores(data));
//   .then(data => console.log(data));
}

function setRaffStoreGoal( rs, checkChanged ) {
  var mb=null;
  mb=document.getElementById("meterG"+rs.Id+"0");
  if ( mb==null ){return};
  mb.value=rs.height;
  mb=document.getElementById("meterG"+rs.Id+"1");
  mb.value=rs.angle;
  var eMB = document.getElementById("meterBox"+rs.Id);
  if( checkChanged && eMB.hasAttribute("data-selected") ) {
    eMB.setAttribute("data-selected",1);
    eMB.style.backgroundColor = ( "#004F00" );
  }

}

function setRaffStoreGoals( rsl, checkChanged ) {

  for (const [keys, rs] of raffStoreList.entries()) {
    setRaffStoreGoal( rs, true );
  }

}

function loadConfig( pdata ) {
  console.log(pdata);
  let ddata = JSON.parse( pdata );
//   console.log(ddata);
//   raffStoreList.clear();
  for( let d of ddata ) {
//     console.log( "data of array: ", d.key, d.data );
    raffStoreList.set( d.key, d.data );
    let rs=raffStoreList.get( d.key );
    setRaffStoreGoal( rs, true );
  }
//   setRaffStoreGoals( raffStoreList, true );
}


function fetchConfig( configName )  {
//   console.log(configName);
  fetch('pin.php/?action=getConfig&name='+configName)
    .then(response => response.json())
  //   .then(result => { console.log('Result: ', result) } )
    .then(data => loadConfig(data));
//     .then(data => console.log(data));
}


function upDateLoadConfigs( pdata, sid ) {
//   console.log(pdata);
  la = pdata;
  e=document.getElementById("ddconfig");
  e.innerHTML="";
  if( la.lenght==0 ){
    e.innerHTML="<span >no config found</span>";
  } else {
    for( let configName of pdata ) {
  //     console.log( configName );
      e.innerHTML+='<span onclick="fetchConfig(\''+configName+'\')">'+configName+'</span>';
  //     e.innerHTML+='<a href="#" onclick="fetchConfig(\''+configName+'\')">'+configName+'</a>'
    }
  }
  sid++;
}

function fetchConfigs( sid ) {
//   console.log( "got "+sid );
  fetch('pin.php/?action=getConfigs')
    .then(response => response.json())
  //   .then(result => { console.log('Result: ', result) } )
    .then(data => upDateLoadConfigs(data, sid));
//     .then(data => console.log(data));
}

function saveConfig() {
  let configName = null;
  var lArr = new Array();
  if( ! raffStoreList.has("name") ) {
    configName = prompt("Please a name \nfor new config:", "schnuIstDerBeste");
  } else {
    configName = prompt("Please a name \nfor config:", "schnuIstDerBeste");
  }
  if (configName == null || configName == "") {
    return;
  } else {
    raffStoreList.set("name",configName );
    let rs=raffStoreList.get("name");
    lArr.push ( { key:"name", data:rs } );
  }


  for (const [keys, rs] of raffStoreList.entries()) {
//     console.log(keys, JSON.stringify( rs ) );
//     lArr.push( { key:keys, data:JSON.stringify( rs ) } );
    if( rs.Id >=0 ) {
      let eMB = document.getElementById("meterBox"+rs.Id);
      if( eMB == null ) {
        console.log('oeha');
      }
      if( ( eMB.hasAttribute("data-selected") && eMB.getAttribute("data-selected") == 1 ) ) {
        lArr.push( { key:keys, data:rs } );
      }
    }
  }
//   console.log( JSON.stringify( lArr ) );
//   console.log( lArr.length );
  const o = { headers:{"Content-type":"application/json" },
      body: JSON.stringify( lArr ),
      method: "POST",
      mode: "same-origin", // no-cors, *cors, same-origin
      credentials: "same-origin", // include, *same-origin, omit
  };
  fetch('pin.php?'+'postaction=saveConfig&fileName='+configName
//         + new URLSearchParams({
//         postaction: 'saveConfig',
//         fileNames: configName
//     })
        ,o )
//   .then(response => console.log(response))
  .then(response => response.json())
//   .then(result => { console.log('Result: ', result) } )
//   .then(data => upDateRaffStores(data));
  .then(data => console.log(data));
}

// // https://stackoverflow.com/questions/33439030/how-to-grab-data-using-fetch-api-post-method-in-php
// async function postData( url='', data={ } ) {
//   // *starred options in comments are default values
//   const response = await fetch(
//     url,
//     {
//       method: "POST", // *GET, POST, PUT, DELETE, etc.
//       mode: "same-origin", // no-cors, *cors, same-origin
//       cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
//       credentials: "same-origin", // include, *same-origin, omit
//       headers: {
//         "Content-Type": "application/json",  // sent request
//         "Accept":       "application/json"   // expected data sent back
//       },
//       redirect: 'follow', // manual, *follow, error
//       referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
//       body: JSON.stringify( data ), // body data type must match "Content-Type" header
//     },
//   );
//
//   return response.json( ); // parses JSON response into native JavaScript objects
// }
//
// const data = {
//   'key1': 'value1',
//   'key2': 2
// };
//
// postData( 'receive_body___send_response.php', JSON.stringify( data ) )
//   .then( response => {
//     // Manipulate response here
//     console.log( "response: ", response ); // JSON data parsed by `data.json()` call
//     // In this case where I send entire $decoded from PHP you could arbitrarily use this
//     console.log( "response.data: ", JSON.parse( response.data ) );
//   } );
//
//
//
// // https://codepen.io/dericksozo/post/fetch-api-json-php
// fetch("/", {
//     method: "POST",
//     mode: "same-origin",
//     credentials: "same-origin",
//     headers: {
//       "Content-Type": "application/json"
//     },
//     body: JSON.stringify({
//       "payload": myObj
//     })
//   })



// function change_meter () {
//     //this is the http request
//     var request = new XMLHttpRequest();
