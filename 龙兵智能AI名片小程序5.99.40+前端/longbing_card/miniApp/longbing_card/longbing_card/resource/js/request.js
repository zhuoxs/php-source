
// 简单封装 微擎 类库 request 方法
var app = getApp();
function request(action, method, data) {
  if (!data) {
    data = {};
  }
  if (!data.m) {
    data.m = 'longbing_card';
  }
 
  return new Promise((resolve, reject)=>{
    app.util.request({
      'url': 'entry/wxapp/'+action, 
      'data': data,
      success: function (res) { 
        if (res.data.errno == 0) {
           resolve(res.data.data);
        }
        reject(res.data.message);
      },
      fail: function (res) {
        reject(((res.data && res.data.message) ? res.data.message: res.errMsg));
      },
      complete: function () {
      }
    });
  });
 

}

function iget(action, param) {
  return request(action, 'GET', param);
}

function ipost(action, param) {
  return request(action, 'POST', param);
}

export default {get:iget,post:ipost}
