
var util = require('longbing_card/resource/js/util.js'); 
var appUniacid = require('siteinfo.js');
import { baseModel  } from 'longbing_card/resource/apis/index.js';
App({
    onLaunch: function (res) {
        var that = this;
        console.log('版本：2018年11月13日16:00',appUniacid.uniacid);
        // wx.clearStorage();
        
        // var sync_userid = wx.getStorageSync("userid");
        // var sync_user = wx.getStorageSync("user");
        wx.clearStorageSync();
        // wx.setStorageSync("userid", sync_userid);
        // wx.setStorageSync("user", sync_user); 
        //By.jingshuixian   初始化  webSocket Url
        var url = that.siteInfo.siteroot;
        url = util.getHostname(url);
        that.globalData.noticeUrl =  url;
        that.globalData.wssUrl = 'wss://' + url + '/wss';
        that.globalData.wssUrl2 = 'wss://'+ url +'/socket.io/'; 
        that.globalData.bossUrl = 'https://'+ url +'/addons/longbing_card/dist?uniacid='+ appUniacid.uniacid +'&id=';
        // console.log(globalData,"******//////////")
        // that.getConfigInfo();
    },
    onShow: function (res) {
        var that = this;
        wx.getSystemInfo({
            success: res => {
                // console.log('手机信息res' + res.model)
                let modelmes = res.model;
                if (modelmes.search('iPhone X') != -1) {
                    that.globalData.isIphoneX = true
                }
            }
        })
        // console.log(res, res.scene, "app onShow res*******************////////////")

        // is_qr是否是扫名片码进来的 1=>是, 0=>不是
        // is_group是否是群分_享进来的 1=>是, 0=>不是
        // type通过什么内容进来的1=>自定义码, 2=>产品, 3=>动态
        // target_id自定义码, 产品, 动态的 id没有则为0

        
        if (res.query.to_uid) {
            that.globalData.to_uid = res.query.to_uid;
        }
        if (res.query.from_id) {
            that.globalData.loginParam.is_qr = 0;
            that.globalData.from_id = res.query.from_id;
        }
        if (res.scene) {
            let tmp_is_group = 0;
            if (res.scene == 1044) {
                tmp_is_group = 1;
            } 
            that.globalData.loginParam.scene = res.scene;
            that.globalData.loginParam.is_group = tmp_is_group; 
        }

        if (res.query.is_qr) {
            that.globalData.loginParam.is_qr = res.query.is_qr;
            if (!res.query.from_id && res.query.to_uid) { 
                that.globalData.from_id = res.query.to_uid;
            }
        }

        if (res.query.custom) {
            that.globalData.loginParam.type = 1;
            that.globalData.loginParam.target_id = res.query.custom;
        }

        if (res.query.type) {
            that.globalData.loginParam.type = res.query.type;
            let tmp_target_id = 0;
            if (res.query.id) {
                tmp_target_id = res.query.id;
            } 
            that.globalData.loginParam.target_id = tmp_target_id;
        }
        var timerRead;

        // var timer;
        if (res.scene == 1044) {
            wx.getShareInfo({
                shareTicket: res.shareTicket,
                complete(res) {
                    console.log(res, "onLaunch ========= getShareInfo res")
                    that.globalData.encryptedData = res.encryptedData;
                    that.globalData.iv = res.iv;
                    that.getToLogin();
                }
            }) 
        } else {
            let from_id = that.globalData.from_id;
            if(from_id){
                that.getToLogin();
            }
        } 
        timerRead = setInterval(function(){
            let paramObj = {
                to_uid: that.globalData.to_uid,
            } 
            baseModel.getClientUnread(paramObj).then((d) => { 
                let {staff_count,user_count} = d.data.count;
                if(staff_count){
                    that.globalData.badgeNum = staff_count;
                    that._createBadgeTimer();
                }
                if(user_count){
                    if (that.globalData.clientUnread < user_count) {
                        that.globalData.clientUnreadImg =  true; 
                        setTimeout(function () { 
                            that.globalData.clientUnreadImg = false;
                        }, 5000)
                    }
                    that.globalData.clientUnread = user_count;
                } 
            })
        },10000)
    },
    onHide: function () {
    },
    onError: function (msg) {
        console.log(msg)
    },
    _clearBadgeTimer: function() {
        var that = this;
        if (that.globalData._setTabBarBadgeTimer) {
            clearInterval(that.globalData._setTabBarBadgeTimer);
            that.globalData._setTabBarBadgeTimer = null;
        }
    },
    _createBadgeTimer: function() {
        var that = this;
        if (that.globalData._setTabBarBadgeTimer) {
            return;
        } else {
            that.globalData._setTabBarBadgeTimer = setInterval(function() { 
                that.setMsgBadge(that.globalData.badgeNum);
            }, 300);
        }
    },
    // 设置TabBar消息数量
    setMsgBadge: function(num) {
        var that = this; 
        if (num == 0) {
            wx.removeTabBarBadge({
                index: 1,
                success: function() { 
                    that._clearBadgeTimer();
                },
                fail: function() {
                    // console.log('wx.removeTabBarBadge    fail');
                    that._createBadgeTimer();
                },
            });
            return;
        }
        wx.setTabBarBadge({
            index: 1,
            text: String(num),
            success: function() { 
                that._clearBadgeTimer();
            },
            fail: function() {  
                // console.log('wx.setTabBarBadge fail');
                that._createBadgeTimer();
            },
        });
    },
    //获取全局配置信息
    getConfigInfo: function (refrensh = false, isTabBar = false) {
        let that = this;
        let configInfo = that.globalData.configInfo;
        return new Promise((resove, reject) => {
        if (configInfo && !refrensh) {
            let allConfigInfo = Object.assign({}, configInfo)
            resove(allConfigInfo) 
        } else { 
            baseModel.getConfigV2().then((d) => {
            let configInfo = d.data;
            let { my_company, tabBar} = configInfo;
            if(my_company){ 
                if (my_company.addr.length > 23) {
                    my_company.addrMore = my_company.addr.slice(0, 23) +'...';
                } 
            }
            if(isTabBar == true){
                // 跳转方式0=>跳转外部链接1=>小程序appid 
                console.log("跳转方式0=>跳转外部链接1=>小程序appid",isTabBar)
                let tmpTabList = that.globalData.tabBarList;
                for (let i in tabBar.menu_name) {
                    if (tabBar.menu_url_out[i]) {
                        if (tabBar.menu_url_jump_way[i] == 0) {
                        tmpTabList[i].jump = 'toOutUrl';
                        }
                        if (tabBar.menu_url_jump_way[i] == 1) {
                        tmpTabList[i].jump = 'toMiniApp';
                        tmpTabList[i].toMiniApp = tabBar.menu_url_out[i].split('；'); 
                        }
                    }
                    if (tabBar.menu_is_hide[i] == 1) {
                        tmpTabList[i].showTab = 1;
                    }  
                    tmpTabList[i].text = tabBar.menu_name[i];
                    if (tabBar.menu_url[i].indexOf('currentTabBar=') > -1) {
                        tmpTabList[i].type = tabBar.menu_url[i].split('currentTabBar=')[1];
                    }
                    tmpTabList[i].url = tabBar.menu_url[i];
                    if (tabBar.menu_url_out[i]) {
                        tmpTabList[i].url = tabBar.menu_url_out[i];
                    }
                }
                that.globalData.tabBarList = tmpTabList;
            }
            //赋值全局配置变量
            that.globalData.configInfo = configInfo;
            let allConfigInfo = Object.assign({}, configInfo)
            resove(allConfigInfo) 
            }) 
        }
        }).then((allConfigInfo) => {
        //设置全局tabbar
        //util.setTabbar(configInfo.tabbar)
        return allConfigInfo
        })
    },
    getToLogin:function(){
        let that = this;
        wx.login({
            success: function (res) {
                console.log('来自分享 传入from_id   wx.login ==>>', res);
                let {scene,is_qr,is_group,type,target_id} = that.globalData.loginParam;
                let {encryptedData, iv, from_id} = that.globalData; 
                let paramObj = {
                    code: res.code,
                    scene: scene,
                    is_qr: is_qr,
                    is_group: is_group,
                    type: type,
                    target_id: target_id,
                    encryptedData: encryptedData,
                    iv: iv,
                    from_id: from_id
                }
                wx.setStorageSync("loginParamObj",paramObj)
                baseModel.getLogin(paramObj).then((d) => {
                    let {userid, user} = d.data;
                    that.globalData.userid = userid;
                    wx.setStorageSync('userid', userid);
                    if(user){
                        that.globalData.openGId_2 = user.openGId_2;
                        if(user.phone){
                            that.globalData.hasClientPhone = true
                        }
                        wx.setStorageSync("user",user);
                    } 
                })
            }
        })
    },
    //加载微擎工具类
    util: util,
    //导航菜单，微擎将会自己实现一个导航菜单，结构与小程序导航菜单相同
    //用户信息，sessionid是用户是否登录的凭证
    userInfo: {
        sessionid: null,
    },
    siteInfo: require('siteinfo.js'),
    // {
    //     "pagePath": "longbing_card/staff/spread/spread",
    //     "iconPath": "longbing_card/resource/icon/icon-spread.png",
    //     "selectedIconPath": "longbing_card/resource/icon/icon-spread-cur.png",
    //     "text": "推广"
    // },
    globalData: {
        isIphoneX: false,
        userid : '',
        openGId_2 : '',
        to_uid: 0,
        from_id: 0,
        nickName: '',
        avatarUrl: '',
        encryptedData: false,
        iv: false,
        isStaff: false,
        isBoss: false,
        userIsStaff: false,
        hasClientPhone: false, 
        configInfo:false, 
        checkvoucher: false,
        voucherStatus:{
            tag: 'big',
            status: 'unreceive'
        }, 
        chooseStaffInfo: {
            avatar:'',
            avatarImg:'',
        },
        loginParam: {
            scene: '',
            is_qr: '',
            is_group: '',
            type: '',
            target_id: '',
        },
        wssUrl: '',//webSocket url地址 By.jingshuixian
        bossUrl: '',
        noticeUrl: '',
        _setTabBarBadgeTimer: null,
        badgeNum: 0,
        clientUnread: 1,
        chatImg: 'http://retail.xiaochengxucms.com/images/12/2018/09/uEunvCzB16TY1gmTEtDDiEZ6YdU7Zu.png',
<<<<<<< HEAD
        defaultUserImg: 'http://retail.xiaochengxucms.com/images/12/2018/09/dJJl8rANdVklRvo2RRDl8dMJnmlNlD.png',
=======
        logoImg: 'http://retail.xiaochengxucms.com/images/12/2018/11/crDXyl3TyBRLUBch6ToqXL6e9D96hY.jpg',
        startMarkImg: 'http://retail.xiaochengxucms.com/images/12/2018/11/a2fPOjVpczPC8v8Xn8228e8y288x22.png',
        defaultUserImg: 'http://retail.xiaochengxucms.com/images/12/2018/11/fDK7kkrmkMReK50l4r1Le740Kmra85.jpg',
>>>>>>> f760bdd28ff92263964b9b2b10b51530791a923b
        noUserImg: 'http://retail.xiaochengxucms.com/images/12/2018/09/jyJlH5ax28TztQAQ2Jh8tIkXLhBQyK.png',
        moreImgs: 'http://retail.xiaochengxucms.com/images/12/2018/09/jeVh5RF0dfndncFeZzmhzeW511V4Rm.png',
        ingImg: 'http://retail.xiaochengxucms.com/images/12/2018/09/hnqwnkQsV4lNx2vIyCA3lxF3LTfGqv.png',
        bossImg: 'http://retail.xiaochengxucms.com/images/12/2018/09/KYdftdZuDYh2TF9pQnJ0uT9tgNt2q2.png',
        playVideoImg: 'http://retail.xiaochengxucms.com/images/12/2018/10/T8A1maB3boAB3A8Sb8yTYBs1b0BmaA.png',
        companyVideoImg: 'http://retail.xiaochengxucms.com/images/12/2018/10/vmKklLlnkMRCRBFuZDMEkEcfu4fEKr.png',
        cardVideoImg: 'http://retail.xiaochengxucms.com/images/12/2018/10/Ik4kmm8i4a8Qb5383a699m6p3g3g6q.png',
        tabBarList: [
            {
                "iconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/avmtXpnmpxxPBoKrOPToRKTQk8BOvz.png",
                "selectedIconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/Da2xhKU0XSKpAH5jr73ajjDa545uJ5.png",
                "url":'',
                "showTab":0,
                "jump": "toPageUrl",
                "type": "toCard",
                "text": "名片"
            },
            {
                "iconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/uzTgllPit2lPGGWWWoL2LT66PWtklA.png",
                "selectedIconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/NW2qZvQprPTj1WR9W343pZ91qDRQkk.png",
                "url":'',
                "showTab":0,
                "type": "toShop",
                "jump": "toPageUrl",
                "text": "商城"
            },
            {
                "iconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/ubgV0BZ1tNzegWKvK6bWKX1kBbXBWS.png",
                "selectedIconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/OdddjR5PKZURjdbdGNeEPpNURtEdJ4.png",
                "url":'',
                "showTab":0,
                "type": "toNews",
                "jump": "toPageUrl",
                "text": "动态"
            },
            {
                "iconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/GXaiUxrwJnYJKkiNsI7zu6URwIKEAN.png",
                "selectedIconPath": "http://retail.xiaochengxucms.com/images/12/2018/11/dB2jkzIzmYzRCE2s2ZqISrHbEk15xI.png",
                "url":'',
                "showTab":0,
                "type": "toCompany",
                "jump": "toPageUrl",
                "text": "官网"
            }
        ]
    }
});