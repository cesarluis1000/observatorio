
	var style = new ol.style.Style({
		fill : new ol.style.Fill({
			color : 'rgba(255, 255, 255, 0.5)'//color de backgrount de poligono
		}),
		stroke : new ol.style.Stroke({
			color : '#319FD3',
			width : 2 //Ancho de limite
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

	var departamento_id = $('#ReportesDepartamentoId option:selected').val();
	var provincia_id = $('#ReportesProvinciaId option:selected').val();
	
	var base = $('base').attr('href');
	var url  = base+'/Distritos/geojson?departamento_id='+departamento_id+'&provincia_id='+provincia_id;
	var url2 = base+'/Distritos/delitosgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id;
	var url3 = base+'/Distritos/institucionesgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id;
	
	/*********Puntos*********/
	var ftrCoordenadas = [];
	var vectorSource;
	var a_vectorLayer = [];
	var a_style = [];
	var a_clusterSource = [];
	var distance = document.getElementById('distance');
	
	if($('.form-check input:checked').serialize()==''){
		$("form input:checkbox").attr( "checked" , true );
	}
	
	$.ajax({
		url : url2,
		dataType : 'json',
		async : false,
		method: 'get',
		data: $('.form-check input:checked, input[type=text], input[type=hidden]').serialize(),
		//data: {categoria: $('.form-check input:checked').serialize()},
		success : function(json1) {
			$.each(json1, function(key, data) {
				if (key == 'features') {
					$.each(data, function(k, v) {
						ftrCoordenadas = [];
						if (v.type == 'Feature') {
							if (v.geometry.coordinates[0].length >= 1) {
								$.each(v.geometry.coordinates[0], function(i, c) {
									ftrCoordenadas[i] = new ol.Feature({
										geometry : new ol.geom.Point(ol.proj
												.transform(c, 'EPSG:4326','EPSG:3857')),
										name : c,
										population : 4000,
										rainfall : 500
									});
	
								});
	
							}
						}
						
						a_style[k] = new ol.style.Style({	
							image : new ol.style.Icon(
							({
								anchor : [ 0.5, 30 ],
								anchorXUnits : 'fraction',
								anchorYUnits : 'pixels',
								scale: 0.4,
								src : './img/map/'+v.delito 
							}))
						});
						
						vectorSource = new ol.source.Vector({
							features : ftrCoordenadas,
							format : new ol.format.GeoJSON(),
							url : url
						});
						
						a_vectorLayer[k] = new ol.layer.Vector({
													source : vectorSource,
													style : a_style[k]
											});
						
						
					});
				}
			});
		}
	});
	
	/*********Institucion*********/
	var ftrCoordenadasInst = [];
	var vectorSourceInst;
	var a_vectorLayerInst = [];
	var a_styleInst = [];
	
	$.ajax({
		url : url3,
		dataType : 'json',
		async : false,
		method: 'get',
		//data: $('.form-check input:checked, input[type=text], input[type=hidden]').serialize(),
		//data: {categoria: $('.form-check input:checked').serialize()},
		success : function(json1) {
			$.each(json1, function(key, data) {
				if (key == 'features') {
					$.each(data, function(k, v) {
						ftrCoordenadasInst = [];
						if (v.type == 'Feature') {
							if (v.geometry.coordinates[0].length >= 1) {
								$.each(v.geometry.coordinates[0], function(i, c) {
									ftrCoordenadasInst[i] = new ol.Feature({
										geometry : new ol.geom.Point(ol.proj
												.transform(c, 'EPSG:4326','EPSG:3857')),
										name : c,
										population : 4000,
										rainfall : 500
									});
	
								});
	
							}
						}
						
						a_styleInst[k] = new ol.style.Style({	
							image : new ol.style.Icon(
							({
								anchor : [ 0.5, 30 ],
								anchorXUnits : 'fraction',
								anchorYUnits : 'pixels',
								scale: 0.2,
								src : './img/map/'+v.institucion
							}))
						});
						
						vectorSourceInst = new ol.source.Vector({
							features : ftrCoordenadasInst,
							format : new ol.format.GeoJSON(),
							url : url
						});
						
						a_vectorLayerInst[k] = new ol.layer.Vector({
													source : vectorSourceInst,
													style : a_styleInst[k]
											});
						
					});
				}
			});
		}
	});

	/*******Dibuja el mapa ********/
	/*
	var raster = new ol.layer.Tile({
		source : new ol.source.OSM()
	});
	*/
	var raster = new ol.layer.Tile({
	source: new ol.source.XYZ({
	attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/' +
	  'rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
	url: 'https://server.arcgisonline.com/ArcGIS/rest/services/' +
	  'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
	})
		});
	
	
	/*******End Dibuja el mapa ********/
	
	var source = new ol.source.Vector({
		format : new ol.format.GeoJSON(),
		url : url
	});
	 
	/*******Dibuja el perimetro ********/
	var vectorLayer = new ol.layer.Vector({
		source : source,
		style : function(feature) {
			style.getText().setText(feature.get('nombdist'));
			return style;
		}
	});
	/*******Dibuja el perimetro ********/
	
	/*******Centrar el poligo en el mapa********/
	var coordenada;
	var vectorSourcePol;

	$.ajax({
		url: base+'/Provincias/geojson?departamento_id='+departamento_id+'&provincia_id='+provincia_id,
	    dataType: 'json',
	    async: false,
	}).done(function(data){
		//debugger;
	    var format = new ol.format.GeoJSON();
	    vectorSourcePol = format.readFeatures(data, {
					        defaultDataProjection: ol.proj.get('EPSG:3765'),
					        featureProjection: 'EPSG:3857'
					    });
	    Extent = vectorSourcePol[0].getGeometry().getExtent();  
	    
	    X = Extent[0] + (Extent[2]-Extent[0])/2;
	    Y = Extent[1] + (Extent[3]-Extent[1])/2;
	    coordenada = [X, Y];
	    
	});
	
	var view = new ol.View({
		center : coordenada
	})
	/*******END Centrar el poligo en el mapa********/
	
	/*******Visualización de las coordenadas con el mouse********/		
	var mousePositionControl = new ol.control.MousePosition({
		coordinateFormat : ol.coordinate.createStringXY(12),
		projection : 'EPSG:4326',// (-xx.xxxx)
	});

	var controls = ol.control.defaults({
		attributionOptions : {
			collapsible : false
		}
	}).extend([ mousePositionControl ]);
	
	/*******END Visualización de las coordenadas con el mouse********/
	
	var a_layers = [ raster, vectorLayer];
	
	for (var i = 0; i < a_vectorLayer.length; i++) {
		a_layers.push(a_vectorLayer[i]);
	}
	
	for (var i = 0; i < a_vectorLayerInst.length; i++) {
		//a_layers.push(a_vectorLayerInst[i]);
	}
		
	
/*******MAPA*******/	
var map = new ol.Map({
	controls : controls,
	layers : a_layers,
	target : 'map',
	view : view
});

	//Redimencionar el zoom para el tamaño del poligono
	//map.getView().fit(vectorSourcePol[0].getGeometry(), map.getSize())
	ghostZoom = $('#ReportesGhostZoom').val();
	centroZoom = $('#ReportesCentroZoom').val().split(',');
	if (ghostZoom != '' && centroZoom != '') {
		map.getView().setCenter([parseFloat(centroZoom[0]),parseFloat(centroZoom[1])]);
	    map.getView().setZoom(ghostZoom);
	}else{
		map.getView().fit(vectorSourcePol[0].getGeometry(), map.getSize())
	} 

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
			highlightStyle.getText().setText(feature.get('nombdist'));
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
			console.log(source.getFeatures());
			info.innerHTML = 'Distrito: '+ feature.get('nombdist') + ' Area: '+ feature.get('area_minam');
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
/*
	var zoomDepartamento = document.getElementById('zoomDepartamento');
	zoomDepartamento.addEventListener('click', function() {	

		var departamento = $('#ReportesDepartamentoId option:selected').text();
		
		if(departamento == 'Seleccionar'){
			location.reload();
		}else{
			var features = source.getFeatures();
		    for(var i=0; i< features.length; i++) {
		    	if(source.getFeatures()[i].get('nombdist') == departamento){
			    	break;
		    	}	    	
		    }
			
			var feature = source.getFeatures()[i];
			var polygon = (feature.getGeometry());
			
			view.fit(polygon, {
				padding : [ 5, 20, 5, 20 ],
				constrainResolution : false
			});
		}
		
		
	}, false);
	*/
