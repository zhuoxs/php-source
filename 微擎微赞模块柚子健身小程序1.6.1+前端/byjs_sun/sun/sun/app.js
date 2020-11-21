//app.js
var app = getApp();

App({
   

    onLaunch: function () {
        //调用API从本地缓存中获取数据
      // this.getUserInfo();
   
    },
   
    
    onShow: function () {
      
     

    },
    // getUserInfo: function () {
    //   wx.login({
    //     success: function () {
    //       wx.getUserInfo({
    //         success: function (res) {
    //           console.log(res)
              
    //         }
    //       })
    //     }
    //   })
    // },

    onHide: function () {
    },
    onError: function (msg) {
        // console.log(msg)
    },
    /*
    tabBar: {
        "color": "#123",
        "selectedColor": "#1ba9ba",
        "borderStyle": "#1ba9ba",
        "backgroundColor": "#fff",
        "list": [
            {
                "pagePath": "/hssd_sun/pages/first/index",
                "iconPath": "/hssd_sun/resource/icon/home.png",
                "selectedIconPath": "/hssd_sun/resource/icon/homeselect.png",
                "text": "首页"
            },
            {
                "pagePath": "/hssd_sun/pages/todo/todo",
                "iconPath": "/hssd_sun/resource/icon/todo.png",
                "selectedIconPath": "/hssd_sun/resource/icon/todoselect.png",
                "text": "ToDo"
            },
            {
                "pagePath": "/hssd_sun/pages/pay/pay",
                "iconPath": "/hssd_sun/resource/icon/user.png",
                "selectedIconPath": "/hssd_sun/resource/icon/userselect.png",
                "text": "支付"
            },
            {
                "pagePath": "/rcdonkey_signup/pages/publish/publish",
                "iconPath": "/hssd_sun/resource/icon/user.png",
                "selectedIconPath": "/hssd_sun/resource/icon/userselect.png",
                "text": "报名"
            }
        ]
    },
    */
    globalData: {
        userInfo: null,
        refresh:true
        
    },
    siteInfo:require('siteinfo.js'),
    util: require('/we7/js/util.js'),
});