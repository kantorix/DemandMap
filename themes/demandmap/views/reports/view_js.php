$(function () {
    var markers = L.markerClusterGroup();
    var latitude = null;
    var longitude = null;
    $.ajax({
      dataType: 'json',
      url: '/api?task=incidents&by=incidentid&id=<?php print $incident_id; ?>',
      success: function (data) {
        $.each(data.payload.incidents, function (i, item) {
          latitude = item.incident.locationlatitude;
          longitude = item.incident.locationlongitude;
          var title = item.incident.incidenttitle;
          var marker = L.marker(new L.LatLng(item.incident.locationlatitude, item.incident.locationlongitude), { title: title });
          marker.bindPopup(title);
          markers.addLayer(marker);
        });
        var map = new L.Map('map', {
          center: new L.LatLng(latitude, longitude),
          zoom: 6,
          scrollWheelZoom: false,
          layers: [baseLayer]
        });
        map.addLayer(markers);
      }
  });
});