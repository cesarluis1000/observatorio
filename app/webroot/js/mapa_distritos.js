	var departamento_id = $('#ReportesDepartamentoId option:selected').val();
	var provincia_id 	= $('#ReportesProvinciaId option:selected').val();
	var distrito_id 	= $('#ReportesDistritoId option:selected').val();
	var base  = $('base').attr('href');
	var poligono = (distrito_id != '')?'Distritos':'Provincias';
	var url   = base+poligono+'/geojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id='+ distrito_id;
	var url3  = base+'Distritos/institucionesgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id=' + distrito_id + '&reporte=criminologico';	
	var url4  = base+'ZonaPolygons/panamericanosgeojson';
	var url_c = url; //base+poligono+'/geojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id;
	
	
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
	
	/******************************/
	
	/*******Zonas DISTRITO********/
		var style = new ol.style.Style({
			fill : new ol.style.Fill({
				color : 'RGBA(128,128,128,0.1)' //color de backgrount de poligono
			}),
			stroke : new ol.style.Stroke({
				color : '#85B037',
				width : 2 //Ancho de limite
			}),
			text : new ol.style.Text({
				font : '20px Calibri,sans-serif',
				fill : new ol.style.Fill({
					color : '#0000FF'
				}),
				stroke : new ol.style.Stroke({
					color : '#fff',
					width : 3
				})
			})
		});
	
		var source = new ol.source.Vector({
									format : new ol.format.GeoJSON(),
									url : url
								});	
	//console.info(source);
	var vectorLayer = new ol.layer.Vector({
		source 	: source,
		style 	: function(feature) {						
						style.getText().setText(feature.get('nombdist'));
						return style;
					}
	});
	/*******************************************/
		
	/*******Centrar el poligo en el mapa********/
		var coordenada;
		var vectorSourcePol;
		var Extent;
		
		$.ajax({
			url : url_c,
			dataType : 'json',
			async : false,
		}).done(function(data) {
			var format = new ol.format.GeoJSON();
			vectorSourcePol = format.readFeatures(data, {
								defaultDataProjection : ol.proj.get('EPSG:4326'),
								featureProjection : 'EPSG:3857'
							});

			Extent = vectorSourcePol[0].getGeometry().getExtent();			
			center = ol.extent.getCenter(Extent);
		});	
	/**********************************************/	
	
	var a_layers = [raster, vectorLayer];
	
	/*********PUNTOS DELITOS*********/		
	var params 		 = $('.form-check input:checked, input[type=text], input[type=hidden]').serialize();		
	var urldenuncias = base+'denuncias/denunciasgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id=' + distrito_id + params;
	
	var baseTextStyle = {
			font : '10px Calibri,sans-serif',
			fill : new ol.style.Fill({
				color : '#0000FF'
			}),
			stroke : new ol.style.Stroke({
				color : '#fff',
				width : 5
			})
	    };
	
	var styleSearchPoly = new ol.style.Style({
		fill : new ol.style.Fill({
			color : 'RGBA(0,0,255,0.07)' //color de backgrount de poligono
		}),
		stroke : new ol.style.Stroke({
			color : '#0000FF',
			width : 2 //Ancho de limite
		}),
		text : new ol.style.Text(baseTextStyle)
	});
	
	var sourceDenuncias = new ol.source.Vector({
		format 	: new ol.format.GeoJSON(),
		url 	: urldenuncias
	});	
	//new ol.layer.Vector //ol.layer.Heatmap 
	var vectorLayerDenuncias = new ol.layer.Heatmap({
		source 	: sourceDenuncias,
		style 	: styleFunctionDenuncias
	});
	
	function styleFunctionDenuncias(feature, resolution) {			
		var styleSearch;        
        	var iconName = "img/map/"+feature.get("icon");		    
		    baseTextStyle.text = feature.get('denuncia');
		    
		    styleSearch = new ol.style.Style({
					        image: new ol.style.Icon(({
					        	anchor		: [0.3, 30],
					        	scale		: 1,
					            anchorXUnits: 'fraction',
					            anchorYUnits: 'pixels',
					            src			: iconName
					        })),
					        text: new ol.style.Text(baseTextStyle),
					        zIndex: 2
					    });	        	
       		   
		return [styleSearch];
	}

	a_layers.push(vectorLayerDenuncias);	
	/******************************/
	
	/*********PUNTOS INSTITUTOS*********/
	/*
	var ftrCoordenadasInst = [];
	var vectorSourceInst;
	var a_vectorLayerInst = [];
	var a_styleInst = [];
	var institucion;
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
							institucion = v;
							if (v.geometry.coordinates[0].length >= 1) {
								$.each(v.geometry.coordinates[0], function(i, c) {
									ftrCoordenadasInst[i] = new ol.Feature({
										geometry 				: new ol.geom.Point(ol.proj.transform(c, 'EPSG:4326','EPSG:3857')),
										name 					: c,
										tipoInstitucion 		: institucion.tipoInstitucion,
										institucionId 			: institucion.institucionId,
										institucionNombre		: institucion.institucionNombre,
										institucionUbicacion	: institucion.institucionUbicacion,
									});
	
								});
	
							}
						}
						
						a_styleInst[k] 		= new ol.style.Style({	
													image : new ol.style.Icon(
													({
														anchor 			: [ 0.5, 30 ],
														anchorXUnits 	: 'fraction',
														anchorYUnits 	: 'pixels',
														scale			: 0.25,
														src 			: './img/map/'+v.institucion
													}))
												});
						
						vectorSourceInst 	= new ol.source.Vector({
												features 	: ftrCoordenadasInst,
												format 		: new ol.format.GeoJSON(),
												url 		: url
											});
						
						a_vectorLayerInst[k] = new ol.layer.Vector({
													source 	: vectorSourceInst,
													style 	: a_styleInst[k]
											});
						
					});
				}
			});
		}
	});
	*/
	/******************************/
		
	thebox = ol.proj.transformExtent(Extent, 'EPSG:3857', 'EPSG:4326');
	x1 = thebox[0].toFixed(6);
	y1 = thebox[3].toFixed(6);
	x2 = thebox[2].toFixed(6);
	y2 = thebox[1].toFixed(6);
	viewbox = x1.toString().concat(',',y1,',',x2,',',y2);
	
	/*********PUNTOS INSTITUTOS*********/
	var instituciones = ['hospital', 'policia','bomberos'];
	
	instituciones.forEach(function (elemento, indice, array) {
		var urlopenstreetmap = 'https://nominatim.openstreetmap.org/?format=geojson&q='+elemento+'&polygon_geojson=0&bounded=1&limit=100&viewbox='+viewbox;
		
		var baseTextStyle = {
				font : '10px Calibri,sans-serif',
				fill : new ol.style.Fill({
					color : '#0000FF'
				}),
				stroke : new ol.style.Stroke({
					color : '#fff',
					width : 5
				})
		    };
		
		var styleSearchPoly = new ol.style.Style({
			fill : new ol.style.Fill({
				color : 'RGBA(0,0,255,0.07)' //color de backgrount de poligono
			}),
			stroke : new ol.style.Stroke({
				color : '#0000FF',
				width : 2 //Ancho de limite
			}),
			text : new ol.style.Text(baseTextStyle)
		});
		
		var sourceSearch = new ol.source.Vector({
			format 	: new ol.format.GeoJSON(),
			url 	: urlopenstreetmap
		});	
		
		var vectorLayerSearch = new ol.layer.Vector({
			source 	: sourceSearch,
			style 	: styleFunctionSearch
		});
		
		function styleFunctionSearch(feature, resolution) {
			var styleSearch;
	        var geom = feature.getGeometry();
	        if (geom.getType() == 'Point') {	        
	        	var iconName = feature.get("icon") || "img/map/homicidio_20px.png";
			    var display_name =feature.get('display_name').split(',');
			    baseTextStyle.text = display_name[0];
			    
			    styleSearch = new ol.style.Style({
						        image: new ol.style.Icon(({
						        	anchor		: [0.3, 30],
						        	scale		: 1,
						            anchorXUnits: 'fraction',
						            anchorYUnits: 'pixels',
						            src			: iconName
						        })),
						        //ext: new ol.style.Text(baseTextStyle),
						        zIndex: 2
						    });	        	
	        }else{
	        	styleSearch = styleSearchPoly;
	        }		   
			return [styleSearch];
		}
	
		a_layers.push(vectorLayerSearch);
	});
	/******************************/
	
	/*******Poligono de lugar de busqueda********/	
	reportesBuscar 	= $('#ReportesBuscar').val();
	//reportesBuscar = 'mall';
	if(reportesBuscar != ''){
				
		var urlopenstreetmap = 'https://nominatim.openstreetmap.org/?format=geojson&q='+reportesBuscar+'&polygon_geojson=1&bounded=1&limit=1&viewbox='+viewbox;
		
		var baseTextStyle = {
				font : '10px Calibri,sans-serif',
				fill : new ol.style.Fill({
					color : '#0000FF'
				}),
				stroke : new ol.style.Stroke({
					color : '#fff',
					width : 5
				})
		    };
		
		var styleSearchPoly = new ol.style.Style({
			fill : new ol.style.Fill({
				color : 'RGBA(0,0,255,0.07)' //color de backgrount de poligono
			}),
			stroke : new ol.style.Stroke({
				color : '#0000FF',
				width : 2 //Ancho de limite
			}),
			text : new ol.style.Text(baseTextStyle)
		});
		
		var sourceSearch = new ol.source.Vector({
			format 	: new ol.format.GeoJSON(),
			url 	: urlopenstreetmap
		});	
		
		var vectorLayerSearch = new ol.layer.Vector({
			source 	: sourceSearch,
			style 	: styleFunctionSearch
		});
		
		function styleFunctionSearch(feature, resolution) {
			var styleSearch;
			
			var display_name =feature.get('display_name').split(',');			    
		    baseTextStyle.text = display_name[0];
		    
	        var geom = feature.getGeometry();
	        if (geom.getType() == 'Point') {	        
	        	var iconName = feature.get("icon") || "img/map/homicidio_20px.png";
			    			    
			    styleSearch = new ol.style.Style({
						        image: new ol.style.Icon(({
						        	anchor		: [0.3, 30],
						        	scale		: 1,
						            anchorXUnits: 'fraction',
						            anchorYUnits: 'pixels',
						            src			: iconName
						        })),
						        text: new ol.style.Text(baseTextStyle),
						        zIndex: 2
						    });	        	
	        }else{
	        	styleSearch = styleSearchPoly;
	        	styleSearch.getText().setText(display_name[0]);
	        }		   
			return [styleSearch];
		}
	
		a_layers.push(vectorLayerSearch);
		
		$.ajax({
			url : urlopenstreetmap,
			dataType : 'json',
			async : false,
		}).done(function(data) {
			var format = new ol.format.GeoJSON();
			vectorSourcePol = format.readFeatures(data, {
								defaultDataProjection : ol.proj.get('EPSG:4326'),
								featureProjection : 'EPSG:3857'
							});	
			Extent = vectorSourcePol[0].getGeometry().getExtent();
			center = ol.extent.getCenter(Extent);
		})
		
	}
	
	/**********************************************/
	
	var view = new ol.View({
		center : center
	});	
	/*
	for (var i = 0; i < a_vectorLayerInst.length; i++) {				
		a_layers.push(a_vectorLayerInst[i]);
	}
	*/
	/*******Visualización de las coordenadas con el mouse********/		
		var mousePositionControl = new ol.control.MousePosition({
			coordinateFormat : ol.coordinate.createStringXY(12),
			projection : 'EPSG:4326',// (-xx.xxxx)
		});
	
	var controls = ol.control.defaults({
		attributionOptions : {
			collapsible : false
		}
	}).extend([ mousePositionControl, new ol.control.FullScreen(),new ol.control.ZoomSlider() ]);
	/****************************************************************/	
	
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
		var seleccion = map.forEachFeatureAtPixel(evt.pixel,function(feature, layer) {
						//return feature;
						return [feature, layer];
					});
		var feature = seleccion[0];
		var layer 	= seleccion[1];
		
		if (feature !== undefined && feature.get('display_name') !== undefined) {
			  var coordinate 	= evt.coordinate;
			  
			  var tipo = feature.get('type');
			  switch (tipo) {
			    case 'bank':
			    	tipo = 'Banco';
			      break;
			    case 'fire_station':
			    	tipo = 'Bombero';
			      break;  
			    default:
			      console.log('default');
			  }
			  
			  content.innerHTML = '<p><b></b></p>' +			  					  	
			  					  '<b>' + tipo.toUpperCase() + '</b></br>' + 
			  					  feature.get('display_name');
			  overlay.setPosition(coordinate);
		}
		/*
		if (feature !== undefined && feature.get('tipoInstitucion') !== undefined) {
			  var coordinate 	= evt.coordinate;
			  content.innerHTML = '<p><b>' + feature.get('tipoInstitucion') + '</b></p>' +			  					  	
			  					  '<b>' + feature.get('institucionNombre') + '</b></br>' + 
			  					  feature.get('institucionUbicacion');
			  overlay.setPosition(coordinate);
		}
		
		if (feature !== undefined && feature.get('institucionImg') !== undefined) {
			  var coordinate 	= evt.coordinate;
			  imagen 			= '<img src="' + base + 'img/panamericanos/' + feature.get('institucionImg') + '.jpg" style="width: 300px;" alt="Sede">';
			  content.innerHTML = imagen + '</br></br>' + 
			  					  '<div class="sede">' + 	
			  					  '<b>' + feature.get('institucionNombre') + '</b></br>' + 
			  					  feature.get('institucionUbicacion')+ '</div>';
			  overlay.setPosition(coordinate);
		}
		*/
	});	
	
	/*****Concervar el zoom y el centro del mapa en una busqueda****/	
	ghostZoom 		= $('#ReportesGhostZoom').val();
	centroZoom 		= $('#ReportesCentroZoom').val().split(',');	
	
	if (ghostZoom != '' && centroZoom != '' && reportesBuscar == '') {
		long = parseFloat(centroZoom[0]);
		lat  = parseFloat(centroZoom[1]);
		map.getView().setCenter(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857'));		
	    map.getView().setZoom(ghostZoom);
	}else{		
		map.getView().fit(vectorSourcePol[0].getGeometry(), map.getSize());
	} 

	var ghostZoom = map.getView().getZoom();//
    map.on('moveend', function(evt) {
    	//console.info(map.getView().getZoom());
        if (ghostZoom != map.getView().getZoom()) {
            ghostZoom = map.getView().getZoom();            
            $('#ReportesGhostZoom').val(ghostZoom);            
        }
        //centroZoom = map.getView().getCenter();
        centroZoom = ol.proj.transform(map.getView().getCenter(), 'EPSG:3857', 'EPSG:4326');
        centroZoom[0] = centroZoom[0].toFixed(6);
        centroZoom[1] = centroZoom[1].toFixed(6);        
        $('#ReportesCentroZoom').val(centroZoom);        
    });