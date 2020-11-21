let _that;
let _userModel; 
let _util;
function getVoucher(that, userModel, util, e) {
    _that = that;
    _userModel = userModel; 
    _util = util;
    console.log(e,"getPhoneNumber  eeee  ")
    if (e.detail.errMsg == 'getPhoneNumber:ok') {
        console.log("同意授权获取电话号码")
        var encryptedData = e.detail.encryptedData;
        var iv = e.detail.iv;
        console.log(encryptedData, iv)
        that.setPhoneInfo(encryptedData, iv);
    } else if (e.detail.errMsg == 'getPhoneNumber:fail user deny') {
        console.log("拒绝授权获取电话号码")
    }
}
function setPhoneInfo(encryptedData, iv) {
    wx.login({
        success: function (res) {
            console.log('wx.login ==>>', res);
            let paramObj = {
                encryptedData: encryptedData,
                iv: iv,
                code: res.code,
                to_uid: _that.data.globalData.to_uid
            }
            _userModel.getPhone(paramObj).then((d) => {
                util.hideAll();
                app.globalData.hasClientPhone = true; 
                _that.setData({
                    'globalData.hasClientPhone': true,
                },function(){
                    let paramObj = {
                        to_uid: _that.data.paramData.to_uid,
                        coupon_id: _that.data.cardIndexData.coupon.id,
                    } 
                    _userModel.getCoupon(paramObj).then((d) => {
                    _util.hideAll(); 
                    _that.setData({
                        'voucherStatus.status': 'receive'
                    }) 
                    })
                })
            })
        },
        fail: function (res) {
            console.log("fail ==> ", res)
        }
    })
} 
function toGetCoupon(that, userModel, util) {
    _that = that;
    _userModel = userModel;
    _util = util;
    let paramObj = {
        to_uid: _that.data.paramData.to_uid,
        coupon_id: _that.data.cardIndexData.coupon.id,
    } 
    _userModel.getCoupon(paramObj).then((d) => {
      _util.hideAll();  
      _that.setData({
        'voucherStatus.status': 'receive'
      }) 
    })
}
function toBigVoucher(that) {
    _that = that; 
    _that.setData({
        'voucherStatus.show': true
    }) 
} 
function toCloseVoucher(that) {
    _that = that;  
    _that.setData({
        'voucherStatus.show': false
    }) 
}

module.exports = {
    getVoucher: getVoucher,
    toGetCoupon: toGetCoupon,
    toBigVoucher: toBigVoucher, 
    toCloseVoucher: toCloseVoucher
};


