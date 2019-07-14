$(document).ready(function() {
	var style = new ol.style.Style({
		fill : new ol.style.Fill({
			color : 'rgba(255, 255, 255, 0.0)'
		}),
		stroke : new ol.style.Stroke({
			color : '#319FD3',
			width : 1
		}),
		text : new ol.style.Text({
			font : '10px Calibri,sans-serif',
			fill : new ol.style.Fill({
				color : '#000'
			}),
			stroke : new ol.style.Stroke({
				color : '#fff',
				width : 5
			})
		})
	});

	var source = new ol.source.Vector({
		url : '../js/distrital.geojson',
		format : new ol.format.GeoJSON()
	});

	var vectorLayer = new ol.layer.Vector({
		source : source,
		style : function(feature) {
			style.getText().setText(feature.get('NOMBDIST'));
			return style;
		}
	});

	var view = new ol.View({
		center : [ -8573000, -1354000 ],
		zoom : 11.5
	})

	var map = new ol.Map({
		layers : [ new ol.layer.Tile({
			source : new ol.source.OSM()
		}), vectorLayer ],
		target : 'map',
		view : view
	});

	var highlightStyle = new ol.style.Style({
		stroke : new ol.style.Stroke({
			color : '#f00',
			width : 1
		}),
		fill : new ol.style.Fill({
			color : 'rgba(255,0,0,0.1)'
		}),
		text : new ol.style.Text({
			font : '12px Calibri,sans-serif',
			fill : new ol.style.Fill({
				color : '#000'
			}),
			stroke : new ol.style.Stroke({
				color : '#fff',
				width : 3
			})
		})
	});

	var featureOverlay = new ol.layer.Vector({
		source : new ol.source.Vector(),
		map : map,
		style : function(feature) {
			highlightStyle.getText().setText(feature.get('NOMBDIST'));
			return highlightStyle;
		}
	});

	var highlight;
	var displayFeatureInfo = function(pixel) {

		var feature = map.forEachFeatureAtPixel(pixel, function(feature) {
			return feature;
		});

		var info = document.getElementById('info');
		if (feature) {
			info.innerHTML = 'Departamento: '+ feature.get('NOMBDIST') + ' Area: '+ feature.get('AREA_MINAM');
		} else {
			//info.innerHTML = '&nbsp;';
		}
		
		if (feature !== highlight) {
			if (highlight) {
				featureOverlay.getSource().removeFeature(highlight);
			}
			if (feature) {
				featureOverlay.getSource().addFeature(feature);
			}
			highlight = feature;
		}

	};

	map.on('click', function(evt) {
		displayFeatureInfo(evt.pixel);
	});

	var zoomtoswitzerlandbest = document.getElementById('zoomtoswitzerlandbest');
	zoomtoswitzerlandbest.addEventListener('click', function() {

		var features = source.getFeatures();
	    for(var i=0; i< features.length; i++) {
	    	if(source.getFeatures()[i].get('NOMBDIST') == 'LA VICTORIA' && 
	    			source.getFeatures()[i].get('NOMBPROV') == 'LIMA' &&
	    			 	source.getFeatures()[i].get('NOMBDEP') == 'LIMA'){
	    		break;
	    		
	    	}	    	
	    }		
	    
		var feature = source.getFeatures()[i];
		var polygon = (feature.getGeometry());
		
		view.fit(polygon, {
			padding : [ 5, 20, 5, 20 ],
			constrainResolution : false
		});
		
	}, false);

});
