var DEFAULT_DATA = {
    show: !1,
    message: "",
    icon: "",
    image: "",
    mask: !1
}, SUPPORT_TYPE = [ "loading", "success", "fail" ];

Component({
    data: Object.assign({}, DEFAULT_DATA),
    methods: {
        show: function(s) {
            var a = Object.assign({}, s), e = s.icon || "", t = s.image || "";
            -1 < SUPPORT_TYPE.indexOf(s.type) && (e = s.type, t = ""), this.setData(Object.assign({}, a, {
                icon: e,
                image: t
            }));
        },
        clear: function() {
            this.setData(Object.assign({}, DEFAULT_DATA));
        }
    }
});