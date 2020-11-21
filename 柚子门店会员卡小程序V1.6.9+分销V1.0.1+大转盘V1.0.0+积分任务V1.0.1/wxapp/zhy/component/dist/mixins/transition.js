Object.defineProperty(exports, "__esModule", {
    value: !0
});

var transition = exports.transition = function(t) {
    return Behavior({
        properties: {
            customStyle: String,
            show: {
                value: t,
                type: Boolean,
                observer: function(t) {
                    t ? this.show() : this.setData({
                        type: "leave"
                    });
                }
            },
            duration: {
                type: Number,
                value: 300
            }
        },
        data: {
            type: "",
            inited: !1,
            display: !1
        },
        attached: function() {
            this.data.show && this.show();
        },
        methods: {
            show: function() {
                this.setData({
                    inited: !0,
                    display: !0,
                    type: "enter"
                });
            },
            onAnimationEnd: function() {
                this.data.show || this.setData({
                    display: !1
                });
            }
        }
    });
};