var Fly = require("./wx.js") //wx.js为您下载的源码文件
var fly = new Fly; //创建fly实例
var tokenFly = new Fly();
import util from './xx_util.js';
import siteInfo from '../../../siteinfo.js';
var model_name = "longbing_card";
var tmpUrl = `${siteInfo.siteroot}?i=${siteInfo.uniacid}&t=${siteInfo.multiid}&v=${siteInfo.version}&from=wxapp&c=entry&a=wxapp&m=${model_name}&do=`


//添加finally方法
Promise.prototype.finally = function (callback) {
    let P = this.constructor;
    return this.then(
        value => P.resolve(callback()).then(() => value),
        reason => P.resolve(callback()).then(() => { throw reason })
    );
};

//设置超时

fly.config.timeout = 15000;
//设置请求基地址

//给所有请求添加自定义header
fly.config.headers = tokenFly.config.headers = {
    "content-type": "application/x-www-form-urlencoded"
}

//添加请求拦截器
fly.interceptors.request.use((request) => { 

    if (!request.body) {
        request.body = {}
    }
    let userid = wx.getStorageSync('userid');

    if (!userid) {
        fly.lock()
        return new Promise((resove, reject) => {
            //登陆
            wx.login({
                success: function (res) {
                    let code = res.code;
                    if (code) {
                        //发起网络请求
                        resove(code)
                        
                    console.log("登录成功")
                    } else {
                        console.log('登录失败！')
                    }
                }, fail: function () {
                    console.log('登录失败！')
                }
            });
        }).then((code) => {
            var loginUrl = tmpUrl + 'login';
            let loginParam = {
                code: code,
            }
            return tokenFly.post(loginUrl, loginParam)

        }).then((d) => { 
            var app = getApp();
            let userid = d.data.user_id;
            let user = d.data.user; 
            if(user){
                wx.setStorageSync("user",user);
                if(user.phone){
                    app.globalData.hasClientPhone = true
                }
            }
            request.body["user_id"] = userid;
            app.globalData.userid = userid;
            wx.setStorageSync("userid", userid);//保存uid
        }).finally(() => {

            fly.unlock();//解锁后，会继续发起请求队列中的任务，详情见后面文档
            //关联
            // let pid = wx.getStorageSync('pid')
            // if (pid) {

            //   fly.post("api.member/save", { pid }).then(() => {
            //     //util.showModal({ content: "关联上下级成功" })
            //   })
            // }
        }).then(() => {
            return fly.request(request); //只有最终返回request对象时，原来的请求才会继续
        });
    } else {
        request.body.user_id = userid;
    }
})

//添加响应拦截器，响应拦截器会在then/catch处理之前执行
tokenFly.interceptors.response.use(
    (response) => {
        //只将请求结果的data字段返回
        util.hideAll()
        if(response.data.errno == -2){ 
            util.showModal({ content: response.data.message })
        }
        return response.data;

    },
    (err) => {
        //发生网络错误后会走到这里
        util.hideAll();
        // util.networkError({ msg: '服务器开小差了' });
    }
) 
fly.interceptors.response.use(
    (response) => {
        //只将请求结果的data字段返回
        util.hideAll()
        if(response.data.errno == -2){
            util.showModal({ content: response.data.message })
        }
        return response.data;

    },
    (err) => {
        //发生网络错误后会走到这里
        util.hideAll();
        // util.networkError({ msg: '服务器开小差了' });
    }
)

const uploadFile = (url, { name = "file", filePath, formData = { type: "picture" } } = {}) => {
 
    url = tmpUrl + `${url}`; 
    return new Promise((resove, reject) => {
        wx.uploadFile({
            url,
            filePath,
            name,
            header: {
            },
            formData,
            success: function (res) {
                if (res.statusCode == 200) {
                    let data = JSON.parse(res.data)
                    if (data.errno == 0) {
                        resove(data.data)
                    } else {
                        util.showModal({ content: "上传失败" })
                    }
                } else {
                    util.showModal({ content: "上传失败" })
                }
            },
            fail: function (res) {
                util.showModal({ content: "上传失败" })
                wx.hideLoading();
            },
            complete: function (res) { },
        })
    })
}
//统一处理报错时，不再往下执行
const req = {

    post(url, param) {
        url = tmpUrl + `${url}`;
        return new Promise((resove, reject) => {
            fly.post(url, param).then((d) => {
                if (d.errno == 0) {
                    resove(d)
                } else if(d.errno == -2){
                    util.showModal({ content: d.message })
                } else { 
                    // util.showModal({ content: d.message })
                }
            })
        })
    },
    get(url, param) {
        url = tmpUrl + `${url}`;
        return new Promise((resove, reject) => {
            fly.get(url, param).then((d) => {
                if (d.errno == 0) {
                    resove(d) 
                } else if(d.errno == -2){
                    util.showModal({ content: d.message })
                } else {
                    // util.showModal({ content: d.message })
                }
            })
        })
    }
}
export { tmpUrl ,fly, req, uploadFile }