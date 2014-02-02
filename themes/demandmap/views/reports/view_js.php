<?php // Hack ushahidis javascript embedding to get syntax highlighting in editors ?>
<?php if (1 == 0) { ?>
<script type="text/javascript">
  <?php } ?>
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
          var title = '<h3> ' + item.incident.incidenttitle + '</h3>';
          var marker = L.marker(new L.LatLng(item.incident.locationlatitude, item.incident.locationlongitude), { title: "test" });
          marker.bindPopup(title).openPopup();
          markers.addLayer(marker);
        });
        map = new L.Map('map', {
          center: new L.LatLng(latitude, longitude),
          zoom: 8,
          scrollWheelZoom: false,
          layers: [googleLayer],
          fullscreenControl: true,
			    fullscreenControlOptions: {
            title: 'Toggle Fullscreen Mode'
			    }
        });
        // detect fullscreen toggling and activate scrollwheel
        map.on('enterFullscreen', function(){
          map.scrollWheelZoom.enable();
        });
        map.on('exitFullscreen', function(){
          map.scrollWheelZoom.disable();
        });
        map.addLayer(markers);
      }
    });
  });
  <?php if (1 == 0) { ?>
</script>
<?php } ?>