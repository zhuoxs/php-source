// yzkm_sun/pages/fabu/fabu.js

// 调用tabbar模板
const app = getApp();
var template = require('../template/template.js');
var imgArray1 = [];
var image = '';

Page({
  /**
   * 页面的初始数据
   */
  data: {
    showNotes:false,
    currentTab: 0,
    pics: [],
    class_tz: [],
    post_id:''//帖子类别id
  },
  address: '',
  latitude: '',//发布用户纬度
  longitude: '',//发布用户经度
  /**
   * 生命周期函数--监听页面加载
   */



  onLoad: function (options) {
    var that = this
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.setStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/system',
      success: function (res) {
        console.log('****************************');
        console.log(res);
        wx.setStorageSync('system', res.data);
        wx.setNavigationBarColor({
          frontColor: res.data.color,
          backgroundColor: res.data.fontcolor,
          animation: {
            // duration: ,
            timingFunc: 'easeIn'
          }
        })
      }
    })
    var openid = wx.getStorageSync('openid');//用户openid
    that.diyWinColor();
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
        wx.setStorageSync('id', res.data.id);
      }
    })

    app.util.request({
      'url': 'entry/wxapp/Custom_photo',
      success: function (res) {
        console.log('自定义数据显示');
        console.log(res.data);
        var url = wx.getStorageSync('url')
        template.tabbar("tabBar", 2, that, res, url)//0表示第一个tabbar 
        // that.setData({

        // })
      }
    })

    //帖子分类列表
    app.util.request({
      url: 'entry/wxapp/Post_tz',
      success: function (res) {
        console.log('帖子分类数据');
        console.log(res);
        for (var i = 0; i < res.data.length; i++) {
          // var combine1 = res.data[i].tname ;
          that.data.class_tz.push(res.data[i].post_name);
          console.log(that.data.class_tz);
        }
        console.log(that.data.class_tz);
        that.setData({
          class_tz: that.data.class_tz,
          noDealData_fl: res.data,
        })
        // wx.setStorageSync('user_id', res.data.id);
      }
    })


  },
  // 以下是新增 帖子类别方法
  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    console.log(e)

    var post_id = this.data.noDealData_fl[e.detail.value].id;
    console.log(post_id);
    this.setData({
      index_qx: e.detail.value,
      post_id: post_id,
    })





    this.setData({
      classIndex: e.detail.value
    })
  },
  // ----------------------------------上传图片----------------------------------
  //20180424 @淡蓝海寓 图片上传
  chooseImage: function () {//这里是选取图片的方法
    var that = this;
    let uimg = that.data.pics;
    //限定图片数量，只能9张
    if (uimg.length < 9) {
      wx.chooseImage({
        count: 9 - uimg.length, // 允许上传图片数量，默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图(original)还是压缩图(compressed)，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册(album)还是相机(camera)，默认二者都有
        success: function (res) {
          // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
          uimg = uimg.concat(res.tempFilePaths);
          console.log('1111111111111')
          console.log(uimg)
          //console.log(that.data.content+"---");
          that.setData({
            pics: uimg
          });
        }
      })
    } else {
      wx.showToast({
        title: '只允许上传9张图片！！！',
        icon: 'none',
      })
    }
  },

  uploadimg: function (data, param) {//多张图片上传
    var that = this,
      i = data.i ? data.i : 0,//当前上传的哪张图片
      success = data.success ? data.success : 0,//上传成功的个数
      fail = data.fail ? data.fail : 0;//上传失败的个数
    console.log(param);
    wx.uploadFile({
      url: data.url,
      filePath: data.path[i],
      name: 'file',//这里根据自己的实际情况改
      formData: param,//这里是上传图片时一起上传的数据
      success: (res) => {
        if (res.data == 1) {
          success++;//图片上传成功，图片上传成功的变量+1
        }
        console.log(res)
        console.log(i);
      },
      fail: (res) => {
        if (res.data == 2) {
          fail++;//图片上传失败，图片上传失败的变量+1
        }
        console.log('fail:' + i + "fail:" + fail);
      },
      complete: () => {
        //console.log(i);
        i++;//这个图片执行完上传后，开始上传下一张
        if (i == data.path.length) {   //当图片传完时，停止调用          
          console.log('执行完毕');
          wx.hideLoading();//关闭加载层
          wx.showToast({
            title: '发布成功！！！',
            icon: 'success',
            success: function () {
              //发布成功之后清除
              that.setData({
                pics: [],
                content: "",
                disabled: false,
                sendtitle: "发送"
              })
              //注意switchTab才能跳转tab的页面，navigateTo之类不行
              app.globalData.aci = "";//设置一个全局变量，过后需要清除该数据
              //  延迟两秒跳转
              setTimeout(function () {
                wx.navigateTo({
                  url: '../circle/circle',
                })
              }, 2000)
            }
          })
        } else {//若图片还没有传完，则继续调用函数
          //console.log(i);
          data.i = i;
          data.success = success;
          data.fail = fail;
          that.uploadimg(data, param);
        }
      }
    });
  },

  //20180424 @淡蓝海寓 发布达人圈
  // 点击发布
  publish: function (e) {
    console.log('表单数据')
    console.log(e)
    var formdata = e.detail.value;
    var that = this;

    //var uurl = app.util.url("entry/wxapp/Toupload") + "&m=" + app.siteInfo.mname;
    var uurl = app.util.url("entry/wxapp/Toupload") + "&m=yzkm_sun";

    var uimg = that.data.pics;
    console.log('表单上传的图片数据')
    console.log(uimg)

    /*
    var sign = app.util.getSign(c, arr);
    if (sign) {
      c = c + "&sign=" + sign;
    }*/
    //console.log(uurl);
    // if (!formdata.push_text && uimg.length <= 0) {
    //   wx.showToast({
    //     title: '写点内容或者发张图片吧！！！',
    //     icon: 'none',
    //   })
    //   return false;
    // }
    //增加一个提示上传中层，以免用户在没有上传玩图片就退出页面
    wx.showLoading({
      title: '内容发布中，请稍后...',
      mask: true
    })
    //先提交写的内容到服务器在上传图片
    var id = wx.getStorageSync('id');//用户id

    that.setData({
      disabled: true,
      sendtitle: "稍后"
    })
// 判断发布内容是否为空
if (e.detail.value.content==''){
      wx.showToast({
        title: '发布内容不能为空',
        icon: 'none',
      })
      return false;
}
// 帖子类别不能为空
    if (e.detail.value.post_tzfl == '') {
  wx.showToast({
    title: '帖子类别不能为空',
    icon: 'none',
  })
  return false;
}

  app.util.request({
    url: "entry/wxapp/Addtalentcircle",
    cachetime: "0",
    data: {
      latitude: that.data.latitude,
      longitude: that.data.longitude,
      post_id: that.data.post_id,
      uimg: uimg,
      name: e.detail.value.name,
      tel: e.detail.value.tel,
      id: id,
      content: e.detail.value.content, 
      address: e.detail.value.address
    },
    success: function (res) {
      console.log('发布数据请求')
      console.log(res.data)
      var tcid = res.data;
      if (uimg.length > 0) {
        //console.log(uimg);
        //console.log(22222);
        //上传图片
        let thetcid = { "tcid": tcid };
        console.log('2222222222222222');
        console.log(tcid);
        that.uploadimg({
          url: uurl,//这里是你图片上传的接口
          path: uimg//这里是选取的图片的地址数组
        }, thetcid);
      } else {
        wx.hideLoading();//关闭加载层
        wx.showToast({
          title: '发布成功！！！',
          icon: 'success',
          success: function () {
            //注意switchTab才能跳转tab的页面，navigateTo之类不行
            wx.navigateTo({
              url: '../circle/circle',
            })
          }
        })
      }
    },
    fail: function () {
      that.setData({
        disabled: false,
        sendtitle: "发送"
      })
      wx.showToast({
        title: '可能由于网络原因，发布失败，请重新发布！！！',
        icon: 'none',
        success: function () {
          wx.hideLoading();//关闭加载层
        }
      })
    }
  })




  },

  //20180424 @淡蓝海寓 删除图片
  deleteImage: function (e) {
    var that = this;
    var imgData = this.data.pics;
    var tindex = e.currentTarget.dataset.index;
    imgData.splice(tindex, 1);
    this.setData({
      pics: imgData
    })
  },

  // 自动获取用户的地址
  add: function () {
    var that = this;
    wx.chooseLocation({
      type: 'wgs84 ', //返回可以用于wx.openLocation的地址
      success: function (res) {
        console.log('获取地址')
        console.log(res)
        that.setData({
          address: res.address,
          longitude: res.longitude,
          latitude: res.latitude,
        })
      }
    })
  },

  // 预览上传的图片
  previewImage: function (e) {
    console.log(e);
    var index = e.currentTarget.dataset.index;
    var imgArr = e.currentTarget.dataset.list;//获取data-list
    // // //图片预览
    wx.previewImage({
      current: imgArr[index],     //当前图片地址
      urls: imgArr,               //所有要预览的图片的地址集合 数组形式
    })
  },

  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '发布',
    })
  },

  /*底部tab*/
  bindChange: function (e) {

    var that = this;
    that.setData({ currentTab: e.detail.current });

  },
  swichNav: function (e) {

    var that = this;

    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
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
    // template.tabbar("tabBar", 2, this)//0表示第一个tabbar 
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
  // 点击发布须知
  bindNotesTap(e) {
    var that=this
    var currentStatu = e.currentTarget.dataset.statu;
        app.util.request({
          url: 'entry/wxapp/Fabu_xz',
          success: function (res) {
            console.log('查看发布需知');
            console.log(res);
            that.setData({
              fabu_xz: res.data.releaseneeds,
            })
          }
        })
        that.util(currentStatu);
    console.log(e);
  },
  close: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
  },
  util: function (currentStatu) {
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });
    this.animation = animation;
    animation.opacity(0).height(0).step();
    this.setData({
      animationData: animation.export()
    })
    setTimeout(function () {
      animation.opacity(1).height('630rpx').step();
      this.setData({
        animationData: animation
      })
      if (currentStatu == "close") {
        this.setData(
          {
            showNotes: false
          }
        );
      }
    }.bind(this), 200)
    if (currentStatu == "open") {
      this.setData(
        {
          showNotes: true
        }
      );
    }
  },
})