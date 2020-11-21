// yzmdwsc_sun/pages/backstage/manager/manager.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    manager:[
      {
        uthumb:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname:'这是名字',
        id:1234
      },
      {
        uthumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname: '这是名字',
        id: 1234
      },
      {
        uthumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname: '这是名字',
        id: 1234
      },
    ],
    id:'',
    searchFlag:false
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    that.getHxstaff();
  
  },
  getHxstaff(e){
    var that=this;
    //获取核销人员
    app.util.request({
      'url': 'entry/wxapp/getHxstaff',
      'cachetime': '0',
      data: {
        'type': 1,
      },
      success(res) {
        that.setData({
          hxstaff: res.data,
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
 /* onShareAppMessage: function () {
  
  },*/
  enterInput(e){
    this.setData({
      id:e.detail.value
    })
  },
  /**搜索 */
  submit(e) {
    var that=this;
    var keyword = that.data.id;
    console.log(keyword)
    if (keyword == '') {
      wx: wx.showModal({
        title: '提示',
        showCancel: false,
        content: 'id不得为空',
      })
    } else {
      //获取选择用户
      app.util.request({
        'url': 'entry/wxapp/getUserXz',
        'cachetime': '0',
        data: {
          id: keyword,
        },
        success(res) {
          that.setData({
            user: res.data,
          })
        }
      })

      /**提交表单 */
      that.setData({
        searchFlag:true
      })
    }
  },
  /***删除核销员 */
  toDelete(e){
    var that=this;
    var uname=e.currentTarget.dataset.name;
    var id = e.currentTarget.dataset.id;
    wx.showModal({
      title: '',
      content: '确定删除核销员：'+uname,
      success:function(res){
        if(res.confirm){
          /***删除 */
          app.util.request({ 
            'url': 'entry/wxapp/delHxstaff',
            'cachetime': '0',
            data: {
              id: id,
            },
            success(res) {
              that.getHxstaff();
            }
          })
        }
      }
    })
  },
  toAdd(e){
    /***添加 */
    console.log(e)
    var that=this;
    //添加核销人员
    app.util.request({
      'url': 'entry/wxapp/setHxstaff',
      'cachetime': '0',
      data: {
        openid: e.currentTarget.dataset.openid,
      },
      success(res) {
        that.getHxstaff();
        that.setData({
          searchFlag: false
        })
      }
    })
   
  }
})