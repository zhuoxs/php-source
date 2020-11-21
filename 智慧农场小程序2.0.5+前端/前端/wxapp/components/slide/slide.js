Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        imgUrl: {
            type: Array,
            value: []
        },
        focus: {
            type: Boolean,
            value: !1
        },
        focusColor: {
            type: String,
            value: "#000"
        },
        swiperHeight: {
            type: Number,
            value: 250
        }
    },
    data: {
        currentIndex: 0
    },
    methods: {
        changeCurrent: function(e) {
            var t = e.detail.current;
            this.setData({
                currentIndex: t
            });
        },
        intoDetailSlide: function(e) {
            var t = e.currentTarget.dataset.linktype, r = e.currentTarget.dataset.linkparam;
            0 == r || "" == r ? wx.navigateTo({
                url: "/" + t
            }) : wx.navigateTo({
                url: "/" + r
            });
        }
    }
});