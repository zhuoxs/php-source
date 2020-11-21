Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        articleData: {
            type: Array,
            value: []
        },
        text: {
            type: String,
            value: "ceece"
        },
        list: {
            type: Array,
            value: []
        },
        typeData: {
            type: Array,
            value: []
        }
    },
    data: {
        setData: wx.getStorageSync("kundian_farm_setData")
    },
    methods: {
        intoArticle: function(t) {
            wx.navigateTo({
                url: "/kundian_farm/pages/information/index/index"
            });
        }
    }
});