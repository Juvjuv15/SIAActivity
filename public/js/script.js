var map;
// var lat=10.3175;
// var lng=123.8854;
var lat=10.3080;
var lng=123.8942;
var legend;
var service;
var latlng, i;
var markers = [];

// latlng=new google.maps.LatLng(10.3175,123.8986319);
$(document).ready(function(){
  // var latlng={lat:lat, lng:lng};
  binaliwlatlng=new google.maps.LatLng(10.4229,123.9165);
  cebulatlng=new google.maps.LatLng(10.3157,123.8854);

  latlng=new google.maps.LatLng(lat,lng);
  //create a map
  function createMap(latlng){
    map =new google.maps.Map(document.getElementById('map'),{
      center: latlng,
      zoom: 15,
      mapTypeId: 'terrain',
      visibility:new google.maps.MVCObject,
      streetViewControl: true,
               
      styles: [
        {elementType: 'labels.text.fill', stylers: [{color: '#000000'}]},
        {
          featureType: 'administrative.locality',
          elementType: 'labels.text.fill',
          stylers: [{color: '#001a00'}]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.fill',
          stylers: [{color: '#cc3300'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'geometry',
          stylers: [{color: ' #adebad'}]
        },
        {
          featureType: 'poi.business',
          elementType: 'geometry',
          stylers: [{color: '#d2a679'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry',
          stylers: [{color: '#bfbfbf'}]
        },
        {
          featureType: 'poi.school',
          elementType: 'geometry',
          stylers: [{color: '#ffffcc'}]
        },

        {
          featureType: 'poi.medical',
          elementType: 'geometry',
          stylers: [{color: '#ff9999'}]
        },
      
        {
          featureType: 'road.highway',
          elementType: 'geometry',
          stylers: [{color: '#737373'}]
        },
        // {
       
        {
          featureType: 'transit',
          elementType: 'geometry',
          stylers: [{color: '#2f3948'}]
        },
      
        {
          featureType: 'water',
          elementType: 'geometry',
          stylers: [{color: '#69D4E3'}]
        },
       
      ]
      
    });
    // searchaddress
    var input = document.getElementById('searchaddress');
    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();
      
      if (places.length == 0) {
        
        return;
      } 
  
// For each place, get the icon, name and location.


      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
       
        } else {
          map.setCenter(place.geometry.location);
          var lat=place.geometry.location;
          console.log(lat);

          map.setZoom(17);
        }
      });
      // map.fitBounds(bounds);
      // searchLot(lat,lng);
    });

     //### Add Google Street View ...
//  window.panorama = new google.maps.StreetViewPanorama(
//   document.getElementById('google-street-view_images'), {
//     position: latlng,
//     pov: {
//       heading: 34,
//       pitch: 10
//     }
//   });
// map.setStreetView(window.panorama);

//### Modify Street View controls ...
// var panoOptions = {
//  scrollwheel: true,
//  disableDefaultUI: false,
//  clickToGo: true
// };
// window.panorama.setOptions(panoOptions);
   }

//search nearby schools
function findNearbyPlaces(latlng,type){
var request ={
location:latlng,
radius:'5000',
types:[type]
};
service=new google.maps.places.PlacesService(map);
service.nearbySearch(request,callback);

function callback(results,status){

if(status == google.maps.places.PlacesServiceStatus.OK){
  console.log(results.length);
  for(var i=0;i<results.length;i++){
    var place = results[i];
    latlng=place.geometry.location;
    lat=place.geometry.location.lat();
    lng=place.geometry.location.lng();
    name=place.name
    console.log(lat);
    console.log(lng);
    console.log(name);

    name=place.name;

    
    // createMarkerNearByPlaces(latlng,icon,name);
  }
  }
}
}

//for the marker
// function createMarkerNearByPlaces(latlng,icon,name){
// var marker=new google.maps.Marker({
//       position:latlng,
//       map:map,
//       icon:icon,
//       title:name,
//     });
// }


function legend(){
  var icons = {
        Residential: {
          name: 'RESIDENTIAL LOT',
          image:'/images/i2.png',
        },
        Commercial: {
          name: 'COMMERCIAL LOT',
          image:'/images/i1.png'
        },
        Beach: {
          name: 'BEACH LOT',
          image:'/images/i4.png'
        },
        Agricultural: {
          name: 'AGRICULTURAL LOT',
          image:'/images/i3.png'
        },
        Road: {
          name: 'LOCAL ROADS',
          image:'/images/road.png'
        },
        Highway: {
          name: 'HIGHWAY ROAD',
          image:'/images/highway.png'
        },
        Water: {
          name: 'WATER',
          image:'/images/water.png'
        },
        School: {
          name: 'SCHOOLS',
          image:'/images/school.png'
        },
        Emergency: {
          name: 'EMERGENCY SERVICES',
          image:'/images/emergency.png'
        },
        Business: {
          name: 'BUSINESS ESTABLISHMENTS',
          image:'/images/business.png'
        },
        Park: {
          name: 'PARKS',
          image:'/images/park.png'
        },
      };

   var legend = document.getElementById('legend');
      for (var key in icons) {
        var type = icons[key];
        var name = type.name;
        var image = type.image;
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + image + '"> ' + name;
        legend.appendChild(div);
      }

      map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);
}
function searchLot(lat,lng){
  $.get('api/searchLots',{lat:lat,lng:lng},function(match){
    console.log(match);   
      // legend();
      $("#lotresult").html("");
      $("#countresult").html("");
      var countresult= `<div align="left" class="alert alert-dark m-2">
      <h6>Recommended Properties.....</h6>
    </div>`;
    $("#countresult").append(`${countresult}`);
      $.each(match,function(i,val){
        
        var fileExt = val.fileExt;
        var latval=val.lat;
        var lngval=val.lng;
        var name=val.name;
        var tid=val.tid;
        var slottype=val.lotType;
        var lotOwner=val.lotOwner;
        var slotaddress=val.lotAddress;
        var slotarea=val.lotArea;
        var unitOfMeasure=val.unitOfMeasure;
        var lotdescription=val.lotDescription;
        var lotprice=val.lotPrice;
        // var leaseprice=val.leaseprice;
        var paymenttype=val.paymentType;
        var sellingtype=val.sellingType;
        var lotCornerInfluence=val.lotCornerInfluence;
        var lotMarketValue=val.lotMarketValue;
        var created_at = val.created_at;
          var LatLng = new google.maps.LatLng(latval, lngval);
          if(slottype=="Residential Lot"){
          var icon= {
            url:'/images/ires2.png',
            scaledSize:new google.maps.Size(35,55)
          };
        }
        else if(slottype=="Agricultural Lot"){
          var icon= {
            // url:'/images/agreen.png',
            url:'/images/iagri2.png',
            scaledSize:new google.maps.Size(35,55)
          };
        }
        else if(slottype=="Commercial Lot"){
          var icon= {
            // url:'/images/cgreen.png',
            url:'/images/icom2.png',
            scaledSize:new google.maps.Size(35,55)
          };
        }
        else if(slottype=="Beach Lot"){
          var icon= {
            // url:'/images/cgreen.png',
            url:'/images/ibeach2.png',
            scaledSize:new google.maps.Size(35,55)
          };
        }
        var months = new Array("January", "February", "March", 
        "April", "May", "June", "July", "August", "September", 
        "October", "November", "December");
      var datePosted = new Date(created_at);
      var d = datePosted.getDate();
      var m =  datePosted.getMonth();
      m += 1;  // JavaScript months are 0-11
      var y = datePosted.getFullYear();
        var mySecondDiv= `
                        <div class="col-xl-12 col-lg-3">
                          <div class="card shadow mb-2">
                            <table width="100%">
                                <tr>
                                  <td style=" vertical-align:top" width="30"><img src="${fileExt}" height="125" width="250"></td>
                                  <td style="padding:2px; vertical-align:top">
                                          <b><font color="teal">${sellingtype} ${slottype}</font></b><br/>
                                          <i class="fas fa-map-marker-alt"></i>&nbsp;<b>${slotaddress}</b><br/>
                                          <a style="position:absolute; margin-left:60%;" class="btn btn-outline-info" href="displayData/${tid}/view">VIEW MORE INFO</a>
                                          <i class="fa-2x text-gray">&#8369;</i>${lotprice.toLocaleString()}.00 (${paymenttype})<br/>
                                          <br/><font size="1">Posted by: ${name}&emsp;&nbsp;Date posted: ${months[m]} ${d},${y}</font>
                                          
                                  </td>
                                </tr>
                            </table>
                          </div>
                        </div>`;
      $("#lotresult").append(`${mySecondDiv}`);
        createMarker(LatLng, icon, name, tid,lotOwner, slotaddress, slottype, slotarea,unitOfMeasure, lotprice,paymenttype,sellingtype,lotCornerInfluence,lotMarketValue);
      });
  });
}



// function clearMarker(){
//   setMapOnAll(null);
//   }
  
// function delateMarkers(){
//   clearMarker()
//   markers = []
// }



function createMarker(coordinates, icon, name,tid,lotOwner,slotaddress,slottype,slotarea,unitOfMeasure,lotprice,paymenttype,sellingtype,lotCornerInfluence,lotMarketValue, deleteMarkers) {

    var marker = new google.maps.Marker({
      position: coordinates,
      map: map,
      icon: icon,
      title: name,
      url:'displayData/'+tid+'/view',
      animation: google.maps.Animation.DROP
  });
        var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<ol>'+
        '<div id="bodyContent">'
        +sellingtype+' '+slottype+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'+
        'Located at '+slotaddress+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'
        +'Area:'+slotarea+' '+unitOfMeasure+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'
        +'Price: <font size="1"><i class="fa-2x text-gray">&#8369;</i></font>'+lotprice.toLocaleString()+'.00 '+'('+paymenttype+')'+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'+
        'Corner Influence: '+lotCornerInfluence+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'+
        'Lot Market Value: <font size="1"><i class="fa-2x text-gray">&#8369;</i></font>'+lotMarketValue.toLocaleString()+'.00'+
        '</div>'+
        '</ol>'+
        '<ol>'+
        '<div id="bodyContent">'+
        'Posted by '+name+
        '</div>'+
        '</ol>'+
        '</div>';        


      var infowindow = new google.maps.InfoWindow({
        content: contentString,
        title:lotOwner,
    
      });
    
      //View all details
      marker.addListener("click",function(find){
        window.location.href=this.url;
    });
    
    //View Polygon
    marker.addListener('dblclick', function() {
      map.setCenter(marker.getPosition());
      map.setZoom(20);
    });
    
    //View some lot Details
    marker.addListener('mouseover', function() {
    infowindow.open(map, marker);
    });
    
    marker.addListener('mouseout', function() {
    // infowindow.close();
    infowindow.open(map, marker);
    });
    
      google.maps.event.addListener(marker,"click",function(find){
        window.location.href=this.url;
      })
    
  if(slottype =="Agricultural Lot"){
    agri.push(marker);
  }else if(slottype =="Residential Lot"){
    res.push(marker);
  }else if(slottype =="Commercial Lot"){
    comm.push(marker);
  }else if(slottype =="Beach Lot"){
    beach.push(marker);
  }else{
    markers.push(marker);
  }
}
var res= [];
var agri=[];
var comm=[];
var beach=[];
function beachlot(map, slottype){
  // createMarker(latlng);
   for(var i=0; i<beach.length; i++){
    beach[i].setMap(map);
  }
}

function agricultural(map, slottype){
  // createMarker(latlng);
   for(var i=0; i<agri.length; i++){
    agri[i].setMap(map);
  }
}

function residential(map, slottype){
  // createMarker(latlng);
   for(var i=0; i<res.length; i++){
    res[i].setMap(map);
  }
}

function commercial(map, slottype){
  // createMarker(latlng);
   for(var i=0; i<comm.length; i++){
    comm[i].setMap(map);
  }
}

function hide(map, slottype){
  // createMarker(latlng);
   for(var i=0; i<markers.length; i++){
    markers[i].setMap(map);
  }
}

function hideAll(){
  hide(null);
}

function hideBeach(){
  beachlot(null);
}

function hideResidential(){
  residential(null);
}

function hideCommercial(){
  commercial(null);
}

function hideAgricultural(){ 
    agricultural(null);
}

// function deleteMarkers(){
//   clearMarkers();
//   markers= [];
// }



createMap(latlng);
legend();

$("#clickbuyer").click(function(){
  searchLot(lat,lng); 
});


$('#filter').submit(function(e){
e.preventDefault();
$("#lotresult").html("");
$("#countresult").html("");
var searchaddressVal=$('#searchaddress').val();
var sellTypeVal=$('#selltype').val();
var lotTypeVal=$('#lottype').val();
var minPriceVal=$('#minPrice').val();
var maxPriceVal=$('#maxPrice').val();

console.log(searchaddressVal);
console.log(sellTypeVal);
console.log(lotTypeVal);
console.log(minPriceVal);
console.log(maxPriceVal);

// createMap(latlng);
// legend();
var filter = {lotTypeVal:false, sellTypeVal:false}
hideResidential();
hideCommercial();
hideAgricultural();
hideBeach();

$.post('/api/filter',{searchaddressVal:searchaddressVal,lotTypeVal:lotTypeVal,sellTypeVal:sellTypeVal,minPriceVal:minPriceVal,maxPriceVal:maxPriceVal},function(match){
  // createMap(latlng);

  console.log(match);
// var coords= new google.maps.LatLng(match[0],match[1]);
// latlng=new google.maps.LatLng(lat,lng);
// searchLot((match[0],match[1]));
  var countresult= `<div align="left" class="alert alert-dark m-2">
  <h6>Search results.....${match.length}</h6>
</div>`;
$("#countresult").append(`${countresult}`);

// $.each(match[0],function(i,val){
  $.each(match,function(i,val){
  var fileExt = val.fileExt;
  var latval=val.lat;
  var lngval=val.lng;
  var name=val.name;
  var tid=val.tid;
  var slottype=val.lotType;
  var lotOwner=val.lotOwner;
  var slotaddress=val.lotAddress;
  var slotarea=val.lotArea;
  var unitOfMeasure=val.unitOfMeasure;
  var lotdescription=val.lotDescription;
  var lotprice=val.lotPrice;
  // var leaseprice=val.leaseprice;
  var paymenttype=val.paymentType;
  var sellingtype=val.sellingType;
  var lotCornerInfluence=val.lotCornerInfluence;
  var lotMarketValue=val.lotMarketValue;
  var created_at = val.created_at;
var coordinates = new google.maps.LatLng(latval, lngval);
// findNearbyPlaces(cebulatlng,"school");
// findNearbyPlaces(binaliwlatlng,"school");
if(slottype=="Residential Lot"){
var icon= {
url:'/images/ires2.png',
scaledSize:new google.maps.Size(35,55)
};
}
else if(slottype=="Agricultural Lot"){
var icon= {
url:'/images/iagri2.png',
scaledSize:new google.maps.Size(35,55)
};
}
else if(slottype=="Commercial Lot"){
var icon= {
url:'/images/icom2.png',
scaledSize:new google.maps.Size(35,55)
};
}
else if(slottype=="Beach Lot"){
  var icon= {
  url:'/images/ibeach2.png',
  scaledSize:new google.maps.Size(35,55)
  };
  }
var months = new Array("January", "February", "March", 
  "April", "May", "June", "July", "August", "September", 
  "October", "November", "December");
var datePosted = new Date(created_at);
var d = datePosted.getDate();
var m =  datePosted.getMonth();
m += 1;  // JavaScript months are 0-11
var y = datePosted.getFullYear();
  var mySecondDiv= `<div class="col-xl-12 col-lg-3">
                    <div class="card shadow mb-2">
                      <table width="100%">
                          <tr>
                            <td style=" vertical-align:top" width="30"><img src="${fileExt}" height="125" width="250"></td>
                            <td style="padding:2px; vertical-align:top">
                                    <b><font color="teal">${sellingtype} ${slottype}</font></b><br/>
                                    <i class="fas fa-map-marker-alt"></i>&nbsp;<b>${slotaddress}</b><br/>
                                    <a style="position:absolute; margin-left:60%;" class="btn btn-outline-info" href="displayData/${tid}/view">VIEW MORE INFO</a>
                                    <i class="fa-2x text-gray">&#8369;</i>${lotprice.toLocaleString()}.00 (${paymenttype})<br/>
                                    <br/><font size="1">Posted by: ${name}&emsp;&nbsp;Date posted: ${months[m]} ${d},${y}</font>
                                    
                            </td>
                          </tr>
                      </table>
                    </div>
                  </div>`;
$("#lotresult").append(`${mySecondDiv}`);
  createMarker(coordinates, icon, name, tid,lotOwner, slotaddress, slottype, slotarea,unitOfMeasure, lotprice,paymenttype,sellingtype,lotCornerInfluence,lotMarketValue);
});


});
});
{/* <font size="1">Posted by: ${lotOwner}&emsp;&nbsp; */}
{/* <div style="white-space: nowrap; width:650px; overflow: hidden; text-overflow: ellipsis;" >${lotdescription}</div> */}
});