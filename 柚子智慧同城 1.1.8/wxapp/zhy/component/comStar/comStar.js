Component({
    properties: {
        imgh: {
            type: String,
            value: "",
            observer: function(e, t, n) {}
        },
        img: {
            type: String,
            value: "",
            observer: function(e, t, n) {}
        },
        width: {
            type: Number,
            value: 30,
            observer: function(e, t, n) {}
        },
        num: {
            type: Number,
            value: 5,
            observer: function(e, t, n) {}
        },
        change: {
            type: Boolean,
            value: !1,
            observer: function(e, t, n) {}
        }
    },
    methods: {
        _onChangeTab: function(e) {
            if (this.data.change) {
                var t = e.currentTarget.dataset.idx;
                this.setData({
                    num: t
                }), this.triggerEvent("watch", t);
            }
        }
    }
});