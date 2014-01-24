  $(function () {
    var map = new L.Map('map', {
      center: new L.LatLng(7.253496050069552, 31.827392578125),
      zoom: 6,
      scrollWheelZoom: false,
      //layers: [track, baseLayer]
      layers: [googleLayer]
    });


    var markers = L.markerClusterGroup();
    $.ajax({
      dataType: 'json',
      url: '/api?task=incidents',
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