Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        searchColor: {
            type: String,
            value: "#fff"
        },
        bgColor: {
            type: String,
            value: "#fff"
        },
        fontColor: {
            type: String,
            value: "#000"
        },
        hotSearch: {
            type: String,
            value: "111,222,333"
        },
        mtb: {
            type: Number,
            value: 0
        },
        mlr: {
            type: Number,
            value: 0
        },
        radius: {
            type: Number,
            value: 0
        }
    },
    methods: {
        selectGoods: function(e) {
            wx.navigateTo({
                url: "/kundian_farm/pages/shop/search/index"
            });
        }
    }
});