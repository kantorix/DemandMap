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
});