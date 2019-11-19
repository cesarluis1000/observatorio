	var departamento_id = $('#ReportesDepartamentoId option:selected').val();
	var provincia_id 	= $('#ReportesProvinciaId option:selected').val();
	var distrito_id 	= $('#ReportesDistritoId option:selected').val();
	var base  		 = $('base').attr('href');
	var poligono 	 = (distrito_id != '')?'Distritos':'Provincias';			
	var url4  		 = base+'ZonaPolygons/panamericanosgeojson';	
	
	/**********Google Map**********/		
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
	
	var a_layers = [raster];
		
	var view = new ol.View({
        center: [0, 0],
        zoom: 1
      });
	
	/*******COORDENADAS Y MOUSE********/		
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
	
	/*******POPUP*************/	
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

	/**********GEOLOCALIZACION*********/
	var geolocation = new ol.Geolocation({
		  projection: view.getProjection()
		});
		
	var styleGeoLocation = new ol.style.Style({
		  image: new ol.style.Circle({
			    radius: 6,
			    fill: new ol.style.Fill({
			      color: '#0000BC' //Rellenar
			    }),
			    stroke: new ol.style.Stroke({
			      color: '#fff', //Perimetro
			      width: 2
			    })
			  })
			});

	var positionFeature = new ol.Feature();

	var vectorSourceGeo = new ol.source.Vector({
	    features: [positionFeature]
	});

	var vectorLayerGeo = new ol.layer.Vector({
			source 	: vectorSourceGeo,
			style	: styleGeoLocation
		});

	geolocation.setTracking(true);
	
	function changePosition(){
		var coordinates = geolocation.getPosition();
		datajson = JSON.stringify(coordinates);
		console.info(datajson);	
		$.ajax({
			url: base+'Distritos/stcontains',
		    dataType: 'json',
		    async: false,
		    method: 'get',
		    data: datajson,
		    success : function(data) {
		    	console.info(data);
		    }
		});
		positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
	}
	
	geolocation.on('change:position', changePosition);
	
	function geoError(){
		console.info(error.message);
	}
	
	geolocation.on('error', geoError);
		
	map.addLayer(vectorLayerGeo);
	
	
	/**********************************/
	
	/*********STYLE DENUNCIA INSTITUCION********/
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
	/*********************************/
	
	/*******POLIGONO DISTRITO, PROVINCIA o DEPARTAMENTO********/
	var urlPrincipal = base+poligono+'/geojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id='+ distrito_id;

	var stylePrincial = new ol.style.Style({
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

	var vectorSource = new ol.source.Vector({
					format : new ol.format.GeoJSON(),
					url : urlPrincipal
				});	

	var vectorLayer = new ol.layer.Vector({
		source 	: vectorSource,
		style 	: function(feature) {						
						stylePrincial.getText().setText(feature.get('nombdist'));
						return stylePrincial;
					}
	});
	
	map.addLayer(vectorLayer);
	/*************************************/
		
	/*********POINT DENUNCIAS*********/		
	var params 		 = $('.form-check input:checked, input[type=text], input[type=hidden]').serialize();		
	var urldenuncias = base+'denuncias/denunciasgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id=' + distrito_id + '&' + params;
			
	function styleDenuncias(feature, resolution) {			
		var styleSearch;        
    	var iconName = "img/map/"+feature.get("icon");		    
	    baseTextStyle.text = feature.get('denuncia');
	    
	    styleDenuncia = new ol.style.Style({
				        image: new ol.style.Icon(({
				        	anchor		: [0.3, 30],
				        	scale		: 1,
				            anchorXUnits: 'fraction',
				            anchorYUnits: 'pixels',
				            src			: iconName
				        })),
				        //text: new ol.style.Text(baseTextStyle),
				        zIndex: 2
				    });	        	
       		   
		return [styleDenuncia];
	}

	var sourceDenuncias = new ol.source.Vector({
			format 	: new ol.format.GeoJSON(),
			url 	: urldenuncias
		});	
		
	//new ol.layer.Vector //ol.layer.Heatmap		
	var vectorLayerDenuncias = new ol.layer.Heatmap({
		source 	: sourceDenuncias,
		style 	: styleDenuncias,
		blur	: 15,
	    radius	: 8
	});
	
	map.addLayer(vectorLayerDenuncias);	
	/******************************/	
	
	/*****Concervar el zoom y el centro del mapa en una busqueda****/	
	function vectorSourceChange(evt){
		//Cargo el vectorSource Princial que es el poligo del Distrito o Provincia
	    if(vectorSource.getState() === 'ready') {
	    		    	
	    	Extent = vectorSource.getExtent();	               		        
	        thebox = ol.proj.transformExtent(Extent, 'EPSG:3857', 'EPSG:4326');
			x1 = thebox[0].toFixed(6);
			y1 = thebox[3].toFixed(6);
			x2 = thebox[2].toFixed(6);
			y2 = thebox[1].toFixed(6);
			viewbox = x1.toString().concat(',',y1,',',x2,',',y2);
			
			functionInstituciones(viewbox)
						
			reportesBuscar 	= $('#ReportesBuscar').val();
			var sourceSearch;
			if(reportesBuscar != ''){
				sourceSearch = functionBusqueda(reportesBuscar, viewbox);
			}
			
			ghostZoom 		= $('#ReportesGhostZoom').val();
			centroZoom 		= $('#ReportesCentroZoom').val().split(',');			
			if (ghostZoom != 1 && centroZoom != '' && reportesBuscar == '') {
				//Si se ha movido algo y sin busqueda
				long = parseFloat(centroZoom[0]);
				lat  = parseFloat(centroZoom[1]);
				map.getView().setCenter(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857'));		
			    map.getView().setZoom(ghostZoom);
				//map.getView().setZoom(13);
			}else{
				// Centra al polygono del distrito o provincia
				map.getView().fit(Extent, map.getSize());
				map.getView().setZoom(14);
				if(sourceSearch !== undefined){
					sourceSearch.once('change',function(e){
						if(sourceSearch.getState() === 'ready'){
							map.getView().fit(sourceSearch.getExtent(), map.getSize());
						}		
					});	
				}				
			}
	    }
	}
	
	vectorSource.once('change',vectorSourceChange);
	
	/*********POINT INSTITUTOS*********/	
	function styleInstituciones(feature, resolution) {
    	
    	if(feature.get('type')!==undefined){
    		tipo = feature.get('type');
			switch (tipo) {			
			case 'hospital':
				iconName = "img/map/Hospital60px.png";
		    	break;	
			case 'police':
				iconName = "img/map/Policia60px.png";
		    	break;
			case 'fire_station':
				iconName = "img/map/Bomberos60px.png";
		    	break;	
			default:
				iconName = "img/map/homicidio_20px.png";
			}
    	}	
	    //display_name =feature.get('display_name').split(',');
	    //baseTextStyle.text = display_name[0];		    
	    styleInstitucion = new ol.style.Style({
				        image: new ol.style.Icon(({
				        	anchor		: [0.3, 30],
				        	scale		: 0.25,
				            anchorXUnits: 'fraction',
				            anchorYUnits: 'pixels',
				            src			: iconName
				        })),
				        //text: new ol.style.Text(baseTextStyle),
				        zIndex: 2
				    });	        	
       		   
		return [styleInstitucion];
	}

	function functionInstituciones(viewbox){
		instituciones = ['hospital', 'police','bomberos'];
		instituciones = ['police'];
		instituciones.forEach(function (elemento, indice, array) {
			urlInstitucion = 'https://nominatim.openstreetmap.org/?format=geojson&q='+elemento+'&polygon_geojson=0&bounded=1&limit=1000&viewbox='+viewbox;
					
			sourceInstitucion = new ol.source.Vector({
				format 	: new ol.format.GeoJSON(),
				url 	: urlInstitucion
			});	
			
			vectorLayerInstitucion = new ol.layer.Vector({
				source 	: sourceInstitucion,
				style 	: styleInstituciones
			});
			
			map.addLayer(vectorLayerInstitucion);
		});
	}
	
	var baseTextStyleSearch = {
			font : '12px Calibri,sans-serif',
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
		text : new ol.style.Text(baseTextStyleSearch)
	});
	
	/*******Poligono de lugar de busqueda********/
	function styleBuscador(feature, resolution) {
				
		display_name =feature.get('display_name').split(',');			    
		baseTextStyleSearch.text = display_name[0].toUpperCase();
	    
        geom = feature.getGeometry();
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
					        text: new ol.style.Text(baseTextStyleSearch),
					        zIndex: 2
					    });	        	
        }else{
        	styleSearch = styleSearchPoly;
        	styleSearch.getText().setText(baseTextStyleSearch.text);
        }		   
		return [styleSearch];
	}
	
	function functionBusqueda(reportesBuscar, viewbox){
		
		urlSearch = 'https://nominatim.openstreetmap.org/?format=geojson&q='+reportesBuscar+'&polygon_geojson=1&bounded=1&limit=1&viewbox='+viewbox;
		
		sourceSearch = new ol.source.Vector({
			format 	: new ol.format.GeoJSON(),
			url 	: urlSearch
		});	
	
		vectorLayerSearch = new ol.layer.Vector({
			source 	: sourceSearch,
			style 	: styleBuscador
		});
	
		map.addLayer(vectorLayerSearch);
		
		return sourceSearch;
	}
	
	/*******Asigna Zoon y Centro****************/	
	function moveend(evt){
		ghostZoom = map.getView().getZoom();        
        if(ghostZoom != 1){
        	$('#ReportesGhostZoom').val(ghostZoom);
        }        
        coordenadas = map.getView().getCenter();        
        if(coordenadas[0] != 0){
        	centroZoom = ol.proj.transform(coordenadas, 'EPSG:3857', 'EPSG:4326');
            centroZoom[0] = centroZoom[0].toFixed(6);
            centroZoom[1] = centroZoom[1].toFixed(6);        
            $('#ReportesCentroZoom').val(centroZoom);	
        }
	}
	
    map.on('moveend', moveend);
    
    /*******ACCION Popup detalle*******/	
	function singleclickPopup(evt){
		var seleccion = map.forEachFeatureAtPixel(evt.pixel,function(feature, layer) {
						return [feature, layer];
					});
				
		if (seleccion !== undefined) {
			var feature = seleccion[0];
			var layer 	= seleccion[1];
			var coordinate 	= evt.coordinate;
			  
			var tipo = feature.get('type');
			
			if(feature.get('type')!==undefined){
				switch (tipo) {
				case 'police':
			    	tipo = 'Policia';
			    	break;
				case 'fire_station':
			    	tipo = 'Bombero';	
			    	break;
				}
	  
				content.innerHTML = '<p><b></b></p>' +			  					  	
									'<b>' + tipo.toUpperCase() + '</b></br>' + 
									feature.get('display_name');
				overlay.setPosition(coordinate);	
			}			
		}
	}
	
	map.on('singleclick', singleclickPopup);	
