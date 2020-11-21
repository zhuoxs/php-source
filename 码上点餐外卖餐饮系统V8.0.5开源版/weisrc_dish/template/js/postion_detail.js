$(function() {
    function distanceByLnglat(lng1, lat1, lng2, lat2) {
        var radLat1 = Rad(lat1);
        var radLat2 = Rad(lat2);
        var a = radLat1 - radLat2;
        var b = Rad(lng1) - Rad(lng2);
        var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) + Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)));
        s = s * 6378137.0;
        s = Math.round(s * 10000) / 10000000;
        s = s.toFixed(2);
        return s;
    }
    function Rad(d) {
        return d * Math.PI / 180.0
    };
    var point = new BMap.Point(116.331398, 39.897445);
    var geolocation = new BMap.Geolocation();
    if (document.location.href.indexOf("/shop/all/") == 0) {
        geolocation = null
    };
    geolocation.getCurrentPosition(function(r) {
        var _this = this;
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            var mk = new BMap.Marker(r.point);
            locLng = r.point.lng;
            locLat = r.point.lat;
            $(".morelist").each(function() {
                var ShopLngLat = $(this).find("#showlan").val();
                var InputOF = ShopLngLat.indexOf(",");
                var InputOFLast = ShopLngLat.length;
                var ShopLng = ShopLngLat.slice(0, InputOF);
                var ShopLat = ShopLngLat.slice(InputOF + 1, InputOFLast);
                var dis111 = distanceByLnglat(locLng, locLat, ShopLng, ShopLat);
                $(this).find("#shopspostion").html(dis111 + "km");
            });
            $("#curlat").val(locLat);
            $("#curlng").val(locLng);
        } else {
            $(".morelist").each(function() {
                $(this).find("#shopspostion").html("无法获取距离" + _this.getStatus() + "");
            });
        }
    }, {
        enableHighAccuracy: true
    });
    //关于状态码
    //BMAP_STATUS_SUCCESS	检索成功。对应数值“0”。
    //BMAP_STATUS_CITY_LIST	城市列表。对应数值“1”。
    //BMAP_STATUS_UNKNOWN_LOCATION	位置结果未知。对应数值“2”。
    //BMAP_STATUS_UNKNOWN_ROUTE	导航结果未知。对应数值“3”。
    //BMAP_STATUS_INVALID_KEY	非法密钥。对应数值“4”。
    //BMAP_STATUS_INVALID_REQUEST	非法请求。对应数值“5”。
    //BMAP_STATUS_PERMISSION_DENIED	没有权限。对应数值“6”。(自 1.1 新增)
    //BMAP_STATUS_SERVICE_UNAVAILABLE	服务不可用。对应数值“7”。(自 1.1 新增)
    //BMAP_STATUS_TIMEOUT	超时。对应数值“8”。(自 1.1 新增)
});

