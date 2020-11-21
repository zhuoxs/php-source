Component({
    properties: {
        interval: {
            type: Number,
            value: 300
        },
        timeout: {
            type: Number,
            value: 2e3
        },
        bubble: {
            type: Boolean,
            value: !0
        }
    },
    data: {
        clickFun: null
    },
    methods: {
        click: function() {
            var e, l, u, a, n, i = this;
            if (!i.data.clickFun) {
                i.setData({
                    clickFun: (e = function(t) {
                        console.log(i.data.bubble);
                        var e = {
                            bubbles: i.data.bubble
                        };
                        i.triggerEvent("click", {}, e);
                    }, l = i.data.interval, u = i.data.timeout, a = null, n = null, function() {
                        var t = arguments;
                        a ? clearTimeout(a) : e.apply(this, t), n || (a = setTimeout(function() {
                            n = setTimeout(function() {
                                n = a = null, i.setData({
                                    clickFun: null
                                });
                            }, u);
                        }, l));
                    })
                });
            }
            i.data.clickFun();
        }
    }
});