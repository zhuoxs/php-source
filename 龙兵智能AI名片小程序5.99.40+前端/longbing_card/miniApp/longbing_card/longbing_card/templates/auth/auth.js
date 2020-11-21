let _that;
let _baseModel;
let _util;
function checkAuth(that,baseModel,util) {
  _that = that;
  _baseModel = baseModel;
  _util = util;
  // console.log("checkAuth that  ==> wx.getSetting ")
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        console.log("有res.authSetting['scope.userInfo']")
        _that.setData({
          authStatus: true
        })
        wx.getUserInfo({
          lang:'zh_CN',
          success: function(res) { 
            console.log('获取微信用户信息 ==>>', res.userInfo);
            getChangeUserInfo(res.userInfo);  
          }
        })
      } else {
        console.log("没有res.authSetting['scope.userInfo']")
        _that.setData({
          authStatus: false
        })
      }
    },
    fail: function (res) {
      console.log("wx.getSetting ==>> fail")
      _that.setData({
        authStatus: false
      })
    }
  });
}


function getUserInfo(e) { 
  if (e.detail.userInfo) {
    let userInfo = e.detail.userInfo;
    console.log('获取微信用户信息 ==>>', userInfo);
    getChangeUserInfo(userInfo);
    _that.setData({
      authStatus: true
    })
  } else {
    console.log("拒绝授权")
    _that.setData({
      authStatus: false
    }) 

  }
}

function getChangeUserInfo(userInfo) {
  let paramObj =  userInfo
  _baseModel.getUpdateUserInfo(paramObj).then((d) => {
    _util.hideAll();
  }) 
}

module.exports = {
  checkAuth: checkAuth,
  getUserInfo: getUserInfo
};


