  $(function () {
    var map = new L.Map('map', {
      center: new L.LatLng(7.253496050069552, 31.827392578125),
      zoom: 6,
      scrollWheelZoom: false,
      //layers: [track, baseLayer]
      layers: [googleLayer]
    });


    var markers = L.markerClusterGroup({
      maxClusterRadius: 40,
      iconCreateFunction: function(cluster) {
        var childCount = cluster.getChildCount();
        var c = ' marker-cluster-';
        if (childCount < 20) {
          c += 'small';
        } else if (childCount < 50) {
          c += 'medium';
        } else {
          c += 'large';
        }
        return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', className: 'marker-cluster' + c, iconSize: new L.Point(40, 40) });
      }
    });
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

    /*var track = new L.KML("/themes/demandmap/kml/undp_states.kml", {async: true});
    track.on("loaded", function(e) { map.fitBounds(e.target.getBounds()); });*/

    map.addLayer(track);
  });