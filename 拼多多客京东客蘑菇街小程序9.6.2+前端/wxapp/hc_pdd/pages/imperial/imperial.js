Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        title: {
            type: String,
            value: "标题"
        },
        backgroundColor: {
            type: String,
            value: "#000"
        }
    },
    data: {
        listNone: !0
    },
    methods: {
        hideDialog: function() {
            this.setData({
                listNone: !this.data.listNone
            });
        },
        fanhui: function() {
            wx.navigateBack({
                delta: 1
            });
        },
        showDialog: function() {
            this.setData({
                listNone: !this.data.listNone
            });
        },
        listdisappear: function() {
            this.triggerEvent("listdisappear"), this.hideDialog();
        }
    }
});