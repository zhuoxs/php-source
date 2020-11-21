var t = require("../../../../utils/base.js"), a = require("../../../../../api.js"), e = new t.Base();

Page({
    data: {
        swith: 0
    },
    onLoad: function(t) {
        this.getTeam();
    },
    swith: function(t) {
        var a = t.currentTarget.dataset.swith, e = [];
        this.setData({
            swith: a
        }), e = 0 == a ? this.data.teamData.first : 1 == a ? this.data.teamData.second : this.data.teamData.third, 
        this.setData({
            team: e
        });
    },
    getTeam: function(t) {
        var s = this, i = {
            url: a.default.share_team,
            method: "GET"
        };
        e.getData(i, function(t) {
            console.log(t), 1 == t.errorCode && s.setData({
                teamData: t.data,
                team: t.data.first
            });
        });
    }
});