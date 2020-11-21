Component({
    properties: {
        info: {
            type: Object,
            value: {}
        }
    },
    data: {},
    methods: {
        gotoVideoDetail: function(t) {
            var e = t.currentTarget.dataset.id;
            wx.navigateTo({
                url: "/kundian_farm/pages/information/article/index?aid=" + e
            });
        }
    }
});