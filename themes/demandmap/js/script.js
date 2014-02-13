$(function () {
  $('#region-category-filter-plus').click(function (e) {
    $('#region-category-filter-inner').animate({
      fontSize: '1em',
      width: '242px'
    });
    $(this).hide();
    $('#region-category-filter-minus').show();
    e.preventDefault();
  });
  $('#region-category-filter-minus').click(function (e) {
    $('#region-category-filter-inner').animate({
      fontSize: '0',
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
    $('#trigger-list').removeClass('active');
    $(this).addClass('active');
    $('.collapsible-list').hide();
    $('.collapsible-map').show();
    e.preventDefault();
  });
  $('#trigger-list').click(function (e) {
    $('#trigger-map').removeClass('active');
    $(this).addClass('active');
    $('.collapsible-list').show();
    $('.collapsible-map').hide();
    e.preventDefault();
  });

  // reset filter
  $('.btn_reset').click(function (e) {
    $('#resource-filter-form').find('input, select').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
    $('#resource-filter-form').submit();
  });

  //Load colorbox
  $('a.colorbox').colorbox({
    maxHeight: '100%'
  });

  // equal heights
  $('#frontpage-buttons').equalize({children: '.frontpage-buttons-inner'});

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
  // base coordinates
  defaultLatitude = 7.253496050069552;
  defaultLongitude = 31.827392578125;

  LeafIcon = L.Icon.extend({
    options: {
      iconSize:     [25, 41],
      iconAnchor:   [12, 41],
      popupAnchor:  [0, -41]
    }
  });

});