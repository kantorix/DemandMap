<?php // Hack ushahidis javascript embedding to get syntax highlighting in editors ?>
<?php if (1 == 0) { ?>
<script type="text/javascript">
<?php } ?>
  $(function () {
    markers = null;
    function addMarkers(category_id) {
      category_id = category_id || '';
      filter = '';
      markers = L.markerClusterGroup({
        maxClusterRadius: 40,
        iconCreateFunction: function (cluster) {
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
      if (category_id.length > 0) {
        filter = '&by=catid&id=' + category_id;
      }
      if (filter.lengt > 0) {
        filter = '&by=all';
      }
      $.ajax({
        dataType: 'json',
        url: '/api?task=incidents' + filter,
        success: function (data) {
          $.each(data.payload.incidents, function (i, item) {
            var title = '<h3><a href="reports/view/' + item.incident.incidentid + '">' + item.incident.incidenttitle + '<a></h3>';
            var marker = L.marker(new L.LatLng(item.incident.locationlatitude, item.incident.locationlongitude), { title: title });
            marker.bindPopup(title);
            markers.addLayer(marker);
          });
        }
      });
      map.addLayer(markers);
    };

    var map = new L.Map('map', {
      center: new L.LatLng(7.253496050069552, 31.827392578125),
      zoom: 6,
      scrollWheelZoom: false,
      layers: [googleLayer]
    });

    // add markers to the map
    addMarkers();

    $('#type_switch a').click(function(e) {
      $('#type_switch a').removeClass('active');
      $(this).addClass('active');
      map.removeLayer(markers);
      category_id = $(this).attr('id').substr(4);
      addMarkers(category_id);
      if (category_id != '') {
        $('.category_swich_cat').hide();
        $('#category_swich_cat_' + category_id).show();
      } else {
        $('.category_swich_cat').show();
      }
      e.preventDefault();
    });

    $('#category_switch a').click(function(e) {
      $('#category_switch a').removeClass('active');
      $(this).addClass('active');
      map.removeLayer(markers);
      category_id = $(this).attr('id').substr(4);
      addMarkers(category_id);
      e.preventDefault();
    });

    /*var track = new L.KML("/themes/demandmap/kml/undp_states.kml", {async: true});
     track.on("loaded", function(e) { map.fitBounds(e.target.getBounds()); });

     map.addLayer(track);*/
  });
<?php if (1 == 0) { ?>
</script>
<?php } ?>