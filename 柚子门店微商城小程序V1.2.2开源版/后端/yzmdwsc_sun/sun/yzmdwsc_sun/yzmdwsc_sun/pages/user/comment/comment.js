// wnjz_sun/pages/user/comment/comment.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    imgsrc:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15216861845.png',
    startnum: ['../../../../style/images/stars.png', '../../../../style/images/stars.png', '../../../../style/images/stars.png', '../../../../style/images/stars.png','../../../../style/images/stars.png'],
    uploadPic:[],
    scores:0,
    flag:true
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn' 
      }
    })
    var url = wx.getStorageSync('url');
    var openid = wx.getStorageSync('openid');
    var order_id=options.order_id;
    var order_detail_id=options.order_detail_id;
   /* order_id=101;
    order_detail_id=100;*/
    that.setData({
      order_id: order_id,
      order_detail_id: order_detail_id,
      url:url,
    })
    //获取评价商品信息
    app.util.request({
      'url': 'entry/wxapp/getOrderDetailComment',
      'cachetime': '0',
      data: {
        order_id: order_id,
        order_detail_id: order_detail_id,
        uid:openid,
      },
      success(res) {
        that.setData({
          detail:res.data,
        })
      }
    })

  
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
  
  },
  stars(e){
    var that=this;
    var num = e.currentTarget.dataset.num;
    var startnum = [];  
    for(var i=0;i<num+1;i++){
      startnum.unshift('../../../../style/images/starss.png');
    }
    for (var i = 0; i < 4-num; i++) {
      startnum.push('../../../../style/images/stars.png');
    }
    console.log(num)
    that.setData({
      startnum: startnum,
      scores:num+1,
    })
  },
  /**上传照片 */
  uploadPic(e){
    var that=this;
    wx.chooseImage({
      count: 4, 
      sizeType: ['original', 'compressed'], 
      sourceType: ['album', 'camera'], 
      success: function (res) {
        var tempFilePaths = res.tempFilePaths;

        wx.uploadFile({
          url: '/style/upload', //
          filePath: tempFilePaths[0],
          name: 'file',
          formData: {
            'user': 'test'
          },
          header: {
            "Content-Type": "multipart/form-data"
          },  
          success: function (res) {
            var data = res.data
            console.log(data)
          }
        })
      }
    })
    /**验证 */
  },
  formSubmit(e) {
    var that=this;
    var flag=true;
    var warn = "";
    var scores = that.data.scores;
    var order_id = that.data.order_id;
    var order_detail_id = that.data.order_detail_id;
    var comment = e.detail.value.comment;
    var openid = wx.getStorageSync('openid');
    console.log((e.detail.value.comment).length);
    if (scores <= 0){
      warn = "您还未评分";
    } else if ((e.detail.value.comment).length <=10) {
      warn = "评论内容至少10个字哦~";
    }else {
      flag = "false";
      //发表评价
      app.util.request({
        'url': 'entry/wxapp/setComment',
        'cachetime': '0',
        data: {
          uid:openid,
          order_id:order_id,
          order_detail_id:order_detail_id,
          stars:scores,
          content: comment, 
        },
        success(res) {
          wx.showToast({
            title: '评价成功',
            icon: 'success',
            duration: 2000,
            success: function () {

            },
            complete: function () {
              wx.navigateTo({
                url: '../myorder/myorder',
              })
            }, 
          })

        }
      })
   

  
      // wx.navigateTo({});/**跳转 */
    }
    if (flag == true) {
      wx.showModal({
        title: '提示',
        content: warn,
        showCancel: false
      })
    } 
  
  }
})