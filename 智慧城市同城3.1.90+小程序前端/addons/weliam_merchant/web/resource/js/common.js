var common = {};
//获取后台链接信息 一
common.webUrl = function(routes, params,complete = false){
    if(!routes){ console.log('请求地址不能为空');return false;}
    var strs = [],url;
    strs = routes.split("/");
    if(complete){
        let http = window.location.href.split("web");
        url = http[0]+'/web/agent.php?p=' + strs[0] + '&ac=' + strs[1] + '&do=' + strs[2];
    }else{
        url = './web/agent.php?p=' + strs[0] + '&ac=' + strs[1] + '&do=' + strs[2];
    }
    if(params) {
        if(typeof(params) == 'object') {
            url += "&" + common.toQueryString(params)
        } else if(typeof(params) == 'string') {
            url += "&" + params
        }
    }
    return url;
};
//获取移动端链接信息 一
common.appUrl = function(routes, params,complete = false){
    var strs = [],url;
    strs = routes.split("/");
    if(complete){
        let http = window.location.href.split("web");
        url = http[0]+'app/index.php?i=' + window.sysinfo.uniacid + '&c=entry&m=weliam_merchant&p=' + strs[0] + '&ac=' + strs[1] + '&do=' + strs[2];
    }else{
        url = './index.php?i=' + window.sysinfo.uniacid + '&c=entry&m=weliam_merchant&p=' + strs[0] + '&ac=' + strs[1] + '&do=' + strs[2];
    }
    if(params) {
        if(typeof(params) == 'object') {
            url += "&" + common.toQueryString(params)
        } else if(typeof(params) == 'string') {
            url += "&" + params
        }
    }
    return url;
};
//获取链接信息 二
common.toQueryString  = function(obj) {
    var ret = [];
    for (var key in obj) {
        key = encodeURIComponent(key);
        var values = obj[key];
        if (values && values.constructor == Array) {
            var queryValues = [];
            for (var i = 0, len = values.length, value; i < len; i++) {
                value = values[i];
                queryValues.push(common.toQueryPair(key, value))
            }
            ret = concat(queryValues)
        } else {
            ret.push(common.toQueryPair(key, values))
        }
    }
    return ret.join('&')
};
//获取链接信息 三
common.toQueryPair  = function(key, value) {
    if (typeof value == 'undefined') {
        return key
    }
    return key + '=' + encodeURIComponent(value === null ? '' : String(value))
};
//复制链接信息
common.copyLink = function () {
    require(['jquery.zclip'], function() {
        $('.js-clip').each(function() {
            var text = $(this).data('text') || $(this).data('href') || $(this).data('url');
            $(this).zclip({
                path: './resource/components/zclip/ZeroClipboard.swf',
                copy: text,
                afterCopy: function() {
                    tip.msgbox.suc('复制成功')
                }
            });
            this.clip = true
        })
    })
};
common.getUrlParam = function(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

/**
 * vue公共方法
 */
var commonVue = new Vue({
    el: '',
    data: {
        demo:'调用成功',
    },
    methods: {
        //ajax请求
        requestAjax(path,params,returnType = false){
            let result,
                url = common.webUrl(path,'',true);
            $.ajax({
                type: "POST",
                url: url,
                data:params,
                dataType: "json",
                async: false,
                success: function (data) {
                    if(returnType){
                        result = data;
                    }else{
                        result = data['data'];
                    }
                },
                error: function (errors) {
                    console.log("请求失败");
                }
            });
            return result;
        },
        //获取拥有的模块信息
        getModular(){
            let res = commonVue.requestAjax('goods/Goods/getModular',{page:this.page});
            return res;
        },
    },
    watch: {},
});