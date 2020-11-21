Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        fontColor: {
            type: String,
            value: "#333333"
        },
        priceColor: {
            type: String,
            value: "#333333"
        },
        btnColor: {
            type: String,
            value: "#333333"
        },
        selectType: {
            type: Number,
            value: 1
        },
        selectGroup: {
            type: Number,
            value: 1
        },
        limitNum: {
            type: Number,
            value: 2
        },
        lists: {
            type: Array,
            value: []
        },
        newList: {
            type: Array,
            value: []
        },
        listType: {
            type: Number,
            value: 1
        }
    },
    data: {},
    methods: {
        intoGoodsDetail: function(e) {
            var t = e.currentTarget.dataset.goodsid;
            wx.navigateTo({
                url: "/kundian_farm/pages/shop/prodeteils/index?goodsid=" + t
            });
        }
    }
});