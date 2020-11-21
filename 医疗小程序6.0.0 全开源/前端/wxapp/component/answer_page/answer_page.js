var app = getApp();

Component({
    properties: {
        myId: {
            type: String
        }
    },
    data: {
        answerArr: []
    },
    methods: {
        setListData: function() {
            this.setData({
                answerArr: app.globalData.answer
            }), app.globalData.answer = [];
        },
        answerDetail: function(t) {
            var a = {
                id: t.detail.id,
                title: t.detail.title
            };
            this.triggerEvent("answerDetail", a);
        }
    },
    ready: function() {
        this.setListData();
    }
});