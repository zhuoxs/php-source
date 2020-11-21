var app = getApp()
var chatInput = require('../../chat/chat-input/chat-input.js');
import util from '../../resource/js/xx_util.js';
import { userModel, baseModel } from '../../resource/apis/index.js'
var timer = 0; //重连定时器
var closeReconnect = false; //是否关闭断线重连
var lockReconnect = false; //断线检查状态 
var ping_user_id;
var ping_chat_to_uid;
let heartCheck = {
  timeout: 5000,
  timeoutObj: null,
  serverTimeoutObj: null,
  reset: function () {
    clearTimeout(timer);
    clearTimeout(this.timeoutObj);
    clearTimeout(this.serverTimeoutObj);
    return this;
  },
  start: function () {
    this.timeoutObj = setTimeout(() => {
      console.log("发送ping");
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
    useMessageType: [],
    currUType: 0,
    useMessage: [],
    showEditSec: false,
    clientSource: [],
    messageList: [],
    lockReconnect: false,   //断线检查状态
    limit: 0, //断线检查计数
    closeReconnect: false,  //是否关闭断线重连 
    showAddUseSec: false,
    showUseMessage: false,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    console.log(options, "/////////////**99999999999999999999*********")


    if (options.is_tpl == 1) {
      let paramObj = {
        user_id: wx.getStorageSync("userid"),
        target_id: options.to_uid
      }
      baseModel.getChatInfo(paramObj).then((d) => {
        console.log(d.data, "baseModel.getChatInfo(paramObj)")
        let { user_info, target_info, chat_id } = d.data;
        let { nickName, avatarUrl } = target_info;
        let userAvatarUrl = user_info.avatarUrl;
        that.setData({
          is_tpl: 1,
          chat_to_uid: options.to_uid,
          'chatInfo.chat_id': chat_id,
          chatAvatarUrl: userAvatarUrl,
          toChatAvatarUrl: avatarUrl,
          contactUserName: nickName,
          user_id: wx.getStorageSync("userid"),
          globalData: app.globalData
        }, function () {
          ping_user_id = wx.getStorageSync("userid");
          ping_chat_to_uid = that.data.chat_to_uid;
          that.initData();
          if (that.data.chatInfo.chat_id) {
            // if (options.chatid) {
            that.getMessageList();
          } else if (!that.data.chatInfo.chat_id) {
            // } else if (!options.chatid) {
            that.getChat();
          }
        })
      })
    } else {
      // } else if (options.chat_to_uid) {
      that.setData({
        chat_to_uid: options.chat_to_uid,
        'chatInfo.chat_id': options.chatid,
        chatAvatarUrl: options.chatAvatarUrl,
        toChatAvatarUrl: options.toChatAvatarUrl,
        contactUserName: options.contactUserName,
        user_id: wx.getStorageSync("userid"),
        globalData: app.globalData
      }, function () {
        ping_user_id = wx.getStorageSync("userid");
        ping_chat_to_uid = that.data.chat_to_uid;
        that.initData();
        if (that.data.chatInfo.chat_id) {
          // if (options.chatid) {
          that.getMessageList();
        } else if (!that.data.chatInfo.chat_id) {
          // } else if (!options.chatid) {
          that.getChat();
        }
      })
    }

    wx.setNavigationBarTitle({
      title: that.data.contactUserName
    })
 

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
    that.setLinkTitle('连接中')
    that.closeReconnect = false; //启动断线重连
    that.limit = 0;
    wx.connectSocket({
      url: app.globalData.wssUrl,
      success() {
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
      that.setLinkTitle();
      //收到消息
      if (res.data == "pong") {
        console.log('WebSocket连接正常....')
        heartCheck.reset().start()
      } else {
        //处理数据
        console.log('收到服务器内容：', res)
        var resData = JSON.parse(res.data);
        console.log('收到服务器内容resData：', resData)
        console.log(that.data.chat_to_uid, that.data.user_id, "chat_to_uid ==> user_id")
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
              console.log(resData.data2.user_id, that.data.chat_to_uid, data)
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
            console.log(data)
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
              console.log(create_time, "that.data.messageList length = 0 ////***555")
              tmpData.push({ create_time: create_time, list: [data] });
            }

            that.setData({
              messageList: tmpData
            }, function () {
              that.pageScrollToBottom()
            })
            console.log("res.data不为空 messageList", that.data.messageList)
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
      console.log('WebSocket连接打开失败')
      this.reconnect()
    })
    wx.onSocketClose((res) => {
      console.log('WebSocket 已关闭！')
      this.reconnect()
    })
  },
  /**
   * 卸载创建的WebSocket
   */
  unloadWebSocket() {
    var that = this;
    console.log('开始卸载 WebSocket')
    closeReconnect = true; // 关闭断线重连
    lockReconnect = true; // 关闭心跳
    heartCheck.reset();  //关闭心跳
    wx.closeSocket((res) => {
      console.log('卸载创建 的  WebSocket')
    })
  },
  /**
   * 断线重连
   */
  reconnect() {
    //取消断线重连
    let that = this
    console.log('closeReconnect', closeReconnect, timer);
    if (closeReconnect) {
      clearTimeout(timer);
      closeReconnect = true;
      lockReconnect = false;
      return true;
    }
    console.log('closeReconnect', closeReconnect, timer);
    if (lockReconnect && closeReconnect) return;
    that.setLinkTitle('重连中')
    lockReconnect = true;
    clearTimeout(timer)
    if (this.data.limit < 12) {
      timer = setTimeout(() => {
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
    // console.log("监听用户下拉动作")
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
      show: true
    })
    that.getMessageList();
    setTimeout(() => {
      wx.stopPullDownRefresh();
    }, 1000);
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")  
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  initData: function () {
    let that = this;
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
        //   picName: 'take_photos',
        //   description: '拍摄'
        // },
      ],
      // tabbarHeigth: 48
    });

    that.setData({
      pageHeight: systemInfo.windowHeight,
    });
    that.textButton();
    that.extraButton();
    that.getSource();
    // that.voiceButton();
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

      // that.toSendMessage(data,1);

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
          that.SendTemplateCilent(currentTime);

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
      that.hideExtra();
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
  hideExtra: function (e) {
    this.setData({
      'inputObj.extraObj.chatInputShowExtra': false
    })
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
        that.SendTemplateCilent(currentTime);
        if (toStatus == 2) {
          that.setData({
            showUseMessage: false,
            showAddUseSec: false
          })
        }
      },
      fail: function (res) {
        if (toStatus == 2) {
          that.setData({
            showUseMessage: false,
            showAddUseSec: false
          })
        } else if (toStatus == 3) {
          that.toSendMessage(data, toStatus)
        }
      }
    })
  },
  SendTemplateCilent: function (currentTime) {
    var that = this;
    console.log(that.data.chat_to_uid, "chat_to_uid")
    app.util.request({
      'url': 'entry/wxapp/SendTemplateCilent',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        client_id: that.data.chat_to_uid,
        date: currentTime
      },
      success: function (res) {
        console.log("entry/wxapp/SendTemplateCilent ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/SendTemplateCilent ==> fail ==> ", res)
      }
    })
  },
  getSource: function () {
    var that = this;
    console.log(that.data.chat_to_uid, "that.data.chat_to_uid")
    app.util.request({
      'url': 'entry/wxapp/Source',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        client_id: that.data.chat_to_uid
      },
      success: function (res) {
        console.log("entry/wxapp/Source ==>", res)
        if (!res.data.errno) {
          that.setData({
            clientSource: res.data.data
          })
          console.log(res.data.data, that.data.clientSource)
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
    that.getReplyList();
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
        that.linkSocket();
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


        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getReplyList: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/ReplyList',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        console.log("entry/wxapp/ReplyList ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var tmpType = that.data.useMessageType;

          for (let i in tmpData) {
            tmpType.push(tmpData[i].title)
          }
          that.setData({
            useMessage: tmpData,
            useMessageType: tmpType
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getAddReply: function (content) {
    var that = this;
    var tmpDataList = that.data.useMessage;
    var tmpData = tmpDataList[that.data.currUType].list;
    app.util.request({
      'url': 'entry/wxapp/AddReply',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        content: content
      },
      success: function (res) {
        console.log("entry/wxapp/AddReply ==>", res)
        if (!res.data.errno) {
          tmpData.push({ id: res.data.data.id, content: content })
          that.setData({
            currUType: 0,
            useMessage: tmpDataList,
            showAddUseSec: false
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getEditReply: function (content) {
    var that = this;
    var tmpDataList = that.data.useMessage;
    var tmpData = tmpDataList[that.data.currUType].list;
    app.util.request({
      'url': 'entry/wxapp/EditReply',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        id: tmpData[that.data.toEditInd].id,
        content: content
      },
      success: function (res) {
        console.log("entry/wxapp/EditReply ==>", res)
        if (!res.data.errno) {
          tmpData[that.data.toEditInd].content = content;
          that.setData({
            useMessage: tmpDataList,
            showAddUseSecContent: '',
            showAddUseSec: false,
            showEditSec: false
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
        that.setData({
          showAddUseSecContent: '',
          showAddUseSec: false,
          showEditSec: false
        })
      }
    })
  },
  getDelReply: function (index) {
    var that = this;
    var tmpDataList = that.data.useMessage;
    var tmpData = tmpDataList[that.data.currUType].list;
    app.util.request({
      'url': 'entry/wxapp/DelReply',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        id: tmpData[index].id
      },
      success: function (res) {
        console.log("entry/wxapp/DelReply ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '已成功删除数据！',
            duration: 1000
          })
          tmpData.splice(index, 1)
          that.setData({
            useMessage: tmpDataList,
            showEditSec: false
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
        that.setData({
          showEditSec: false
        })
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var type = e.currentTarget.dataset.type;
    var content = e.currentTarget.dataset.content;
    if (status == 'toHome' || status == 'toJumpUrl') {
      app.util.goUrl(e);
    } else if (status == 'toStarMark') {
      console.log("设为星标")
      // that.setMark();
    } else if (status == 'previewImage') {
      console.log(e)
      wx.previewImage({
        current: content,
        urls: [content]
      })
    } else if (status == 'toCopy') {
      console.log("复制聊天内容")
      app.util.goUrl(e);
    } else if (status == 'toUse') {
      console.log("常用话术")
      that.setData({
        showUseMessage: true
      })
    } else if (status == 'toSetTab') {
      console.log("切换分类")
      that.setData({
        currUType: index,
        showEditSec: false
      })
    } else if (status == 'toSendMessage') {
      console.log("发送常用话术")
      let data = {
        user_id: that.data.user_id,
        target_id: that.data.chat_to_uid,
        content: content,
        type: 'text',
        uniacid: app.siteInfo.uniacid
      }
      data = JSON.stringify(data)
      console.log(data, "发送常用话术 *************************************")
      that.toSendMessage(data, 2);

    } else if (status == 'toClose') {
      console.log("关闭常用话术")
      that.setData({
        showUseMessage: false,
        showAddUseSec: false,
        showAddUseSecContent: '',
        toEditInd: ''
      })
    } else if (status == 'toAdd') {
      console.log("新增话术")
      that.setData({
        showAddUseSec: true
      })
    } else if (status == 'toEditSec') {
      console.log("编辑话术")
      var tmpType;
      if (type == true) {
        tmpType = false
      }
      if (type == false) {
        tmpType = true
      }
      that.setData({
        showEditSec: tmpType
      })
    } else if (status == 'toEdit') {
      console.log("编辑话术")
      that.setData({
        showAddUseSecContent: content,
        showAddUseSec: true,
        toEditInd: index
      })
    } else if (status == 'toDelete') {
      console.log("删除话术")
      wx.showModal({
        title: '',
        content: '是否确认删除此数据？',
        success: res => {
          if (res.confirm) {
            that.getDelReply(index);
          } else {
            that.setData({
              showEditSec: false
            })
          }
        }
      })
    }
  },
  formSubmit: function (e) {
    var that = this;
    var status = e.detail.target.dataset.status;
    var formId = e.detail.formId;
    that.toSaveFormIds(formId);
    if (status == 'toCancel') {
      console.log("取消")
      that.setData({
        showAddUseSec: false,
        showAddUseSecContent: '',
        toEditInd: ''
      })
    } else if (status == 'toSaveUseMessage') {
      console.log("保存")
      var content = e.detail.value.newuse;
      if (that.data.showAddUseSecContent) {
        that.getEditReply(content);
      } else {
        that.getAddReply(content);
      }
    }
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
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }
});