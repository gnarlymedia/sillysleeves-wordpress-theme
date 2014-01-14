// JavaScript Document

var canvas = document.getElementById('drawing_touch_canvas');
if(canvas){var context= canvas.getContext('2d');}
var tool;
tool = new tool_pencil();


//document.body.addEventListener('touchmove',function(event){ event.preventDefault(); },false);
//document.getElementById('drawing_touch_container').addEventListener('touchmove',function(event){ event.preventDefault(); },false);

addOnloadEvent('touchmove');

jQuery(document).ready(function($)
{
    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut
    listen();
});

function addOnloadEvent(fnc){
  if ( typeof window.addEventListener != "undefined" )
    window.addEventListener( "load", fnc, false );
  else if ( typeof window.attachEvent != "undefined" ) {
    window.attachEvent( "onload", fnc );
  }
  else {
    if ( window.onload != null ) {
      var oldOnload = window.onload;
      window.onload = function ( e ) {
        oldOnload( e );
        window[fnc]();
      };
    }
    else 
      window.onload = fnc;
  }
}
function listen()
{
    canvas = document.getElementById('drawing_touch_canvas'); 
    if(canvas){
        context= canvas.getContext('2d');
        context.fillStyle = "rgb(255,255,255)";  
        context.fillRect(0, 0, canvas.width, canvas.height);
        iphone = ((window.navigator.userAgent.match('iPhone'))||(window.navigator.userAgent.match('iPod')))?true:false;
        ipad = (window.navigator.userAgent.match('iPad'))?true:false;
        if(iphone||ipad){
            canvas.addEventListener('touchstart', ev_canvas, false);
            canvas.addEventListener('touchend', ev_canvas, false);
            canvas.addEventListener('touchmove', ev_canvas, false);
        }
        else{
            canvas.addEventListener('mousedown', ev_canvas, false);
            canvas.addEventListener('mousemove', ev_canvas, false);
            canvas.addEventListener('mouseup',   ev_canvas, false);
        }
    }
}
function tool_pencil () {
    var tool = this;
    this.started = false;
    this.mousedown = function (ev) {
        context.beginPath();
        context.moveTo(ev._x, ev._y);
        tool.started = true;
    };
    this.mousemove = function (ev) {
        if (tool.started) {
            context.lineTo(ev._x, ev._y);
            context.stroke();
        }
    };
    this.mouseup = function (ev) {
        if (tool.started) {
            tool.mousemove(ev);
            tool.started = false;
            //img_update();
        }
    };
    this.touchstart = function (ev) {
        ev.preventDefault();
        context.beginPath();
        context.moveTo(ev._x, ev._y);
        tool.started = true;
    };
    this.touchmove = function (ev) {
        ev.preventDefault();
        if (tool.started) {
            context.lineTo(ev._x, ev._y);
            context.stroke();
        }
    };
    this.touchend = function (ev) {
        ev.preventDefault();
        if (tool.started) {
            tool.started = false;
        }
    };
}
// The general-purpose event handler. This function just determines the mouse position relative to the canvas element.
function ev_canvas (ev) {
    iphone = ((window.navigator.userAgent.match('iPhone'))||(window.navigator.userAgent.match('iPod')))?true:false;
    ipad = (window.navigator.userAgent.match('iPad'))?true:false;
    if (((iphone)||(ipad))&&(ev.touches[0])){ //iPad
        ev._x = ev.touches[0].clientX;
        ev._y = ev.touches[0].clientY;
    }
    else if (ev.layerX || ev.layerX == 0) { // Firefox
        ev._x = ev.layerX;
        ev._y = ev.layerY;
    }
    else if (ev.offsetX || ev.offsetX == 0) { // Opera
        ev._x = ev.offsetX;
        ev._y = ev.offsetY;
    }
  // Call the event handler of the tool.
    var func = tool[ev.type];
    if (func) {
        func(ev);
    }
}
function clearImage(){
    var yes=confirm('Clear drawing?');
    if(yes){
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.fillStyle = "rgb(255,255,255)";  
        context.fillRect(0, 0, canvas.width, canvas.height);
    }
}