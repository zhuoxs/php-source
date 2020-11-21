var app = getApp()
var chatInput = require('../../chat/chat-input/chat-input.js');
import util from '../../resource/js/xx_util.js';
import { userModel,baseModel } from '../../resource/apis/index.js'
var timer = 0; //重连定时器
var closeReconnect = false; //是否关闭断线重连
var lockReconnect = false; //断线检查状态
var sendGoodsId;
var ping_user_id;
var ping_chat_to_uid;
var beginTime = 0, endTime = 0;

let heartCheck = {
    timeout: 3000,
    timeoutObj: null,
    serverTimeoutObj: null,
    reset: function () {
        console.log('heartCheck.reset.timer', timer);
        clearTimeout(timer);
        clearTimeout(this.timeoutObj);
        clearTimeout(this.serverTimeoutObj);
        return this;
    },
    start: function () {
        this.timeoutObj = setTimeout(() => {
            console.log("发送ping");

            // if (sendGoodsId) {
            //     let tmpPingGoods = {
            //         goods_id: sendGoodsId,
            //         user_id: ping_user_id,
            //         target_id: ping_chat_to_uid,
            //         uniacid: app.siteInfo.uniacid
            //     }
            //     tmpPingGoods = JSON.stringify(tmpPingGoods);
            //     wx.sendSocketMessage({
            //         data: tmpPingGoods,
            //         success() {
            //             console.log("发送goods_id成功", tmpPingGoods);
            //             sendGoodsId = '';
            //         }
            //     });
            // }


            let tmpPing = {
                ping: true,
                user_id: ping_user_id,
                target_id: ping_chat_to_uid,
            }
            tmpPing = JSON.stringify(tmpPing);
            wx.sendSocketMessage({
                data: tmpPing,
                success() {
                    console.log("发送ping成功", tmpPing);
                }
            });
            /*
            this.serverTimeoutObj = setTimeout(() => {
                wx.closeSocket((res) => {
                    console.log('serverTimeoutObj 卸载创建 的  WebSocket')
                })
            }, this.timeout);
            */

            

        }, this.timeout);
    }
};

Page({

    /**
     * 页面的初始数据
     */
    data: {
        /*自己to_uid*/
        user_id: '',
        /*对方to_uid*/
        chat_to_uid: '',
        /*员工端会话chatid*/
        chatid: '',
        /*对方昵称*/
        contactUserName: '',
        /*自己头像*/
        chatAvatarUrl: '',
        /*对方头像*/
        toChatAvatarUrl: '',
        messageDate: '',
        chatInfo: {},
        messageList: [],
        //lockReconnect: false,   //断线检查状态
        limit: 0, //断线检查计数
        //closeReconnect: false,  //是否关闭断线重连
        staffDefaultData: {
            title: '',
            phone: '',
            wechat: '',
            info: [
                { img: '/longbing_card/resource/images/img/1.png', name: '进入我的名片' },
                { img: '/longbing_card/resource/images/img/2.png', name: '查看公司官网' },
                { img: '/longbing_card/resource/images/img/3.png', name: '查看公司商品' },
                { img: '/longbing_card/resource/images/img/4.png', name: '查看我的动态' },
            ],
        }
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        var that = this;
        console.log(options, "/////////////**99999999999999999999*********")


        var staffUrl = app.util.url('entry/wxapp/StaffCard');
        var nowPage = getCurrentPages();
        if (nowPage.length) {
            nowPage = nowPage[getCurrentPages().length - 1];
            if (nowPage && nowPage.__route__) {
                staffUrl = staffUrl + '&m=' + nowPage.__route__.split('/')[0];
            }
        }
        that.setData({
            staffUrl: staffUrl,
            user_id: wx.getStorageSync("userid")
        })


        console.log(options, "//////////////////////////****")

        if (options.is_tpl == 1) {
              let paramObj = {
                user_id: wx.getStorageSync("userid"),
                target_id: options.to_uid
              } 
              baseModel.getChatInfo(paramObj).then((d) => {
                console.log(d.data) 
                let {user_info,target_info,chat_id} = d.data;
                let {nickName,avatarUrl} = target_info;
                let userAvatarUrl = user_info.avatarUrl;
                that.setData({
                    is_tpl: 1,
                    user_id: wx.getStorageSync("userid"),
                    chat_to_uid: options.to_uid,
                    'chatInfo.chat_id': chat_id,
                    chatAvatarUrl: userAvatarUrl,
                    toChatAvatarUrl: avatarUrl,
                    contactUserName: nickName,
                    globalData: app.globalData
                },function(){
                    ping_user_id = wx.getStorageSync("userid");
                    ping_chat_to_uid = that.data.chat_to_uid;
                    that.initData();
                    that.getCardIndexData(); 
                    that.getChat();
                }) 
              })
        } else if (options.chat_to_uid) {
            that.setData({
                user_id: wx.getStorageSync("userid"),
                chat_to_uid: options.chat_to_uid,
                'chatInfo.chat_id': options.chatid,
                chatAvatarUrl: options.chatAvatarUrl,
                toChatAvatarUrl: options.toChatAvatarUrl,
                contactUserName: options.contactUserName,
                globalData: app.globalData
            },function(){
                ping_user_id = wx.getStorageSync("userid");
                ping_chat_to_uid = that.data.chat_to_uid;
                that.initData();
                that.getCardIndexData();
                that.getChat();
            }) 
        }
        wx.setNavigationBarTitle({
           title: that.data.contactUserName
        })
        // By.jingshuixian  可能引起  showModal:fail parameter error: parameter.content should be String instead of Number; 
 
        

        if (options.goods_id) {
            sendGoodsId = options.goods_id;
            console.log(options.goods_id, "options.goods_id*************//")
            var currPage = getCurrentPages(); 
            var prevPage = currPage[currPage.length - 2].__viewData__;
            console.log('prevPage',prevPage)

            let tmp_text_content = '您好，我想咨询下产品【' + prevPage.detailData.name + '】的相关信息。'; 
            let tmp_image_path =  prevPage.detailData.cover_true;
            let tmpGoodsData = {};
            let dataText = {
                user_id: that.data.user_id,
                target_id: that.data.chat_to_uid,
                content: tmp_text_content,
                type: 'text',
                uniacid: app.siteInfo.uniacid
            }
            let dataImg = {
                user_id: that.data.user_id,
                target_id: that.data.chat_to_uid,
                content: tmp_image_path,
                type: 'image',
                uniacid: app.siteInfo.uniacid
            }
            dataText = JSON.stringify(dataText);
            dataImg = JSON.stringify(dataImg);
            tmpGoodsData.text = dataText;
            tmpGoodsData.image = dataImg; 
            that.setData({
                tmpGoodsData
            })
        }


        var uploadUrl = app.util.url('entry/wxapp/upload');
        var nowPage = getCurrentPages();
        if (nowPage.length) {
            nowPage = nowPage[getCurrentPages().length - 1];
            if (nowPage && nowPage.__route__) {
                uploadUrl = uploadUrl + '&m=' + nowPage.__route__.split('/')[0];
            }
        }

        that.setData({
            uploadUrl: uploadUrl
        }) 

    },

    setLinkTitle(title = '') {
        var that = this;
        if (title != '') {
            title = title + '...'
            wx.showNavigationBarLoading()
        } else {
            title = that.data.contactUserName
            wx.hideNavigationBarLoading()
        }

        wx.setNavigationBarTitle({
            title: title
        })

    },

    /**
     * 连接WebSocket
     */
    linkSocket() {
        let that = this
        closeReconnect = false; //启动断线重连
        that.limit = 0;
        that.setLinkTitle('连接中')
        wx.connectSocket({
            url: app.globalData.wssUrl,
            success() {
                beginTime = new Date();
                console.log('连接成功')
                that.initEventHandle()
            }
        })
    },
    /**
     * 启动监听WebSocket
     */
    initEventHandle() {
        let that = this
        wx.onSocketMessage((res) => {
            that.setLinkTitle()
            //收到消息 
            if (res.data == "pong") {
                console.log('WebSocket连接正常....')
                // heartCheck.reset().start();
            } else {
                //处理数据
                console.log('收到服务器内容：', res)
                var resData = JSON.parse(res.data);
                console.log('收到服务器内容resData：', resData)
                console.log(that.data.chat_to_uid, that.data.user_id, 'chat_to_uid ==> user_id')
                if (resData.data != '') {
                    console.log("res.data不为空", resData.data)
                    let data = {};
                    if (resData.data2) {
                        if (resData.data2.user_id == that.data.chat_to_uid && resData.data2.target_id == that.data.user_id) {
                            let tmp_type2 = resData.data2.message_type;
                            if(!tmp_type2){
                              tmp_type2 = 'text';
                            }
                            data = {
                                user_id: that.data.chat_to_uid,
                                target_id: that.data.user_id, 
                                content: resData.data2.content,
                                // content: resData.data2.data,
                                type: tmp_type2,
                                uniacid: app.siteInfo.uniacid
                            }
                        }
                    } else {
                        let tmp_type1 = resData.type;
                        if(!tmp_type1){
                          tmp_type1 = 'text';
                        }
                        data = {
                            user_id: that.data.chat_to_uid,
                            target_id: that.data.user_id,
                            content: resData.data,
                            type: tmp_type1,
                            uniacid: app.siteInfo.uniacid
                        }
                    }


                    if (!data.content) {
                        console.log("不是当前聊天对象的数据,不添加到页面")
                    } else {
                        var tmpData = that.data.messageList;
                        var length = tmpData.length;
                        console.log(that.data.messageList, "that.data.messageList")


                        if (length > 0) {
                            tmpData[length - 1].list.push(data);
                        } else {
                            var date = new app.util.date();
                            var create_time = (date.dateToLong(new Date) / 1000).toFixed(0);
                            create_time = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(create_time * 1000));

                            console.log(create_time, "////***555")
                            tmpData.push({ create_time: create_time, list: [data] }); 
                        }
                        console.log("res.data不为空 messageList", that.data.messageList)
                        that.setData({
                            messageList: tmpData
                        }, function () {
                            that.pageScrollToBottom()
                        })
                    }

                }
            }
        })

        wx.onSocketOpen(() => {
            console.log('WebSocket连接打开')
            that.setLinkTitle();
            heartCheck.reset().start();
        })
        wx.onSocketError((res) => {
            console.log('WebSocket连接打开失败 closeReconnect')
            that.reconnect()
        })
        wx.onSocketClose((res) => {
            console.log('WebSocket 已关闭！ closeReconnect')
            that.reconnect()
        })
    },
    /**
     * 卸载创建的WebSocket
     */
    unloadWebSocket() {
        var that = this;
        console.log('开始卸载 WebSocket')
        closeReconnect = true; // 关闭断线重连
        lockReconnect = true;//
        heartCheck.reset();  //关闭心跳
        wx.closeSocket({
            success: function (res) {
                console.log('卸载创建 的  WebSocket 成功', res)
            },
            fail: function (res) {
                console.log('卸载创建 的  WebSocket 失败', res)
            }
        })
        heartCheck.reset();
    },
    /**
     * 断线重连
     */
    reconnect() {
        //取消断线重连
        var that = this;
        console.log('reconnect closeReconnect_1 lockReconnect', lockReconnect, closeReconnect, timer);
        if (closeReconnect) {
            clearTimeout(timer);
            closeReconnect = true;
            lockReconnect = false;
            return true;
        }
        console.log('reconnect closeReconnect_2 lockReconnect', lockReconnect, closeReconnect, timer);
        if (lockReconnect && closeReconnect) return;

        that.setLinkTitle('重连中')
        lockReconnect = true;
        that.getWebSocketErrorTime();
        clearTimeout(timer)
        if (this.data.limit < 12) {
            timer = setTimeout(() => {
                console.log('reconnect', 'this.linkSocket()');
                this.linkSocket();
                lockReconnect = false;
            }, 5000);
            this.setData({
                limit: this.data.limit + 1
            })
        } else {
            //当重新链接超过12次以后, 
            //提示客服重新链接 
            wx.navigateBack();
        }
    },

    onReady: function () {
        console.log("页面渲染完成")
    },
    onShow: function () {
        console.log("页面显示")
        //this.reconnect();
    },
    onHide: function () {
        console.log("页面隐藏")
        // this.unloadWebSocket();
    },
    onUnload: function () {
        console.log("页面卸载")
        this.unloadWebSocket();
    },
    onPullDownRefresh: function () {
        console.log("监听用户下拉动作")
        var that = this;
        if (!that.data.messageDate) {
            if (that.data.messageList.length == 1) {
                messageDate = that.data.messageList[0].list[0].id
                that.setData({
                    messageDate: messageDate
                })
                console.log(messageDate)
            }
        }
        that.setData({
            show: true,
        })
        that.getMessageList();
        setTimeout(() => {
            wx.stopPullDownRefresh();
        }, 1000);
    },
    onReachBottom: function () {
        console.log("监听页面上拉触底")
    },
    onPageScroll: function (e) {
        // console.log("监听页面滚动", e);
    },
    onShareAppMessage: function (res) {
        console.log("用户点击右上角分_享")
    },
    getStaffCard: function () {
        var that = this;
        console.log("that.data.chat_to_uid", that.data.chat_to_uid)
        wx.request({
            'url': that.data.staffUrl,
            'data': {
                user_id: that.data.chat_to_uid
            },
            'header': {},
            'method': 'POST',
            'header': {
                'content-type': 'application/x-www-form-urlencoded'
            },
            'success': function (res) {
                wx.hideNavigationBarLoading();
                wx.hideLoading();
                if (!res.data.errno) {
                    console.log(res, "getStaffCard getStaffCard */////////**")
                    that.setData({
                        'contactUserName': res.data.data.count.name,
                        'staffDefaultData.phone': res.data.data.count.phone,
                        'staffDefaultData.wechat': res.data.data.count.wechat,
                        'staffDefaultData.title': '你好，我是' + res.data.data.count.name + '，有什么可以帮到你？记得联系我！'
                    })
                }
            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        });

    },
    initData: function () {
        let that = this;
        that.linkSocket();
        let systemInfo = wx.getSystemInfoSync();
        chatInput.init(this, {
            systemInfo: systemInfo,
            minVoiceTime: 1,
            maxVoiceTime: 60,
            startTimeDown: 56,
            format: 'mp3',//aac/mp3
            sendButtonBgColor: 'mediumseagreen',
            sendButtonTextColor: 'white',
            extraArr: [
                {
                    picName: 'choose_picture',
                    description: '照片'
                }
                // , {
                //     picName: 'take_photos',
                //     description: '拍摄'
                // },
            ],
            // tabbarHeigth: 48
        });

        that.setData({
            pageHeight: systemInfo.windowHeight,
        });

        that.textButton();
        that.extraButton();
    },
    textButton: function () {
        var that = this;
        chatInput.setTextMessageListener(function (options) { 
            //jingshuixian 同步参数获取
            var success = options.success,
                e = options.e,
                fail = options.fail;

            let content = e.detail.value;
            console.log("userid**********************", that.data.user_id, that.data.chat_to_uid)
            
            let data = {
                user_id: that.data.user_id,
                target_id: that.data.chat_to_uid,
                content: content,
                type: 'text',
                uniacid: app.siteInfo.uniacid
            }
            data = JSON.stringify(data)
            console.log(data, "*************************************")

            wx.sendSocketMessage({
                data: data,
                success: function (res) {
                    console.log(res, "success");
                    var tmpData = that.data.messageList;
                    var length = tmpData.length;

                    data = JSON.parse(data);
                    if (length > 0) {
                        tmpData[length - 1].list.push(data);
                        that.setData({
                            messageList: tmpData
                        }, function () {
                            that.pageScrollToBottom()
                        })
                    } else {

                        var date = new app.util.date();
                        var create_time = (date.dateToLong(new Date) / 1000).toFixed(0);
                        create_time = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(create_time * 1000));

                        console.log(create_time, "////***555")
                        tmpData.push({ create_time: create_time, list: [data] });


                        that.setData({
                            messageList: tmpData
                        }, function () {
                            that.pageScrollToBottom()
                        })
                    }

                    var date = new app.util.date();
                    var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);
                    that.SendTemplate(currentTime);
                    success(true) //jingshuixian 同步结果  发送消息状态,用于判断是否清空文本框
                },
                fail: function (res) {
                    console.log(res, "fail")
                    fail(false) //jingshuixian 同步结果  发送消息状态,用于判断是否清空文本框
                }
            })


            

        });
    },
    extraButton: function () {
        let that = this;
        chatInput.clickExtraListener(function (e) {
            // console.log(e);
            let itemIndex = parseInt(e.currentTarget.dataset.index);
            if (itemIndex === 1) {
                wx.chooseVideo({
                    maxDuration: 10,
                    success: function (res) {
                        console.log(res)
                        let tempFilePath = res.tempFilePath;
                        let thumbTempFilePath = res.thumbTempFilePath;
                        wx.showLoading({
                            title: '发送中...',
                        })
                        console.log(tempFilePath, thumbTempFilePath)
                    },
                    fail: function (res) { },
                    complete: function (res) { },
                })
                return;
            }
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['compressed'],
                sourceType: itemIndex === 0 ? ['album'] : ['camera'],
                success: function (res) {
                    let tempFiles = res.tempFiles;
                    wx.showLoading({
                        title: '发送中...',
                    })
                    console.log(tempFiles)
                    wx.uploadFile({
                        url: that.data.uploadUrl,
                        filePath: tempFiles[0].path,
                        name: 'upfile',
                        formData: {},
                        success: function (res) {
                            console.log(res, "******/////////////////////res")
                            wx.hideLoading();
                            var tmpData = JSON.parse(res.data);
                            var imgPath = tmpData.data.path;
                            let data = {
                                user_id: that.data.user_id,
                                target_id: that.data.chat_to_uid,
                                content: imgPath,
                                type: 'image',
                                uniacid: app.siteInfo.uniacid
                            }

                            data = JSON.stringify(data);
                            that.toSendMessage(data, 3);
                        }
                    })
                }
            });
            chatInput.closeExtraView();
        });
        chatInput.setExtraButtonClickListener(function (dismiss) {
            console.log('Extra弹窗是否消息', dismiss);
        })
    },
    pageScrollToBottom: function () {
        wx.createSelectorQuery().select('.speak_box').boundingClientRect(function (rect) {
            // 使页面滚动到底部
            console.log(rect)
            wx.pageScrollTo({
                scrollTop: rect.height
            })
        }).exec()
    },
    toSendMessage(data, toStatus) {
        var that = this;
        wx.sendSocketMessage({
            data: data,
            success: function (res) {
                console.log(res, "success");
                var tmpData = that.data.messageList;
                var length = tmpData.length;

                data = JSON.parse(data);
                console.log(data, "*************************************")
                if (length > 0) {
                    tmpData[length - 1].list.push(data);
                } else {
                    var date = new app.util.date();
                    var create_time = (date.dateToLong(new Date) / 1000).toFixed(0);
                    create_time = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(create_time * 1000));
                    console.log(create_time, "////***555")
                    tmpData.push({ create_time: create_time, list: [data] });
                }

                that.setData({
                    messageList: tmpData
                }, function () {
                    that.pageScrollToBottom()
                })

                var date = new app.util.date();
                var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);

                console.log("SendTemplate 客户发送给员工 模板消息")
                that.SendTemplate(currentTime);
            },
            fail: function (res) { 
                that.toSendMessage(data, toStatus);
            }
        })
    },
    SendTemplate: function (currentTime) {
        var that = this;
        app.util.request({
            'url': 'entry/wxapp/SendTemplate',
            'cachetime': '30',
            'showLoading': false,
            'method': 'POST',
            'data': {
                to_uid: that.data.chat_to_uid,
                date: currentTime
            },
            success: function (res) {
                console.log("entry/wxapp/SendTemplate ==>", res)
                if (!res.data.errno) {
                }
            },
            fail: function (res) {
                console.log("entry/wxapp/SendTemplate ==> fail ==> ", res)
            }
        })
    },
    getChat: function () {
        var that = this;
        app.util.request({
            'url': 'entry/wxapp/chatId',
            'cachetime': '30',
            'showLoading': false,
            'method': 'POST',
            'data': {
                to_uid: that.data.chat_to_uid
            },
            success: function (res) {
                console.log("entry/wxapp/chatId ==>", res)
                if (!res.data.errno) {
                    that.setData({
                        chatInfo: res.data.data,
                        chatAvatarUrl: res.data.data.user_info.avatarUrl,
                        toChatAvatarUrl: res.data.data.target_info.avatarUrl
                    })
                    that.getMessageList();
                }
            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        })
    },
    getMessageList: function () {
        var that = this;
        var paramData = {
            chat_id: that.data.chatInfo.chat_id
        }
        if (that.data.messageDate) {
            paramData.create_time = that.data.messageDate
        }
        app.util.request({
            'url': 'entry/wxapp/messages',
            'cachetime': '30',
            'showLoading': false,
            'method': 'POST',
            'data': paramData,
            success: function (res) {
                console.log("entry/wxapp/messages ==>", res) 
                // that.linkSocket();

                if (!res.data.errno) {
                    var tmpData = res.data.data.list;
                    if (tmpData.length == 0) {
                        that.setData({
                            more: false,
                            loading: false,
                            isEmpty: true,
                            show: true
                        })
                        return false;
                    }

                    that.setData({
                        loading: true,
                        messageDate: res.data.data.create_time
                    })

                    var tmpListData = that.data.messageList;

                    if (that.data.onPullDownRefresh == true) {
                        tmpListData = []
                    }
                    tmpListData = tmpListData.reverse();

                    // tmpData = tmpData.reverse();



                    var date = new app.util.date();
                    // if (res.data.data.create_time.length < 12) {
                    //     tmpCreateTime = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(res.data.data.create_time * 1000));
                    // }
                    var tmpCreateTime;
                    for (let i in tmpData) {
                        if (tmpData[i].create_time.length < 12) {
                            tmpData[i].create_time = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(tmpData[i].create_time * 1000));
                        }
                        tmpCreateTime = tmpData[0].create_time;
                        // tmpListData.push(tmpData[i]);
                    }
                    tmpData = tmpData.reverse();

                    tmpListData.push({ create_time: tmpCreateTime, list: tmpData })

                    tmpListData = tmpListData.reverse();

                    that.setData({
                        messageList: tmpListData,
                        onPullDownRefresh: false
                    }) 


                    let { tmpGoodsData } = that.data;
                    if(tmpGoodsData){ 
                            that.toSendMessage(tmpGoodsData.text, 3); 
                            setTimeout(() => {
                                that.toSendMessage(tmpGoodsData.image, 3);
                                that.setData({
                                    tmpGoodsData : false
                                })
                            }, 600); 
                    }
                } 

            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        })
    },
    // 名片
    getCardIndexData: function () {
        var that = this;
        app.util.request({
            'url': 'entry/wxapp/cardV3',
            // 'url': 'entry/wxapp/card',
            'cachetime': '30',
            // 'showLoading': false,
            'method': 'POST',
            'data': {
                to_uid: that.data.chat_to_uid,
                from_id: that.data.chat_to_uid
            },
            success: function (res) {
                console.log("entry/wxapp/cardV3 ==>", res)
                if (!res.data.errno) {
                    var tmpDataIndex = res.data.data;
                    var tmpDataAddr = tmpDataIndex.info.myCompany.addr;
                    var tmpMore = '';
                    if (tmpDataAddr.length > 23) {
                        tmpMore = '...';
                    }
                    tmpDataIndex.info.myCompany.addrMore = tmpDataAddr.slice(0, 23) + tmpMore;

                    var paramObj = { 
                        avatar: tmpDataIndex.info.avatar,
                        name: tmpDataIndex.info.name,
                        job_name: tmpDataIndex.info.job_name,
                        phone: tmpDataIndex.info.phone,
                        wechat: tmpDataIndex.info.wechat,
                        companyName: tmpDataIndex.info.myCompany.name,
                        logo: tmpDataIndex.info.myCompany.logo,
                        addrMore: tmpDataIndex.info.myCompany.addrMore,
                        qrImg: tmpDataIndex.qr
                      } 
                      that.setData({
                        cardIndexData: tmpDataIndex,
                        tmpShareData: paramObj
                      },function(){
                        that.getStaffCard();
                    })
                }
            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        })
    }, 
    toJump: function (e) {
        var that = this;
        var status = e.currentTarget.dataset.status;
        var index = e.currentTarget.dataset.index;
        var type = e.currentTarget.dataset.type;
        var content = e.currentTarget.dataset.content;
        if (status == 'toHome') {
          app.util.goUrl(e);
        } else if (status == 'toSeeStaff') {
            var paramUrl = '/longbing_card/pages/index/index?to_uid=' + that.data.chat_to_uid + '&from_id=' + app.globalData.from_id + '&currentTabBar='
            if (index == 0) {
                console.log("0 ==>进入我的名片")
                paramUrl = paramUrl + 'toCard'
            } else if (index == 1) {
                console.log("1 ==>查看公司官网")
                paramUrl = paramUrl + 'toCompany'
            } else if (index == 2) {
                console.log("2 ==>查看公司商品")
                paramUrl = paramUrl + 'toShop'
            } else if (index == 3) {
                console.log("3 ==>查看我的动态")
                paramUrl = paramUrl + 'toNews'
            }
            wx.navigateTo({
                url: paramUrl
            })
        } else if (status == 'toCallCopy') {
            if (!content) {
                return false;
            } else {
                console.log(content, "//**//")
                if (type == 2) {
                    wx.makePhoneCall({
                        phoneNumber: content,
                        success: function (res) {
                            // console.log('拨打电话成功 ==>>', res.data); 
                            that.toCopyRecord(type);
                        }
                    });
                } else if (type == 4) {
                    wx.setClipboardData({
                        data: content,
                        success: function (res) {
                            wx.getClipboardData({
                                success: function (res) {
                                    that.toCopyRecord(type);
                                }
                            });
                        }
                    });
                }
            }
        } else if (status == 'toCopy') {
            console.log("复制聊天内容 || 复制微信 || 打电话")
            app.util.goUrl(e);
        } else if (status == 'toCopyWechat') {
            console.log("复制微信")
            wx.setClipboardData({
                data: content,
                success: function (res) {
                    console.log(res)
                    wx.getClipboardData({
                        success: function (res) {
                            console.log('复制文本成功 ==>>', res.data);
                        }
                    });
                }
            });
            that.toCopyRecord(type);
        } else if (status == 'toCallPhone') {
            console.log("打电话")
            app.util.goUrl(e);
            that.toCopyRecord(type);
        } else if (status == 'toSaveCard') {
            console.log("保存名片码") 
            wx.navigateTo({
                url: '/longbing_card/pages/card/share/share'
            })
        } else if (status == 'previewImage') {
            console.log(e)
            wx.previewImage({
                current: content,
                urls: [content]
            })
        }
    },
    toCopyRecord: function (type) {
        var that = this;
        app.util.request({
            'url': 'entry/wxapp/copyRecord',
            'cachetime': '30',
            'showLoading': false,
            'method': 'POST',
            'data': {
                type: type,
                to_uid: that.data.chat_to_uid
            },
            success: function (res) {
                // console.log("entry/wxapp/copyRecord ==>", res)
                if (!res.data.errno) {
                }
            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        })
    },
    formSubmit: function (e) {
        var that = this;
        var formId = e.detail.formId;
        that.toSaveFormIds(formId);
    },
    toSaveFormIds: function (formId) {
        var that = this;
        app.util.request({
            'url': 'entry/wxapp/formid',
            'cachetime': '30',
            'showLoading': false,
            'method': 'POST',
            'data': {
                formId: formId
            },
            success: function (res) {
                console.log("entry/wxapp/formid ==>", res)
                if (!res.data.errno) {
                }
            },
            fail: function (res) {
                console.log("fail ==> ", res)
            }
        })
    },
    getWebSocketErrorTime: function () {
        endTime = new Date();
        var date1 = beginTime;  //开始时间
        console.log('beginTime', beginTime, 'endTime', endTime)
        var date2 = endTime;    //结束时间
        var date3 = date2.getTime() - date1.getTime()  //时间差的毫秒数


        //计算出相差天数
        var days = Math.floor(date3 / (24 * 3600 * 1000))

        //计算出小时数

        var leave1 = date3 % (24 * 3600 * 1000)    //计算天数后剩余的毫秒数
        var hours = Math.floor(leave1 / (3600 * 1000))
        //计算相差分钟数
        var leave2 = leave1 % (3600 * 1000)        //计算小时数后剩余的毫秒数
        var minutes = Math.floor(leave2 / (60 * 1000))


        //计算相差秒数
        var leave3 = leave2 % (60 * 1000)      //计算分钟数后剩余的毫秒数
        var seconds = Math.round(leave3 / 1000)


        console.log(" 相差 " + days + "天 " + hours + "小时 " + minutes + " 分钟" + seconds + " 秒")
    }
});