$(function () {
  $('#region-category-filter-plus').click(function (e) {
    $('#region-category-filter-inner').animate({
      width: '242px'
    });
    $(this).hide();
    $('#region-category-filter-minus').show();
    e.preventDefault();
  });
  $('#region-category-filter-minus').click(function (e) {
    $('#region-category-filter-inner').animate({
      width: '0'
    });
    $(this).hide();
    $('#region-category-filter-plus').show();
    e.preventDefault();
  });
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
  var styles = [
    {
      featureType: 'all',
      stylers: [
        { saturation: -2, lightness: 8, gamma: 1.95, weight: 1.0 }
      ]
    }
  ];
  googleLayer = new L.Google('ROADMAP', {
    mapOptions: {
      styles: styles
    }
  });
  googleLayerSubmit = new L.Google('ROADMAP', {
    mapOptions: {
      styles: styles
    }
  });
});