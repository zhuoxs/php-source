var tMapKey = {
	baidu: 'v22uaSd5zGqvQbBIAvnAM89LjcgYcdkd',
	gould: 'c193b7c51e579ad80ec35989db0d8898'
}
// var baiduMap = {
// 	show: function() {
// 		baiduMap.loScript();
// 	},
// 	loScript: function() {
// 		var script = document.createElement("script");
// 		script.src = "http://api.map.baidu.com/api?v=2.0&ak=" + tMapKey.baidu + "&callback=initialize";
// 		document.getElementsByTagName('head')[0].appendChild(script);
// 	},
// 	createMap: function(obj) {
// 		var map = new BMap.Map(obj);
// 		var point = new BMap.Point(116.404, 39.915);
// 		map.centerAndZoom(point, 15);
// 		map.enableScrollWheelZoom(true);
// 		var geolocation = new BMap.Geolocation();
// 		geolocation.getCurrentPosition(function(r) {
// 			if (this.getStatus() == BMAP_STATUS_SUCCESS) {
// 				var mk = new BMap.Marker(r.point);
// 				map.addOverlay(mk);
// 				map.panTo(r.point);
// 				var str = ['定位成功'];
// 				str.push('<div class="map_longitude" data-getLng="' + r.point.lng + '"> 经度：' + r.point.lng + '</div>');
// 				str.push('<div class="map_latitude" data-getLat="' + r.point.lat + '">纬度：' + r.point.lat + '</div>');
// 				document.getElementById('baiduTip').innerHTML = str.join(' ');
// 			} else {
// 				console.log('failed' + this.getStatus());
// 			}
// 		},
// 		{
// 			enableHighAccuracy: true
//     }) 
//     map.addEventListener('click',
// 		function() {
// 			var center = map.getCenter();
			
// 			remove_overlay();
// 			add_overlay(center.lng,center.lat);

// 			document.querySelector('.editmap_map .map_longitude').innerHTML = '经度:' + center.lng;
// 			document.querySelector('.editmap_map .map_latitude').innerHTML = '纬度:' + center.lat;
// 			document.querySelector('.editmap_map  .map_longitude').setAttribute("data-getLng", '' + center.lng + '');
// 			document.querySelector('.editmap_map .map_latitude').setAttribute("data-getLat", '' + center.lat + '');
// 		});
// 		var ac = new BMap.Autocomplete({
// 			"input": "editmap_id",
// 			"location": map
// 		});
// 		ac.addEventListener("onhighlight",
// 		function(e) {
// 			var str = "";
// 			var _value = e.fromitem.value;
// 			var value = "";
// 			if (e.fromitem.index > -1) {
// 				value = _value.province + _value.city + _value.district + _value.street + _value.business;
// 			}
// 			str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
// 			value = "";
// 			if (e.toitem.index > -1) {
// 				_value = e.toitem.value;
// 				value = _value.province + _value.city + _value.district + _value.street + _value.business;
// 			}
// 			str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
// 			document.getElementById("searchResultPanel").innerHTML = str;
// 		});
// 		var myValue;
// 		ac.addEventListener("onconfirm",
// 		function(e) {
// 			var _value = e.item.value;
// 			myValue = _value.province + _value.city + _value.district + _value.street + _value.business;
// 			document.getElementById("searchResultPanel").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
// 			setPlace();
// 		});
// 		function setPlace() {
// 			map.clearOverlays();
// 			function myFun() {
// 				var pp = local.getResults().getPoi(0).point;
// 				map.centerAndZoom(pp, 18);
// 				map.addOverlay(new BMap.Marker(pp));
// 			}
// 			var local = new BMap.LocalSearch(map, {
// 				onSearchComplete: myFun
// 			});
// 			local.search(myValue);
// 		}

// 		//添加覆盖物
// 		function add_overlay(lng,lat){
// 			var marker = new BMap.Marker(new BMap.Point(lng, lat));
// 			map.addOverlay(marker);            //增加点
// 		}
// 		//清除覆盖物
// 		function remove_overlay(){
// 			map.clearOverlays();         
// 		}

// 	}
// };
var gouldMap = {
	show: function() {
		gouldMap.loScript();
	},
	loScript: function() {
		var script = document.createElement("script");
		script.src = "http://webapi.amap.com/maps?v=1.4.0&key=" + tMapKey.gould + "&plugin=AMap.Autocomplete";
		document.getElementsByTagName('head')[0].appendChild(script);
	},
	createMap: function(obj) {
		var marker,map = new AMap.Map(obj, {
			resizeEnable: true,
			zoom: 10,
			center: [116.480983, 40.0958]
		});
		
		map.plugin('AMap.Geolocation',
		function() {
			geolocation = new AMap.Geolocation({
				enableHighAccuracy: true,
				timeout: 10000,
				buttonOffset: new AMap.Pixel(10, 20),
				zoomToAccuracy: true,
				buttonPosition: 'RB'
			});
			
			// map.addControl(geolocation);
			// geolocation.getCurrentPosition();
      // console.log(onComplete)
      // AMap.event.addListener(geolocation, 'complete', onComplete);
			// AMap.event.addListener(geolocation, 'error', onError);
			
		});

		// lnglat = lnglat.split(",");
		
		var thisLng = document.querySelector('#tip').getAttribute('data-getlng');
		var thisLat = document.querySelector('#tip').getAttribute('data-getlat');

		if(thisLng!=''){
			addMarker(thisLng,thisLat);
			map.setZoomAndCenter(14, [thisLng,thisLat]);
		}else{
			
			AMap.plugin('AMap.CitySearch', function () {
				var citySearch = new AMap.CitySearch()
				citySearch.getLocalCity(function (status, result) {
					if (status === 'complete' && result.info === 'OK') {
						// 查询成功，result即为当前所在城市信息
						var cityinfo = result.city;
						var citybounds = result.bounds;
						// document.getElementById('tip').innerHTML = '您当前所在城市：'+cityinfo;
						//地图显示当前城市
						map.setBounds(citybounds);
					}
				})
			})
		}
		var str = [''];
			str.push('<div class="map_longitude" data-getLng="' + thisLng + '"> 经度：' + thisLng + '</div>');
			str.push('<div class="map_latitude"  data-getLat="' + thisLat + '">纬度：' + thisLat + '</div>');
			document.getElementById('tip').innerHTML = str.join(' ');

		// function onComplete(data) {
			
		// 	var str = ['定位成功'];
		// 	str.push('<div class="map_longitude" data-getLng="' + data.position.getLng() + '"> 经度：' + data.position.getLng() + '</div>');
		// 	str.push('<div class="map_latitude"  data-getLat="' + data.position.getLat() + '">纬度：' + data.position.getLat() + '</div>');
		// 	if (data.accuracy) {
		// 		str.push('精度：' + data.accuracy + ' 米');
		// 	}
		// 	str.push('是否经过偏移：' + (data.isConverted ? '是': '否'));
		// 	document.getElementById('tip').innerHTML = str.join(' ');
		// }
		// function onError(data) {
		// 	document.getElementById('tip').innerHTML = '定位失败';
		// }
		map.plugin(['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Geocoder'],
		function() {
			var autoOptions = {
				city: "北京",
				input: "editmap_id"
			};

			autocomplete = new AMap.Autocomplete(autoOptions);
			var placeSearch = new AMap.PlaceSearch({
				city: '北京',
				map: map
			});
			
			AMap.event.addListener(autocomplete, "select",
			function(e) {
				placeSearch.setCity(e.poi.adcode);
				placeSearch.search(e.poi.name)
			});

			//搜索后，点标记-点击事件
			AMap.event.addListener(placeSearch, "markerClick", function(e){
				// console.log(e.data.location);//当前marker的经纬度信息
				//  document.getElementById("lnglat").value = e.data.location.lng + ',' + e.data.location.lat;
				// console.log( e.data.address);//获取当前marker的具体地址信息
				// console.log(e.data);//则是包含所有的marker数据
				// document.getElementById("input").value =  e.data.address;
				if (marker) {
					marker.setMap(null);
					marker = null;
				}
				document.querySelector('.map_longitude').innerHTML = '经度:' + e.data.location.lng;
				document.querySelector('.map_latitude').innerHTML = '纬度:' + e.data.location.lat;
				document.querySelector('.map_longitude').setAttribute("data-getLng", '' + e.data.location.lng + '');
				document.querySelector('.map_latitude').setAttribute("data-getLat", '' + e.data.location.lat + '');
				var address = e.data.address;
				var addressCity = e.data.cityname;
				document.querySelector('.map_longitude').setAttribute("data-address", '' + address + '');
				document.querySelector('.map_longitude').setAttribute("data-addresscity", '' + addressCity + '');
				document.querySelector('.editmMap_btnAll_ok').disabled = false;
	
			});

			

		});
		var _self = this;
		var clickEventListener = map.on('click',
		function(e) {
      if (marker) {
        marker.setMap(null);
        marker = null;
			}
      addMarker(e.lnglat.getLng(),e.lnglat.getLat());
			regeoCode(e.lnglat.getLng(),e.lnglat.getLat());
			document.querySelector('.map_longitude').innerHTML = '经度:' + e.lnglat.getLng();
			document.querySelector('.map_latitude').innerHTML = '纬度:' + e.lnglat.getLat();
			document.querySelector('.map_longitude').setAttribute("data-getLng", '' + e.lnglat.getLng() + '');
			document.querySelector('.map_latitude').setAttribute("data-getLat", '' + e.lnglat.getLat() + '');
		});
		var auto = new AMap.Autocomplete({
			input: "tipinput"
		});
		AMap.event.addListener(auto, "select", select);
		function select(e) {
			if (e.poi && e.poi.location) {
				map.setZoom(15);
				map.setCenter(e.poi.location);
			}
    }
    function addMarker(Lng,Lat) {
			map.setCenter([Lng, Lat]);
      marker = new AMap.Marker({
          icon: "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
          position: [Lng, Lat]
      });
      marker.setMap(map);
		}
		var geocoder,marker;
		function regeoCode(Lng,Lat) {
			if(!geocoder){
					geocoder = new AMap.Geocoder({
							city: "010", //城市设为北京，默认：“全国”
							radius: 1000 //范围，默认：500
					});
			}
			// var lnglat  = document.getElementById('lnglat').value.split(',');
			var lnglat  = [Lng,Lat];
				if(!marker){
					marker = new AMap.Marker();
					map.add(marker);
			}
			marker.setPosition(lnglat);
			
			geocoder.getAddress(lnglat, function(status, result) {
					if (status === 'complete'&&result.regeocode) {
							var address = result.regeocode.formattedAddress;
							var addressCity = result.regeocode.addressComponent.city || result.regeocode.addressComponent.province;
							document.querySelector('.map_longitude').setAttribute("data-address", '' + address + '');
							document.querySelector('.map_longitude').setAttribute("data-addresscity", '' + addressCity + '');

							document.querySelector('.editmMap_btnAll_ok').disabled = false;
					}else{alert(JSON.stringify(result))}
			});
    }

		

			
	}

};
var returnMap = function(map) {
	if (map.show instanceof Function) {
		map.show();
	};
}