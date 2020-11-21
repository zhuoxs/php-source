import WeCropper from '../../../templates/we-cropper/we-cropper.js'
var app = getApp()

const device = wx.getSystemInfoSync()
const width = device.windowWidth
const height = device.windowHeight - 50

Page({
  data: {
    cropperOpt: {
      id: 'cropper',
      width,
      height,
      scale: 2.5,
      zoom: 8,
      cut: {
        x: (width - width) / 2,
        y: (height - width) / 2,
        width: width,
        height: width
        // width: 400,
        // height: 400
      }
    }
  },
  touchStart (e) {
    this.wecropper.touchStart(e)
  },
  touchMove (e) {
    this.wecropper.touchMove(e)
  },
  touchEnd (e) {
    this.wecropper.touchEnd(e)
  },
  getCropperImage () {
    this.wecropper.getCropperImage((avatar) => {
      if (avatar) {
        //  获取到裁剪后的图片
        console.log('获取到裁剪后的图片',avatar,this.data.uploadUrl) 
       app.util.showLoading(3);
        this.toUploadImgs(avatar);
      } else {
        console.log('获取图片失败，请稍后重试')
        wx.showToast({
          icon:'none',
          title:'图片上传失败，请稍后重试！',
          duration: 2000
        })
      }
    })
  },
  toUploadImgs:function(avatar){
    var that = this;
    wx.uploadFile({
      url: this.data.uploadUrl,
      filePath: avatar,
      name: 'upfile',
      formData: {},
      // headers: {
      //   'Content-Type': 'application/octet-stream'
      // },
      success: function (res) {
        console.log(res, "******/////////////////////res")
        var tmpData = JSON.parse(res.data);
        var avatar = tmpData.data.path;
        var avatarImg = tmpData.data.img;
        var cardType = that.data.cardType;
        var paramstatus = that.data.paramstatus;
        wx.hideLoading();
        wx.redirectTo({
          url: `/longbing_card/staff/mine/editInfo/editInfo?avatar=${avatar}&avatarImg=${avatarImg}&cardtype=${cardType}&status=${paramstatus}`
        })
      },
      fail:function(res){
        wx.hideLoading();
        console.log('获取图片失败，请稍后重试')
        wx.showModal({
          title: '', 
          content: '图片上传失败，请稍后重试',
          confirmText: '重新上传',
          cancelText: '重新选择', 
          success:function(res){ 
            if (res.confirm) {
              var chooseImageAvatar = that.data.cropperOpt.src;
              that.toUploadImgs(chooseImageAvatar);
            } else if(res.cancel){ 
              console.log("wx.chooseImage ==>")
              that.uploadTap();
            }
          }
        });
      }
    })
  },
  uploadTap () {
    const self = this
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success (res) {
        const src = res.tempFilePaths[0]
        //  获取裁剪图片资源后，给data添加src属性及其值
        self.wecropper.pushOrign(src)
      },
      fail(res) {
        console.log("wx.chooseImage fail==>",res)
        wx.showModal({
          title: '',
          content: '获取图片失败，请稍后重试', 
          confirmText: '知道啦', 
          showCancel:false,
          success:function(res){ 
            if (res.confirm) { 
            } else if(res.cancel){  
            }
          }
        });
      }
    })
  },
  onLoad (option) {
    app.util.showLoading(1);
    const { cropperOpt } = this.data
     
    if (option.src) {
      cropperOpt.src = option.src
      new WeCropper(cropperOpt)
        .on('ready', (ctx) => {
          console.log(`wecropper is ready for work!`)
        })
        .on('beforeImageLoad', (ctx) => {
          console.log(`before picture loaded, i can do something`)
          console.log(`current canvas context:`, ctx)
          // wx.showToast({
          //   title: '上传中',
          //   icon: 'loading',
          //   duration: 20000
          // }) 
        })
        .on('imageLoad', (ctx) => {
          console.log(`picture loaded`)
          console.log(`current canvas context:`, ctx)
          // wx.hideToast()
        })
        .on('beforeDraw', (ctx, instance) => {
          console.log(`before canvas draw,i can do something`)
          console.log(`current canvas context:`, ctx)
        })
        .updateCanvas()
    } 
    
    var uploadUrl = app.util.url('entry/wxapp/upload');
    var nowPage = getCurrentPages();
    if (nowPage.length) {
      nowPage = nowPage[getCurrentPages().length - 1];
      if (nowPage && nowPage.__route__) {
        uploadUrl = uploadUrl + '&m=' + nowPage.__route__.split('/')[0];
      }
    }
    this.setData({
      uploadUrl: uploadUrl,
      cardType: option.cardtype,
      paramstatus: option.paramstatus,
      globalData: app.globalData
    })
    wx.hideLoading();
  }
})
