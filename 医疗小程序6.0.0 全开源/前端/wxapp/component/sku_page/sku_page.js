var app = getApp();

Component({
    properties: {
        myId: {
            type: String
        }
    },
    data: {
        keArr: [],
        commodity: []
    },
    methods: {
        setListData: function() {
            this.setData({
                keArr: app.globalData.skuList
            }), app.globalData.skuList = [];
        },
        detailClick: function(t) {
            console.log(t);
            var a = {
                id: t.detail.id,
                title: t.detail.title
            };
            this.triggerEvent("detailBtn", a);
        }
    },
    ready: function() {
        this.setListData();
    }
});