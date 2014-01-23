  $(function () {
    var latitude = <?php echo Kohana::config('settings.default_lat'); ?>;
    var longitude = <?php echo Kohana::config('settings.default_lon'); ?>;
    // set initial marker values
    $('#latitude').val(latitude);
    $('#longitude').val(longitude);
    var submitMap = new L.Map('submitMap', {
      center: new L.LatLng(latitude, longitude),
      zoom: 6,
      scrollWheelZoom: false,
      layers: [baseLayerSubmit]
    });
    var marker = L.marker(new L.LatLng(latitude, longitude), { draggable: true, title: "New marker" });
    marker.on('dragend', function(event) {
      var marker = event.target;
      var result = marker.getLatLng();
      $('#latitude').val(result.lat);
      $('#longitude').val(result.lng);
    });
    submitMap.addLayer(marker);
  });