function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(__cfg && __cfg('lang') && __cfg('lang')[str]) ? __cfg('lang')[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function split( val ) {
    return val.split( /,\s*/ );
}
function extractLast( term ) {
    return split( term ).pop();
}

// script by Vladimir Olovyannikov
// ForcePictures V1.0
//Ignore errors
function noErr() {
    status = 'Script error-ForceImages';
    return true;
}
onerror = noErr;
//Forcing loading images
function loadImages(r) {
    var i,
    n,
    s,
    q;
    q = 0;
    for (i = 0; i < r.document.images.length; i ++ ) {
        s = r.document.images[i].src;
        if ( ! r.document.images[i].complete || r.document.images[i].fileSize < 0) {
            r.document.images[i].src = __cfg('path_absolute') + 'img/empty.gif';
            r.document.images[i].src = s;
        }
    }
}
function FBShare() {
    if ($('div#js-FB-Share-iframe', 'body').is('div#js-FB-Share-iframe')) {
        var loader = $('#js-loader');
        var fb_connect = loader.data('fb_connect');
        var fb_app_id = loader.data('fb_app_id');
        var project_url = loader.data('job_url');
        var project_image = loader.data('job_image');
        var project_name = $('#js-FB-Share-title').text();
		var project_caption = $('#js-FB-Share-caption').text();
        var project_description = $('#js-FB-Share-description').text();
        var redirect_url = loader.data('redirect_url');
        var sitename = __cfg('site_name');
        var type = loader.data('type');
        $.getScript("http://connect.facebook.net/en_US/all.js", function(data) {
            FB.init( {
                appId: fb_app_id,
                status: true,
                cookie: true
            });
            FB.getLoginStatus(function(response) {
				var publish = {
					method: 'feed',
					display: type,
					access_token: FB.getAccessToken(),
					redirect_uri: redirect_url,
					link: project_url,
					picture: project_image,
					name: project_name,
					caption: project_caption,
					description: project_description
				};
                loader.removeClass('loader');
				setTimeout(function() {
					$('.js-skip-show').slideDown('slow');
				}, 1000);
                if (response.status === 'connected') {
                    if (fb_connect == "1") {
						FB.ui(publish, publishCallBack);
						$('div#js-FB-Share-iframe').removeClass('hide');
                    } else {
                        $('div#js-FB-Share-beforelogin').removeClass('hide');
                    }
                } else {
                    $('div#js-FB-Share-beforelogin').removeClass('hide');
                }
            });
        });
    }
}

function FBImport() {    
    if ($('div#js-fb-invite-friends-btn', 'body').is('div#js-fb-invite-friends-btn')) { 
        $.getScript('http://connect.facebook.net/en_US/all.js', function(data) {
        FB.init( {
            appId: $('#facebook').data('fb_app_id'),
            status: true,
            cookie: true
        });
        FB.getLoginStatus(function(response) {            
            $('#facebook').removeClass('loader');    
            if (response.status == 'connected') {
                $('#js-fb-invite-friends-btn').remove();
                $('#js-fb-login-check').show();
            } else {
                $('#js-fb-login-check').remove();
                $('#js-fb-invite-friends-btn').show();
            }
          });
        });
    }
}

//Main function, looks through the window frame-by-frame to get all the pictures failed to load
function forceImages(r) {
    var errOccured = false;
    var i;
    var frm;
    for (i = 0; i < r.frames.length; i ++ ) {
        frm = r.frames[i];
        var bdy = null;
        //trying to open the document.
        try {
            bdy = frm.document.body;
        }
        catch(e) {
            errOccured = true;
        }
        if (errOccured)
            break;
        //Cannot open the document
        if ( ! bdy)
        //Not yet loaded? Wait and retry
         {
            window.r = r;
            r.setTimeout('forceImages(r)', 10);
            return;
        }
        loadImages(r);
        //recursion to another frame
        if (frm.frames.length > 0)
            forceImages(frm);
    }
    if (r.document.body)
        loadImages(r);
}

function loadAdminPanel() {
		$('.js-alab').html('');
		$('header').removeClass('show-panel');
		var url = '';
		if (typeof($('.js-user-view').data('user-id')) != 'undefined' && $('.js-user-view').data('user-id') !='' && $('.js-user-view').data('user-id') != null) {
			var uid = $('.js-user-view').data('user-id');
			var url = 'users/show_admin_control_panel/view_type:user/id:'+uid;
		}
		if (typeof($('.js-job-view').data('job-id')) != 'undefined' &&  $('.js-job-view').data('job-id') !='' && $('.js-job-view').data('job-id') != null) {
			var pid = $('.js-job-view').data('job-id');
			var url = 'jobs/show_admin_control_panel/view_type:job/id:'+pid;
		}
        if (typeof($('.js-request-view').data('request-id')) != 'undefined' &&  $('.js-request-view').data('request-id') !='' && $('.js-request-view').data('request-id') != null) {
			var pid = $('.js-request-view').data('request-id');
			var url = 'requests/show_admin_control_panel/view_type:request/id:'+pid;
		}
		if (url !='') {
			$.get(__cfg('path_relative') + url, function(data) {
				$('.js-alab').html(data).removeClass('hide').show();
			});
		}
}

	function render_map(){
		var address = $('#JobAddress').val();
		var index = address.indexOf('\n');
        while(index != -1){
            address = address.replace('\n',' ');
            index = address.indexOf('\n');
        }
		$('#JobAddress').val(address);
		geocoder.geocode( {
			'address': address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				marker.setMap(null);
				map.setCenter(results[0].geometry.location);
				marker = new google.maps.Marker( {
					draggable: true,
					map: map,
					icon: markerimage,
					position: results[0].geometry.location
				});					
				$('#JobLatitude').val(marker.getPosition().lat());
				$('#JobLongitude').val(marker.getPosition().lng());	
				if($('.js-service:checked').val() == 2){
					radious = $('#JobJobCoverageRadius').val();
					radious_unit = $('#JobJobCoverageRadiusUnitId').val();
					conv_redious = 0;
					if(radious_unit == 2){
						conv_redious = radious * 1000;							
					}
					if(radious_unit == 1){
						conv_redious = milesconv(radious) * 1000;
					}
					circle.set('radius', conv_redious);
					circle.bindTo('center', marker, 'position');
				}
				else{
					circle.set('radius', 0);
					circle.bindTo('center', marker, 'position');
				}

			}
		});   
	}
	function render_map_col(){
		var address = $('#JobAddress_colbx').val();
		var index = address.indexOf('\n');
		while(index != -1){
			address = address.replace('\n',' ');
			index = address.indexOf('\n');
		}
		$('#JobAddress_colbx').val(address);
		geocoder_col.geocode( {
			'address': address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				
				marker_col.setMap(null);
				map_col.setCenter(results[0].geometry.location);
				marker_col = new google.maps.Marker( {
					draggable: true,
					map: map_col,
					icon: markerimage_col,
					position: results[0].geometry.location
				});	
				$('#JobLatitude_colbx').val(marker_col.getPosition().lat());
				$('#JobLongitude_colbx').val(marker_col.getPosition().lng());	
			}
		});   
	}

	
var geocoder;
var map;
var marker;
var markerimage;
var marker_green;
var marker_red;
var infowindow;
var locations;
var latlng;
var poly = [] ; 
var line ; 
var circle;
var markersArray = Array();

var geocoder_col;
var map_col;
var marker_col;
var locations_col;
var latlng_col;
var poly_col = [] ; 
var line_col ; 
var circle_col;
var markerimage_col;

var styles = [[ {
    url: 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/heart50.png',
    width: 50,
    height: 44,
    opt_anchor: [12, 0],
    opt_textSize: 12
}]];
var markerClusterer = null;

function searchmapaction() {
    bounds = (map.getBounds());
	var southWestLan = '';
	var northEastLng = '';
	
    var southWest = bounds.getSouthWest();
    var northEast = bounds.getNorthEast();
	$('#ne_latitude').val(northEast.lat());	
    $('#sw_latitude').val(southWest.lat());
	
	if(isNaN(northEast.lng())){
		northEastLng  = '0';
	}else{
		northEastLng = northEast.lng();
	}	
    $('#ne_longitude').val(northEastLng);
	
	if(isNaN(southWest.lng())){
		southWestLan  = '0';
	}else{
		southWestLan = southWest.lng();
	}
    $('#sw_longitude').val(southWestLan);
	if($('#JobR').val() == 'pages'){
		//fetchMarker();
		//fetchRequestMarker();
		updateProductlist('pages');
		updateRequestlist('pages');
	}else if($('#JobR').val() == 'jobs'){		
		//fetchMarker();
		updateProductlist('jobs');
	}else if($('#JobR').val() == 'requests'){
		//fetchRequestMarker();
		updateRequestlist('requests');
	}	
}
function loadColMap(){
	geocoder_col = new google.maps.Geocoder();
	if(document.getElementById('js-colorbox-map-container')){
		lat = $('#JobLatitude_colbx').val(); 
		if(lat ==''){
			lat = 0;
			$('#JobLatitude_colbx').val(lat);
		}
		lng = $('#JobLongitude_colbx').val();
		if(lng ==''){
			lng = 0;
			$('#JobLongitude_colbx').val(lng);
		}
		zoom_level = $('#JobZoomLevel_colbx').val();
		if(zoom_level !=''){
			zoom_level = parseInt($('#JobZoomLevel_colbx').val());		
		}
		if(zoom_level ==''){
			zoom_level = 10;
			$('#JobZoomLevel_colbx').val(zoom_level);
		}
		latlng_col = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: zoom_level,
			center: latlng_col,
			mapTypeControl: false,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map_col = new google.maps.Map(document.getElementById('js-colorbox-map-container'), myOptions); 
		markerimage_col = new google.maps.MarkerImage(__cfg('path_relative') + 'img/marker-green.png');
		circle_col = new google.maps.Circle({
		  map: map_col,
		  radius: 100000 // 3000 km
		});		
		initMapCol();
	}
}
function loadMap() {
	geocoder = new google.maps.Geocoder();
	if(document.getElementById('js-map-container')){
		map_add();
	}
	if(document.getElementById('js-map-view-container')){
		map_view();
	}
	if(document.getElementById('js-map-search-container')){
		lat = $('#job_latitude').val();
		lng = $('#job_longitude').val();
		zoom_level = parseInt($('#job_zoom_level').val());
		lat = $('#job_latitude').val(); 
			if(lat ==''){
				lat = 0;
				$('#job_latitude').val(lat);
			}
			lng = $('#job_longitude').val();
			if(lng ==''){
				lng = 0;
				$('#job_longitude').val(lng);
			}		
		latlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: zoom_level,
			center: latlng,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_TOP
            },
			draggable: true,
			disableDefaultUI:true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById('js-map-search-container'), myOptions);   
		markerimage = new google.maps.MarkerImage(__cfg('path_relative') + 'img/marker-green.png');
		marker_green = new google.maps.MarkerImage(__cfg('path_relative') + 'img/marker-green.png');
		marker_red = new google.maps.MarkerImage(__cfg('path_relative') + 'img/marker-red.png');
		//infowindow = new google.maps.InfoWindow();
		initMap();

	}
}
function refreshMap() {
    if (markerClusterer) {
        markerClusterer.clearMarkers();
    }    
}
function map_view(){
	lat = $('span#js-view-lat').text(); 
	if(lat ==''){
		lat = 0;
	}
	lng = $('span#js-view-log').text();
	if(lng ==''){
		lng = 0;
	}
	zoom_level = parseInt($('span#js-view-zoom').text());	
	latlng = new google.maps.LatLng(lat, lng);
	var myOptions = {
		zoom: zoom_level,
		center: latlng,
		mapTypeControl: false,
        panControl: false,
		navigationControl: false,
        draggable: false,
		disableDefaultUI:true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById('js-map-view-container'), myOptions);   
	circle = new google.maps.Circle({
					  map: map,
					  radius: 100000 // 3000 km
					});		
	initMap();
	radious = $('span#js-view-radius').text();
	radious_unit = $('span#js-view-radius-units').text();
	conv_redious = 0;
	if(radious_unit == 2){
	conv_redious = radious * 1000;						
	}
	if(radious_unit == 1){
	conv_redious = milesconv(radious) * 1000;
	}
	circle.set('radius', conv_redious);
	circle.bindTo('center', marker, 'position');
}
function map_add(){
	
		lat = $('#JobLatitude').val(); 
		if(lat ==''){
			lat = 0;
			$('#JobLatitude').val(lat);
		}
		lng = $('#JobLongitude').val();
		if(lng ==''){
			lng = 0;
			$('#JobLongitude').val(lng);
		}
		zoom_level = $('#JobZoomLevel').val();
		if(zoom_level !=''){
			zoom_level = parseInt($('#JobZoomLevel').val());		
		}
		if(zoom_level ==''){
			zoom_level = 10;
			$('#JobZoomLevel').val(zoom_level);
		}
		
		latlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: zoom_level,
			center: latlng,
			mapTypeControl: false,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById('js-map-container'), myOptions);   
		circle = new google.maps.Circle({
						  map: map,
						  radius: 100000 // 3000 km
						});		
		google.maps.event.addListener(map, 'mouseout', function(event) {
			$('#JobZoomLevel').val(map.getZoom());
		});
		google.maps.event.addListener(map, 'zoom_changed', function() {				
		   $('#JobZoomLevel').val(map.getZoom());
		});
		initMap();
		if($('.js-service')){
			if($('.js-service:checked').val() == 2){					
							radious = $('#JobJobCoverageRadius').val();
							radious_unit = $('#JobJobCoverageRadiusUnitId').val();
							conv_redious = 0;
							if(radious_unit == 2){
								conv_redious = radious * 1000;						
							}
							if(radious_unit == 1){
								conv_redious = milesconv(radious) * 1000;
							}
							circle.set('radius', conv_redious);
							circle.bindTo('center', marker, 'position');
			}
		}
}
function geocodePosition(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);            
            $('#JobLatitude').val(marker.getPosition().lat());
            $('#JobLongitude').val(marker.getPosition().lng());
        } 
    });
}
function geocodePositionCol(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);            
            $('#JobLatitude_colbx').val(marker.getPosition().lat());
            $('#JobLongitude_colbx').val(marker.getPosition().lng());
        } 
    });
}
// @to do: ajaxCallBacktoloadgraph, fajaxvalidation

function publishCallBack(response) {
	window.location.href = $('#js-loader').data('redirect_url');
}
function loopy_call(hidden) {
	(function loopy(){
		var objs = hidden.removeClass('needsSparkline');
		hidden = hidden.filter('.needsSparkline');
		if (objs.length) {
			objs.css({
				'display':'',
				'visibility':'hidden'
			});
			$.sparkline_display_visible();
			objs.css({
				'display':'none',
				'visibility':''
			});
			setTimeout( loopy, 250 );
		}
	})();
}
function fetchMarker() {
    $.ajax( {
        type: 'POST',
        url: __cfg('path_relative') + 'jobs/index/type:search/view:json',
        data: $('.js-search-map').serialize(),
//	   data: "sw_latitude="+ $('#sw_latitude').val()+"&sw_longitude="+ $('#sw_latitude').val()+"&ne_latitude="+ $('#ne_latitude').val()+"&ne_longitude="+ $('#ne_longitude').val()+"&job_latitude="+ $('#job_latitude').val()+"&job_longitude="+ $('#job_longitude').val()+"&job_zoom_level="+ $('#job_zoom_level').val()+"&JobJobSearch="+ $('#JobJobSearch').val()+"&q="+ $('#JobQ').val(),
        dataType: 'json',
        cache: false,
        success: function(responses) {           
		   for (var i = 0; i < responses.length; i ++ ) {
				lat = (responses[i].Job.latitude);
				lnt = (responses[i].Job.longitude);
				slug = (responses[i].Job.slug);		
				job_title = (responses[i].Job.title);	
				medium_thumb = (responses[i].Job.medium_thumb);	
				updateMarker(lat, lnt, slug, job_title, medium_thumb, i, 'jobs');
		   }
		   addMapCluster();		   	   
        }
    });
}
var marker_fetch_count = 0;
function addMapCluster(){	
	marker_fetch_count++;
	var compare_count = 1;
	if($('#JobR').val() == 'pages'){
		compare_count = 2;
	}
	if(marker_fetch_count == compare_count){
		var zoom = null;
        var size = null;
        var style = null;
        markerClusterer = new MarkerClusterer(map, markersArray, {
            maxZoom: zoom,
            gridSize: size,
            styles: styles[style]
        });	
	}
}
function fetchRequestMarker() {
    $.ajax( {
        type: 'POST',
        url: __cfg('path_relative') + 'requests/index/type:search/view:json',
        data: $('.js-search-map').serialize(),
//	   data: "sw_latitude="+ $('#sw_latitude').val()+"&sw_longitude="+ $('#sw_latitude').val()+"&ne_latitude="+ $('#ne_latitude').val()+"&ne_longitude="+ $('#ne_longitude').val()+"&job_latitude="+ $('#job_latitude').val()+"&job_longitude="+ $('#job_longitude').val()+"&job_zoom_level="+ $('#job_zoom_level').val()+"&JobJobSearch="+ $('#JobJobSearch').val()+"&q="+ $('#JobQ').val(),
        dataType: 'json',
        cache: false,
        success: function(responses) {
           for (var i = 0; i < responses.length; i ++ ) {
				lat = (responses[i].Request.latitude);
				lnt = (responses[i].Request.longitude);
				slug = (responses[i].Request.slug);		
				request_title = (responses[i].Request.name);	
				if(request_title.length > 85){
					request_title = request_title.substr(0,90)+ '...';
				}
				display_amount = (responses[i].Request.display_amount);
				updateMarker(lat, lnt, slug, request_title, display_amount, i, 'requests');
		   }
		   addMapCluster();		   	
        }
    });
}
function updateMarker(lat, lnt, slug, item_title, detail_des, i, curr_cont){
	if (lat != null) {
		myLatLng = new google.maps.LatLng(lat, lnt);
		if(curr_cont == 'jobs'){
			markerimage = marker_green;
		}else if(curr_cont == 'requests'){
			markerimage = marker_red;
		}
		
		eval('var marker' + i + ' = new google.maps.Marker({ position: myLatLng,  map: map, icon: markerimage, zIndex: i});');
		markersArray.push(eval('marker' + i));		
	}
}
function updateProductlist(cont) {
	var url = '';
	if(cont == 'pages'){
		url = "type:search";
	}
    $.ajax( {
        type: 'POST',
        url: __cfg('path_relative') + 'jobs/index/'+url,
        data: $('.js-search-map').serialize(),
//        data: "sw_latitude="+ $('#sw_latitude').val()+"&sw_longitude="+ $('#sw_latitude').val()+"&ne_latitude="+ $('#ne_latitude').val()+"&ne_longitude="+ $('#ne_longitude').val()+"&job_latitude="+ $('#job_latitude').val()+"&job_longitude="+ $('#job_longitude').val()+"&job_zoom_level="+ $('#job_zoom_level').val()+"&JobJobSearch="+ $('#JobJobSearch').val()+"&q="+ $('#JobQ').val(),
        cache: false,
        beforeSend: function() {
            $('.js-search-responses').block();
        },
        success: function(responses) {
            $('.js-search-responses').html(responses);
            $('.js-search-responses').unblock();
        }
    });
}
function updateRequestlist(cont) {
	var url = '';
	if(cont == 'pages'){
		url = "type:search";
	}
    $.ajax( {
        type: 'POST',
        url: __cfg('path_relative') + 'requests/index/type:search',
        data: $('.js-search-map').serialize(),
//        data: "sw_latitude="+ $('#sw_latitude').val()+"&sw_longitude="+ $('#sw_latitude').val()+"&ne_latitude="+ $('#ne_latitude').val()+"&ne_longitude="+ $('#ne_longitude').val()+"&job_latitude="+ $('#job_latitude').val()+"&job_longitude="+ $('#job_longitude').val()+"&job_zoom_level="+ $('#job_zoom_level').val()+"&JobJobSearch="+ $('#JobJobSearch').val()+"&q="+ $('#JobQ').val(),
        cache: false,
        beforeSend: function() {
            $('.js-request-responses').block();
        },
        success: function(responses) {
            $('.js-request-responses').html(responses);
            $('.js-request-responses').unblock();
        }
    });
	
}
function loopy_call(hidden) {
	(function loopy(){
		var objs = hidden.removeClass('needsSparkline');
		hidden = hidden.filter('.needsSparkline');
		if (objs.length) {
			objs.css({
				'display':'',
				'visibility':'hidden'
			});
			$.sparkline_display_visible();
			objs.css({
				'display':'none',
				'visibility':''
			});
			setTimeout( loopy, 250 );
		}
	})();
}
function buildChart(so)
{


			$('.js-line-chart'+ so).each(function(e) {
				var sparkliness = $(this).sparkline('html', {
					type: 'line',
					width: '32',
					height: '16',
					lineColor: $(this).metadata().colour,
					fillColor: $(this).metadata().colour,
					lineWidth: 0,
					spotColor: undefined,
					minSpotColor: undefined,
					maxSpotColor: undefined,
					highlightSpotColor: undefined,
					highlightLineColor: undefined,
					spotRadius: 0
				});
				var hidden = sparkliness.parent().filter(':hidden').addClass('needsSparkline');
				loopy_call(hidden);
				sparkliness.parent().filter(':hidden').show();
			}).addClass('xltriggered');
			$('.js-sparkline-chart'+ so).each(function(e) {
				var sparklines = $(this).sparkline('html', {
					type: 'bar',
					height: '40',
					barWidth: 5,
					barColor: $(this).metadata().colour,
					negBarColor: '#',
					stackedBarColor: []
				});
				var hidden = sparklines.parent().filter(':hidden').addClass('needsSparkline');
				loopy_call(hidden);
				sparklines.parent().filter(':hidden').show();
			}).addClass('xltriggered');
			$('.easy-pie-chart.percentage'+ so).each(function(e) {
				var barColor = $(this).data('color');
				var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
				var size = parseInt($(this).data('size')) || 50;
				$(this).easyPieChart({
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: parseInt(size/10),
					animate: 1000,
					size: size
				});
			}).addClass('xltriggered');
			/* Dashboard chart*/
		$('.js-load-pie-chart' + so).each(function() {
					$this = $(this);
					data_container = $this.metadata().data_container;
					chart_container = $this.metadata().chart_container;
					chart_title = $this.metadata().chart_title;
					chart_y_title = $this.metadata().chart_y_title;
					var table = document.getElementById(data_container);
					options = {
						colors: [
							'#f2a640',
							'#8c66d9',
							'#e6804d',
							'#79dbed',
							'#a7a77d',
							'#ccc',
							'#3c995b',
							'#f24440',
							'#888',
							'#f2df40',
							'#7984ed',
							'#d879ed'
						],
						chart: {
							renderTo: chart_container,
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: chart_title
						},
						tooltip: {
							formatter: function() {
								return '<b>' + this.point.name + '</b>: ' + (this.percentage).toFixed(2) + ' %';
							}
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: false
								},
								showInLegend: false
							}
						},
						series: [ {
							type: 'pie',
							name: chart_y_title,
							 innerSize: '70%',
							data: []
							}]
						};
					options.series[0].data = [];
					jQuery('tr', table).each(function(i) {
						var tr = this;
						jQuery('th, td', tr).each(function(j) {
							if (j == 0) {
								options.series[0].data[i] = [];
								options.series[0].data[i][j] = this.innerHTML
							} else {
								// add values
								options.series[0].data[i][j] = parseFloat(this.innerHTML);
							}
						});
					});
					
					var chart = new Highcharts.Chart(options);
				}).addClass('xltriggered');
		$('.js-load-line-graph' + so).each(function() {
					$this = $(this);
					data_container = $this.metadata().data_container;
					chart_container = $this.metadata().chart_container;
					chart_title = $this.metadata().chart_title;
					chart_y_title = $this.metadata().chart_y_title;
					var table = document.getElementById(data_container);
					options = {
						colors: [
							'#50b432',
							'#058dc7',
							'#ed561b',
							'#f83a22',
							'#fad165',
							'#a47ae2',
							'#f691b2',
							'#ac725e',
							'#42d692',
							'#ffee34'
						],
						chart: {
							renderTo: chart_container,
							defaultSeriesType: 'line'
						},
						title: {
							text: chart_title
						},
						xAxis: {
							tickWidth: 0,
							labels: {
								rotation :- 90
							}
						},
						yAxis: {
							title: {
								text: chart_y_title
							}
						},
						tooltip: {
							crosshairs: true,
							shared: true
						},
						series: {
							cursor: 'pointer',
							marker: {
								lineWidth: 1
							}
						}
					};
					// the categories
					options.xAxis.categories = [];
					jQuery('tbody th', table).each(function(i) {
						options.xAxis.categories.push(this.innerHTML);
					});
					// the data series
					options.series = [];
					jQuery('tr', table).each(function(i) {
						var tr = this;
						jQuery('th, td', tr).each(function(j) {
							if (j > 0) {
								// skip first column
								if (i == 0) {
									// get the name and init the series
									options.series[j - 1] = {
										name: this.innerHTML,
										data: []
										};
								} else {
									// add values
									options.series[j - 1].data.push(parseFloat(this.innerHTML));
								}
							}
						});
					});
					var chart = new Highcharts.Chart(options);
				}).addClass('xltriggered');
		$('.js-load-column-chart'+ so).each(function(){
			data_container = $(this).metadata().data_container;
			chart_container = $(this).metadata().chart_container;
			chart_title = $(this).metadata().chart_title;	
			chart_y_title = $(this).metadata().chart_y_title;	
			var table = document.getElementById(data_container);
			seriesType = 'column';
			if($(this).metadata().series_type){
				seriesType = $(this).metadata().series_type;
			}
			options = { 
					chart: {
						renderTo: chart_container,
						defaultSeriesType: seriesType,
						margin: [ 50, 50, 100, 80]
					},
					title: {
						text: chart_title
					},
					xAxis: {
						categories: [							
						],
						labels: {
							rotation: -90,
							align: 'right',
							style: {
								 font: 'normal 13px Verdana, sans-serif'
							}
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: chart_y_title
						}
					},
					legend: {
						enabled: false
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								  Highcharts.numberFormat(this.y, 1);
						}
					},
				    series: [{
						name: 'Data',
						data: [],
						dataLabels: {
							enabled: true,
							rotation: -90,
							color: '#FFFFFF',
							align: 'right',
							x: -3,
							y: 10,
							formatter: function() {
								return '';
							},
							style: {
								font: 'normal 13px Verdana, sans-serif'
							}
						}			
					}]
			};
			// the categories
			options.xAxis.categories = [];
			options.series[0].data = [] ;						
			jQuery('tr', table).each( function(i) {
				var tr = this;
				jQuery('th, td', tr).each( function(j) {
					if(j == 0){
						options.xAxis.categories.push(this.innerHTML);											
					} else { // add values						
						options.series[0].data.push(parseFloat(this.innerHTML));
					}
				});				
			});			
			chart = new Highcharts.Chart(options);
		});
		/* dashboard chart*/
}

function kiloconv(val){
	return ((val* 0.621)).toFixed(2);
}
function milesconv(val){ 
	return ((val*1.61)).toFixed(2);
}
function file_upload() {
	if ($('.js-upload', 'body').is('.js-upload')) {
        $('.js-upload-form').fileupload( {
            forceIframeTransport: isSetIframeTransport(),
            maxNumberOfFiles: 5,
            acceptFileTypes: getFileType(),
			dataType: '',
            submit: function(e, data) {
				$(this).find('div.input input[type=text], div.input textarea, div.input select').filter(':visible').trigger('blur');
				var $this = $(this);
                if (j_validate($this) == 'error') {
					$('.template-upload').find('.start').removeattr('disabled');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
            },
            done: function(e, data) {
                // Updating Progress Bar
                $('.progress .bar').css('width', '100%');
				location.href = $('#success_redirect_url').val();
            }
        }).on('fileuploadadd', function(e, data) {
            if (data.files[0].name != null) {
				// Fix for chrome
                $('#browseFile').attr('title', data.files[0].name);
            }
        }).on('fileuploadfail', function(e, data) {
            $('.js-upload-cancel').removeClass('hide');
        }).on('fileuploadchange',function(e,data){
			$('.js-fileupload-enable').on('click',function(){
				$('.start').trigger('click');
				return false;
			});
		});
    }
}
function updateAfterUpload(data) {
    location.href = $('#success_redirect_url').val();
    return true;
}
function replaceAll(txt, replace, with_this) {
    return txt.replace(new RegExp(replace, 'g'), with_this);
}
function j_validate(that) {
    var $this = that;
    if ($this.data('submitted') != 'true') {
        // quick hack to trigger submit only once
        $('#js-save').trigger('submit');
        $this.data('submitted', 'true');
    }
    if ($('div.error', $this).length == 0) {
        // return true when there's no error in form
        return '';
    } else {
        return 'error';
    }
}
/*
IFrame Transport -
- set false for 'normal' upload
- For Direct, 'vimeo' alone set to false
*/
function isSetIframeTransport() {
	/*if ($('#direct_service').length != 0 && $('#direct_service').val() == 'vimeo') {
        return false;
    }
    if ($('#service_type').length != 0 && $('#service_type').val() == 'normal') {
        return false;
    }*/
    return true;
}
function getFileType() {
    if ($('#allowedFileType').length != 0) {
        var type = replaceAll($('#allowedFileType').data('allowed-extensions').replace(/ /g, ''), ',', '|');
        if (typeof(type) != 'undefined' && type != null) {
            return new RegExp(type, 'i');
        }
    }
}
/*************************Function Over*****************************/

(function() {
var $dc = $(document);
// do not overwrite the namespace, if it already exists; ref http://stackoverflow.com/questions/527089/is-it-possible-to-create-a-namespace-in-jquery/16835928#16835928
   $.p = $.p || {};
	jQuery('html').addClass('js');
	function xload(is_after_ajax) {
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('#SudopayCreditCardNumber' + so).payment('formatCardNumber').addClass('xltriggered');
        $('#SudopayCreditCardExpire' + so).payment('formatCardExpiry').addClass('xltriggered');
        $('#SudopayCreditCardCode' + so).payment('formatCardCVC').addClass('xltriggered');
		$(document).on('submit', '.js-submit-target', function(e) {
			var $this = $(this);
			var cardType = $.payment.cardType($this.find('#SudopayCreditCardNumber').val());
            $this.find('#SudopayCreditCardNumber').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardNumber($this.find('#SudopayCreditCardNumber').val()));
            $this.find('#SudopayCreditCardExpire').filter(':visible').parent().toggleClass('error', !$.payment.validateCardExpiry($this.find('#SudopayCreditCardExpire').payment('cardExpiryVal')));
            $this.find('#SudopayCreditCardCode').filter(':visible').parent().toggleClass('error', !$.payment.validateCardCVC($this.find('#SudopayCreditCardCode').val(), cardType));
            $this.find('#SudopayCreditCardNameOnCard').filter(':visible').parent().toggleClass('error', ($this.find('#SudopayCreditCardNameOnCard').val().trim().length == 0));
            return($this.find('.error, :invalid').filter(':visible').length == 0);
		});
		
		$('div.input' + so).each(function() {
			var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).prop('class'));
			if (m && m[1]) {
				$(this).on('blur', 'input, textarea:not(.novalidate), select, label', function(event) {
					var validation = eval('({' + m[1] + '})');
					$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
					error_message = 0;
					for (var i in validation) {
						if((typeof(validation[i]['rule']) != 'undefined') && validation[i]['rule'][0]=="_checkNumber"){
							if(!((validation[i]['rule'][2]<$(this).val()) && (validation[i]['rule'][3]>$(this).val()))){
								error_message = 1;
								break;
							}
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'notempty' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'notempty' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! $(this).val()) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'alphaNumeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'alphaNumeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[0-9A-Za-z]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'numeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'numeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[+-]?[0-9|.]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'email' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'email' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'equalTo') || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'equalTo' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val() != validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == '_betweencheck' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == '_betweencheck' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && ($(this).val().toString().length < parseInt(validation[i]['rule'][1]) || $(this).val().toString().length > parseInt(validation[i]['rule'][2]))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'between' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'between' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && (parseInt($(this).val()) < parseInt(validation[i]['rule'][1]) || parseInt($(this).val()) > parseInt(validation[i]['rule'][2]))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'minLength' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'minLength' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val().length < validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
					}
					if (error_message) {
						$(this).parent().addClass('error');
						var message = '';
						if (typeof(validation[i]['message']) != 'undefined') {
							message = validation[i]['message'];
						} else if (typeof(validation['message']) != 'undefined') {
							message = validation['message'];
						}
						$(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
					}
				});
			}
		});
		 $("body").on('click','.js-pagination a', function() {
				$this = $(this);
				$this.parents('div.js-response').block();
				$.get($this.attr('href'), function(data) {
					$this.parents('div.js-response').html(data);
					$this.parents('div.js-response').unblock();
					return false;
				});
				return false;
			});
		$('.js-affix-header').each(function(e) {
			$(this).hide();
			if(window.location.href.indexOf("/users/login") == -1 && window.location.href.indexOf("/users/register") == -1) {
				$(this).show();
			}
		});
		$('.js-payment-type').each(function() {
			var $this = $(this);
			if ($this.prop('checked') == true) {
				if ($this.val() == 3) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val() == 2) {
					$('.js-form, .js-instruction').addClass('hide');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-normal-sudopay').slideUp('fast');
				} else if ($this.val() == 1) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val().indexOf('sp_') != -1) {
					$('.js-gatway_form_tpl').hide();
					form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
					for (var i = 0; i < form_fields_arr.length; i ++ ) {
						$('#form_tpl_' + form_fields_arr[i]).show();
					}
					var instruction_id = $this.val();
					$('.js-instruction').addClass('hide');
					$('.js-form').removeClass('hide');
					if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
						$('.js-instruction_'+instruction_id).removeClass('hide');
					}
					if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
						$('.js-form_'+instruction_id).removeClass('hide');
					}
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				}
			}
		});
			$('#bg-stretch-autoresize img#bg-image' + so + ', #bg-stretch img#bg-image' + so).each(function() {
				var $this = $(this);
				var highResImage = new Image();
				var highResImageUrl = $this.metadata().highResImage;
				highResImage.onload = function() {
					$this.prop('src', highResImageUrl);
				}
				highResImage.src = highResImageUrl;
			}).addClass('xltriggered');
	$('#myCarousel').carousel();
	$('#myCarousel').carousel('next');
	$('.users-login' + so).each(function(e) {
			$.getScript('http://connect.facebook.net/en_US/all.js#xfbml=1', function(data) {
				FB.init( {
					appId: $('#js-facepile-section').metadata().fb_app_id,
					status: true,
					cookie: true,
					xfbml: true
				});
				FB.getLoginStatus(function(response) {
					if (response.status == 'connected' || response.status == 'not_authorized') {
						$('.js-facepile-loader').removeClass('loader');
						document.getElementById('js-facepile-section').innerHTML = '<fb:facepile width="140"></fb:facepile>';
						FB.XFBML.parse(document.getElementById('js-facepile-section'));
					} else {
						$.get(__cfg('path_relative') + 'users/facepile', function(data) {
							$('.js-facepile-loader').removeClass('loader');
							$('#js-facepile-section').html(data);
						});
					}
				});
			});
		}).addClass('xltriggered');
	FBShare();
	FBImport();

		$('.js-skip-show' + so).each(function(e) {
			setTimeout(function() {
				$('.js-skip-show').slideDown('slow');
			}, 1000);
		}).addClass('xltriggered');
			$('#js-map'+ so).each(function() {
				var y = $('#JobLatitude').val();
				var x = $('#JobLongitude').val();
				if($('#JobZoomLevel')){
					zoomlevel = parseInt($('#JobZoomLevel').val());
					if(zoomlevel >0){
						default_zoom_level = zoomlevel;
					}
				}		
				$('#js-map').fshowmap(y, x, true);
			}).addClass('xltriggered');	
		$('a.js-confirm' + so + ', .js-delete' + so).click(function() {
			var alert = this.text.toLowerCase();
			alert = alert.replace(/&amp;/g, '&');
			return window.confirm(__l('Are you sure you want to ') + alert + '?');
		}).addClass('xltriggered');
			$('#JobAddress' + so + ', #JobJobCoverageRadius' + so).on('blur', function() {
				if ($('#JobAddress').val() != '') {
					render_map();
				}
			}).addClass('xltriggered');	
			$('#JobAddress_colbx' + so).on('blur', function() {		
				if ($('#JobAddress_colbx').val() != '') {
					var address = $('#JobAddress_colbx').val();			
					var index = address.indexOf('\n');
					while(index != -1){
						address = address.replace('\n',' ');
						index = address.indexOf('\n');
					}
					$('#JobAddress_colbx').val(address);
					geocoder_col.geocode( {
						'address': address
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							marker_col.setMap(null);
							map_col.setCenter(results[0].geometry.location);
							marker_col = new google.maps.Marker( {
								draggable: true,
								map: map_col,
								icon: markerimage_col,
								position: results[0].geometry.location
							});	
							$('#JobLatitude_colbx').val(marker_col.getPosition().lat());
							$('#JobLongitude_colbx').val(marker_col.getPosition().lng());	
						}
					});
				}
			}).addClass('xltriggered');
			
			$('#JobJobCoverageRadiusUnitId' + so).on('change', function() {
				if ($('#JobAddress').val() != '') {
					render_map();
				}
			}).addClass('xltriggered');
			$('#JobJobServiceLocationId1' + so + ', #JobJobServiceLocationId2'+ so).on('click', function() {
					render_map();
			}).addClass('xltriggered');	

			$('.js-register-terms label').on('click', function() {
				$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
			});
			$('.js-textarea textarea').on('focus', function() {
				$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
			});
			$('.js-file-type').on('change', function() {
				$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
			});
           
			$('#js-gallery' + so).slideViewerPro( {
				thumbs: 6,
				autoslide: false,
				asTimer: 3500,
				typo: false,
				galBorderWidth: 1,
				thumbsBorderOpacity: 0,
				buttonsTextColor: '#707070',
				buttonsWidth: 30,
				thumbsActiveBorderOpacity: 0.8,
				shuffle: false,
				galBorderColor: '#ddd',
				thumbsActiveBorderColor: '#d8d8d8',
				thumbsActiveBorderColor: '#ff0000'
			}).addClass('xltriggered');
			$('.js-job-title' + so).each(function() {
				$(this).simplyCountable( {
					counter: '#js-job-title-count',
					countable: 'characters',
					maxCount: __cfg('maximum_job_title_length'),
					strictMax: true,
					countDirection: 'down',
					safeClass: 'safe',
					overClass: 'over'
				});
			}).addClass('xltriggered');
			$('.js-job-description' + so).each(function() {
				$(this).simplyCountable( {
					counter: '#js-job-description-title-count',
					countable: 'characters',
					maxCount: __cfg('maximum_job_description_length'),
					strictMax: true,
					countDirection: 'down',
					safeClass: 'safe',
					overClass: 'over'
				});
			}).addClass('xltriggered');

            $('.alab' + so).each(function(e) {
                loadAdminPanel();
            }).addClass('xltriggered');
			// google map versaion3
			//js-add-map
			$('form.js-add-map' + so + ',div.js-add-map' + so + ', form.js-search-map' + so + ', form.js-add-map-dynm' + so).each(function() {
				var script = document.createElement('script');
				var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadMap';
				script.setAttribute('src', google_map_key);
				script.setAttribute('type', 'text/javascript');
				document.documentElement.firstChild.appendChild(script);
			}).addClass('xltriggered');	
			$('form.js-search-map' + so).submit(function() {
				var address = $('#address').val();
				if (address != '') {
					geocoder.geocode( {
						'address': address
					}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							
							$('#job_latitude').val(results[0].geometry.location.Ja);
							$('#job_longitude').val(results[0].geometry.location.Ka);   
							/*----------------------------------------*/
							//loadMap();
							//initMap();
							/*----------------------------------------*/					
							map.setCenter(new google.maps.LatLng(results[0].geometry.location.Ja, results[0].geometry.location.Ka));
							map.setZoom(10);
							searchmapaction();
						}
					});
				} else {
					map.setZoom(1);
					$('#job_latitude').val('0');
					$('#job_longitude').val('0');
					if($('#JobR').val() == 'pages'){
						fetchMarker();
						fetchRequestMarker();
					}else if($('#JobR').val() == 'jobs'){
						fetchMarker();
					}else if($('#JobR').val() == 'requests'){
						fetchRequestMarker();
					}
				}
				return false;
			}).addClass('xltriggered');
			$('.js-auto-submit' + so).each(function() {
				$(this).submit();
			}).addClass('xltriggered');
			
			 $('div.js-tab-container' + so).each(function(i) {
					$(this).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
						var $this = $(pannel);
						$id = $this.selector;
						$('div' + $id).html("<div class='row dc hor-space'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
					});
			  }).addClass('xltriggered');
			 $('.js-job-photo-checkbox' + so).each(function() {
				var active = $('.js-job-photo-checkbox:checked').length;
				var total = $('.js-job-photo-checkbox').length;
				if (active == total)
					$('.js-job-photo-checkbox').parent('.input').hide();
				return false;
			}).addClass('xltriggered');
			$('.js-notification' + so).on('click',function(e) {
				$this = $(this);
				$.get($this.prop('href'), function(data) {
					$('.js-notification-list').html(data);
				});
			}).addClass('xltriggered');

			$('.js-like' + so).click(function(e) {
				var _this = $(this);
				_this.html('<img src="' + __cfg('path_absolute') + 'img/heart-beat.gif">');
				var controller = _this.metadata().controller;
				var relative_url = _this.attr('href');
				var class_link = _this.attr('class');
				$.get(relative_url, function(data) {
					if (data != '') {
						var data_array = data.split('|');
						if (data_array[0] == 'added') {
							_this.html('<i class="icon-heart redc no-pad"></i>');
							_this.attr('class', 'js-like un-like pull-left text-13 no-under');
							_this.attr('escape', false);
							_this.attr('title', __l('Unlike'));
							_this.attr('href', data_array[1]);
						} else if (data_array[0] == 'removed') {
							_this.html('<i class="icon-heart grayc no-pad"></i>');
							_this.attr('class', 'js-like like pull-left text-13 no-under');
							_this.attr('title', __l('Like'));
							_this.attr('escape', false);
							_this.attr('href', data_array[1]);
						}
					}
					$('.js-like').unblock();
				});
				return false;
			}).addClass('xltriggered');
			$('.js-like-view' + so).click(function(e) {
				var _this = $(this);
				_this.html('<img src="' + __cfg('path_absolute') + 'img/red-loader-big.gif">');
				var controller = _this.metadata().controller;                
				var relative_url = _this.attr('href');
				var class_link = _this.attr('class');                            
				$.get(relative_url, function(data) {
					if (data != '') {
						var data_array = data.split('|');
						if (data_array[0] == 'added') {
							_this.html('<img src="' + __cfg('path_absolute') + 'img/big-heart.gif">');
							_this.attr('class', 'js-like-view un-like-view pull-left text-24 no-under top-space');
							_this.attr('escape', false);
							_this.attr('title', __l('Unlike'));
							_this.attr('href', data_array[1]);
						} else if (data_array[0] == 'removed') {                                                        
							_this.html('<img src="' + __cfg('path_absolute') + 'img/big-heart2.gif">');
							_this.attr('class', 'js-like-view like-view pull-left text-24 no-under top-space');
							_this.attr('title', __l('Like'));
							_this.attr('escape', false);
							_this.attr('href', data_array[1]);
						}
					}
					$('.js-like-view').unblock();
				});
				return false;
			}).addClass('xltriggered');
			$('#JobJobCategoryId' + so).each(function() {
				select_option =  $('#JobJobCategoryId').val();
				data = eval($('.js-select_category').html());		
				$('#JobJobCategoryId').html("");
				$('#JobJobCategoryId').append("<option value=''>please select</option>");
				if($('.js-radio-select:checked').val()){
					$.each(data, function(i,item){
						if( $('.js-radio-select:checked').val() == item.JobCategory.job_type_id ){
							$("#JobJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");
						}
					});	
				}
				else{
					$.each(data, function(i,item){				
						$("#JobJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");				
					});
				}
				$('#JobJobCategoryId').val(select_option);       	
			}).addClass('xltriggered');	
			
			$('#RequestJobCategoryId' + so).each(function() {
				select_option =  $('#RequestJobCategoryId').val();
				data = eval($('.js-select_category').html());		
				$('#RequestJobCategoryId').html("");
				$('#RequestJobCategoryId').append("<option value=''>please select</option>");
				if($('.js-type-select-change:checked').val()){
					$.each(data, function(i,item){
						if( $('.js-type-select-change:checked').val() == item.JobCategory.job_type_id ){
							$("#RequestJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");
						}
					});
				}
				else{
					$.each(data, function(i,item){				
						$("#RequestJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");				
					});
				}
				$('#RequestJobCategoryId').val(select_option);       
			}).addClass('xltriggered');
			$('.js-reports' + so).each(function() {
				 if($('.js-reports:checked').val() == 0){		
					$('.js-redeliver').show();
					$('.js-mutual_cancel').hide();
				  }
				  else if($('.js-reports:checked').val() == 1){		
					$('.js-redeliver').hide();
					$('.js-mutual_cancel').show();
				  }
			}).addClass('xltriggered');	
			$('.js-online-jobs' + so).each(function() {
					$('.js-job-service').hide();
					$('#js-required-class').removeClass('required');
					$('#js-required-class textarea').addClass('novalidate');
					$('div.error-message').remove();
					$('#js-required-class textarea').parent().removeClass('error');
					$('#js-required-class textarea').parent().removeClass('required');
			}).addClass('xltriggered');	
			$('div.js-lazyload img' + so).lazyload({
				 placeholder : __cfg('path_absolute') + "img/grey.gif" 
			 });
			 $('.js-bootstrap-tooltip'+ so).tooltip().addClass('xltriggered');
             if(window.location.href.indexOf("/admin/") > -1) {
				$('.js-live-tour-link').hide();
			} else {
				$('.js-live-tour-link').show();
			}
			$('.js-affix-header' + so).affix().addClass('xltriggered');
			$('#paymentgateways-tab-container' + so + ', #ajax-tab-container-job-view' + so + ', #ajax-tab-container-admin' + so + ', #ajax-tab-container-review' + so + ',#ajax-tab-container-review-tabs, #ajax-tab-container-request-view' + so).each(function(i) {
			    $(this).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
					var $this = $(pannel);
					$id = $this.selector;
					$('div' + $id).html("<div class='row dc hor-space'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
				}).bind('easytabs:midTransition', function(e, tab, pannel) {
					if ($(pannel).attr('id').indexOf('paymentGateway-') != -1) {
						$(pannel).find('input:radio:first').trigger('click');
					}
				}).bind('easytabs:after', function(e, tab, pannel) {
					$('div.error-message').remove();
				});
			}).addClass('xltriggered');
			$('#Sudopay_credit_card_number').payment('formatCardNumber');
			$('#Sudopay_credit_card_expire').payment('formatCardExpiry');
			$('#Sudopay_credit_card_code').payment('formatCardCVC');
			// captcha play
			$.p.captchaPlay('a.js-captcha-play'+ so);
			// common confirmation delete function
			// bind form using ajaxForm
			$.p.fajaxform('.js-ajax-form'+ so);
			// Scroll to
			$.p.fscrollTo('.js-scrollto a'+ so);	
			// jquery autocomplete function
			$.p.fautocomplete('.js-autocomplete'+ so);
			$.p.fmultiautocomplete('.js-multi-autocomplete'+ so);
			$.p.fdatepicker('form div.js-datetime'+ so);
			$.p.foverlabel('.js-overlabel label'+ so);
			$.p.fajaxsubmit('.js-ajax-submit'+ so);
			$.p.fajaxlogin('.js-ajax-login'+ so);
			file_upload();
			buildChart(so);
			
	}
    $.fn.setflashMsg = function($msg, $type) {
        switch($type) {
            case 'auth': $id = 'authMessage';
            break;
            case 'error': $id = 'errorMessage';
            break;
            case 'success': $id = 'successMessage';
            break;
            default: $id = 'flashMessage';
        }
        $flash_message_html = '<div class="message" id="' + $id + '">' + $msg + '</div>';
        $('#main').prepend($flash_message_html);
    };
    $.fn.fclickselect = function() {
        this.on('click', function(event) {
            $(this).trigger('select');
        });
    };
	// taken from http://demos.flesler.com/jquery/scrollTo/js/init.js
	// borrowed from jQuery easing plugin
	// http://gsgd.co.uk/sandbox/jquery.easing.php
	$.easing.elasout=function(x,t,b,c,d){
		var s=1.70158;
		var p=0;
		var a=c;
		if(t==0)return b;
		if((t/=d)==1)return b+c;
		if(!p)p=d*.3;
		if(a<Math.abs(c)){
			a=c;
			var s=p/4;
		}
		else var s=p/(2*Math.PI)*Math.asin(c/a);
		return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;
	};
	$.p.fscrollTo=function(selector){
		$(selector).on('click',function(){
			$.scrollTo('js-jobs-scroll-here',1500);
			return true;
		});
	};
 // auto completes starts
   	 $.p.fautocomplete = function(selector) {
			// don't navigate away from the field on tab when selecting an item
		if ($(selector, 'body').is(selector)) {
            $(selector).each(function(e) {
                $this = $(this);
                var autocompleteUrl = $this.metadata().url;
                var targetField = $this.metadata().targetField;
                var targetId = $this.metadata().id;
                var placeId = $this.attr('id');
                $this.autocomplete( {
                    source: function(request, response) {
                        $.getJSON(autocompleteUrl, {
                            term: extractLast(request.term)
                            }, response);
                    },
                    open: function() {
                        $(".ui-autocomplete").css("z-index", "10").addClass("dropdown-menu");
                    },
                    search: function() {
                        // custom minLength
                        var term = extractLast(this.value);
                        if (term.length < 2) {
                            return false;
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function(event, ui) {
                        if ($('#' + targetId).val()) {
                            $('#' + targetId).val(ui.item['id']);
                        } else {
                            var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
                            $('#' + placeId).after(targetField1);
                            $('#' + targetId).val(ui.item['id']);
                        }
                    }
                });
            }).addClass('xltriggered');
        }
	    }
   // auto complete ends



   // Multi auto complete starts
   	 $.p.fmultiautocomplete = function(selector) {
		// don't navigate away from the field on tab when selecting an item
		$(selector).each(function(e) {
			$this = $(this);
		    $this.each(function(e) {
				var autocompleteUrl = $this.metadata().url;
				$this.autocomplete({
				//	source:$this.metadata().url,
				source: function( request, response ) {
					$.getJSON( autocompleteUrl, {
						term: extractLast( request.term )
					}, response );
				},
				open: function() {
					$(".ui-autocomplete").css("z-index", "10").addClass("dropdown-menu");
				},				
				search: function() {
					// custom minLength
					var term = extractLast( this.value );
					if ( term.length < 2 ) {
						return false;
					}
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},

				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}

			  });
			});
		  }).addClass('xltriggered');
	   }
   $.p.fajaxform = function(selector) {
        $(selector).each(function(e) {
            $(this).on('submit', function() {
                var $this = $(this);
                $this.block();
                $this.ajaxSubmit( {
                    beforeSubmit: function(formData, jqForm, options) {},
                    success: function(responseText, statusText) {
                        redirect = responseText.split('*');
                        if (redirect[0] == 'redirect') {
                            location.href = redirect[1];
                        } else if ($this.metadata().container) {
                            $('.' + $this.metadata().container).html(responseText);
                        } else {
                            $this.parents('.js-responses').html(responseText);
                        }
                        $this.unblock();
                    }
                });
                return false;
            });
        }).addClass('xltriggered');
    }
	$.p.fajaxsubmit = function(selector) {
        $(selector).on('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit:function(formData,jqForm,options){
					// var queryString = $.param(formData);
					// alert('About to submit: \n\n' + queryString);
					$('input:file',jqForm[0]).each(function(i){
						if($('input:file',jqForm[0]).eq(i).val()){
							options['extraData']={	'is_iframe_submit':1 };
						}
					});
				},
                success: function(responseText, statusText) {
					$(this).each(function(){
						//$.fn.colorbox({html:responseText, open:true, scrolling:false});
						$(".modal-body").html(responseText);
						$("#js-ajax-modal").modal('show');
					});
	                $this.unblock();
                }
            });
            return false;
        });
    };
    $.p.fajaxlogin = function(selector) {
        $(selector).on('submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText == 'success') {
                        window.location.reload();
                    } else {
						$this.parents('.js-login-response').html(responseText);
					}
                }
            });
            return false;
        });
    };
    var i = 1;
    $.p.fdatepicker = function(selector) {
        $(selector).each(function() {
            var $this = $(this);
			if ($this.data('displayed') == true) {
				return false;
			}
			$this.attr('data-displayed', 'true');
			var full_label = error_message = '';
			if (label = $this.find('label').text()) {
				full_label = '<label for="' + label + '">' + label + '</label>';
			}
			var info = $this.find('.info').text()
				if ($('div.error-message', $this).html()) {
				error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
			}
			var start_year = end_year = '';
			$this.find('select[id$="Year"]').find('option').each(function() {
				$tthis = $(this);
				if ($tthis.prop('value') != '') {
					if (start_year == '') {
						start_year = $tthis.prop('value');
					}
					end_year = $tthis.prop('value');
				}
			});
			var display_date = '', display_date_set = false;
			$this.prop('data-date-format', 'yyyy-mm-dd');
			year = $this.find('select[id$="Year"]').val();
			month = $this.find('select[id$="Month"]').val();
			day = $this.find('select[id$="Day"]').val();
			$this.prop('data-date', year + '-' + month + '-' + day);
			if (year == '' && month == '' && day == '') {
				display_date = 'No Date Time Set';
			} else {
				display_date = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
				display_date_set = true;
			}
			var picketime = false;
			if ($(this).hasClass('js-datetimepicker')) {
				hour = $this.find('select[id$="Hour"]').val();
				min = $this.find('select[id$="Min"]').val();
				meridian = $this.find('select[id$="Meridian"]').val();
				$this.prop('data-date', year + '-' + month + '-' + day + ' ' + hour + '.' + min + ' ' + meridian);
				display_date = display_date + ' ' + hour + '.' + min + ' ' + meridian;
				picketime = true;
			} else {
				if(!display_date_set) {
					display_date = 'No Date Set';
				}
			}
			$this.find('.js-cake-date').hide();
			$this.append();
			$this.append('<div id="datetimepicker' + i + '" class="input-append date datetimepicker"><input type="hidden" />' + full_label + '<span class="add-onn top-smspace js-calender-block hor-space show-inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar text-16"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
			$this.find('#datetimepicker' + i).datetimepicker( {
				format: 'yyyy-MM-dd-hh-mm-PP',
				language: 'en',
				pickTime: picketime,
				pick12HourFormat: true
			}).on('changeDate', function(ev) {
				var selected_date = $(ev.currentTarget).find('input').val();
				var newDate = selected_date.split('-');
				display_date = date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2]));

				$this.find("select[id$='Day']").val(newDate[2]);
				$this.find("select[id$='Month']").val(newDate[1]);
				$this.find("select[id$='Year']").val(newDate[0]);
				if (picketime) {
					display_date = display_date + ' ' + newDate[3] + '.' + newDate[4] + ' ' + newDate[5];
					$this.find("select[id$='Hour']").val(newDate[3]);
					$this.find("select[id$='Min']").val(newDate[4]);
					$this.find("select[id$='Meridian']").val(newDate[5]);
				}
				$this.find('.js-display-date').html(display_date);
				$this.find('.error-message').remove();
			});
			i = i + 1;
		}).addClass('xltriggered');
    };
    $.p.foverlabel = function(selector) {
        $(selector).each(function(e) {
            $(this).overlabel();
        }).addClass('xltriggered');
    };
	$.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
	$.fn.fshowmap = function(point_y, point_x, drag) {        
		$('#js-map').jmap('init', {
            mapCenter: [point_y, point_x],
            mapShowjMapIcon: true,
            mapZoom: default_zoom_level,
            mapEnableDragging: true,
            mapEnableScrollZoom: true
        }, function(el, options) {
            $(el).jmap('addMarker', {
                pointLatLng: [point_y, point_x],
                pointIsDraggable: drag
            });
            map_reference = el.jmap;
            location_reference = new GLatLng(parseFloat(point_y), parseFloat(point_x));
        });
    };
	initMap = function() {
		$('form.js-add-map, form.js-add-map-dynm, div.js-add-map').each(function() {
			 marker = new google.maps.Marker( {
                draggable: true,
                map: map,
                icon: markerimage,
                position: latlng
            });
		    map.setCenter(latlng);
            //infowindow.setContent('No Man\'s Land');
            //infowindow.open(map, marker);
            google.maps.event.addListener(marker, 'dragstart', function(event) {
                //infowindow.setContent('Adjusting position...');
            });
			google.maps.event.addListener(marker, 'dragend', function(event) {
                geocodePosition(marker.getPosition());
            });
			

			lat = $('#job_latitude').val();
            lng = $('#job_longitude').val();
            if (parseInt(lat) != 0 && parseInt(lng) != 0) {
                geocodePosition(marker.getPosition());
            }
		});
		$('form.js-search-map').each(function() {
			refreshMap();
			if($('#JobR').val() == 'pages'){
				fetchMarker();
				fetchRequestMarker();
			}else if($('#JobR').val() == 'jobs'){
				fetchMarker();
			}else if($('#JobR').val() == 'requests'){
				fetchRequestMarker();
			}
            google.maps.event.addListener(map, 'dragend', function() {
                searchmapaction();
            });
            google.maps.event.addListener(map, 'zoom_changed', function() {
                searchmapaction();
            });
        });
	};
	initMapCol = function() {
		$('form.js-dynm-add-map').each(function() {
			 marker_col = new google.maps.Marker( {
                draggable: true,
                map: map_col,
                icon: markerimage_col,
                position: latlng_col
            });
            map_col.setCenter(latlng_col);
			google.maps.event.addListener(marker_col, 'dragend', function(event) {
                geocodePositionCol(marker_col.getPosition());
            });
			google.maps.event.addListener(map_col, 'mouseout', function(event) {
                $('#JobZoomLevel_colbx').val(map_col.getZoom());
            });
		});
	};
	$.p.captchaPlay = function(selector) {
        $(selector).each(function() {
            $(this).flash(null, {
                version: 8
            }, function(htmlOptions) {
                var $this = $(this);
                var href = $this.get(0).href;
                var params = $.query(href);
                htmlOptions = params;
                href = href.substr(0, href.indexOf('&'));
                // upto ? (base path)
                htmlOptions.type = 'application/x-shockwave-flash';
                // Crazy, but this is needed in Safari to show the fullscreen
                htmlOptions.src = href;
                $this.parent().html($.fn.flash.transform(htmlOptions));
            });
        }).addClass('xltriggered');
    };
	$('a.js-toggle-icon').click(function() {
		$this = $(this);
		class_name = $this.find('.icon-chevron-up').prop('class');
		class_name_plus = $this.find('.icon-chevron-down').prop('class');
		if (typeof(class_name) != 'undefined') {
			if (class_name.indexOf('icon-chevron-up') > -1) {
				$this.find('.icon-chevron-up').addClass('icon-chevron-down');
				$this.find('.icon-chevron-down').removeClass('icon-chevron-up');
			}
		}
		if (typeof(class_name_plus) != 'undefined') {
			if (class_name_plus.indexOf('icon-chevron-down') > -1) {
				$this.find('.icon-chevron-down').addClass('icon-chevron-up');
				$this.find('.icon-chevron-up').removeClass('icon-chevron-down');
			}
		}
	});
	


	
	var tout = '\\x46\\x50\\x50\\x6C\\x61\\x74\\x46\\x6F\\x72\\x6D\\x55\\x6C\\x74\\x72\\x61\\x50\\x6C\\x75\\x73\\x2C\\x20\\x41\\x67\\x72\\x69\\x79\\x61';
	if (tout && 1) {
		window._tdump = tout;
	}

$dc.ready(function($) {
	window.current_url = document.URL;
		xload(false);
		
		$dc.on('click', 'a:not(.js-no-pjax, .close, .disabled):not([href^=http], .js-like, .js-like-view, .js-star)', function(event) {
				if ($.support.pjax) {
					$.pjax.click(event, {container: '#pjax-body', fragment: '#pjax-body'});
				}
			
			}).on('click', 'a:not(.js-no-pjax, .close, .disabled):not([href^=http], .js-like, .js-like-view, .js-star)', function(event) {
				if (!$.support.pjax) { return; }
				var link = $(this).prop('href');
				var current_url = window.current_url;
				if (link.indexOf('admin') < 0 && current_url.indexOf('admin') > 0) {
					window.location.href = link;
				}
				if (link.indexOf('admin') >= 0) {
					$('.admin-menu li').removeClass('active');
					$(this).parents('li').addClass('active');
				} else {
					$('.selling, .request, .how_it_works, .login, .register, .dashboard, .editprofile, .sellercp, .buyercp, .findfriends').removeClass('active');
					if (link.indexOf('requests') >= 0) {
						$('.selling').addClass('active');
					} else if (link.indexOf('jobs') >= 0) {
						$('.request').addClass('active');
					} else if (link.indexOf('how-it-works') >= 0) {
						$('.how_it_works').addClass('active');
					} else if (link.indexOf('login') >= 0) {
						$('.login').addClass('active');
					} else if (link.indexOf('register') >= 0) {
						$('.register').addClass('active');
					} else if (link.indexOf('users/dashboard') >= 0) {
						$('.dashboard').addClass('active');
					} else if (link.indexOf('user_profiles/edit') >= 0) {
						$('.editprofile').addClass('active');
					} else if (link.indexOf('jobs/manage') >= 0) {
						$('.sellercp').addClass('active');
					} else if (link.indexOf('job_orders/index') >= 0) {
						$('.buyercp').addClass('active');
					} else if (link.indexOf('social_marketings/import_friends') >= 0) {
						$('.findfriends').addClass('active');
					}
				}
			}).on('click', '.js-upload-form-submit', function(e) {
				e.preventDefault();
                var $this = $('.js-upload-form');
				$this.find('div.input input[type=text], div.input textarea, div.input select').filter(':visible').trigger('blur');
                if (j_validate($this) == 'error') {
					$('input, textarea, select', $('.error', $this).filter(':first')).trigger('focus');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
				if($('.js-upload-form').prop('id') == "JobEditForm"){
					if(filesList.length <= 0){
						$('.js-upload-form').unbind().submit();
					}else{
						$('.js-upload-form').block();
						$('.js-upload-form').fileupload('send', {files:filesList, paramName: paramNames});
					}
				}else{
					if(filesList.length > 0){
						$('.js-upload-form').block();
					}
					$('.js-upload-form').fileupload('send', {files:filesList, paramName: paramNames});
				}
		}).on('click', '.js-admin-update-status', function(e) {
			$this = $(this);
			var status = '';
			if ($this.parents('td').hasClass('js-payment-status')) {
				status = 1;
			}
			$this.html('<img src="' + __cfg('path_absolute') + 'img/small_loader.gif">');
			$.get($this.prop('href'), function(data) {
				$this.parent('td').html(data);
				if (status == 1) {
					$.p.fwarninginfochange('.js-wallet' + so + ', .js-payment-all' + so);
				}
			});
			return false;
		}).on('click','img.js-open-datepicker', function() {
				var div_id = $(this).attr('name');
				$('#' + div_id).toggle();
				$(this).parent().parent().toggleClass('date-cont');
			}).on('click','a.js-close-calendar', function() {
				$('#' + $(this).metadata().container).hide();
				$('#' + $(this).metadata().container).parent().parent().toggleClass('date-cont');
				return false;
			}).on('click','a.js-accordion-link', function() {
					$this = $(this);
					var contentDiv = $this.attr('href');
					$id = $this.metadata().data_id;
					$parent_class = $('.js-content-' + $id).parent('div').attr('class');
					if ($this.children('i').hasClass("icon-plus"))
						$this.children('i').removeClass("icon-plus").addClass("icon-minus");
					else $this.children('i').removeClass("icon-minus").addClass("icon-plus");
					if ($parent_class.indexOf('in') > -1) {
						$('.js-content-' + $id).block();
						$.get($(this).metadata().url, function(data) {
							$('.js-content-' + $id).html(data).unblock();
							return false;
						});
					}
				}).on('click', '.js-select', function(e) {
				$this = $(this);
				if (unchecked = $this.metadata().unchecked) {
					$('.' + unchecked).prop('checked', false);
				}
				if (checked = $this.metadata().checked) {
					$('.' + checked).prop('checked', 'checked');
				}
				return false;
			}).on('click','a.js-no-date-set', function() {
				$this = $(this);
				$tthis = $this.parents('.input');
				$('div.js-datetime', $tthis).children("select[id$='Day']").val('');
				$('div.js-datetime', $tthis).children("select[id$='Month']").val('');
				$('div.js-datetime', $tthis).children("select[id$='Year']").val('');
				$('div.js-datetime', $tthis).children("select[id$='Hour']").val('');
				$('div.js-datetime', $tthis).children("select[id$='Min']").val('');
				$('div.js-datetime', $tthis).children("select[id$='Meridian']").val('');
				$('#caketime' + $this.metadata().container).html('');
				$('.displaydate' + $this.metadata().container + ' span').html('No Date Set');
				return false;
			}).on('hidden', '.modal', function () {
				$(this).removeData('modal');
			}).on('show', '.modal', function(e) {
				if ($(this).prop('id') == 'js-ajax-modal') {
					$('.modal-header').html($('#modal-header').html());
				}
				if (!$(this).hasClass('bootstrap-wysihtml5-insert-image-modal') && !$(this).hasClass('bootstrap-wysihtml5-insert-link-modal') && !$(this).hasClass('modal hide fade in')) {
					$(this).find('.modal-body').html('<img src="' + __cfg('path_absolute') + '/img/throbber.gif"> Loading...');
				}
			}).on('click', '.js-notification', function(e) {
				$this = $(this);
				$.get($this.prop('href'), function(data) {
					$('.js-notification-list').html(data);
				});
			}).on('click', '.js-update-order-field', function(e) {
				var user_balance;
				user_balance = $('.js-user-available-balance').metadata().balance;
				if ($('#PaymentGatewayId2:checked').val() && user_balance != '' && user_balance != '0.00') {
					return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
				} else if (( ! user_balance || user_balance == '0.00') && ($('#PaymentGatewayId2:checked').val() != '' && typeof($('#PaymentGatewayId2:checked').val()) != 'undefined')) {
					alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
					return false;
				} else {
					return true;
				}
			}).on('click', '#js-drop-down', function(e) {
				$(e.target).toggleClass('icon-angle-down icon-angle-up', 200);
			}).on('shown','.modal',function(){
				$('form.js-dynm-add-map').each(function() {
						var script = document.createElement('script');
						var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadColMap';
						script.setAttribute('src', google_map_key);
						script.setAttribute('type', 'text/javascript');
						document.documentElement.firstChild.appendChild(script);
					});	
			}).on('click','.js-admin-select-all', function() {
				$('.js-checkbox-list').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-none', function() {
				$('.js-checkbox-list').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-pending', function() {
				$('.js-checkbox-active').attr('checked', false);
				$('.js-checkbox-inactive').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-approved', function() {
				$('.js-checkbox-active').attr('checked', 'checked');
				$('.js-checkbox-inactive').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-notfeatured', function() {
				$('.js-checkbox-featured').attr('checked', false);
				$('.js-checkbox-notfeatured').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-featured', function() {
				$('.js-checkbox-featured').attr('checked', 'checked');
				$('.js-checkbox-notfeatured').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-jobapproved', function() {
				$('.js-checkbox-approved').attr('checked', 'checked');
				$('.js-checkbox-disapproved').attr('checked', false );
				return false;
			}).on('click','.js-admin-select-jobdisapproved', function() {
				$('.js-checkbox-disapproved').attr('checked', 'checked');
				$('.js-checkbox-approved').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-unsuspended', function() {
				$('.js-checkbox-suspended').attr('checked', false);
				$('.js-checkbox-unsuspended').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-suspended', function() {
				$('.js-checkbox-suspended').attr('checked', 'checked');
				$('.js-checkbox-unsuspended').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-unflagged', function() {
				$('.js-checkbox-flagged').attr('checked', false);
				$('.js-checkbox-unflagged').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-flagged', function() {
				$('.js-checkbox-flagged').attr('checked', 'checked');
				$('.js-checkbox-unflagged').attr('checked', false);
				return false;
			}).on('click','.js-admin-select-activeusers', function() {
				$('.js-checkbox-deactiveusers').attr('checked', false);
				$('.js-checkbox-activeusers').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-deactiveusers', function() {
				$('.js-checkbox-deactiveusers').attr('checked', 'checked');
				$('.js-checkbox-activeusers').attr('checked', false);
				return false;
			}).on('click','.js-admin-user-reported', function() {
				$('.js-checkbox-unreported').attr('checked', false);
				$('.js-checkbox-user-reported').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-unreported', function() {
				$('.js-checkbox-user-reported').attr('checked', false);
				$('.js-checkbox-unreported').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-waitingforacceptance', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-waitingforacceptance').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-inprogress', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-inprogress').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-waitingforreview', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-waitingforreview').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-completed', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-completed').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-rejected', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-rejected').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-cancelled', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-cancelled').attr('checked', 'checked');
				return false;
			}).on('click','.js-admin-select-paymentcleared', function() {
				$('.js-admin-checkbox').attr('checked', false);
				$('.js-checkbox-paymentcleared').attr('checked', 'checked');
				return false;
			}).on('click','.js-job-photo-checkbox', function() {
				var active = $('.js-job-photo-checkbox:checked').length;
				var total = $('.js-job-photo-checkbox').length;
				if (active == total) {
					alert(__l('You cannot delete all the Photos!'));
					return false;
				} else {
					if ($(this).is(':checked')) {
						if (window.confirm(__l('Are you sure you want to Remove the photo?'))) {
							var feedback_select = $(this).is(':checked');
							if (feedback_select) {
								$(this).parents('.attachment-delete-block').append("<span class='js-job-delete-class'></span>");
							} else {
								$(this).parents('.attachment-delete-block').find('.js-job-delete-class').remove();
							}
						} else {
							return false;
						}
					}
				}
			}).on('click','.js-order-submit', function() {
				if (window.confirm('Amount will be deducted from your balance account. Do you want to proceed ? ')) {
					$(this).parents('form').submit();
				} else {
					return false;
				}
			}).on('click', '.js-live-tour', function(e) {
				bootstro.start();
				return false;
			}).on('click', '.bootstro-goto', function(e) {
				bootstro.start();
				bootstro.go_to(1);
				return false;
			}).on('click','.js-admin-action', function() {
				var active = $('input.js-checkbox-active:checked').length;
				var inactive = $('input.js-checkbox-inactive:checked').length;
				if (active <= 0 && inactive <= 0) {
					alert(__l('Please select atleast one record!'));
					return false;
				} else {
					return window.confirm(__l('Are you sure you want to do this action?'));
				}
			}).on('click','.js-subject-insert',function(e) {
				var $this = $(this).parent('.js-insert');
				$('.js-email-subject', $this).replaceSelection(this.title);
				e.preventDefault();
			}).on('submit', 'form', function(e) {
				$(this).find('div.input input[type=text], div.input input[type=password], div.input textarea, div.input select').filter(':visible').trigger('blur');
				$('input, textarea, select', $('.error', $(this)).filter(':first')).trigger('focus');
				if($('.js-job-type', 'body').is('.js-job-type')){
					var checkedtype = $('input.js-job-type:checked').val();
					var $this = $('.js-job-type');
					$this.siblings('div.error-message').remove();
					if(typeof(checkedtype) == 'undefined'){				
						$this.parent().append('<div class="error-message no-mar">Required</div>').fadeIn();
					}
				}
				return ! ($('.error-message', $(this)).length);
			}).on('click','.js-show-message',function(e) {
				$this = $(this);
					class_name='.js-message-view' + $this.metadata().message_id;
					//console.log(class_name);
					var is_read = $this.metadata().is_read;
					var is_auto =$this.metadata().is_auto;
					$this.metadata().is_read = 1;
					var msg_id =$this.metadata().message_id;
					if(is_read == 0 || is_read == ''){
						$this.parent().addClass(' cur com-bg grayc');
							$.get(__cfg('path_relative') + 'messages/update_message_read/'+msg_id+'/'+is_auto, function(data) {
							$('.js-unread').html(data);
							return false;
						});
					}
					$(class_name).toggle();
			}).on('click', '.js-content-insert',function(e) {
				var $this = $(this).parent('.js-insert');
				$('.js-email-content', $this).replaceSelection(this.title);
				e.preventDefault();
			}).on('click','.js-captcha-reload', function() {
				captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').attr('src');
				captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
				$(this).parents('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
				return false;
			}).on('change','.js-admin-index-autosubmit', function() {
				if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() >= 1) {
					alert(__l('Please select atleast one record!'));
					return false;
				} else if ($(this).val() >= 1) {
					if (window.confirm(__l('Are you sure you want to do this action?'))) {
						$(this).parents('form').submit();
					} else {
						$(this).val('');
					}
				}
			}).on('change','.js-autosubmit', function() {
				$(this).parents('form').submit();
			}).on('mouseenter', '.js-share', function(e) {
				$(this).removeClass('social-buttons');
				Socialite.load($(this)[0]);
			}).on('click','.js-connect', function(e) {                    
					$.oauthpopup( {             
					path: $(this).metadata().url,                
					callback: function() {                
						var href = window.location.href;     
						if (href.indexOf('users/register') != -1) {                    
							location.href = __cfg('path_absolute') + 'users/login';
						} else {
							window.location.reload();
						}
					}
				});
				return false;
			}).on('click','.js-toggle-show', function() {
				$('.' + $(this).metadata().container).toggle();
				return false;
			}).on('click', '.js-star',function() {
				var $this = $(this);
				$this.block();
				$this.html('<img src="' + __cfg('path_absolute') + 'img/star-load.gif" style="margin:5px 0 0 2px">');
				$.get($this.prop('href'), null, function(data) {
					$this.parent().html(data);
					$this.unblock();
				});
				return false;
			}).on('click','.js-admin-update-job', function() {
				if(window.confirm(__l('Are you sure you want to') + ' ' + this.text.toLowerCase() + '?')){
					var _this = $(this);
					//confirm();
					_this.parent().block();
					var controller = _this.metadata().controller;
					var relative_url = _this.attr('href');
					var class_link = _this.attr('class');
					$.get(relative_url, function(data) {
						if (data != '') {
							var data_array = data.split('|');
							if (data_array[0] == 'user_blocked') {
								_this.text(__l('Activate user'));
								_this.attr('class', 'js-admin-update-job active-user btn blackc js-no-pjax');
								_this.attr('title', __l('Activate user'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('User has been deactivated.'), 'success');
							} else if (data_array[0] == 'user_unblocked') {
								_this.text(__l('Deactivate user'));
								_this.attr('class', 'js-admin-update-job deactive-user btn blackc js-no-pjax');
								_this.attr('title', __l('Deactivate user'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('User has been re-activated.'), 'success');
							} else if (data_array[0] == 'job_suspend') {
								_this.text(__l('Unsuspend')+' '+__l('jobs'));
								_this.attr('class', 'js-admin-update-job suspend btn blackc js-no-pjax');
								_this.attr('title', __l('Unsuspend')+' '+__l('jobs'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Job')+' '+__l('has been suspended.'), 'success');
							} else if (data_array[0] == 'job_unsuspend') {
								_this.text(__l('Suspend')+' '+__l('jobs'));
								_this.attr('class', 'js-admin-update-job unsuspend btn blackc js-no-pjax');
								_this.attr('title', __l('Suspend')+' '+__l('jobs'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Job')+' '+__l('has been Unsuspended.'), 'success');
							} else if (data_array[0] == 'flagged') {
								_this.text(__l('Clear Flag'));
								_this.attr('class', 'js-admin-update-job clear-flag btn blackc js-no-pjax');
								_this.attr('title', __l('Clear Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Job')+' '+__l('has been flagged.'), 'success');
							} else if (data_array[0] == 'message_flagged') {
								_this.text(__l('Clear Flag'));
								_this.attr('class', 'js-admin-update-job clear-flag btn blackc js-no-pjax');
								_this.attr('title', __l('Clear Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('User Message ')+' '+__l('has been flagged.'), 'success');
							} else if (data_array[0] == 'message_flag_cleared') {
								_this.text(__l('Flag'));
								_this.attr('class', 'js-admin-update-job fla btn blackc js-no-pjaxg');
								_this.attr('title', __l('Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('User Message Flag has been cleared.'), 'success');
							}
							else if (data_array[0] == 'flag_cleared') {
								_this.text(__l('Flag'));
								_this.attr('class', 'js-admin-update-job flag btn blackc js-no-pjax');
								_this.attr('title', __l('Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Flag has been cleared.'), 'success');
							}
							 else if (data_array[0] == 'job_approved') {
								_this.text(__l('Approved'));
								_this.attr('class', 'js-admin-update-job dis-approved btn blackc js-no-pjax');
								_this.attr('title', __l('Approve'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Job has been Approved.'), 'success');
							}
							 else if (data_array[0] == 'job_disapproved') {
								_this.text(__l('Disapproved'));
								_this.attr('class', 'js-admin-update-job approved btn blackc js-no-pjax');
								_this.attr('title', __l('Disapprove'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Job has been disapproved.'), 'success');
							}
							 else if (data_array[0] == 'request_approved') {
								_this.text(__l('Approved'));
								_this.attr('class', 'js-admin-update-job dis-approved btn blackc js-no-pjax');
								_this.attr('title', __l('Approve'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Request')+' '+__l('has been disapproved.'), 'success');
							}
							 else if (data_array[0] == 'request_disapproved') {
								_this.text(__l('Disapproved'));
								_this.attr('class', 'js-admin-update-job approved btn blackc js-no-pjax');
								_this.attr('title', __l('Disapprove'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Request')+' '+__l('has been approved.'), 'success');
							}
							 else if (data_array[0] == 'request_flagged') {
								_this.text(__l('Clear Flag'));
								_this.attr('class', 'js-admin-update-job clear-flag btn blackc js-no-pjax');
								_this.attr('title', __l('Clear Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Request')+' '+__l('has been flagged.'), 'success');
							}
							else if (data_array[0] == 'request_flag_cleared') {
								_this.text(__l('Flag'));
								_this.attr('class', 'js-admin-update-job flag btn blackc js-no-pjax');
								_this.attr('title', __l('Flag'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Flag has been cleared.'), 'success');
							}
							else if (data_array[0] == 'request_suspend') {
								_this.text(__l('Unsuspend')+' '+__l('requets'));
								_this.attr('class', 'js-admin-update-job unsuspend btn blackc js-no-pjax');
								_this.attr('title', __l('Unsuspend')+' '+__l('requests'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Requests')+' '+__l('has been suspended.'), 'success');
							} else if (data_array[0] == 'request_unsuspend') {
								_this.text(__l('Suspend')+' '+__l('requests'));
								_this.attr('class', 'js-admin-update-job suspend btn blackc js-no-pjax');
								_this.attr('title', __l('Suspend')+' '+__l('requests'));
								_this.attr('href', data_array[1]);
								$.fn.setflashMsg(__l('Requests')+' '+__l('has been Unsuspended.'), 'success');
							}
						}
						$('.js-admin-update-job').parent().unblock();
					});
					return false;
				}else{
					return false;
				}
			}).on('click','.js-order-update', function() {
				var $this = $(this);
				if (window.confirm(__l('Are you sure you want to do this action?'))) {
					$this.block();
					var order_id;
					order_id = $(this).metadata().order_id;
					$.get($this.attr('href'), function(data) {
						if (data != 'failed') {
							switch(data) {
								case 'cancelled': $.fn.setflashMsg(__l('Order has been Cancelled.'), 'success');
								break;
								case 'rejected': $.fn.setflashMsg(__l('Order has been Rejected.'), 'success');
								break;
								case 'accepted': $.fn.setflashMsg(__l('Order has been Accepted.'), 'success');
								break;
							}
							$this.parent().html('<span class="no-action">' + __l('No action') + '</span>');
							$(".js-order-udpate-"+order_id).hide();
						} else {
							$.fn.setflashMsg(__l('Unable to update Order, Please try again.'), 'success');
							$this.unblock();
						}
					});
				}
				return false;
			}).on('change','.js-change-action', function(event) {
				var $this = $(this);
				$('.' + $this.metadata().container).block();
				$.get(__cfg('path_relative') + $this.metadata().url + $this.val(), {}, function(data) {
					$('.' + $this.metadata().container).html(data);
					$('.' + $this.metadata().container).unblock();
				});
			}).on('click','.js-toggle-check', function() {
				$('.' + $(this).metadata().divClass).toggle('slow');
			}).on('click','.js-toggle-div', function() {
				$('.' + $(this).metadata().divClass).toggle('slow');
				return false;
			}).on('click','.js-share-toggle-check', function() {
				if ( ! $(this).next('div').is(':hidden')) {
					$(this).next('div').hide('fast');
				} else {
					$(this).next('div').show('fast');
				}
			}).on('click','.js-feedback-toggle-check',function() {
				var feedback_select = ($('.js-feedback-toggle-check:checked').val());
				if (feedback_select == 0) {
					$('.js-negative-block').show();
				} else {
					$('.js-negative-block').hide();
				}
			}).on('submit','#csv-form', function(e) {
				var $this = $(this);
				var ext = $('#AttachmentFilename').val().split('.').pop().toLowerCase();
				var allow = new Array('csv');
				if (jQuery.inArray(ext, allow) == -1) {
					$('div.error-message').remove();
					$('#AttachmentFilename').parent().append('<div class="error-message">' + __l('Invalid extension, Only csv is allowed') + '</div>');
					return false;
				}
			}).on('change','.js-invite-all', function() {
				$('.invite-select').val($(this).val());
			}).on('click','.js-alert-message', function() {        
				if (window.confirm(__l('Are you sure you want to do this action?'))) {
				}
				else{
				  return false;
				}
			}).on('click','.js-radio-select', function() {	
				if($(this).val() == 2){
					$('.js-job-service').show();	
					$('#js-required-class').addClass('required');
					$('#js-required-class textarea').removeClass('novalidate');
				 }else if ($(this).val() == 1){
					$('.js-job-service').hide();
					$('#js-required-class').removeClass('required');
					$('#js-required-class textarea').addClass('novalidate');
					$('div.error-message').remove();
					$('#js-required-class textarea').parent().removeClass('error');
					$('#js-required-class textarea').parent().removeClass('required');
				 }
				data = eval($('.js-select_category').html());		
				$('#JobJobCategoryId').val('');
				$('#JobJobCategoryId').html("");
				$('#JobJobCategoryId').append("<option value=''>please select</option>");
				$.each(data, function(i,item){
					if( $('.js-radio-select:checked').val() == item.JobCategory.job_type_id ){
						$("#JobJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");
					}
				});		
			}).on('mouseenter', '.js-sudopay-disconnect', function(e) {
				$(this).html('<i class="icon-remove"></i> ' + __l('Disconnect'));
			}).on('mouseleave', '.js-sudopay-disconnect', function(e) {
				$(this).html('<i class="icon-ok"></i> ' + __l('Connected'));
			}).on('click','.js-type-select-change', function() {	
				data = eval($('.js-select_category').html());
				$(this).parent().removeClass('error');
				$(this).siblings('div.error-message').remove();
				if($(this).val() == 2){
					$('#js-required-class').addClass('required');
				}else{
					$('#js-required-class').removeClass('required');
					$('#JobAddress').parent().removeClass('error');
					$('#JobAddress').siblings('div.error-message').remove();
				}
				$('#RequestJobCategoryId').val('');
				$('#RequestJobCategoryId').html("");
				$('#RequestJobCategoryId').append("<option value=''>please select</option>");
				$.each(data, function(i,item){
					if( $('.js-type-select-change:checked').val() == item.JobCategory.job_type_id ){
						$("#RequestJobCategoryId").append("<option value='"+item.JobCategory.id+"'>"+item.JobCategory.name+"</option>");
					}
				});															 
				
			}).on('click','.js-service', function() {
				 if($(this).val() == 1){
					$('.js-buyer-seller').hide();
				 }else if($(this).val() == 2){
					$('.js-buyer-seller').show();
				 }
			}).on('click','.js-paypal-connected-submit', function() {
				if (window.confirm('Amount will be deducted from your connected PayPal account. Do you want to proceed?')) {
					$(this).parents('form').submit();
				} else {
					return false;
				}
			}).on('blur','.js-related-jobs', function() {		 
				href = __cfg('path_relative') + "jobs/index/type:related_jobs/q:" + $(this).val();		
				$.get(href, {},function(data) {
					$('.js-related-jobs-load').html(data);
				});
			}).on('change','.js-reports', function() {
				  if($('.js-reports:checked').val() == 0){
					$('.js-hide-on-dispute').show();
					$('.js-redeliver').show();
					$('.js-mutual_cancel').hide();
					$('.js-dispute-container').hide();
				  }
				  else if($('.js-reports:checked').val() == 1){		
					$('.js-hide-on-dispute').show();
					$('.js-redeliver').hide();
					$('.js-dispute-container').hide();
					$('.js-mutual_cancel').show();
				  }else if($('.js-reports:checked').val() == 2){		
					$('.js-hide-on-dispute').hide();
					$('.js-redeliver').hide();
					$('.js-mutual_cancel').hide();
					$('.js-dispute-container').show();
				  }
			}).on('click', '.js-link-chart', function() {
				$this = $(this);
				dataloading = $this.metadata().data_load;
				$('.' + dataloading).block();
				$.get($this.attr('href'), function(data) {
					$('.' + dataloading).html(data);
					$('.' + dataloading).find('script').each(function(i) {
						eval($(this).text());
					});
					$('.' + dataloading).unblock();
				});
				return false;
			}).on('click', '.js-request_invite', function(e) {
				$('div.js-responses').eq(0).block();
				$.get(__cfg('path_absolute') + 'subscriptions/add/type:invite_request', function(data) {
					$('div.js-responses').html(data);
					$('div.js-responses').unblock();
				});
				return false;
			}).on('click', '.js-payment-type', function() {
				var $this = $(this);
				if ($this.val() == 3) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val() == 2) {
					$('.js-form, .js-instruction').addClass('hide');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-normal-sudopay').slideUp('fast');
				} else if ($this.val() == 1) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val().indexOf('sp_') != -1) {
					$('.js-gatway_form_tpl').hide();
					form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
					for (var i = 0; i < form_fields_arr.length; i ++ ) {
						$('#form_tpl_' + form_fields_arr[i]).show();
					}
					var instruction_id = $this.val();
					$('.js-instruction').addClass('hide');
					$('.js-form').removeClass('hide');
					if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
						$('.js-instruction_'+instruction_id).removeClass('hide');
					}
					if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
						$('.js-form_'+instruction_id).removeClass('hide');
					}
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				}
			}).on('pjax:send', 'body', function(e) {
					if (!$.support.pjax) { return; }
					if ($('#progress').length === 0) {
						$('body').append($('<div><dt/><dd/></div>').attr('id', 'progress'));
						$('#progress').width((50 + Math.random() * 30) + '%');
					}
					$(this).addClass('loading');
			}).on('pjax:complete', 'body', function(e) {
					if (!$.support.pjax) { return; }
					$(this).removeClass('loading');
			}).on('pjax:timeout', 'body', function(e) {
					if (!$.support.pjax) { return; }
					e.preventDefault();
			}).on('pjax:success', 'body', function() {
					xload(false);
					$('#progress').width('101%').delay(200).fadeOut(400, function() {
						$(this).remove();
					});
					$('#successMessage,#errorMessage').remove();
					$('.js-affix-header').hide();
					if (window.location.href.indexOf("/users/login") == -1 && window.location.href.indexOf("/users/register") == -1) {
						$('.js-affix-header').show();
					}
				 if ((window.location.href.indexOf("/job/") != -1 || window.location.href.indexOf("/user/") != -1)) {
					$('.js-alab').html('');
					$('header').removeClass('show-panel');
					var url = '';
					if(typeof($('.js-user-view').data('user-id')) != 'undefined' && $('.js-user-view').data('user-id') !='' && $('.js-user-view').data('user-id') != null) {
						var uid = $('.js-user-view').data('user-id');
						var url = 'users/show_admin_control_panel/view_type:user/id:'+uid;
					}
					if(typeof($('.js-job-view').data('job-id')) != 'undefined' &&  $('.js-job-view').data('job-id') !='' && $('.js-job-view').data('job-id') != null) {
						var pid = $('.js-job-view').data('project-id');
						var url = 'jobs/show_admin_control_panel/view_type:job/id:'+pid;
					}
					if(url !='') {
						$.get(__cfg('path_relative') + url, function(data) {
							$('.js-alab').html(data).removeClass('hide').show();
						});
					}
				} else {
					$('.js-alab').hide();
				}
			}).on('click', '.js-lang-change', function(e) {
			var parser = document.createElement('a');
			parser.href = window.location.href;
			var subtext=parser.pathname;
			subtext = subtext.replace(__cfg('path_relative'),'');
			location.href=__cfg('path_absolute') + 'languages/change_language/language_id:' + $(this).data('lang_id') + '?f=' + subtext;
			});
			if ($.cookie('_geo') == null) {
				$.ajax( {
					type: 'GET',
					url: '//j.maxmind.com/app/geoip.js',
					dataType: 'script',
					cache: true,
					success: function() {
						var geo = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
						$.cookie('_geo', geo, {
							expires: 100,
							path: '/'
						});
					}
				});
			}			
	}).ajaxStop(function() {
        xload(true);        
    });
})
();
