
var app = getApp()
const recorderManager = wx.getRecorderManager(); 
const innerAudioContext = wx.createInnerAudioContext();
Page({
  data: {
    cardTypeImgList:['http://retail.xiaochengxucms.com/images/12/2018/11/Yg7rq8Y1CBi2S1R7s2c22TEcqrshCT.png','http://retail.xiaochengxucms.com/images/12/2018/11/nR22ZLhs8lQoX77DQX1fJ97fc7Ryzl.png'],
    cardTypeList:['cardType1','cardType2'],
    cardTypeIndex:0, 
    job: -1,
    company: -1,
    firstCreate: 0,
    playPushStatus: 1,
    startPushStatus: 1,
    recordAuthMethod: 2,
    globalData: {},
    uploadUrl: '',
    imgCountNum: 9,
    tempRecordFilePath: '',
    tempRecordFileTime: '',
    recordStatusText: '开始录音 按住说话',
    staffInfo: {
      images: []
    },
    currentIndex: 0,
    staffInfoAvatar: '',
    staffInfoImages: [],
    recordStatus: true,
    icon_voice_png:'http://retail.xiaochengxucms.com/images/12/2018/11/IgvvwVNUIVn6UMh4Dmh4m6nM4Widug.png',
    icon_voice_gif:'http://retail.xiaochengxucms.com/images/12/2018/11/CRFPPPTKf6f45J6H3N44BNCrjbFZxH.gif',
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    // <!-- {{startPushStatus == 1 ? '开始' : '停止'}}录音 -->

    app.util.showLoading(1);
    wx.hideShareMenu(); 

    // that.getCheckAuthRecord(); 
    that.getStaffCard(options);

    var tmpRecordStatusText = '';
    if (that.data.staffInfo.voice) {
      tmpRecordStatusText = '重新录音 按住说话'
    } else if (!that.data.staffInfo.voice) {
      tmpRecordStatusText = '开始录音 按住说话'
    }

    var uploadUrl = app.util.url('entry/wxapp/upload');
    var nowPage = getCurrentPages();
    if (nowPage.length) {
      nowPage = nowPage[getCurrentPages().length - 1];
      if (nowPage && nowPage.__route__) {
        uploadUrl = uploadUrl + '&m=' + nowPage.__route__.split('/')[0];
      }
    }
    
    var tmpCompanyID = 0;
    if(app.globalData.configInfo.my_company){
      for(let i in app.globalData.configInfo.company_list){
        if(app.globalData.configInfo.my_company.id == app.globalData.configInfo.company_list[i].id){
          tmpCompanyID = i 
        }
      }
    }
    if(options.status){
      that.setData({
        paramStatus: options.status
      })
    }
    that.setData({
      recordStatusText: tmpRecordStatusText,
      uploadUrl: uploadUrl,
      company: tmpCompanyID,
      globalData: app.globalData
    })
   // console.log(that.data.company,"////////////**company")
   wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
    var that = this;

    if (that.data.recordAuthMethod == 1) {

      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.record']) {
            console.log('onshow已经授权')
            that.setData({
              recordAuthMethod: 2
            })
          } else {
            that.setData({
              recordAuthMethod: 1
            })
          }
        },
        fail: function (res) {
          console.log('onshow未授权')
          that.setData({
            recordAuthMethod: 1
          })
        }
      })

      var tmpRecordStatusText = '';
      if (that.data.staffInfo.voice) {
        if (that.data.recordAuthMethod == 1) {
          tmpRecordStatusText = '重新录音 按住说话'
        } else if (that.data.recordAuthMethod == 2) {
          tmpRecordStatusText = '重新录音 按住说话'
        }
      } else if (!that.data.staffInfo.voice) {
        if (that.data.recordAuthMethod == 1) {
          tmpRecordStatusText = '开始录音 按住说话'
        } else if (that.data.recordAuthMethod == 2) {
          tmpRecordStatusText = '开始录音 按住说话'
        }
      }
      that.setData({
        recordStatusText: tmpRecordStatusText
      })
    }
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")
    let that = this;
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
    var that = this;
  },
  bindInputName:function(e){
    var that = this;
    that.setData({
      'tmpCardData.name': e.detail.value
    })
  },
  bindInputPhone:function(e){
    var that = this; 
    that.setData({
      'tmpCardData.phone': e.detail.value
    })
  },
  bindInputEmail:function(e){
    var that = this;
    that.setData({
      'tmpCardData.email': e.detail.value
    })
  },
  pickerSelected: function (e) {
    let that = this;
    let status = e.currentTarget.dataset.status;
    if (status == 'job') {
      var tmpJob = that.data.staffInfo.jobList;
      that.setData({
        job: e.detail.value,
        'tmpCardData.job_name': tmpJob[e.detail.value].name
      })
    }
    if (status == 'address') {
      var tmpCompany = that.data.globalData.configInfo.company_list;
      that.setData({
        company: e.detail.value,
        'tmpCardData.logo': tmpCompany[e.detail.value].logo,
        'tmpCardData.company_addr': tmpCompany[e.detail.value].addr,
        'tmpCardData.company_name': tmpCompany[e.detail.value].name,
        'tmpCardData.company_short_name': tmpCompany[e.detail.value].short_name,
      })
    }
  },
  getStaffCard: function (options) {
    var that = this; 
    wx.showLoading({
      title: '加载中'
    })
    app.util.request({
      'url': 'entry/wxapp/StaffCard',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        // console.log("entry/wxapp/StaffCard ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data.count;

          let tmpImgPath = that.data.staffInfoImages;
          for (let j in tmpData.images) {
            if (!tmpData.images[j]) {
              tmpData.images.splice(j, 1)
            }
            if (tmpData.images.length > 0) {
              tmpImgPath.push(tmpData.images[j])
            }
          }

          var firstCreate = 0;
          if (!tmpData.id) {
            firstCreate = 1
          } 
          console.log(firstCreate,"**********///0000")

          var tmpAvatarImg = '';
          if(options.avatar){
            tmpData.avatar = options.avatar
            tmpAvatarImg = options.avatarImg
            tmpData.card_type = options.cardtype
          }  

          var tmpCompany = that.data.globalData.configInfo.my_company;
          if(!tmpCompany){
            tmpCompany = that.data.globalData.configInfo.company_list[0];
          }

          if (!tmpData.card_type) {
            tmpData.card_type = 'cardType1'
          }
          
          var tmpCardData = {
            logo: tmpCompany.logo,
            company_name: tmpCompany.name,
            company_short_name: tmpCompany.short_name,
            company_addr: tmpCompany.addr,
            avatar: tmpData.avatar,
            default: app.globalData.defaultUserImg,
            defaultLogo: app.globalData.logoImg,
            name: tmpData.name,
            phone: tmpData.phone,
            email: tmpData.email,
            job_name: res.data.data.job_list[res.data.data.job_index].name,
          };


          that.setData({
            firstCreate: firstCreate, 
            tmpCardData: tmpCardData,
            job: res.data.data.job_index,
            staffInfoImages: tmpImgPath,
            staffInfo: tmpData,
            cardTypeIndex: parseInt(tmpData.card_type.split('cardType')[1]) - 1,
            'staffInfo.jobList': res.data.data.job_list,
            staffInfoAvatar: tmpAvatarImg,
            imgCountNum: 9 - tmpImgPath.length
          })
         // wx.hideLoading();
        }

      },
      fail: function (res) {
        console.log("fail ==> ", res)
        if(res.data.errno == -1){
          that.setData({
            firstCreate: 1
          })
          console.log(that.data.firstCreate,"**********///111")
        }
      }
    })
  },
  toEditStaff: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/EditStaffV2',
      // 'url': 'entry/wxapp/EditStaff',
      'cachetime': '30',
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        // console.log("entry/wxapp/EditStaff ==>", res)
        if (!res.data.errno) {
          app.globalData.configInfo = false;
          getApp().getConfigInfo().then(() => {
            that.setData({ 
              globalData: app.globalData
            }, function () {
              console.log(that.data.paramStatus,message,"11111111111111")
              var message = '名片修改成功！';
              if (that.data.paramStatus == 'createCard' && that.data.firstCreate == 1) {
                console.log(that.data.paramStatus,that.data.firstCreate,"00000000000")
                message = '名片创建成功，请等待管理人员审核！'
              }
              console.log(message,that.data.paramStatus,that.data.firstCreate,"11111111111111")
               // wx.hideLoading();
                wx.showToast({
                  icon: 'none',
                  title: message,
                  duration: 2000,
                  success: function () {
                    setTimeout(function () {
                      wx.hideToast();
                      if(that.data.paramStatus == 'createCard'){
                        wx.reLaunch({
                          url: '/longbing_card/pages/index/index?currentTabBar=cardList&paramStatus=createCard'
                        })
                      } else {
                        wx.navigateBack();
                      }
                    }, 3000)
                  }
                }) 
              })
            })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/EditStaff ==>fail ==> ", res)
      }
    })
  },
  chooseImage: function () {
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
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    });
  },
  chooseWxImageShop: function (type) {
    var that = this;
    var tmpPath = that.data.staffInfo.images;
    var tmpImg = that.data.staffInfoImages;
    var tmpCount = that.data.imgCountNum; 
    wx.chooseImage({
      count: tmpCount,
      sizeType: ['original', 'compressed'],
      sourceType: [type],
      success: function (res) {
        // console.log(res, "===========================  res****")
        for (let i in res.tempFilePaths) {
          console.log(res.tempFilePaths[i], "****************//res.tempFilePaths[i]");
        
          app.util.showLoading(3);
          wx.uploadFile({
            url: that.data.uploadUrl,
            filePath: res.tempFilePaths[i],
            name: 'upfile',
            formData: {},
            success: function (res) {
              console.log(res, "******/////////////////////res")
              var tmpData = JSON.parse(res.data); 
              tmpPath.push(tmpData.data.path);
              tmpImg.push(tmpData.data.img); 
              wx.hideLoading();
              that.setData({
                'staffInfo.images': tmpPath,
                staffInfoImages: tmpImg,
                imgCountNum: 8 - tmpPath.length
              })
              
              } 
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
        wx.hideLoading();
      }
    })
  },
  getCheckAuthRecord() {
    var that = this;
    wx.authorize({
      scope: 'scope.record',
      success(res) {
        console.log('getCheckAuthRecord 授权成功')
        that.setData({
          recordAuthMethod: 2
        })
      },
      fail() {
        that.setData({
          recordAuthMethod: 1
        })
      }
    })

    var tmpRecordStatusText = '';
    if (that.data.staffInfo.voice) {
      if (that.data.recordAuthMethod == 1) {
        tmpRecordStatusText = '重新录音 按住说话'
      } else if (that.data.recordAuthMethod == 2) {
        tmpRecordStatusText = '重新录音 按住说话'
      }
    } else if (!that.data.staffInfo.voice) {
      if (that.data.recordAuthMethod == 1) {
        tmpRecordStatusText = '开始录音 按住说话'
      } else if (that.data.recordAuthMethod == 2) {
        tmpRecordStatusText = '开始录音 按住说话'
      }
    }

    that.setData({

      recordAuthMethod: tmpRecordStatusText
    })


  },
  startRecord: function () {
    let that = this
    wx.getSetting({
      success: function (res) {
        if (res.authSetting['scope.record']) {
          console.log('startRecord 已经授权')
          that.toStartRecord();
        } else {
          // that.setData({
          //   recordAuthMethod: 1
          // })
          that.getCheckAuthRecord();
          console.log("getCheckAuthRecord")
        }
      },
      fail: function (res) {
        that.getCheckAuthRecord();
        console.log("getCheckAuthRecord")
        // that.setData({
        //   recordAuthMethod: 1
        // })
      }
    })
  },
  //松开按钮
  stopRecord_get: function () {
    var that = this;
    wx.getSetting({
      success(res) {
        if (res.authSetting['scope.record']) {
          that.stopRecord();
        }
      }
    })
  },
  toStartRecord: function () {
    var that = this;
    const options = {
      duration: 60000,//指定录音的时长，单位 ms
      sampleRate: 16000,//采样率
      numberOfChannels: 1,//录音通道数
      encodeBitRate: 96000,//编码码率
      format: 'mp3',//音频格式，有效值 aac/mp3
      frameSize: 50,//指定帧大小，单位 KB
    }
    console.log(recorderManager, "recorderManager")
    //开始录音
    that.setData({
      showTostImg: true
    })
    recorderManager.start(options);
    recorderManager.onStart(() => {
      console.log('recorder start')
      // wx.showToast({
      //   icon: '',
      //   image: '/longbing_card/resource/images/speak.gif',
      //   title: '松开结束',
      //   duration:60000
      // })
    });

    var tmpRecordStatusText = '';
    if (that.data.staffInfo.voice) {
      tmpRecordStatusText = '重新录音 松开结束'
    } else if (!that.data.staffInfo.voice) {
      tmpRecordStatusText = '开始录音 松开结束'
    }

    that.setData({
      tmpRecordStatusText: tmpRecordStatusText
    })
    //错误回调
    recorderManager.onError((res) => {
      console.log(res);
    })
  },
  stopRecord: function () {
    var that = this;
    recorderManager.stop();
    recorderManager.onStop((res) => {
      console.log(res, "recorder onStop")
      that.setData({
        'staffInfo.voice': res.tempFilePath,
        'staffInfo.voice_time': (res.duration / 1000).toFixed(0),
        showTostImg: false
      })

      console.log("staffInfo.voice", that.data.staffInfo.voice)
    })
    that.setData({
      startPushStatus: 1
    })
  },
  toUploadRecord(cb) {
    var that = this;
    // console.log(that.data.tempRecordFilePath, "tempRecordFilePath") 
    if (that.data.staffInfo.voice.indexOf('wxfile://') == -1) {
      cb && cb();
      return;
    }

   // wx.hideLoading();
    wx.uploadFile({
      url: that.data.uploadUrl,
      filePath: that.data.staffInfo.voice,
      name: 'upfile',
      formData: {
      },
      success: function (res) {
        console.log(res, "******/////////////////////res", that.data.tempRecordFileTime)
        var tmpData = JSON.parse(res.data);
        that.setData({
          'staffInfo.voice': tmpData.data.path,
          staffInfoVoice: tmpData.data.img,
        })

        cb && cb();

      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toEditStaff') {
      console.log("修改名片信息")

      var paramObj = e.detail.value;

      that.toUploadRecord(function () {
        // wx.showLoading();
        console.log("wx.showLoading  wx.hideLoading  wx.showToast",paramObj)
        if (!paramObj.name) {
          console.log('姓名:',paramObj.name)
         // wx.hideLoading();
          wx.showToast({
            icon:'none',
            title:'请填写姓名！',
            duration : 2000,
            success: function () {
              setTimeout(function () {
                wx.hideToast();
              }, 3000)
            } 
          })
          return false;
        }
        if (!paramObj.phone) {
          console.log('手机号:',paramObj.phone)
         // wx.hideLoading();
          wx.showToast({
            icon:'none',
            title:'请填写手机号！', 
            duration : 2000,
            success:function(){
              setTimeout(function () {
                wx.hideToast();  
              }, 3000)
            }
          })
          return false;
        }

        var tmpUpData = that.data.staffInfoImages;
        var tmpData = that.data.staffInfo.images;
        var tmpImages = '';
        var tmpAvatar = '';
        var tmpVoice = '';

        if (tmpUpData.length > 0) {
          for (let i in tmpUpData) {
            tmpImages += (tmpUpData[i] + ',')
          }
        } else {
          for (let i in tmpData) {
            tmpImages += (tmpData[i] + ',')
          }
        }

        if (!that.data.staffInfoAvatar) {
          tmpAvatar = that.data.staffInfo.avatar
        } else {
          tmpAvatar = that.data.staffInfoAvatar
        }
        if (!that.data.staffInfoVoice) {
          tmpVoice = that.data.staffInfo.voice
        } else {
          tmpVoice = that.data.staffInfoVoice
        }

        let tmpJob = '';
        if (that.data.job < 0) {
         // wx.hideLoading();
          tmpJob = '';
          wx.showToast({
            icon:'none',
            title:'请选择职称！',
            duration: 2000,
            success:function(){
              setTimeout(function () {
                wx.hideToast();  
              }, 3000)
            }
          }) 
          return false;
        } else {
          tmpJob = that.data.staffInfo.jobList[that.data.job].id;
        }

        var tmpGlobalC = that.data.globalData.configInfo.company_list;
        var tmpCompanyID = tmpGlobalC[that.data.company].id;

        tmpImages = tmpImages.slice(0, -1);
        paramObj.avatar = tmpAvatar;
        paramObj.voice = tmpVoice;
        paramObj.voice_time = that.data.staffInfo.voice_time;
        paramObj.images = tmpImages;
        paramObj.job_id = tmpJob;
        paramObj.company_id = tmpCompanyID;
        paramObj.card_type = that.data.staffInfo.card_type;
        console.log(paramObj, "///////////**********")



        that.toEditStaff(paramObj);

      });

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
  },
  upload () {
    var that = this;
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success (res) {
        const src = res.tempFilePaths[0] 
        const cardType = that.data.staffInfo.card_type
        const paramstatus = that.data.paramStatus
        wx.redirectTo({
          url: `/longbing_card/staff/mine/upload/upload?src=${src}&cardtype=${cardType}&paramstatus=${paramstatus}`
        })
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var type = e.currentTarget.dataset.type;
 
      if(status == 'toCopyright'){
        app.util.goUrl(e)
      }
 

    if (status == 'toCardType') {
      var tmpData = that.data.cardTypeList;
      that.setData({ 
        cardTypeIndex: index,
        'staffInfo.card_type':  tmpData[index]
      })
    } else if (status == 'toUpload') {
      console.log("修改头像 || 图片展示") 
      if(type == 'toAvatar'){
        that.upload();
      } else if(type == 'toImages'){
        that.chooseImage();
      }
    } else if (status == 'toVoice') {
      if (type == 1) {
        console.log("语音播放 playBackgroundAudio", that.data.staffInfo.voice)
        innerAudioContext.autoplay = true
        var voiceSrc = that.data.staffInfo.voice;
        if (!voiceSrc) {
         // wx.hideLoading();
          wx.showToast({
            icon: 'none',
            title: '暂未上传语音！',
            duration: 2000,
            success:function(){
              setTimeout(function () {
                wx.hideToast(); 
                return false;
              }, 3000)
            }
          })
          setTimeout(() => {
            return false;
          }, 3000);
        } else {
          innerAudioContext.src = voiceSrc;
        }
        innerAudioContext.play(() => {
          console.log('开始播放')
        })
        that.setData({
          playPushStatus: 2
        });
      }
      if (type == 2) {
        // console.log("语音播放 pauseBackgroundAudio")
        innerAudioContext.pause(() => {
          console.log('暂停播放')
        })
        that.setData({
          playPushStatus: 1
        });
      }
    } else if (status == 'toDeleteImg') { 
      console.log("删除图片")
      let tmpData = that.data.staffInfo.images;
      let tmpUpData = that.data.staffInfoImages;
      tmpUpData.splice(index, 1);
      tmpData.splice(index, 1);
      that.setData({
        'staffInfo.images': tmpData,
        staffInfoImages: tmpUpData,
        imgCountNum: 8 - tmpData.length
      })
    }

    innerAudioContext.onEnded(() => {
      console.log('音频自然播放结束事件')
      that.setData({
        playPushStatus: 1
      });
    })
  }
})