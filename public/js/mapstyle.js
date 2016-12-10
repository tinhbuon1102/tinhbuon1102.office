// JavaScript Document
 function initialize() {
  var latlng = new google.maps.LatLng(35.415272, 136.758887); //緯度・経度
  var myOptions = {
   zoom: 18, //拡大倍率
   center: latlng, 
   mapTypeId: google.maps.MapTypeId.ROADMAP //地図の種類
  };
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); //地図を表示
 }