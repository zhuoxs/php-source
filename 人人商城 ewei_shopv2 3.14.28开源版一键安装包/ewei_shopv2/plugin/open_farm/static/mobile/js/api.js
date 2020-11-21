$.extend({
    http:function (http,met,url,prams,cb) {
       http({
            method:met,
            url:'/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&'+url,
            data:prams
        }).then(function successCallback(res) {
            cb(res.data)
        }, function errorCallback(res) {
            console.log(res)
        })
    },



    // 获取心情列表
    getInfo:function(http,prams,cb){
        $.http(http,'POST','r=open_farm.mood.getInfo',prams,cb)
    }
});
