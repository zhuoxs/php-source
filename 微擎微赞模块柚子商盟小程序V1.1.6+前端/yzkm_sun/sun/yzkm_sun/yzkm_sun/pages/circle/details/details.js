// yzkm_sun/pages/circle/details/details.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    tel:'',
    noS:'', 
    id:'',  
    fabu_id: '',//发布者id
        yh_id:''//当前用户id 
                  //-----------------------分界线以下可删除-----------------------------
    // comments: [                                                     
    //   {
    //     headerImg: 'http://oydnzfrbv.bkt.clouddn.com/header.png',
    //     nick: 'XXX',
    //     dateTime: '2018-01-23 14:00',
    //     // contents: '这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
    //   },
    //   {
    //     headerImg: 'http://oydnzfrbv.bkt.clouddn.com/header.png',
    //     nick: 'Up',
    //     dateTime: '2020-08-23 09:00',
    //     // contents: '这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
    //   },
    //   {
    //     headerImg: 'http://oydnzfrbv.bkt.clouddn.com/header.png',
    //     nick: 'David',
    //     dateTime: '2016-02-23 23:00',
    //     contents: '这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
    //   }
    // ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this
    var openid = wx.getStorageSync('openid');//用户openid
    // 获取用户id
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          comment_xqy: res.data,
        })
        wx.setStorageSync('user_id', res.data.id);//当前要评论的用户id
      }
    })
    var id=options.id//圈子说说id
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.getStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Circle_qz',
      'data': { id: id },
      success: function (res) {
        console.log('查看圈子详情页数据');
        console.log(res);
        that.setData({
          list: res.data,
          tel:res.data[0].tel,
          fabu_id: res.data[0].id,
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Circle_qz_pl',
      'data': { id: id },
      success: function (res) {
        console.log('查看圈子详情页评论数据');
        console.log(res);
        that.setData({
          list1: res.data,
        })
      }
    })

    var user_id = wx.getStorageSync('user_id');//用户user_id
    console.log(user_id)
    app.util.request({
      'url': 'entry/wxapp/Status_qz',
      'data': { 
        id: id,//发布者id
        user_id: user_id,
         },
      success: function (res) {
        console.log('查看收藏状态');
        console.log(res);
        console.log(id);
        console.log(res.data);
        // console.log(res.data[0].state_qz);
        if (res.data == 0) {
          that.setData({
            noS: 0,//未收藏
          })
        } else {
          that.setData({
            noS: 1,//已收藏
          })
        }

      }
    })
    app.util.request({
      'url': 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看当前用户id');
        console.log(res);
        that.setData({
          yh_id: res.data.id,
        })
        // wx.setStorageSync('id', res.data.id);
      }
    })    


    this.diyWinColor();
  },
  // 点赞点击事件
  praise(e) {
    var that = this
    console.log('圈子说说id')
    console.log(e.currentTarget.dataset.id)
    var idx = e.currentTarget.dataset.idx;
    var fabu_id = that.data.list[idx].id;

    var user_id = wx.getStorageSync('user_id');//用户openid
    that.diyWinColor();
    app.util.request({
      url: 'entry/wxapp/Tickle_qz',
      data: {
        openid: user_id,
        fabu_id: fabu_id,
      },
      success: function (res) {
        console.log('圈子点赞数据信息');
        console.log(res);
        if (res.data == 1) {
          that.setData({
            ['list[' + idx + '].praise']: that.data.list[idx].praise - 0 + 1
          })
        }
      }
    })
  },
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '圈子详情',
    })
  },
// 我要发布跳转页面
  writeComments(e){
    wx.navigateTo({
      url: '../../fabu/fabu',
    })  
  },

  // 拨打电话
  makePhone(e) {
    console.log('电话的参数');
    console.log(e);
    var that = this;
    var tel = e.currentTarget.dataset.id;//当前点击的圈子说说ID
    console.log('打电话')
    console.log(that.data.tel)
    wx.makePhoneCall({
      phoneNumber: that.data.tel,
      success: function (e) {
        console.log("-----拨打电话成功-----")
      },
      fail: function (e) {
        console.log("-----拨打电话失败-----")
      }
    })
  },
  // 一键拨号
  makePhone1(e) {
    console.log('电话的参数');
    console.log(e);
    var that = this;
    var tel = e.currentTarget.dataset.id;//当前点击的圈子说说ID
    console.log('打电话')
    console.log(that.data.tel)
    wx.makePhoneCall({
      phoneNumber: that.data.tel,
      success: function (e) {
        console.log("-----拨打电话成功-----")
      },
      fail: function (e) {
        console.log("-----拨打电话失败-----")
      }
    })
  },
  // 点击收藏
  collectTap(e) {
    var that = this;
    // var iid = wx.getStorageSync('iid')
    var openid = wx.getStorageSync('openid');//用户openid
    console.log('发布用户id查询')
    console.log(e)
    console.log(that.data.yh_id)
    if (that.data.noS == 0) {
      app.util.request({
        'url': 'entry/wxapp/Collect_qz',
        data: {
          noS: '1',
          openid: openid,
          yh_id: that.data.yh_id,
          id: e.currentTarget.dataset.id,
        },
        success: function (res) {
          console.log('收藏数据');
          console.log(res);
          that.setData({
            comment_xqy: res.data,
            noS: '1',
          })
        }
      })
    } else if (that.data.noS == 1) {
      app.util.request({
        'url': 'entry/wxapp/Collect_qz',
        data: {
          noS: '0',
          openid: openid,
          yh_id: that.data.yh_id,
          id: e.currentTarget.dataset.id,//文章ID
        },
        success: function (res) {
          console.log('收藏数据');
          console.log(res);
          that.setData({
            comment_xqy: res.data,
            noS: '0',
          })
        }
      })
    }
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})