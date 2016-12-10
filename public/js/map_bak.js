function initialize() {
 var latlng = new google.maps.LatLng(35.653312, 139.698229);
 var opts = {
 zoom: 17,
 center: latlng,
 mapTypeControl: true,
 mapTypeId: google.maps.MapTypeId.ROADMAP
 };
 /* 表示エリアのID名を指定。この場合id="map"のところに出力されます */
 var map = new google.maps.Map(document.getElementById("map"), opts);
 
 /* 地図style */
 var styleOptions = [{
 
 'stylers': [{
 'gamma': 0.8
 }, {
 'saturation': -100
 }, {
 'lightness': 20
 }]
 }]
 
 //地図の切り替えボタン
 var styledMapOptions = {
 name: 'モノクロ地図'
 }
 var monoType = new google.maps.StyledMapType(styleOptions, styledMapOptions);
 map.mapTypes.set('mono', monoType);
 map.setMapTypeId('mono');
 
 //マーカーの画像パス(相対、絶対どっちでも)
 var image = '../images/placemark.png';
 var Marker = new google.maps.Marker({
 position: latlng,
 map: map,
 icon: image//デフォルトのマーカーを表示する場合は指定無し
 });
 
 //マップのタイトル
 var contentString = 'マップのタイトル';
 var infowindow = new google.maps.InfoWindow({
 content: contentString
 });
 //infowindow.open(map, lopanMarker);//初期状態で吹き出しを表示させる場合は有効にする 
 google.maps.event.addListener(Marker, 'click', function() {
 infowindow.open(map, Marker);
 });
}
google.maps.event.addDomListener(window, 'load', initialize);