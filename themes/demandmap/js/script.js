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
  baseLayer = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleID}/256/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors',
    key: 'ad132e106cd246ec961bbdfbe0228fe8',
    styleID: '100249'
  });
  baseLayerSubmit = L.tileLayer('http://{s}.tile.cloudmade.com/{key}/{styleID}/256/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors',
    key: 'ad132e106cd246ec961bbdfbe0228fe8',
    styleID: '100249'
  });
  var styles = [
    {
      featureType: 'all',
      stylers: [{ saturation: -2, lightness: 8, gamma:1.95, weight:1.0 }]
    }
  ];
  googleLayer = new L.Google('ROADMAP', {
    mapOptions: {
      styles: styles
    }
  });
});