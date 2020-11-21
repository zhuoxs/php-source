/*   time:2019-08-09 13:18:38*/
var app = getApp(),
    data = {
        show: !1
    }, reload = {
        getImgRoot: function() {
            this.setData({
                show: !0
            })
        }
    };
module.exports = {
    data: data,
    reload: reload
};