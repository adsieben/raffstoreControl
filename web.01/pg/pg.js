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
function myFunction(){
  if(window.innerWidth !== undefined && window.innerHeight !== undefined) {
    var w = window.innerWidth;
    var h = window.innerHeight;
  } else {
    var w = document.documentElement.clientWidth;
    var h = document.documentElement.clientHeight;
  }
  var txt = "Page size: width=" + w + ", height=" + h;
  document.getElementById("demo").innerHTML = txt;
}
