var distribution = {
    distribution_parsent: function(i, t) {
        if (0 < t) {
            var n = wx.getStorageSync("openid");
            i.util.request({
                url: "entry/wxapp/DistributionParsent",
                data: {
                    openid: n,
                    uid: t,
                    m: i.globalData.Plugin_distribution
                },
                showLoading: !1,
                success: function(i) {}
            });
        }
    }
};

module.exports = distribution;