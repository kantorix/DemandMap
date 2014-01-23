  $(function () {
  L.Icon.Default.imagePath = '/themes/demandmap/images/leaflet';
  var baseLayer = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleID}/256/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2012 CloudMade',
  key: 'ad132e106cd246ec961bbdfbe0228fe8',
  styleID: '100249'
  });

    var map = new L.Map('map', {
      center: new L.LatLng(7.253496050069552, 31.827392578125),
      zoom: 10,
      scrollWheelZoom: false,
      //layers: [track, baseLayer]
      layers: [baseLayer]
    });

    var markers = L.markerClusterGroup();
    $.ajax({
      dataType: 'json',
      url: '/api?task=incidents&by=incidentid&id=<?php print $incident_id; ?>',
      success: function (data) {
        $.each(data.payload.incidents, function (i, item) {
          var title = item.incident.incidenttitle;
          var marker = L.marker(new L.LatLng(item.incident.locationlatitude, item.incident.locationlongitude), { title: title });
          marker.bindPopup(title);
          markers.addLayer(marker);
        });
      }
    });
    map.addLayer(markers);
  });