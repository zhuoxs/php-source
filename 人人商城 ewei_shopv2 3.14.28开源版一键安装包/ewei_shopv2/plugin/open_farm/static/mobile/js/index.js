// index.js
var app = angular.module("myapp", []);
app.controller('farm',
    [
        '$scope',
        '$http',
        function ($scope, $http) {
            // 背景颜色
            $scope.colors = [
                {"background-color": "#d57e8c", "color": "#d57e8c"},
                {"background-color": "#f1ba98", "color": "#f1ba98"},
                {"background-color": "#b3da9d", "color": "#b3da9d"},
                {"background-color": "#afbbd3", "color": "#afbbd3"}
            ];
            $scope.change_num = 0;
            $scope.newlist = [];
            $scope.userInfo = {};
            $scope.friendlist = [];
            $scope.repotlist = [];
            $scope.moodpram = {
                'background': '',
                'picture': '',
                'autograph': '',
            };
            $scope.presentation = [];
            $scope.loading = function (title) {
                $('body').loading({
                    loadingWidth: 120,
                    title: title,
                    name: 'test',
                    discription: '',
                    direction: 'column',
                    type: 'origin',
                    originDivWidth: 40,
                    originDivHeight: 40,
                    originWidth: 6,
                    originHeight: 6,
                    smallLoading: false,
                    loadingMaskBg: 'rgba(0,0,0,0.2)'
                });
            };
            // 切换心情场景
            $scope.exhibition = 0;
            $scope.show_img = function (index) {
                $scope.exhibition = index;
                $('.img_browse').children().eq(index).addClass('img_bor').siblings().removeClass('img_bor');
                $scope.moodpram.picture = $scope.mood.picture_list[$scope.exhibition].picture;
            };
            $scope.clo_mood=function () {
                $scope.exhibition = 0;
                $(".bg-model").hide();
                //显示窗体的滚动条
                $("body").css({"overflow": "visible"});
            };
            var url = window.location.href;
            url = url.replace(/^https:\/\/[^/]+/, "");
            url = url.split('&r')[0];
            // 正则获取i值
            $scope.getUrlParams = function (name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); //定义正则表达式
                var r = window.location.search.substr(1).match(reg);
                if (r != null) return unescape(r[2]);
                return null;
            };
            var i = $scope.getUrlParams('i');
            // 获取农场配置
            $scope.allocation = {};
            $scope.configure = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.configure.getInfo'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            if (data.data.data.name && data.data.data.name !== "null") {
                                document.title = data.data.data.name;
                                $scope.allocation = data.data.data;
                                if(data.data.data.force_follow == 1){
                                    $('.qrcode_box').css('bottom','15%');
                                }
                                localStorage.setItem('config', JSON.stringify(data.data.data));
                                wx.ready(function () {
                                    sharedata = {
                                        title: $scope.allocation.title,
                                        desc: $scope.allocation.describe,
                                        link: $scope.allocation.url,
                                        imgUrl: $scope.allocation.show_logo,
                                        success: function () {
                                        },
                                        cancel: function () {
                                        }
                                    };
                                    wx.onMenuShareAppMessage(sharedata);
                                });
                            } else {
                                document.title = "人人农场"
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.configure();
            // 获取用户信息
            $scope.we_Info = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.user.getInfo'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            if (data.data.data.follow == "0") {
                                $(".bg-model_qrcode").fadeTo(300, 1);
                                $("body").css({"overflow": "hidden"});
                            } else {
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };

            $scope.we_Info();
            // 商城
            $scope.mall_url = '';
            $scope.farmset = {};
            $scope.mall = function () {
                $scope.loading('');
                $http.post(
                    url + '&r=open_farm.seting.getInfo',
                    {}
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.mall_url = data.data.data.shop;
                            $scope.farmset = data.data.data;
                            // 下蛋需要吃多少克
                            if($scope.userInfo.lay_eggs_eat!=0&&$scope.userInfo.lay_eggs_eat){
                                var num_egg = parseFloat($scope.userInfo.lay_eggs_sum) / parseFloat($scope.userInfo.lay_eggs_eat);
                                if (isNumber(num_egg)) {
                                    $('.result').css("width", parseInt($scope.userInfo.lay_eggs_sum) / parseInt($scope.userInfo.lay_eggs_eat) * 100 + '%');
                                    if (parseInt(num_egg * 100)>100){
                                        $('.result_text').html('99%');
                                    } else{
                                        $('.result_text').html(parseInt(num_egg * 100) + '%');
                                    }
                                } else {
                                    $('.result').css("width", 0);
                                    $('.result_text').html('0%');
                                }
                            }else{
                                var num_egg = parseFloat($scope.userInfo.lay_eggs_sum) / parseFloat(data.data.data.lay_eggs_eat);
                                if (isNumber(num_egg)) {
                                    $('.result').css("width", parseInt($scope.userInfo.lay_eggs_sum) / parseInt(data.data.data.lay_eggs_eat) * 100 + '%');
                                    if (parseInt(num_egg * 100)>100){
                                        $('.result_text').html('99%');
                                    } else{
                                        $('.result_text').html(parseInt(num_egg * 100) + '%');
                                    }
                                } else {
                                    $('.result').css("width", 0);
                                    $('.result_text').html('0%');
                                }
                            }
                            removeLoading('test');
                        }
                    },
                    function () {
                    });
            };
            $scope.mall();
            // 获取用户鸡的信息
            var is_first = true;
            $scope.getuserInfo = function () {
                // $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.getInfo'
                ).then(
                    function (result) {
                        if (result.data.code === 1) {
                            $scope.userInfo = result.data.data;
                            if (is_first) {
                                $scope.mall();
                                is_first = false
                            } else {
                                var num_egg = parseFloat(result.data.data.lay_eggs_sum) / parseFloat(result.data.data.lay_eggs_eat);
                                if (isNumber(num_egg)) {
                                    if (parseInt(num_egg * 100)>100){
                                        $('.result_text').html('99%');
                                    } else{
                                        $('.result_text').html(parseInt(num_egg * 100) + '%');
                                    }
                                    $('.result').css("width", num_egg * 100 + '%');
                                } else {
                                    $('.result').css("width", 0);
                                    $('.result_text').html('0%');
                                }
                            }
                        }
                    },
                    function () {
                    });
            };
            $scope.getuserInfo();
            // 点鸡说话
            $scope.speak_index = -1;
            var clock = true;
            $scope.prompt = true;
            $scope.speak = function () {
                if (!$scope.prompt) {
                    return false;
                }
                if ($scope.talking.length == 0) {
                    return false;
                }
                if (!clock) {
                    return false;
                }
                clock = false;
                $scope.speak_index++;
                if ($scope.speak_index === $scope.talking.length) {
                    $scope.speak_index = 0
                }
                $('.wrap').fadeIn(1000, function () {
                    $this = $(this);
                    setTimeout(function () {
                        $this.fadeOut(4000, function () {
                            clock = true;
                        })
                    }, 700);
                });
            };
            $scope.talking = [];

            // 获取鸡说话的内容
            $scope.chicken_content = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.reply.getList'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.talking = data.data.data;
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.chicken_content();
            // 时间转换 **时**分**秒
            $scope.exchange = function (second) {
                second=second/1000;
                var dd, hh, mm, ss;
                var Surplus = '000';
                second = typeof second === 'string' ? parseInt(second) : second;
                if (!second || second < 0) {
                    return;
                }
                if (second.toString().indexOf('.') != -1) {
                    Surplus = second.toString().split('.')[1];
                    Surplus = Math.floor(Surplus/10);
                    if (Surplus<10) {
                        Surplus = Surplus + '0'
                    }
                } else {
                    Surplus = '00'
                }
                //天
                dd = second / (24 * 3600) | 0;
                second = Math.floor(second) - dd * 24 * 3600;
                //小时
                hh = second / 3600 | 0;
                second = Math.floor(second) - hh * 3600;
                //分
                mm = second / 60 | 0;
                //秒
                ss = Math.floor(second) - mm * 60;
                if (Math.floor(dd) < 10) {
                    dd = dd > 0 ? '0' + dd : '';
                }
                if (Math.floor(hh) < 10) {
                    hh = '0' + hh;
                }
                if (Math.floor(mm) < 10) {
                    mm = '0' + mm;
                }
                if (Math.floor(ss) < 10) {
                    ss = '0' + ss;
                }
                var text = '';
                if (Surplus) {
                    ss = ss + '.' + Surplus
                }
                if (dd) {
                    text = dd + '天' + hh + '时' + mm + '分' + ss + '秒';
                } else {
                    text = hh + '时' + mm + '分' + ss + '秒';
                }
                return "进食剩余" + text;
            };
            // 计算鸡吃饲料结束时间 （开始时间，需要吃多少时间）
            $scope.time_exchange = function (myDate,second) {
                var  ss;
                var Surplus = '00';
                second = typeof second === 'string' ? parseInt(second) : second;
                if (!second || second < 0) {
                    return;
                }
                if (second.toString().indexOf('.') != -1) {
                    Surplus = second.toString().split('.')[1];
                    if (Surplus.length === 1) {
                        Surplus = Surplus + '0'
                    }
                    ss=second.toString().split('.')[0];

                } else {
                    Surplus = '00';
                    ss=second;
                }
                Surplus= Math.floor(parseFloat('0.'+Surplus)*1000);
                myDate.setMilliseconds(myDate.getMilliseconds()+Surplus);
                myDate.setSeconds(myDate.getSeconds()+parseInt(ss));
                return myDate.valueOf();
            };

            $scope.go_mall = function () {
                location.href = $scope.mall_url;

            };
            // 获取心情列表
            $scope.getInfo = function () {
                $scope.loading('');
                // 加载头像
                $http.get(
                    url+'&r=open_farm.chicken.downloadPortrait'
                ).then(
                    function (data) {
                        $http.post(
                            url + '&r=open_farm.mood.getInfo',
                            {}
                        ).then(
                            function (data) {
                                if (data.data.code === 1) {
                                    $scope.mood = data.data.data;
                                    $scope.moodpram.background = data.data.data.background;
                                    $scope.moodpram.picture = $scope.mood.picture_list[0].picture;
                                    setTimeout(function () {
                                        $('.img_browse').children().eq(0).addClass('img_bor');
                                    })
                                }
                            },
                            function () {
                            });
                        removeLoading('test');
                    },
                    function () {
                    });
            };

            // 完成任务
            $scope.go_task = function (index) {
                var param = {
                    'id': $scope.repotlist[index].id,
                    'category': $scope.repotlist[index].category,
                    'value': $scope.repotlist[index].value,
                };
                if ($scope.repotlist[index].category === "任务中心") {
                    $scope.loading('');
                    $http.post(
                        url + '&r=task.picktask&id=' + $scope.repotlist[index].core,
                        {}
                    ).then(
                        function (data) {
                            if (!isNaN(parseInt(data.data.result.message))) {
                                param.rid = data.data.result.message;
                            }
                            $scope.receiveTask(param, index);
                            removeLoading('test');
                        },
                        function () {
                        });
                } else {
                    $scope.receiveTask(param, index);
                    removeLoading('test');
                }
            };
            $scope.receiveTask = function (param, index) {
                $scope.loading('');
                $http.post(
                    url + '&r=open_farm.task.receiveTask',
                    param
                ).then(
                    function (data) {
                        if (data.data.url) {
                            location.href = data.data.url;
                            return false;
                        }
                        if (data.data.code === 1) {
                            if ($scope.repotlist[index].category === "签到" || $scope.repotlist[index].category === "会员领取") {
                                $scope.repotlist[index].status = 2;
                                $scope.getuserInfo();
                            } else {
                                $scope.repotlist[index].status = 1;
                            }
                        } else {
                            showtoastFromDiv(data.data.message);
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.receive_awards = function (index) {
                var param = {
                    'id': $scope.repotlist[index].id,
                    'category': $scope.repotlist[index].category,
                    'value': $scope.repotlist[index].value,
                };
                $scope.loading('');
                $http.post(
                    url + '&r=open_farm.task.receive',
                    param
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.repotlist[index].status = 2;
                            $scope.getuserInfo();
                            showtoastFromDiv('领取成功');
                        } else {
                            showtoastFromDiv(data.data.message);
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };

            // 获取任务列表
            $scope.getList = function () {
                $scope.loading('');
                $scope.task_page = {
                    page: 1,
                };
                $scope.task_content = {
                    is_scroll: false,
                    text: '上拉加载更多'
                };
                $http.post(
                    url + '&r=open_farm.task.getList',
                    $scope.task_page
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.repotlist = data.data.data;
                            $scope.repotlist.forEach(function (item, index) {
                                item.sty = $scope.colors[index % 4];
                            });
                            if (data.data.data.length === 0) {
                                $scope.task_content.is_scroll = true;
                                $scope.task_content.text = '暂无数据';
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.task_page = {
                page: 1,
            };
            $scope.task_content = {
                is_scroll: false,
                text: '上拉加载更多'
            };
            //任务列表上拉加载
            $(".task_list_box").scroll(function (e) {
                var h = $(this).height();//div可视区域的高度
                var sh = $(this)[0].scrollHeight;//滚动的高度，$(this)指代jQuery对象，而$(this)[0]指代的是dom节点
                var st = $(this)[0].scrollTop;//滚动条的高度，即滚动条的当前位置到div顶部的距离
                if (h + st >= sh - 1) {
                    if ($scope.task_content.is_scroll) {
                        return false;
                    }
                    e.preventDefault();
                    $scope.task_page.page += 1;
                    $scope.loading('');
                    $http.post(
                        url + '&r=open_farm.task.getList',
                        $scope.task_page
                    ).then(
                        function (data) {
                            if (data.data.code === 1) {
                                if (data.data.data.length === 0) {
                                    $scope.task_content.is_scroll = true;
                                    $scope.task_content.text = '已加载全部信息';
                                    removeLoading('test');
                                    return false;
                                }
                                var list = data.data.data;
                                list.forEach(function (item, index) {
                                    item.sty = $scope.colors[index % 4];
                                    $scope.repotlist.push(item);
                                })
                            }
                            removeLoading('test');
                        },
                        function () {
                        });
                }
            });
            // 获取公告列表
            $scope.noticeList = function () {
                $scope.loading('');
                $scope.notice_page = {
                    page: 1,
                };
                $scope.notice_content = {
                    is_scroll: false,
                    text: '上拉加载更多'
                };
                $http.post(
                    url + '&r=open_farm.notice.getList',
                    $scope.notice_page
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.newlist = data.data.data;
                            if (data.data.data.length === 0) {
                                $scope.notice_content.is_scroll = true;
                                $scope.notice_content.text = '暂无数据';
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.notice_page = {
                page: 1,
            };
            $scope.notice_content = {
                is_scroll: false,
                text: '上拉加载更多'
            };
            // 公告列表上拉加载
            $(".Tips_list_new").scroll(function (event) {
                var h = $(this).height();//div可视区域的高度
                var sh = $(this)[0].scrollHeight;//滚动的高度，$(this)指代jQuery对象，而$(this)[0]指代的是dom节点
                var st = $(this)[0].scrollTop;//滚动条的高度，即滚动条的当前位置到div顶部的距离
                if (h + st >= sh - 1) {
                    if ($scope.notice_content.is_scroll) {
                        return false;
                    }
                    $scope.notice_page.page += 1;
                    $scope.loading('');
                    $http.post(
                        url + '&r=open_farm.notice.getList',
                        $scope.notice_page
                    ).then(
                        function (data) {
                            if (data.data.code === 1) {
                                if (data.data.data.length === 0) {
                                    $scope.notice_content.is_scroll = true;
                                    $scope.notice_content.text = '已加载全部信息';
                                    removeLoading('test');
                                    return false;
                                }
                                var list = data.data.data;
                                list.forEach(function (item) {
                                    $scope.newlist.push(item);
                                })
                            }
                            removeLoading('test');
                        },
                        function () {
                        });
                }
            });
            // 获取报告列表
            $scope.presen = function () {
                $scope.loading('');
                $scope.Presentation_page = {
                    page: 1
                };
                $scope.Presentation_content = {
                    is_scroll: false,
                    text: '上拉加载更多'
                };
                $http.post(
                    url + '&r=open_farm.presentation.getList',
                    $scope.Presentation_page
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.presentation = data.data.data;
                            if (data.data.data.length === 0) {
                                $scope.Presentation_content.is_scroll = true;
                                $scope.Presentation_content.text = '暂无数据';
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.Presentation_page = {
                page: 1
            };
            $scope.Presentation_content = {
                is_scroll: false,
                text: '上拉加载更多'
            };
            //报告列表上拉加载
            $(".Tips_list_present").scroll(function () {
                var h = $(this).height();//div可视区域的高度
                var sh = $(this)[0].scrollHeight;//滚动的高度，$(this)指代jQuery对象，而$(this)[0]指代的是dom节点
                var st = $(this)[0].scrollTop;//滚动条的高度，即滚动条的当前位置到div顶部的距离
                if (h + st >= sh - 1) {
                    if ($scope.Presentation_content.is_scroll) {
                        return false;
                    }
                    $scope.Presentation_page.page += 1;
                    $scope.loading('');
                    $http.post(
                        url + '&r=open_farm.presentation.getList',
                        $scope.Presentation_page
                    ).then(
                        function (data) {
                            if (data.data.code === 1) {
                                if (data.data.data.length === 0) {
                                    $scope.Presentation_content.is_scroll = true;
                                    $scope.Presentation_content.text = '已加载全部信息';
                                    removeLoading('test');
                                    return false;
                                }
                                var list = data.data.data;
                                list.forEach(function (item) {
                                    $scope.presentation.push(item);
                                })
                            }
                            removeLoading('test');
                        },
                        function () {
                        });
                }
            });
            // 添加心情场景
            $scope.add = function () {
                $scope.moodpram.picture = $scope.mood.picture_list[$scope.exhibition].picture;
                $scope.loading('努力生成中');
                $http.post(
                    url + '&r=open_farm.mood.generateMood',
                    $scope.moodpram
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            var url = location.href;
                            if (localStorage.removeItem('img')){
                                localStorage.removeItem('img');
                            }
                            localStorage.setItem('img', data.data.data+'?'+Math.random());
                            location.href=url.split('&r=open_farm')[0]+'&r=open_farm.mood'+url.split('&r=open_farm')[1];
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
                removeLoading('test');
            };
            // 判断是否正在吃
            $scope.is_eat = false;
            $scope.is_color = false;
            // 吃饲料
            $scope.tishi = "";
            // 彩蛋信息
            $scope.eggshell = {};
            // 积分数额
            $scope.integral_val = "";
            $scope.time_error=false;
            // 开始吃饲料
            $scope.feeding = function () {
                if (parseInt($scope.userInfo.feed_stock) <= 0) {
                    return false;
                }
                if ($scope.is_eat) {
                    return false;
                }
                $scope.finished_start();
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.feeding'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            var feed_strtime= new Date();
                            var feed_timeof=  feed_strtime.valueOf();
                            $scope.is_eat = true;
                            if (parseInt($scope.userInfo.feed_stock) <= parseInt($scope.farmset.bowl)) {
                                $scope.userInfo.feed_stock = 0
                            } else {
                                $scope.userInfo.feed_stock = parseInt($scope.userInfo.feed_stock) - parseInt($scope.farmset.bowl);
                            }
                            var finish_time = parseFloat(data.data.data.time);
                            var feed_endtime = $scope.time_exchange(feed_strtime,finish_time);
                            var timer = setInterval(
                                function () {
                                    finish_time = (parseInt(finish_time * 100) - 1) / 100;
                                    var feed_residue=feed_endtime-(new Date()).valueOf();
                                    if (feed_residue<=0){
                                        clearInterval(timer);
                                        xh();
                                        $(".tiao_clock").html('');
                                        $(".tiao").css("width", "0");
                                        $scope.time_error=true;
                                        $scope.finished_eating(true);
                                        $scope.is_eat = false;
                                        $scope.tishi = $scope.farmset.eat_tips;
                                        $('.wrap1').fadeIn(1000, function () {
                                            $this = $(this);
                                            setTimeout(function () {
                                                $this.fadeOut(4000, function () {
                                                })
                                            }, 100);
                                        });
                                        return false;
                                    }
                                    // 进度条
                                    $(".tiao").css("width", (1 - feed_residue / (feed_endtime-feed_timeof)) * 9 + "rem");
                                    // 时间
                                    $(".tiao_clock").html($scope.exchange(feed_residue));
                                },
                                10
                            );
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
                to_eat();
            };
            // 判断优惠卷和积分
            $scope.is_coupon = true;
            $scope.coupon_type = "";
            $scope.coupon_num = "";
            // 是否有彩蛋
            $scope.uncollected = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.getSurprised'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            if (data.data.data && JSON.stringify(data.data.data) !== '{}' && JSON.stringify(data.data.data) !== '[]' ) {
                                $scope.eggshell = data.data.data;
                            }
                        }
                        $scope.finished_eating();
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.uncollected();
            // 鸡是否吃完
            $scope.is_firstopen = true;
            // 吃饲料前判断是上次否有鸡蛋
            $scope.finished_start = function () {
                var feed_sta = false;
                var delay_num =1;
                $scope.loading('');
                $http.get(
                    url+'&r=open_farm.chicken.checkFeedingEnd'
                ).then(function (data) {
                    if (data.data && data.data.code === 1) {
                        // 彩蛋
                        if (data.data.data.surprised.length !== 0) {
                            var feed_sta = true;
                            var len = data.data.data.surprised.length - 1;
                            $('.suspension').css('display', 'block');
                            $scope.eggshell = data.data.data.surprised[len];
                            delay_num=len + 1;
                            showtoastFromDiv('您共获取1颗彩蛋');
                            if (delay_num==1){
                            }else{
                                for (var j=1;j<delay_num;j++){
                                    setTimeout(function () {
                                        showtoastFromDiv('您共获取1颗彩蛋');
                                    },1200*j)
                                }
                            }
                            $scope.tishi = '主人我下彩蛋了，过期不领是会消失的';
                            $scope.prompt = false;
                            $('.wrap1').fadeIn(1000, function () {
                                $this = $(this);
                                $this.fadeOut(4000, function () {
                                    clock = true;
                                    $scope.prompt = true;
                                })
                            });
                            // 彩蛋类型
                            if ($scope.eggshell.category === '积分') {
                                // 积分数
                                $scope.integral_val = $scope.eggshell.value;
                                // value
                                $scope.is_coupon = false;
                            } else if ($scope.eggshell.category === '优惠券') {
                                $scope.is_coupon = true;
                                if ($scope.eggshell.backtype === '0') {
                                    $scope.coupon_type = "立减";
                                    $scope.coupon_num = $scope.eggshell.deduct;
                                } else if ($scope.eggshell.backtype === '1') {
                                    $scope.coupon_type = "打折";
                                    $scope.coupon_num = data.$scope.eggshell.discount;
                                } else if ($scope.eggshell.backtype === '2') {
                                    if ($scope.eggshell.backmoney) {
                                        $scope.coupon_type = "返余额";
                                        $scope.coupon_num = $scope.eggshell.backmoney;
                                    } else if ($scope.eggshell.backcredit) {
                                        $scope.coupon_type = "返积分";
                                        $scope.coupon_num = data.$scope.eggshell.backcredit;
                                    } else if ($scope.eggshell.backredpack) {
                                        $scope.coupon_type = "返现金";
                                        $scope.coupon_num = $scope.eggshell.backredpack;
                                    }
                                    $scope.coupon_num = $scope.eggshell.discount;
                                }
                            } else {
                            }
                        }
                        if (data.data.data.bowl === 0 && data.data.data.time === 0) {
                            // 判断下蛋
                            if (data.data.data.egg && data.data.data.egg !== 0) {
                                $scope.getEggs();
                                if (feed_sta) {
                                    for (var e =0;e<data.data.data.eggs.length;e++){
                                        (function(g){
                                            setTimeout(function () {
                                                showtoastFromDiv('您共获取' + data.data.data.eggs[g] + '颗蛋');
                                            }, (delay_num+e)*1200);
                                        })(e)
                                    }
                                    setTimeout(function () {
                                        // showtoastFromDiv('您共获取' + data.data.data.egg + '颗蛋');
                                        $scope.tishi = $scope.farmset.lay_eggs_tips;
                                        // 鸡说话提示
                                        $('.wrap1').fadeIn(1000, function () {
                                            $this = $(this);
                                            setTimeout(function () {
                                                $this.fadeOut(4000, function () {
                                                    clock = true;
                                                })
                                            }, 700);
                                        });
                                    }, 1000);
                                } else {
                                    for (var e =0;e<data.data.data.eggs.length;e++){
                                        (function(g){
                                            setTimeout(function () {
                                                showtoastFromDiv('您共获取' + data.data.data.eggs[g] + '颗蛋');
                                            }, (delay_num+e)*1200);
                                        })(e)
                                    }
                                    $scope.tishi = $scope.farmset.lay_eggs_tips;
                                    // 鸡说话提示
                                    $('.wrap1').fadeIn(1000, function () {
                                        $this = $(this);
                                        setTimeout(function () {
                                            $this.fadeOut(4000, function () {
                                                clock = true;
                                            })
                                        }, 700);
                                    });
                                }

                            }
                        }
                    }

                    removeLoading('test');
                }, function () {
                })
            };
            // 吃完饲料判断是否下蛋
            $scope.finished_eating = function (feed,end_time) {
                var delay_num =1;
                var fir_tan = true;
                $scope.loading('');
                $http.get(
                    url +'&r=open_farm.chicken.checkFeedingEnd'
                ).then(
                    function (data) {
                        if (data.data && data.data.code === 1) {
                            var feed_strtime= new Date();
                            var feed_timeof= feed_strtime.valueOf();
                            // 判断彩蛋
                            if (data.data.data.surprised.length !== 0) {
                                var len = data.data.data.surprised.length - 1;
                                $('.suspension').css('display', 'block');
                                $scope.eggshell = data.data.data.surprised[len];
                                // 喂食时判断
                                if (feed) {
                                    $scope.tishi = '主人我下彩蛋了，过期不领是会消失的';
                                    $scope.prompt = false;
                                    $('.wrap1').fadeIn(1000, function () {
                                        $this = $(this);
                                        $this.fadeOut(4000, function () {
                                            clock = true;
                                            $scope.prompt = true;
                                            $scope.tishi = $scope.farmset.lay_eggs_tips;
                                        })
                                    });
                                    delay_num=len + 1;
                                    showtoastFromDiv('您共获取1颗彩蛋');
                                    if (delay_num==1){
                                    }else{
                                        for (var j=1;j<delay_num;j++){
                                            setTimeout(function () {
                                                showtoastFromDiv('您共获取1颗彩蛋');
                                            },1200*j)
                                        }
                                    }
                                }
                            } else {
                            }
                            if (JSON.stringify($scope.eggshell) != "{}" && JSON.stringify($scope.eggshell) != "[]") {
                                if (!$scope.is_firstopen && !feed) {
                                    showtoastFromDiv('您共获取1颗彩蛋');
                                    $scope.tishi = '主人我下彩蛋了，过期不领是会消失的';
                                    $scope.prompt = false;
                                    $('.wrap1').fadeIn(1000, function () {
                                        $this = $(this);
                                        $this.fadeOut(4000, function () {
                                            clock = true;
                                            $scope.prompt = true;
                                            $scope.tishi = $scope.farmset.lay_eggs_tips;
                                        })
                                    });
                                }
                                fir_tan = false;
                                $('.suspension').css('display', 'block');
                                if ($scope.eggshell.category === '积分') {
                                    // 积分数
                                    $scope.integral_val = $scope.eggshell.value;
                                    // value
                                    $scope.is_coupon = false;
                                } else if ($scope.eggshell.category === '优惠券') {
                                    $scope.is_coupon = true;
                                    if ($scope.eggshell.backtype === '0') {
                                        $scope.coupon_type = "立减";
                                        $scope.coupon_num = $scope.eggshell.deduct;
                                    } else if ($scope.eggshell.backtype === '1') {
                                        $scope.coupon_type = "打折";
                                        $scope.coupon_num = data.$scope.eggshell.discount;
                                    } else if ($scope.eggshell.backtype === '2') {
                                        if ($scope.eggshell.backmoney) {
                                            $scope.coupon_type = "返余额";
                                            $scope.coupon_num = $scope.eggshell.backmoney;
                                        } else if ($scope.eggshell.backcredit) {
                                            $scope.coupon_type = "返积分";
                                            $scope.coupon_num = data.$scope.eggshell.backcredit;
                                        } else if ($scope.eggshell.backredpack) {
                                            $scope.coupon_type = "返现金";
                                            $scope.coupon_num = $scope.eggshell.backredpack;
                                        }
                                        $scope.coupon_num = $scope.eggshell.discount;
                                    }
                                } else {
                                }
                            }
                            if (data.data.data.bowl === 0 && data.data.data.time === 0) {
                                // 判断下蛋
                                if (data.data.data.eggs && data.data.data.eggs.length!== 0) {
                                    $scope.getEggs();
                                    if (!fir_tan) {
                                        for (var e =0;e<data.data.data.eggs.length;e++){
                                            (function(g){
                                                setTimeout(function () {
                                                    showtoastFromDiv('您共获取' + data.data.data.eggs[g] + '颗蛋');
                                                }, (delay_num+e)*1200);
                                            })(e)
                                        }
                                    } else {
                                        for (var e =0;e<data.data.data.eggs.length;e++){
                                            (function(g){
                                                setTimeout(function () {
                                                    showtoastFromDiv('您共获取' + data.data.data.eggs[g] + '颗蛋');
                                                }, (delay_num+e)*1200);
                                            })(e)
                                        }
                                    }
                                    if (JSON.stringify($scope.eggshell) != "{}") {
                                    } else {
                                        $scope.tishi = $scope.farmset.lay_eggs_tips;
                                        $('.wrap1').fadeIn(1000, function () {
                                            $this = $(this);
                                            setTimeout(function () {
                                                $this.fadeOut(4000, function () {
                                                    clock = true;
                                                })
                                            }, 700);
                                        })
                                    }
                                }
                                xh();
                                $scope.is_eat = false;
                            } else if (data.data.data.time !== 0) {
                                // 判断吃没吃完
                                $scope.is_eat = true;
                                var finish_time = parseFloat(data.data.data.time);
                                var feed_endtime = $scope.time_exchange(feed_strtime,finish_time);
                                var timer = setInterval(
                                    function () {
                                        finish_time = (parseInt(finish_time * 100) - 1) / 100;
                                        var feed_residue=feed_endtime-(new Date()).valueOf();
                                        if (feed_residue<=0){
                                            clearInterval(timer);
                                            xh();
                                            $(".tiao_clock").html('');
                                            $(".tiao").css("width", "0");
                                            $scope.time_error=true;
                                            $scope.finished_eating(true);
                                            $scope.is_eat = false;
                                            $scope.tishi = $scope.farmset.eat_tips;
                                            $('.wrap1').fadeIn(1000, function () {
                                                $this = $(this);
                                                setTimeout(function () {
                                                    $this.fadeOut(4000, function () {
                                                    })
                                                }, 100);
                                            });
                                            return false;
                                        }
                                        $(".tiao").css("width", (1 - feed_residue / ($scope.farmset.bowl*$scope.farmset.eat_time*((100-$scope.userInfo.accelerate)/100)*1000)) * 9 + "rem");
                                        $(".tiao_clock").html($scope.exchange(feed_residue));
                                        if(!$scope.time_error){1
                                            to_eat();
                                            $scope.time_error=false;
                                        }
                                    },
                                    10
                                );

                            } else {
                                // 判断吃没吃完
                                $scope.is_eat = true;
                                var finish_time = parseInt(data.data.data.bowl * $scope.farmset.eat_time * $scope.userInfo.accelerate) / 100;
                                finish_time = parseFloat(finish_time);
                                var feed_endtime = $scope.time_exchange(feed_strtime,finish_time);
                                var timer = setInterval(function (){
                                        finish_time = (parseInt(finish_time * 100) - 1) / 100;
                                        var feed_residue=feed_endtime-(new Date()).valueOf();
                                        if (feed_residue<=0){
                                            clearInterval(timer);
                                            xh();
                                            $(".tiao_clock").html('');
                                            $(".tiao").css("width", "0");
                                            $scope.time_error=true;
                                            $scope.finished_eating(true);
                                            $scope.is_eat = false;
                                            $scope.tishi = $scope.farmset.eat_tips;
                                            $('.wrap1').fadeIn(1000, function () {
                                                $this = $(this);
                                                setTimeout(function () {
                                                    $this.fadeOut(4000, function () {
                                                    })
                                                }, 100);
                                            });
                                            return false;
                                        }
                                        $(".tiao").css("width", (1 - feed_residue / ($scope.farmset.bowl*$scope.farmset.eat_time*((100-$scope.userInfo.accelerate)/100)*1000)) * 9 + "rem");
                                        $(".tiao_clock").html($scope.exchange(feed_residue));
                                        if(!$scope.time_error){
                                            to_eat();
                                            $scope.time_error=false;
                                        }
                                    }
                                    , 10);
                            }
                            if (feed) {
                                $scope.getuserInfo();
                            }
                        }
                        removeLoading('test');
                        $scope.is_firstopen = false;
                    },
                    function () {
                    });
            };
            // 积分兑换加减
            $scope.egg_nums = 0;
            $scope.add_chnum = function () {
                if ($scope.change_num + 100 > $scope.userInfo.egg_stock) {
                    showtoastFromDiv('您剩余的鸡蛋不足以兑换积分');
                    return false;
                }
                $scope.change_num += 100;
                $scope.egg_nums = parseInt($scope.change_num * ($scope.farmset.rate));
            };
            $scope.jian_chnum = function () {
                $scope.change_num -= 100;
                if ($scope.change_num <= 0) {
                    return false;
                }
                $scope.egg_nums = parseInt($scope.change_num * ($scope.farmset.rate));
            };
            // 积分兑换
            $scope.integral = function () {
                if ($scope.change_num === 0) {
                    return false;
                }
                param = {egg: $scope.change_num, integral: parseInt($scope.change_num * ($scope.farmset.rate))};
                $scope.loading('');
                $http.post(
                    url + '&r=open_farm.integral.addInfo',
                    param
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            showtoastFromDiv(data.data.message);
                            $scope.change_num = 0;
                            $scope.egg_nums = 0;
                            $scope.getuserInfo();
                        } else if (data.data.code === 0) {
                            showtoastFromDiv(data.data.message);
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            // 优惠卷领取
            $scope.Lead_roll = function () {
                $scope.loading('');
                $http.post(
                    url + '&r=sale.coupon.detail.pay&id=' + $scope.eggshell.value
                ).then(
                    function (data) {
                        if (data.data.status === 1) {
                            $http.post(
                                url + '&r=sale.coupon.detail.payresult&id=' + $scope.eggshell.value + '&logid=' + data.data.result.logid
                            ).then(
                                function (data) {
                                    if (data.data.status === 1) {
                                        var parm = {
                                            id: $scope.eggshell.id,
                                            category: $scope.eggshell.category,
                                            surprised_id: $scope.eggshell.surprised_id,
                                        };
                                        if (data.data.result.dataid) {
                                            parm.dataid = data.data.result.dataid;
                                        }
                                        $http.post(
                                            url + '&r=open_farm.chicken.coupon',
                                            parm
                                        ).then(
                                            function (data) {
                                                if (data.data.code === 1) {
                                                    showtoastFromDiv(data.data.message);
                                                    $scope.eggshell = {};
                                                    $scope.receive_end();
                                                    $('.suspension').css('display', 'none');
                                                    $('.bg-model_red').css('display', 'none');
                                                }
                                                location.href = data.data.url;


                                            },
                                            function () {
                                            });
                                    } else {
                                        showtoastFromDiv(data.data.message);
                                    }
                                },
                                function () {
                                });
                        } else {
                            $http.post(
                                url + '&r=open_farm.surprised.deleteUserSurprised',
                                {id: $scope.eggshell.id}
                            ).then(
                                function (data) {
                                    if(data.data && data.data.code === 1){
                                        $('.suspension').css('display', 'none');
                                        $('.bg-model_red').css('display', 'none');
                                        $scope.receive_end()
                                    }

                                },
                                function () {
                                });
                            showtoastFromDiv(data.data.result.message);
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            // 积分领取
            $scope.integral_roll = function () {
                $scope.loading('');
                $http.post(
                    url + '&r=open_farm.chicken.coupon',
                    {
                        id: $scope.eggshell.id,
                        category: $scope.eggshell.category,
                        surprised_id: $scope.eggshell.surprised_id,
                    }
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            showtoastFromDiv(data.data.message);
                            $scope.eggshell = {};
                            $scope.receive_end();
                            $('.suspension').css('display', 'none');
                            $('.bg-model_red').css('display', 'none');
                        }

                        removeLoading('test');
                    },
                    function () {
                    });
            };
            // 查看当前是否有彩蛋库存未领取
            $scope.receive_end = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.getSurprised'
                ).then(
                    function (data) {
                        if (data.data && data.data.code === 1) {
                            if (data.data.data && JSON.stringify(data.data.data) !== '{}' && JSON.stringify(data.data.data) !== '[]' ) {
                                $scope.eggshell = data.data.data;
                                $('.suspension').css('display', 'block');
                            }
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            // 代领取鸡蛋
            $scope.collar_egg = false;
            $scope.collar_num_egg = 0;
            $scope.getEggs = function () {
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.getEggs'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            if (data.data.data != 0) {
                                $scope.collar_egg = true;
                                $scope.collar_num_egg = data.data.data;
                            }
                            $scope.getuserInfo();
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            // 领取鸡蛋
            $scope.receiveEgg = function () {
                if (!$scope.collar_egg) {
                    return false;
                }
                $scope.loading('');
                $http.get(
                    url + '&r=open_farm.chicken.receiveEgg'
                ).then(
                    function (data) {
                        if (data.data.code === 1) {
                            $scope.collar_egg = false;
                            showtoastFromDiv('领取' + $scope.collar_num_egg + '颗蛋');
                            $scope.getuserInfo();
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.getEggs();

            // 银行兑换输入框
            $scope.$watch('change_num', function (newValue, oldValue) {
                if (!$scope.change_num) {
                    $scope.change_num = 0;
                }
                if ($scope.change_num<0) {
                    $scope.change_num = 0;
                }

                if ($scope.change_num !== 0) {
                    $scope.change_num = $scope.change_num * 10 / 10;
                }
                if ($scope.change_num > $scope.userInfo.egg_stock) {
                    $scope.change_num = parseInt($scope.userInfo.egg_stock);
                    showtoastFromDiv('您的鸡蛋不足以兑换更多积分');
                }

                ////$scope.change_num = parseInt($scope.change_num);
                if (String($scope.change_num * $scope.farmset.rate).indexOf('.') !== -1) {
                    $scope.change_num = 0;
                    $scope.egg_nums = 0;
                    showtoastFromDiv('不符合兑换规则');
                } else {
                    if ($scope.farmset.rate) {
                        $scope.egg_nums = parseInt($scope.change_num) * parseFloat($scope.farmset.rate);
                    }
                }
            });
            // 不强制关注二维码叉号
            $scope.close_code=function () {
                $(".bg-model_qrcode").hide();
                //显示窗体的滚动条
                $("body").css({"overflow": "visible"});
            };
            // 关闭银行
            $scope.bank_close=function () {
                $scope.change_num = 0;
                $scope.egg_nums;
                $(".bg-model_bank").hide();
                $(".front_chicken").css('display','block');
                //显示窗体的滚动条
                $("body").css({"overflow": "visible"});
            };
        }
    ]
);
