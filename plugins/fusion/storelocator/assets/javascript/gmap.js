
  var gmarkers = [];
  // var gicons = [];
  var map = null;
  var webserviceurl = 'http://services.uat.coloradogroup.com.au/storelocator.asmx';
  var infowindow = new google.maps.InfoWindow({
    size: new google.maps.Size(150,50)
  });

  // A function to create the marker and set up the event window
  function createMarker(latlng,name,html,type) {
    var contentString = html;
    var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title: name,
      // zIndex: Math.round(latlng.lat()*-100000)<<5
    });

    // === Store the type and name info as a marker properties ===
    marker.mytype = type;
    marker.myname = name;
    gmarkers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.setContent(contentString);
      infowindow.open(map,marker);
    });
  }
  // == shows all markers of a particular type, and ensures the checkbox is checked ==
  function show(type) {
    for (var i=0; i<gmarkers.length; i++)
    {
      if (gmarkers[i].mytype == type)
      {
      gmarkers[i].setVisible(true);
      }
    }
    // == check the checkbox ==
    document.getElementById(type+"box").checked = true;
  }

  // == hides all markers of a particular type, and ensures the checkbox is cleared ==
  function hide(type) {
    for (var i=0; i<gmarkers.length; i++) {
      if (gmarkers[i].mytype == type) {
        gmarkers[i].setVisible(false);
      }
    }
    // == clear the checkbox ==
    document.getElementById(type+"box").checked = false;
    // == close the info window, in case its open on a marker that we just hid
    infowindow.close();
  }
      
  function hideall() {
    for (var i=0; i<gmarkers.length; i++) {
      gmarkers[i].setVisible(false);
    }
  }

  // == a checkbox has been clicked ==
  function boxclick(box,type) {
    if (box.checked) {
      show(type);
    } else {
      hide(type);
    }
  }   

  function searchLocations(url) {
    clearLocations();

    var radius = document.getElementById('radiusSelect').value;
    var searchUrl = 'phpsqlsearch_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
    
    downloadUrl(searchUrl, function(data) {
      var xml = parseXml(data);
      var markerNodes = xml.documentElement.getElementsByTagName("store");
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0; i < markerNodes.length; i++) {
        var name = markerNodes[i].getAttribute("name");
        var address = markerNodes[i].getAttribute("address");
        var distance = parseFloat(markerNodes[i].getAttribute("distance"));
        var latlng = new google.maps.LatLng(
        parseFloat(markerNodes[i].getAttribute("lat")),
        parseFloat(markerNodes[i].getAttribute("lng")));

        createOption(name, distance, i);
        createMarker(latlng, name, address);
        bounds.extend(latlng);
      }

      map.fitBounds(bounds);
      locationSelect.style.visibility = "visible";

      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        google.maps.event.trigger(markers[markerNum], 'click');
      };
    });
  }
        
  function downloadUrl(url, callback) {  
      var request = window.ActiveXObject ? 
      new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;   
      request.onreadystatechange = function() {    
        if (request.readyState == 4) {            
          callback(request);    
        } 
      };   
      request.open('GET', url, true);  
      request.send(null); 
  }

  function initialize() {
    var myOptions = {
      zoom: 13,
      center: new google.maps.LatLng(-37.82263, 144.9322423,17),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    google.maps.event.addListener(map, 'click', function() {
      infowindow.close();
    });

    // // Change this depending on the name of your  file
    // downloadUrl("stores.xml", function(data) {
    //   var xml = data.responseXML;
    //   var markers = xml.documentElement.getElementsByTagName("store");
      
    //   for (var i = 0; i < markers.length; i++) {
    //     var name = markers[i].getAttribute("name");
    //     var address1 = markers[i].getAttribute("address1");
    //     var address2 = markers[i].getAttribute("address2");
    //     var postcode = markers[i].getAttribute("state");
    //     var lat = parseFloat(markers[i].getAttribute("latitude"));
    //     var lng = parseFloat(markers[i].getAttribute("longitude"));
    //     var point = new google.maps.LatLng(lat,lng);
    //     var html = "" + name + " " + address1 + " " + postcode;
    //     var store = createMarker(point,name,html,postcode);
    //   }
    // });
  }

  $( "div#brand" ).on( "click", function() {
    
  });


    //]]>
  