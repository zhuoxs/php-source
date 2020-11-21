var app = getApp();

Component({
    properties: {
        modalHidden: {
            type: Boolean,
            value: !0
        },
        modalMsg: {
            type: String,
            value: "获取你的公开信息(昵称、头像等)"
        }
    },
    data: {
        modalMsg: "获取你的公开信息(昵称、头像等)",
        isLogin: !0
    },
    methods: {
        isLogin: function(t) {
            this.data.isLogin;
            this.setData({
                isLogin: !1
            });
        },
        getUserInfo: function() {
            this.triggerEvent("togetuserinfo", {});
        }
    }
});