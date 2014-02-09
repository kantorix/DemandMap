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

  // icons
  icon_cat4 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-icon.png'
  });

  // skills
  icon_cat14 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-14.png'
  });
  icon_cat15 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-15.png'
  });
  icon_cat16 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-16.png'
  });
  icon_cat17 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-17.png'
  });
  icon_cat18 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-18.png'
  });
  icon_cat19 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-19.png'
  });
  icon_cat20 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-20.png'
  });
  icon_cat21 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-21.png'
  });
  icon_cat22 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-22.png'
  });
  icon_cat23 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-23.png'
  });
  icon_cat24 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-24.png'
  });

  // education
  icon_cat11 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-11.png'
  });
  icon_cat12 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-12.png'
  });
  icon_cat13 = L.icon({
    iconUrl: L.Icon.Default.imagePath + '/marker-cat-13.png'
  });

});