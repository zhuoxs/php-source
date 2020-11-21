var e = getApp().requirejs("core");

module.exports.getAreas = function(r) {
    e.get("shop/get_areas", {}, function(e) {
        var a = [];
        for (var t in e.areas.province) if (0 != t) {
            e.areas.province[t]["@attributes"].name;
            var i = [];
            for (var n in e.areas.province[t].city) if (0 != n) {
                var c = [];
                e.areas.province[t].city[n].name;
                for (var o in e.areas.province[t].city[n].county) {
                    if (e.areas.province[t].city[n].county[o].hasOwnProperty("@attributes")) s = e.areas.province[t].city[n].county[o]["@attributes"].name; else var s = e.areas.province[t].city[n].county[o].name;
                    c.push(s);
                }
                i.push({
                    city_name: c
                });
            }
            a.push({
                province_name: i
            });
        }
        "function" == typeof r && r(e.areas);
    });
};