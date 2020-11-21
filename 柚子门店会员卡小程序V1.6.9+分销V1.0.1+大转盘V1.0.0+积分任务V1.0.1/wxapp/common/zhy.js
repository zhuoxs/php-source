var storage = {
    set: function(e, t, r) {
        if (r < 0) wx.removeStorageSync(e); else {
            var a = r ? new Date().getTime() + 1e3 * r : null;
            wx.setStorageSync(e, {
                expire: a,
                data: t
            });
        }
    },
    get: function(e) {
        var t = wx.getStorageSync(e);
        return null != t.expire && t.expire < new Date().getTime() ? (wx.removeStorageSync(e), 
        null) : t.data;
    },
    remove: function(e) {
        wx.removeStorageSync(e);
    }
};

module.exports = {
    storage: storage
};