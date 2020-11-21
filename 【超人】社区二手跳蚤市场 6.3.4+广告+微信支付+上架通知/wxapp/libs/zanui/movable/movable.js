var _wx$getSystemInfoSync = wx.getSystemInfoSync(), windowWidth = _wx$getSystemInfoSync.windowWidth, windowHeight = _wx$getSystemInfoSync.windowHeight;

Component({
    properties: {
        x: {
            type: Number,
            value: 40
        },
        y: {
            type: Number,
            value: windowHeight - 200
        },
        post_img: {
            type: String
        },
        post_appid: {
            type: String
        },
        post_url: {
            type: String
        }
    },
    methods: {
        jumpToPage: function(t) {
            var e = t.currentTarget.dataset.url;
            -1 != e.indexOf("http") ? wx.navigateTo({
                url: "../ad/index?path=" + encodeURIComponent(e)
            }) : wx.navigateTo({
                url: e
            });
        }
    }
});