function initMap(imagePath){
    var latlng = new google.maps.LatLng(33.5093871, -112.08884849999998); //KL
    var dataCount = 0;
    var dataList = [];
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map"), myOptions);
    var geocoder = new google.maps.Geocoder();
    var gmap = {
        map: map,
        markers: {},
//        markerImage: new google.maps.MarkerImage(imagePath+'medident_marker.png'),
//        markerImagePanel: new google.maps.MarkerImage(imagePath+'medident_marker_reset.png'),
//        markerImageNP: new google.maps.MarkerImage(imagePath+'medident_marker_np.png'),
        infoWindow : new google.maps.InfoWindow(),
        drawMarkers: function( dataList ){
            var me = this;
            jQuery.each(dataList, function(index, data){
                var marker = new MarkerWithLabel({
                    flat:true,
                    icon: (data['type'] === 'P') ? me.markerImagePanel : me.markerImageNP,
                    map:map,
                    position: new google.maps.LatLng(data.lat,data['long']),
                    visible:true,
                    labelContent:data.listed ? data.index : '',
                    labelAnchor:new google.maps.Point(16, 19),
                    labelClass:'marker-labels',
                    zIndex: (data['type'] === 'P') ? 500 : 400
                });
                google.maps.event.addListener(marker, 'click', function(){
                    var cls = (data['type'] === 'P') ? 'panel-window' : 'nonpanel-window';
                    var content = '<div style="overflow:hidden;" class="'+cls+'"><div class="image"></div>'+gmap.nullToString(data.name)+'<br>'+gmap.nullToString(data.address)+'<br>' + gmap.nullToString(data.description)+'</div>';
                    me.infoWindow.setContent(content);
                    me.infoWindow.open(me.map,marker);
                });

                me.markers[data.id] = marker;
            });
        },
        redrawMarkers: function(dataList){
            for(var id in this.markers){
                this.markers[id].setMap(null);
            }
            this.drawMarkers(dataList);
            var me = this;
            jQuery.each(dataList, function(index, data){
                if(data['type'] == 'P')
                    me.markers[data.id].setIcon(me.markerImage);
            });
        },
        startRender: function(json_data){
        	results = json_data;
		    jQuery.each(results, function(index, data){
			    position = gmap.geocodeAddress(data, results.length);;
			});
        },
        geocodeAddress: function(data, total) {
        	var name = data.name;
            var address = data.address;
            var city = data.city;
            var state = data.state;
            var country = data.country;
            var address_google_map = address;
            
            var oPosition = {};
            geocoder.geocode({'address': address_google_map, 'region' : 'jp'},
	            function (results, status)
	            {
	            	if (status == google.maps.GeocoderStatus.OK) {
	            		map.setCenter(results[0].geometry.location);
	                    var marker = new google.maps.Marker({
	                        map: map,
	                        position: results[0].geometry.location
	                    });
	            	} 
	            });
            return oPosition;
        },

        drawWindow: function(data) {
        	var cls = (data['type'] === 'P') ? 'panel-window' : 'nonpanel-window';
            var content = '<div style="overflow:hidden;" class="'+cls+'"><div class="image"></div>'+gmap.nullToString(data.name)+'<br>'+gmap.nullToString(data.address)+'<br>' + gmap.nullToString(data.description)+'</div>';
            gmap.infoWindow.setContent(content);
            gmap.infoWindow.open(gmap.map, gmap.markers[data.id]);
        },
        reset: function(){
            for(var id in this.markers){
                this.markers[id].setMap(null);
            }
            this.map.setZoom(3);
        },
        moveTo: function( lt, lg ){
            var coor = new google.maps.LatLng(lt, lg);
            this.map.setCenter(coor);
            this.map.setZoom(3);
//            this.marker.setPosition(coor);
            var marker = new google.maps.Marker({
                map: map,
                position: coor
            });
        },
        updateMap: function(obj){
            this.moveTo(obj.lat, obj['long']);
        },
        nullToString: function(string){
        	if (typeof string == 'undefined' || !string)
        		return '';
        	else return string;
        }
    };
    return gmap;
}
