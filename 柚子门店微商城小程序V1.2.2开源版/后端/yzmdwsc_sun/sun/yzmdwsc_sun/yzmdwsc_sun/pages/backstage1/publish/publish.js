// yzmdwsc_sun/pages/backstage/publish/publish.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '发布',
    uploadPic: [],
    choose_gid:0,
    choose_gname:'商品名称'
  },
/*'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg'*/
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
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var url = wx.getStorageSync('url');
    this.setData({
      url: url,
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
    var that=this;
    var choose_gid = wx.getStorageSync('goodsChoose_gid'); 
    var choose_gname = wx.getStorageSync('goodsChoose_gname');
    if (choose_gid>0){
        that.setData({
          choose_gid: choose_gid,
        })
    }
    if (choose_gname!=''){
      that.setData({
        choose_gname: choose_gname,
      })
    }
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
/*  onShareAppMessage: function () {

  },*/
  formSubmit(e) {
    var that = this;
    let content = e.detail.value.content;
    var uploadPic_request = that.data.uploadPic;
    var gid = that.data.choose_gid;
    console.log(uploadPic_request);

    if (content == '') {
      wx.showToast({
        title: '请输入发布内容',
        icon: 'none'
      })
    } else if (uploadPic_request.length<=0) {
      wx.showToast({
        title: '请上传图片',
        icon: 'none'
      })
    } else if (gid<=0){
      wx.showToast({
        title: '请选择商品',
        icon: 'none'
      })
    }else{
      console.log('开始提交表单');
      uploadPic_request =uploadPic_request.toString();
     // uploadPic_request= JSON.stringify(uploadPic_request);
      //前台发布动态
      app.util.request({
        'url': 'entry/wxapp/setDynamic',
        'cachetime': '0',
        data: {
          content: content,
          imgs:uploadPic_request,
          gid:gid,
        },
        success: function (res) {
          wx.showToast({
            title: '发布成功', 
            icon: 'success',
            duration: 2000,
            success: function () {
 
            },
            complete: function () {
              wx.navigateTo({
                url: '../../active/active',
              })
            },
          })
          
        },
      })


    }
  },
  /**上传照片 */
  uploadPic(e) {
    var that = this;
    var uploadPic_request = that.data.uploadPic;
    if (uploadPic_request.length>=9){
      wx.showToast({
        title: '最多上传9张图片',
        icon: 'loading',
        mask: true,
        duration: 1000
      })
      return 
    }
    var request_url = app.util.url() +'&c=entry&a=wxapp&do=upload1&&m=yzmdwsc_sun';
    console.log(request_url);
    wx.chooseImage({
      count: 9,
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'],
      success: function (res) {
        var tempFilePaths = res.tempFilePaths;
        if (uploadPic_request.length + tempFilePaths.length>9){
          wx.showToast({
            title: '最多上传9张图片',
            icon: 'loading',
            mask: true,
            duration: 1000
          })
          return
        }
        console.log('测试中');
        console.log(tempFilePaths);
      //  console.log(that.data.uploadPic);
        wx.showToast({
          title: '正在上传...',
          icon: 'loading',
          mask: true,
          duration: 10000
        })
        var uploadImgCount = 0;
        for (var i = 0, h = tempFilePaths.length; i < h; i++) {  
          wx.uploadFile({
            url: request_url, //
            filePath: tempFilePaths[i],
            name: 'upfile',
            formData: {
              'upload': 'upload'
            },
            header: {
              "Content-Type": "multipart/form-data"
            },
            success: function (res) {
              uploadImgCount++;
              var data = res.data;
              uploadPic_request.push(data);
              that.setData({
                uploadPic: uploadPic_request,
              })

              if (uploadImgCount == tempFilePaths.length) {
                wx.hideToast();
              }  

            }
          })



        }


 



      }
    })
    /**验证 */
  },
  toGoodslist(e){
    wx.navigateTo({
      url: '../goodslist/goodslist',
    })
  },
  toIndex(e) {
    wx.redirectTo({
      url: '../index/index'
    })
  },
  toSet(e) {
    wx.redirectTo({
      url: '../set/set'
    })
  }
})