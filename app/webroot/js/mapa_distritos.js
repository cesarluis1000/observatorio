	var style = new ol.style.Style({
		fill : new ol.style.Fill({
			color : 'rgba(255, 255, 255, 0.3)'//color de backgrount de poligono
		}),
		stroke : new ol.style.Stroke({
			color : '#319FD3',
			width : 1 //Ancho de limite
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
	var url  = base+'Distritos/geojson?departamento_id='+departamento_id+'&provincia_id='+provincia_id;
	var url2 = base+'Distritos/delitosgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id;
	var url3 = base+'Distritos/institucionesgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id;
	var url4 = base+'ZonaPolygons/panamericanosgeojson';
	
	/*********PUNTOS DELITOS*********/
	var ftrCoordenadas 		= [];
	var vectorSource;
	var a_vectorLayerDelito	= [];
	var a_style	 			= [];
	
	if($('.form-check input:checked').serialize()==''){
		$("form input:checkbox").attr( "checked" , true );
	}
	
	$.ajax({
		url : url2,
		dataType : 'json',
		async : false,
		method: 'get',
		data: $('.form-check input:checked, input[type=text], input[type=hidden]').serialize(),
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
								scale: 0.6,
								src : './img/map/'+v.delito 
							}))
						});
						
						vectorSource = new ol.source.Vector({
							features : ftrCoordenadas,
							format : new ol.format.GeoJSON(),
							url : url
						});
						
						a_vectorLayerDelito[k] = new ol.layer.Vector({
													source : vectorSource,
													style : a_style[k]
											});
					});
				}
			});
		}
	});
	
	/*********INSTITUTOS*********/
	var ftrCoordenadasInst = [];
	var vectorSourceInst;
	var a_vectorLayerInst = [];
	var a_styleInst = [];
	
	$.ajax({
		url : url3,
		dataType : 'json',
		async : false,
		method: 'get',		
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
								scale: 0.3,
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
	var raster = new ol.layer.Tile({
						source		: new ol.source.XYZ({
						attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/' + 'rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
						url			: 'https://server.arcgisonline.com/ArcGIS/rest/services/' + 'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
						})
					});
		
	/*******End Dibuja el mapa ********/
	
		var source = new ol.source.Vector({
							format 	: new ol.format.GeoJSON(),
							url 	: url
						});
	 
	/*******Dibuja el perimetro ********/
	var vectorLayer = new ol.layer.Vector({
		source 	: source,
		style 	: function(feature) {
						style.getText().setText(feature.get('nombdist'));
						return style;
					}
	});
	/*******Dibuja el perimetro ********/
	
	/*******Centrar el poligo en el mapa********/
		var coordenada;
		var vectorSourcePol;
	
		$.ajax({
			url: base+'Provincias/geojson?departamento_id='+departamento_id+'&provincia_id='+provincia_id,
		    dataType: 'json',
		    async: false,
		}).done(function(data){
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
	
	/*******Zonas Panamericanos********/
		var stylePanamericano = new ol.style.Style({
			fill : new ol.style.Fill({
				color : 'rgba(255, 130, 46, 0.6)'//color de backgrount de poligono
			}),
			stroke : new ol.style.Stroke({
				color : '#FA5B0F',
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
		var sourcePanamericano = new ol.source.Vector({
			format : new ol.format.GeoJSON(),
			url : url4
		});

	var vectorLayerPanamericano = new ol.layer.Vector({
		  source: sourcePanamericano,
		  style : function(feature) {
					  stylePanamericano.getText().setText(feature.get('nombre'));
						return stylePanamericano;
					}
		});
	/*******Zonas Panamericanos********/
	
	var a_layers = [ raster, vectorLayer, vectorLayerPanamericano];
	
	for (var i = 0; i < a_vectorLayerDelito.length; i++) {
		a_layers.push(a_vectorLayerDelito[i]);
	}
	for (var i = 0; i < a_vectorLayerInst.length; i++) {				
		a_layers.push(a_vectorLayerInst[i]);
	}
		
	/*******Popup detalle*******/
	
	var container 	= document.getElementById('popup');
	var content 	= document.getElementById('popup-content');
	var closer 		= document.getElementById('popup-closer');
	
	var overlay = new ol.Overlay({
					  element			: container,
					  autoPan			: true,
					  autoPanAnimation	: {
										    duration: 250
										  }
					});
	
	closer.onclick = function() {
						  overlay.setPosition(undefined);
						  closer.blur();
						  return false;
						};	
						
/*******MAPA*******/	
var map = new ol.Map({	
	layers : a_layers,
	overlays: [overlay],
	target : 'map',
	controls : controls,
	view : view
});

/*******ACCION Popup detalle*******/
map.on('singleclick', function(evt) {
	var feature = map.forEachFeatureAtPixel(evt.pixel,function(feature) {return feature;});
	
	if (feature !== undefined && feature.get('name') !== undefined) {
		  var coordinate 	= evt.coordinate;
		  var xy 			= ol.coordinate.toStringXY(ol.proj.transform(coordinate,'EPSG:3857', 'EPSG:4326'), 15);	  
		  content.innerHTML = '<p><b>Comiseria:</b></p>' + xy;
		  overlay.setPosition(coordinate);
	}  
  
});

	/*****Redimencionar el zoom deacuerdo al poligono o marco de busqueda.****/	
	ghostZoom = $('#ReportesGhostZoom').val();
	centroZoom = $('#ReportesCentroZoom').val().split(',');
	if (ghostZoom != '' && centroZoom != '') {
		map.getView().setCenter([parseFloat(centroZoom[0]),parseFloat(centroZoom[1])]);
	    map.getView().setZoom(ghostZoom);
	}else{
		map.getView().fit(vectorSourcePol[0].getGeometry(), map.getSize())
	} 

	var ghostZoom = map.getView().getZoom();
	    map.on('moveend', function(evt) {
	    	//console.info(map.getView().getZoom());
	        if (ghostZoom != map.getView().getZoom()) {
	            ghostZoom = map.getView().getZoom();            
	            $('#ReportesGhostZoom').val(ghostZoom);            
	        }
	        centroZoom =map.getView().getCenter();
	        $('#ReportesCentroZoom').val(centroZoom);        
	    });	
	    
/******Geolocación Ubicacoin GPS******/
	/*
	function el(id) {
		  return document.getElementById(id);
		}
	
	var geolocation = new ol.Geolocation({
		  projection: view.getProjection()
		})
	
		el('chkGeolocalizacion').addEventListener('change', function() {
		  geolocation.setTracking(this.checked);
		});
		
		// update the HTML page when the position changes.
		geolocation.on('change', function() {
		});
	*/
		var positionFeature = new ol.Feature();
	
		positionFeature.setStyle(new ol.style.Style({
			image: new ol.style.Icon(/** @type {olx.style.IconOptions} */
					({
						anchor : [ 0.5, 30 ],
						anchorXUnits : 'fraction',
						anchorYUnits : 'pixels',
						src : '../img/map/icons8-visit-40.png'
					}))
		}));
	/*
		geolocation.on('change:position', function() {
		  var coordinates = geolocation.getPosition();
		  positionFeature.setGeometry(coordinates ?new ol.geom.Point(coordinates) : null);
		  view.setCenter(coordinates);
	      view.setZoom(14);
		});
	*/
	new ol.layer.Vector({
	  map: map,
	  source: new ol.source.Vector({
	    features: [positionFeature]
	  })
	});	

/******Geolocación Ubicacoin GPS******/		    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    