var zone_markers = [];
var zones = [];
var MAP, polys = [], path;
var poly;
var creating_zone = false;
var locations = new Array( [9.326129,-75.285727], [9.108029183211615,-75.40011405944824] , [9.716667,-75.133333], [9.25,-74.766667], [9.181439,-75.376534], [9.733333,-75.533333]  );

function add_point_zone(event){
 


    path.insertAt(path.length, event.latLng);
   
     

    var marker = new google.maps.Marker({
      position: event.latLng,
      map: MAP,
      draggable: true
    });

    
    zone_markers.push(marker);
    

    google.maps.event.addListener(marker, 'click', function() {
      marker.setMap(null);
      for (var i = 0, I = zone_markers.length; i < I && zone_markers[i] != marker; ++i);
      zone_markers.splice(i, 1);
      path.removeAt(i);
      }
    );

    google.maps.event.addListener(marker, 'dragend', function() {
      for (var i = 0, I = zone_markers.length; i < I && zone_markers[i] != marker; ++i);
         if(marker.getPosition())
         path.setAt(i, marker.getPosition());
      }
    );

}

function zone_controller(){}


function create_zone_in_map(control){
    
    creating_zone = true;    
    
    path = new google.maps.MVCArray;


      
    poly = new google.maps.Polygon({
      strokeWeight: 1,
       strokeColor: "#FCDF0A",
    strokeOpacity: 0.99,    
    fillColor: "#005EB2",
    fillOpacity: 0.50
    });

    poly.setMap(MAP);
    poly.setPaths(new google.maps.MVCArray([path]));
    

    google.maps.event.addListener(poly, "click", function(){

       zone_controller();

    });


    google.maps.event.addListener(MAP, 'click', add_point_zone);

          zone_markers = [];
  


}


function addZone(){

             var zone = {};
      
          zone.points = [];
          console.log(zone_markers);

            for(x in zone_markers)
             if(zone_markers[x].position)
              zone.points.push( zone_markers[x].position );

              zones.push(zone.points);                  


          console.log(zone.points);
          
            for(x in zone_markers)
              if(zone_markers[x].setMap)
              zone_markers[x].setMap(null);

          zone_markers = [];

}


function add(){

      if(zone_markers.length === 0 )
            return zone_markers;    


        addZone();
        create_zone_in_map();

        dialog.show("Zona agregada");

} 


function save_created_zone(control, callback){
          
          if(zone_markers.length === 0 && zones.length === 0)
            return zone_markers;          
          

        if(zone_markers.length > 0)
            addZone();


          
          zone_markers = [];
          var zoneR = zones;
          zones = [];

          return zoneR;


}



function remove_zone_of_map(){

   if(zone_markers.length === 0)
    return false;


    for(x in zone_markers)
       zone_markers[x].setMap(null);
     

      poly.setMap(null);  
     poly = undefined;       

     zone_markers = [];



}

function toCenter(){
     var sede = parseInt($("select[name='sede']").val());
     MAP.setCenter(new google.maps.LatLng(locations[sede][0], locations[sede][1]));
     google.maps.event.trigger(MAP, 'resize');
}


function inimap(zoom){

 var sede = parseInt($("select[name='sede']").val());
 zone_markers = [];

 var zoom =  15;

 var mapOptions = {
    zoom: zoom,
    center: new google.maps.LatLng(locations[sede][0], locations[sede][1]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
  };

 
 MAP = new google.maps.Map(document.getElementById('map'),
  mapOptions);
     google.maps.event.trigger(MAP, 'resize');

 toCenter();

}