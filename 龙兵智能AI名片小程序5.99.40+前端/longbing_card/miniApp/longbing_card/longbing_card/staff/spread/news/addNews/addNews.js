
var app = getApp() 
Page({
  data: {
    dataList: [],
    globalData: {},
    status: '',
    currentIndex: 0,
    imgCountNum: 9,
    tempFilePaths: [],
    tempFileImgs: []
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu(); 

    console.log(options, "//////////***************")
    if (options.status) {
      that.setData({
        status: options.status
      })
      if (options.status == 'news') {
        wx.setNavigationBarTitle({
          title: '动态发布'
        })
      } else if (options.status == 'code') {
        wx.setNavigationBarTitle({
          title: '自定义码'
        })
      } else if (options.status == 'group') {
        wx.setNavigationBarTitle({
          title: '群成员数(人)'
        })
      }
    } 

    var paramData = {};
    if(options.opengid){
      paramData.opengid = options.opengid    
    }
    if(options.number){ 
      paramData.groupNumber = options.number  
    }

    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")  
    var that = this;
    wx.showNavigationBarLoading();
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
  chooseImage: function (e) {
    var that = this;
    wx.showActionSheet({
      itemList: ['优雅自拍', '相册收藏'],
      itemColor: '#3675f1',
      success: function (res) {
        if (!res.cancel) {
          if (res.tapIndex == 0) {
            that.chooseWxImageShop('camera');
          } else if (res.tapIndex == 1) {
            that.chooseWxImageShop('album');
          }
        }
      }
    });
  },
  chooseWxImageShop: function (type) {
    var that = this;
    var tmpPath = that.data.tempFilePaths;
    var tmpImg = that.data.tempFileImgs; 
    wx.chooseImage({
      count: that.data.imgCountNum,
      sizeType: ['original', 'compressed'],
      sourceType: [type],
      success: function (res) {
        console.log(res, "===========================  res****")
        for (let i in res.tempFilePaths) {
          app.util.showLoading(3);
          var uploadUrl = app.util.url('entry/wxapp/upload');
          var nowPage = getCurrentPages();
          if (nowPage.length) {
            nowPage = nowPage[getCurrentPages().length - 1];
            if (nowPage && nowPage.__route__) {
              uploadUrl = uploadUrl + '&m=' + nowPage.__route__.split('/')[0];
            }
          }
          console.log(res.tempFilePaths[i], "res.tempFilePaths[i]")
          wx.uploadFile({
            url: uploadUrl,
            filePath: res.tempFilePaths[i],
            name: 'upfile',
            formData: {},
            success: function (res) {
              console.log(res, "*********uploadFile res")
              var tmpData = JSON.parse(res.data);
              tmpPath.push(tmpData.data.path);
              tmpImg.push(tmpData.data.img);
              wx.hideLoading();
              // if (tmpPath.length > 9) {
              //   wx.showModal({
              //     title: '',
              //     content: '最多只能上传9张图片哦！',
              //     confirmText: '知道啦',
              //     showCancel: false,
              //     success: res => {
              //       if (res.confirm) {
              //       } else {
              //       }
              //     }
              //   });
              //   return false;
              // } 
              that.setData({
                tempFilePaths: tmpPath,
                tempFileImgs: tmpImg,
                imgCountNum : 9 - tmpPath.length
              })
              // console.log(that.data.imgCountNum,"****************************tmpData")
            }
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toAddNews: function (title,content) {
    var that = this;
    app.util.showLoading(1);
    var tmpImg = that.data.tempFileImgs;
    var tmpCover = '';
    for (let i in tmpImg) {
      tmpCover += (tmpImg[i] + ',')
    }
    tmpCover = tmpCover.slice(0, -1);
    app.util.request({
      'url': 'entry/wxapp/releaseTimeline',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        title: title,
        content: content,
        cover: tmpCover
      },
      success: function (res) {
        // console.log("entry/wxapp/releaseTimeline ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon:'none',
            title:'动态发布成功！',
            duration: 1500
          })
          setTimeout(() => {
            wx.hideLoading();
            wx.navigateBack();
          }, 1500);   
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toReleaseQr: function (title, content) {
    var that = this;
    app.util.showLoading(1);
    app.util.request({
      'url': 'entry/wxapp/releaseQr',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        title: title,
        content: content
      },
      success: function (res) {
        // console.log("entry/wxapp/releaseQr ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon:'none',
            title:'自定义码发布成功！',
            duration: 1500
          })
          setTimeout(() => {
            wx.hideLoading();
            wx.navigateBack();
          }, 1500);
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getSetGroupNumber: function (number) {
    var that = this; 
    app.util.showLoading(1);
    app.util.request({
      'url': 'entry/wxapp/SetGroupNumber',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        number: number,
        openGId: that.data.paramData.opengid
      },
      success: function (res) {
        console.log("entry/wxapp/SetGroupNumber ==>", res) 
        if (!res.data.errno) { 
          wx.showToast({
            icon:'none',
            title:'已成功设置群成员数！',
            duration: 1500
          })
          setTimeout(() => {
            wx.hideLoading();
            wx.navigateBack();
          }, 1500);
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
        that.setData({ 
          showAddUseSec: false
        })
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index; 
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    } 

    if (status == 'toDeleteImg') { 
      console.log("删除图片")
      let tmpData = that.data.tempFilePaths;
      let tmpUpData = that.data.tempFileImgs;
      tmpUpData.splice(index, 1);
      tmpData.splice(index, 1);
      that.setData({
        tempFilePaths: tmpData,
        tempFileImgs: tmpUpData,
        imgCountNum : 9 - tmpData.length
      })
    }
  },
  formSubmit: function (e) {
    var that = this;
    console.log(e, "eeeeeeee///////////")
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    var title = e.detail.value.title;
    var number = e.detail.value.number;
    var content = e.detail.value.content;
    that.toSaveFormIds(formId);
    if (status == 'toAddNews') {
      console.log("确定发布")
      if (that.data.status == 'news') {
        console.log("新建动态")
        if (!title) {
          wx.showToast({
            icon: 'none',
            title: '请填写名称！',
            duration: 1500
          })
          return false;
        }
        if (!content) {
          var message = '';
          if (that.data.status == 'news') {
            message = '请填写动态信息！'
          } else if (that.data.status == 'code') {
            message = '请填写自定义码信息！'
          }
          wx.showToast({
            icon: 'none',
            title: message,
            duration: 1500
          })
          return false;
        }
  
        // var tmpImg = that.data.tempFileImgs;
        // if (tmpImg.length < 1) {
        //   wx.showModal({
        //     title: '',
        //     content: '暂未选择图片，请选择图片！',
        //     showCancel: false,
        //     success: function (res) {
        //       if (res.confirm) {
        //       }
        //     }
        //   })
        //   return false;
        // }

        that.toAddNews(title,content);
      } else if (that.data.status == 'code') {
        console.log("自定义码")
        if (!title) {
          wx.showModal({
            title: '',
            content: '请填写自定义码标题！',
            showCancel: false,
            success: function (res) {
              if (res.confirm) {
              }
            }
          })
          return false;
        }
        that.toReleaseQr(title, content);
      } else if (that.data.status == 'group') {
        console.log("群成员数")
        if (!number) {
          wx.showToast({
            icon: 'none',
            title: '请填写群成员数！',
            duration: 1500
          })
          return false;
        }
        that.getSetGroupNumber(number);
      }
    }
  },
  toSaveFormIds: function (formId) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/formid',
      'cachetime': '30',
      
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
})