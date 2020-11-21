Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.transition = function(t) {
    return Behavior({
        properties: {
            customStyle: String,
            show: {
                type: Boolean,
                value: t,
                observer: "observeShow"
            },
            duration: {
                type: Number,
                value: 300
            }
        },
        data: {
            type: "",
            inited: !1,
            display: !1,
            supportAnimation: !0
        },
        attached: function() {
            this.data.show && this.show(), this.detectSupport();
        },
        methods: {
            detectSupport: function() {
                var t = this;
                wx.getSystemInfo({
                    success: function(e) {
                        e && e.system && 0 === e.system.indexOf("iOS 8") && t.set({
                            supportAnimation: !1
                        });
                    }
                });
            },
            observeShow: function(t) {
                t ? this.show() : this.data.supportAnimation ? this.set({
                    type: "leave"
                }) : this.set({
                    display: !1
                });
            },
            show: function() {
                this.set({
                    inited: !0,
                    display: !0,
                    type: "enter"
                });
            },
            onAnimationEnd: function() {
                this.data.show || this.set({
                    display: !1
                });
            }
        }
    });
};