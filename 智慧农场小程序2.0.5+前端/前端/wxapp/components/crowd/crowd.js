Component({
    properties: {
        lists: {
            type: Array,
            value: []
        },
        types: {
            type: Number,
            value: 1
        }
    },
    data: {},
    methods: {
        intoFundingDetail: function(e) {
            var t = e.currentTarget.dataset.projectid;
            wx.navigateTo({
                url: "/kundian_funding/pages/prodetail/index?pid=" + t
            });
        }
    }
});