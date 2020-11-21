define(['core', 'tpl'], function(core, tpl) {
    var modal = {
        params: {}
    };
    modal.init = function(params) {
        if ($('#nearStore').length > 0) {
            var arr = [];
            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r) {
                var _this = this;
                if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                    var lat = r.point.lat,
                        lng = r.point.lng;
                    $('.store-item').each(function() {
                        var location = $(this).find('.location');
                        var store_lng = $(this).data('lng'),
                            store_lat = $(this).data('lat');
                        if (store_lng > 0 && store_lat > 0) {
                            var distance = core.getDistanceByLnglat(lng, lat, store_lng, store_lat);
                            $(this).data('distance', distance);
                            location.html('距离您: ' + distance.toFixed(2) + "km").show()
                        } else {
                            $(this).data('distance', 999999999999999999);
                            location.html('无法获得距离').show()
                        }
                        arr.push($(this))
                    });
                    arr.sort(function(a, b) {
                        return a.data('distance') - b.data('distance')
                    });
                    $.each(arr, function() {
                        $('.store-container').append(this)
                    });
                    $('#nearStore').show();
                    $('#nearStoreHtml').append($(arr[0]).html());
                    var location = $('#nearStoreHtml').find('.location').html();
                    $('#nearStoreHtml').find('.location').html(location + "<span class='fui-label fui-label-danger'>最近</span> ");
                    $(arr[0]).remove()
                }
            }, {
                enableHighAccuracy: true
            })
        }
    };
    return modal
});