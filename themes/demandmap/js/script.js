$(function () {
  $('#trigger-shrink-map').click(function (e) {
    $('.collapsible-views').animate({
      height: '178px'
    });
    $(this).hide();
    $('#trigger-expand-map').show();
    e.preventDefault();
  });
  $('#trigger-expand-map').click(function (e) {
    $('.collapsible-views').animate({
      height: '350px'
    });
    $(this).hide();
    $('#trigger-shrink-map').show();
    e.preventDefault();
  });
  $('#trigger-map').click(function (e) {
    $('.collapsible-list').hide();
    $('.collapsible-map').show();
    e.preventDefault();
  });
  $('#trigger-list').click(function (e) {
    $('.collapsible-list').show();
    $('.collapsible-map').hide();
    e.preventDefault();
  });

  L.Icon.Default.imagePath = '/themes/demandmap/images/leaflet';
  var baseLayer = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleID}/256/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2012 CloudMade',
    key: 'ad132e106cd246ec961bbdfbe0228fe8',
    styleID: '100249'
  });
  /*var track = new L.KML("/themes/demandmap/kml/undp_ss_county.kml", {async: true});
  track.on("loaded", function (e) {
    map.fitBounds(e.target.getBounds());
  });*/

  var map = new L.Map('map', {
    center: new L.LatLng(7.253496050069552, 31.827392578125),
    zoom: 6,
    scrollWheelZoom: false,
    //layers: [track, baseLayer]
    layers: [baseLayer]
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