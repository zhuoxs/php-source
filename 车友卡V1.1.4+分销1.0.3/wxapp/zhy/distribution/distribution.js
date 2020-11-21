var distribution = {
    distribution_parsent: function(t, n) {
        0 < n && t.get_openid().then(function(i) {
            t.util.request({
                url: "entry/wxapp/DistributionParsent",
                data: {
                    openid: i,
                    uid: n,
                    m: t.globalData.Plugin_distribution
                },
                showLoading: !1,
                success: function(i) {}
            });
        });
    }
};

module.exports = distribution;