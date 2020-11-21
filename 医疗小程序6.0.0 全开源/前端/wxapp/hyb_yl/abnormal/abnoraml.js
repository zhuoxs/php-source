var app = getApp();

Component({
    properties: {},
    data: {
        abnormal: {}
    },
    methods: {
        setListData: function() {
            var a = app.globalData.abnormal;
            this.setData({
                abnormal: a
            }), app.globalData.abnormal = [];
        },
        drugsDetailClick: function(a) {
            console.log(a);
            var t = {
                index: a.currentTarget.dataset.index
            };
            this.triggerEvent("drugsDetail", t);
        }
    },
    ready: function() {
        this.setListData();
    }
});