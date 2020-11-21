var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var n = arguments[t];
        for (var s in n) Object.prototype.hasOwnProperty.call(n, s) && (e[s] = n[s]);
    }
    return e;
}, DEFAULT_DATA = {
    show: !1,
    message: "",
    icon: "",
    image: "",
    mask: !1
}, SUPPORT_TYPE = [ "loading", "success", "fail" ];

Component({
    data: _extends({}, DEFAULT_DATA),
    methods: {
        show: function(e) {
            var t = _extends({}, e), n = e.icon || "", s = e.image || "";
            -1 < SUPPORT_TYPE.indexOf(e.type) && (n = e.type, s = ""), this.setData(_extends({}, t, {
                icon: n,
                image: s
            }));
        },
        clear: function() {
            this.setData(_extends({}, DEFAULT_DATA));
        }
    }
});