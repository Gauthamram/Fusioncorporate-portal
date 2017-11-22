
  var gmarkers = [];
  // var gicons = [];
  var map = null;
  var webserviceurl = 'http://fusionretailbrands.com.au/webservices/storelocator.asmx';
  var infowindow = new google.maps.InfoWindow({
    size: new google.maps.Size(150,50)
  });

function initialize() {
    
    $("p.no-store-result").hide();
    showDefaultPosition();
    //statewise selection
     $( ".state-control a" ).on( "click", function() {
		 var aURL = window.location.href;
		  if(aURL.indexOf("www")!=-1)
			webserviceurl = 'http://www.fusionretailbrands.com.au/webservices/storelocator.asmx';
      var state = $(this).data("state");
	  var division = $("input[name='division']:checked"). val();
      var url = webserviceurl + "/GetDivisionStoresLatLong";//"/GetAllStoresLatLong";
      searchStateLocations(url,state,division);
	  
      return;
    });

    //form submission
    $("form#map-form").on("submit",function(e){
      e.preventDefault();
	  
	  var aURL = window.location.href;
	  if(aURL.indexOf("www")!=-1)
		  webserviceurl = 'http://www.fusionretailbrands.com.au/webservices/storelocator.asmx';
    // var formData = new FormData($(this)[0]);
    var params = $(this).serialize();
    var url = webserviceurl+"/SearchForDivisionStoresByPostcodeLatLong"
    searchLocations(url,params);
    return;
    }); 
}

function showDefaultPosition(){
  var myOptions = {
      zoom: 13,
      center: new google.maps.LatLng(-37.82263, 144.9322423,17),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    google.maps.event.addListener(map, 'click', function() {
      infowindow.close();
    });
}

function searchLocations(url, params) {
      clearLocations();
       $("p.no-store-result").hide();
      var searchUrl = url   
      downloadUrl(searchUrl,params,function(data) {
      var xml = data.responseXML;
      var markerNodes = xml.getElementsByTagName("StoreLatLong");
      var bounds = new google.maps.LatLngBounds();
      if(markerNodes.length >= 1){
        for (var i = 0; i < markerNodes.length; i++) {
        
          var name = xml.getElementsByTagName("Name")[i].childNodes[0].nodeValue;
          var address1 = xml.getElementsByTagName("Address1")[i].childNodes[0].nodeValue;
          //var address2 = xml.getElementsByTagName("Address2")[i].childNodes[0].nodeValue;
          //var distance = parseFloat(markerNodes[i].getAttribute("distance"));
          var postcode = xml.getElementsByTagName("Postcode")[i].childNodes[0].nodeValue;
          var phone = "";
		  if(xml.getElementsByTagName("Phone")[i].firstChild != null)
				phone = xml.getElementsByTagName("Phone")[i].childNodes[0].nodeValue;
		  var openinghours = "";
		  if(xml.getElementsByTagName("OpeningHours")[i].firstChild != null)
				openinghours = "<br/><p>Opening Hours:</p><p>"+xml.getElementsByTagName("OpeningHours")[i].childNodes[0].nodeValue+"</p>";		  
          var latlng = new google.maps.LatLng(
          parseFloat(xml.getElementsByTagName("Latitude")[i].childNodes[0].nodeValue),
          parseFloat(xml.getElementsByTagName("Longitude")[i].childNodes[0].nodeValue)
          );
        var html = "" + name + "<br/>" + address1 + "<br/>" + postcode + "<br/><p>Phone:" + phone +"</p>"+openinghours;
        //createOption(name, distance, i);

        createMarker(latlng, name, html,postcode);
        bounds.extend(latlng);  

      }
      map.fitBounds(bounds);
      } else {
        $("p.no-store-result").show();
        showDefaultPosition();
      }
    });
  }

  function searchStateLocations(url, state, division) {
   clearLocations();
    var isFound = false;
	$("p.no-store-result").hide();
      var searchUrl = url   
      downloadUrl(searchUrl,"division="+division,function(data) {
      var xml = data.responseXML;
      var markerNodes = xml.getElementsByTagName("StoreLatLong");
      var bounds = new google.maps.LatLngBounds();
	 
       if(markerNodes.length >= 1){
          for (var i = 0; i < markerNodes.length; i++) {
            if(state){
              if (state.toLowerCase() == xml.getElementsByTagName("State")[i].childNodes[0].nodeValue.toLowerCase()){
				  isFound=true;
                var name = xml.getElementsByTagName("Name")[i].childNodes[0].nodeValue;
                var address1 = xml.getElementsByTagName("Address1")[i].childNodes[0].nodeValue;
                //var address2 = xml.getElementsByTagName("Address2")[i].childNodes[0].nodeValue;
                //var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                var postcode = xml.getElementsByTagName("Postcode")[i].childNodes[0].nodeValue;
                var latlng = new google.maps.LatLng(
                parseFloat(xml.getElementsByTagName("Latitude")[i].childNodes[0].nodeValue),
                parseFloat(xml.getElementsByTagName("Longitude")[i].childNodes[0].nodeValue)
                );

                var html = "" + name + " " + address1 + " " + postcode;

                createMarker(latlng, name, html,postcode);
                bounds.extend(latlng);   
              } 
            }      
        }
        map.fitBounds(bounds); 
       } else {
        $("p.no-store-result").show();
        showDefaultPosition();
       }
	   
	   if(!isFound || division=="") {
	    $("p.no-store-result").show();
        showDefaultPosition();
	   }
    });
  }
  
   // A function to create the marker and set up the event window
  function createMarker(latlng,name,html,type) {
    var contentString = html;
    var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title: name,
    });

    // // === Store the type and name info as a marker properties ===
    marker.mytype = type;
    marker.myname = name;
    gmarkers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.setContent(contentString);
      infowindow.open(map,marker);
    });
  }

  function downloadUrl(url,params,callback) {  
      var request = window.ActiveXObject ? 
      new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;   
      request.onreadystatechange = function() {    
        if (request.readyState == 4) {  
          request.onreadystatechange = doNothing;          
          callback(request);    
        } 
      };   
      request.open('POST', url, true);  
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      if(params){
        request.send(params); 
      } else {
        request.send(null); 
      }
      
  }
function clearLocations() {
  for (var i = 0; i < gmarkers.length; i++) {
   gmarkers[i].setMap(null);
  }
  gmarkers.length = 0;
}
  

  function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

   function doNothing() {} 