/*******Dibuja el mapa ********/		
	var raster = new ol.layer.Tile({
						source: new ol.source.OSM({
				            url: 'http://mt{0-3}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
				            attributions: [
				                new ol.Attribution({ html: '© Google' }),
				                new ol.Attribution({ html: '<a href="https://developers.google.com/maps/terms">Terms of Use.</a>' })
				            ]
				        })
					});
	
    var map = new ol.Map({
    	controls: ol.control.defaults().extend([
            new ol.control.FullScreen()
          ]),
    target: 'map',
    layers: [raster],
    view: new ol.View({
      center: ol.proj.fromLonLat([-76.2595, -9.8606]),
      zoom: 6.5
    })
  });