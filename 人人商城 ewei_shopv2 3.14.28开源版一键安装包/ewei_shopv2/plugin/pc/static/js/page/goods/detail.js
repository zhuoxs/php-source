Array.prototype.diff = function (a) {
    return this.filter(function (i) {
        return a.indexOf(i) < 0;
    });
};

$(function () {
    Array.prototype.remove = function (val) {
        var index = this.indexOf(val);
        if (index > -1) {
            this.splice(index, 1);
        }
    };

    // 页面初始化
    page.init();
});


var page = {
    // 页面初始化加载函数
    init: function () {
        // 加载放大镜
        this.loadMagnifier();
        // 商品详情|规格参数|评论tab切换
        this.switchGoodsTab();
        // 多规格商品绑定点击事件
        this.specsGoodsClickEvent();
        // 套餐tab切换
        this.packageEvent();
        // 购买按钮事件
        this.bindBuyEvent();
        // 秒杀倒计时事件
        this.initSecKillCountDown();
        // 控制数量增减
        this.numberControl();
        // 加入购物车事件
        this.shopCartEvent();
        // 评论事件
        this.commentEvent();
    },
    // 数量控制
    numberControl: function () {
        var $cartInput = $('#cartNum_J');
        $cartInput.on('blur', function () {
            if (parseInt(this.value) <= 0) {
                layer.msg("不可少于一件");
                this.value = 1;
            }
        });


        $('[data-event]').on('click', function (e) {
            var $this = $(this);


            var $cartNum = parseInt($cartInput.val());

            if ($this.data('event') === 'add') {
                $cartInput.val(parseInt($cartInput.val()) + 1)
            }
            if ($this.data('event') === 'reduce') {
                if ($cartNum > 1) {
                    $cartInput.val(parseInt($cartInput.val()) - 1)
                }
                return true;
            }
        })
    },
    // 获取评论方法
    getComment: function (type) {

        layui.use(['laypage', 'layer'], function () {
            var laypage = layui.laypage
                , layer = layui.layer;

            $.ajax({
                url: window.API.commentList,
                data: {
                    id: window.PARAMS.id,
                    level: type,
                    page: 1
                },
                success: function (response) {
                    laypage.render({
                        elem: 'pager',
                        count: response.total,//数据总数
                        jump: jumpCallback
                    });
                },
                dataType: 'json'
            });
        });


        // 创建小星星
        var createStar = function (num) {

            // 保存最后的输出结果
            var $output = '';
            // 亮的星星
            var $lightStar = '<span class="good iconfont">&#xe69a;</span>';
            // 暗的星星
            var $darkStar = '<span class="iconfont">&#xe60c;</span>';
            // 暗的星星的数量
            var $darkStarNum = 5 - num;

            for (var i = 0; i < 5; i++) {
                if ($darkStarNum <= i) {
                    $output += $lightStar;
                }
            }

            for (var i = 0; i < $darkStarNum; i++) {
                $output += $darkStar
            }

            return $output
        };

        // 评论图片
        var createCommentPic = function (images) {
            var $output = '';
            if (typeof images == 'undefined' || typeof images == null) {
                return $output;
            }
            for (var i = 0; i < images.length; i++) {
                var dom = `
                 <li data-src="${images[i]}">
                    <img src="${images[i]}"/>
                 </li>`;
                $output += dom
            }

            return $output
        };


        function jumpCallback(obj, first) {
            $.ajax({
                url: window.API.commentList,
                data: {
                    id: window.PARAMS.id,
                    level: type,
                    page: obj.curr,
                },
                dataType: 'json',
                success: function (response) {
                    var $data = response.list;

                    if (typeof $data == "undefined") {
                        return false;
                    }

                    // 清掉DOM结构
                    $('.commonList > ul').empty();
                    for (var i = 0; i < $data.length; i++) {
                        var item = $data[i];

                        var bigimg = '';
                        if (typeof item.images != "undefined") {
                            bigimg = item.images[0];
                        }
                        var dom = `
                            <li class="item">
                                <div class="commentUser">
                                    <div class="avatarWarp">
                                        <img src="${item.headimgurl}"/>
                                    </div>
                                    <div class="username-withIcon">
                                        <div class="username">${item.nickname}</div>
                                    </div>
                                </div>
                                <div class="commentItem">
                                    <div class="starWrap">
                                        <div class="m-score">
                                            ${createStar(item.level)}
                                        </div>
                                    </div>
<!--                                    <div class="skuInfo">-->
<!--                                        <span>颜色：灰色</span>-->
<!--                                    </div>-->
                                    <div class="commentContent">
                                         ${item.content.replace(/\r\n/g, '<br>')}
                                    </div>
                                    <!-- 图片评论 -->
                                    <div class="commentImgs">
                                        <div class="smallImg">
                                            <ul class="flex">
                                                ${createCommentPic(item.images)}
                                            </ul>
                                        </div>
                                         <div class="bigImg">
                                            <img src="${bigimg}"/>
                                            <a class="tm-m-photo-viewer-navleft"><i class="iconfont">&#xe65f;</i></a>
                                            <a class="tm-m-photo-viewer-navright"><i class="iconfont">&#xe65f;</i></a>
                                        </div>
                                    </div>
                                    <div class="createTime">${item.createtime}</div>
                                </div>
                            </li>
                            
                        `;
                        $('.commonList >  ul').append(dom);
                    }
                    $(".commentImgs").commentImg({
                        activeClass: 'current', //缩略图当前状态class,默认'current'
                        nextButton: '.tm-m-photo-viewer-navright', //向后翻页按钮
                        prevButton: '.tm-m-photo-viewer-navleft', //向前翻页按钮
                        imgNavBox: '.smallImg ul', //缩略图容器
                        imgViewBox: '.bigImg' //浏览图容器
                    });

                }
            })
        }

    },
    // 评论事件
    commentEvent: function () {


        $('[data-comment]').on('click', function () {
            var $this = $(this);
            // 如果当前元素已经被选中了,那么禁止重复请求接口数据
            if ($(this).hasClass('current')) {
                return;
            }
            // 自己添加上类
            $(this).addClass('current');
            // 其他同类元素移除所有元素
            $(this).siblings().removeClass('current');

            var $type = $(this).data('comment');

            page.getComment($type)

        })
    },
    // 购物车相关事件
    shopCartEvent: function () {

        // 添加购物车事件
        $('#addCartBtn_J').on('click', function (e) {


            var $hasDiyForm = $('[data-hasdiyform]').data('hasdiyform') === 1;

            // 当前程序是否终止运行
            var stopFlag;

            // 如果存在多规格
            if ($('[data-attr="spec"]').length > 0) {
                if (typeof goodsOptionId == "undefined") {
                    layer.msg("请先选择规格");
                    return;
                }

                goodsOption.forEach(function (item, index) {
                    if (item.id === goodsOptionId) {
                        if (parseInt(item.stock) <= 0) {
                            layer.msg("商品库存不足~");
                            stopFlag = 1;
                        }
                    }
                })
            }

            if (stopFlag) {
                return false;
            }


            // 如果有自定义表单插件,需要弹出自定义表单
            if ($hasDiyForm) {
                $('#diyForm_J')
                    .show()
                    .on('click', '.close', function () {
                        $('#diyForm_J').hide();
                    });


            } else {
                // 否则直接获取信息进行添加购物车操作
                // 直接进行添加购物车的操作
                $.ajax({
                    url: window.API.addShopCart,
                    data: {
                        // 商品ID
                        id: window.PARAMS.id,
                        optionid: window.goodsOptionId || 0,
                        total: parseInt($('#cartNum_J').val()) > 0 ? $('#cartNum_J').val() : 1,
                    },
                    dataType: 'json',
                    success: function (response) {
                        // 没有错误的情况下加入购物车成功
                        if (response.error === 0) {
                            layer.msg("加入购物车成功~");
                            return true;
                        }
                        layer.msg(response.message);
                    }
                })

            }

        });
    },
    // 初始化秒杀倒计时时间
    initSecKillCountDown: function () {
        var intDiff = parseInt($('#seckill_end_time').val());
        timer(intDiff);
    },
    // 立即购买点击出现二维码的功能
    bindBuyEvent: function () {

        var $this = this;

        var $buyBtn = $('#buyBtn_J');

        var $qrcodeUrl = $buyBtn.data('qrcode');

        $buyBtn.click(function () {
            $this.qrcodeMask($qrcodeUrl)
        })
    },
    loadMagnifier: function () {
        // show  //正常状态的框
        // bigshow   // 放大的框的盒子
        // smallshow  //缩小版的框
        // mask   //放大的区域（黑色遮罩）
        // bigitem  //放大的框
        var obj = new mag('.glass-show', '.bigshow', '.smallshow', '.mask', '.bigitem');
        obj.init();
    },
    // 切换页面tab
    switchGoodsTab: function () {
        $('#tab_J a').on('click', function (e) {
            var clickTarget = $(e.target);
            if (clickTarget.data('tab') === 'comment') {
                page.getComment('all')
            }


            if (clickTarget.hasClass('current')) {
                return true;
            } else {
                // 先全部隐藏
                $('#goods_detail,#comment,#specs').hide();
                var tab = clickTarget.data('tab');
                var tab_selector = '#' + tab;
                $(tab_selector).show();
                clickTarget.parent().siblings().children().removeClass('current');
                clickTarget.addClass('current');
            }
        });
    },
    // 计算多规格商品价格
    specsGoodsClickEvent: function () {

        if (goodsOption === null) {
            return;
        }

        // 一共有几个规格
        var spec_length = $('[data-attr=spec]').length;


        $(document).on('click', '[data-optionid]:not(.no-good)', function () {
            var $this = $(this);
            var isOpen = $this.hasClass('current');
            $this.parent().parent().find("a").removeClass('current');
            if (isOpen) {
                $this.removeClass('current')
            } else {
                $this.addClass('current')
            }

            // 目前已经选中了几个
            var selected_spec_length = $('.tb-skin .current').length;

            if (selected_spec_length < spec_length - 1) {
                $('[data-optionid]')
                    .on('click', function () {
                    })
                    .removeClass('no-good')
            }

            // 选中倒数第二个的时候
            if (selected_spec_length === spec_length - 1) {
                var $specs = [];
                // 删除所有没有规格的商品
                $('[data-optionid]').removeClass('no-good');
                // 找到选中的所有规格
                $('.tb-skin .current').each(function () {
                    var $this = $(this);
                    $specs.push($this.data('optionid'))
                });

                goodsOption.forEach(function (item) {
                    var specs = item.specs.split('_').map(Number);
                    var diff = specs.diff($specs);
                    if (diff.length === 1) {
                        var selector = "[data-optionid=" + diff[0] + "]";
                        if (item.stock <= 0) {
                            $(selector).addClass('no-good');
                        }
                    }
                })
            }


            // 选中所有规格之后,计算一下规格属性
            window.goodsOptionId = undefined;
            if (spec_length === selected_spec_length) {
                var data = [];
                for (var i = 0; i < spec_length; i++) {
                    var optionid = $('.tb-sku .current').eq(i).data('optionid');
                    data.push(optionid)
                }

                // 排序后拼接一下
                data = data.sort().join('_');

                // 获取前台
                goodsOption.forEach(function (obj) {
                    if (obj.specs === data) {
                        $('.num').text(obj.marketprice);
                        window.goodsOptionId = obj.id;
                    }
                })
            }
        });
        //         // 所哟已经选中的规格的id数组
        // $('[data-optionid]').on('click',function (e) {
        //
        //
        //
        //     }
        // );


    },
    // 套餐购买事件
    packageEvent: function () {
        // 套餐tab页面切换
        var $this = this;
        $('#packagetab_J span').on('click', function (e) {

            var $qrcode = $(this).data('qrcode');
            $('#packagetab_J span').removeClass('current');
            var $clickObj = $(e.target);
            $clickObj.addClass('current');
            var packageid = $clickObj.parent().data('packageid');

            $('[id^=package_id_]').hide();


            var $currentPackage = $('#package_id_' + packageid);

            $('#packageBuyBtn_J').data('qrcode', $qrcode);
            $currentPackage.show();

        });

        // 点击套餐立即购买
        $('.package.tab-gobuy-btn').on('click', function () {
            $this.qrcodeMask(this.dataset.qrcode)
        });

        // 套餐拖拽

        function move() {

            var dv = document.getElementsByClassName('tab-selected-area');

            var ox = 0;

            var that = '';

            //上一次的位置 scrollLeft

            var last_left = 0;

            for (var i = 0; i < dv.length; i++) {

                dv[i].onmousedown = function (e) {

                    that = this;

                    that.className = 'tab-selected-area userSelect';

                    that.onmousemove = mousemove;

                    document.onmouseup = mouseup;

                    e = e || window.event;

                    if (last_left > 0) {

                        //就减掉上次的距离

                        ox = last_left + e.clientX;

                    } else {
                        ox = e.clientX;
                    }

                    e.preventDefault()
                };

                function mousemove(e) {
                    e = e || window.event;
                    if (that.scrollWidth - that.scrollLeft !== that.clientWidth) {
                        last_left = ox - e.clientX;
                    }

                    that.scrollLeft = ox - e.clientX;
                }

                function mouseup() {
                    that.onmouseup = that.onmousemove = null;
                }
            }

        }

        move();

    },
    // 二维码弹出层,url填要显示的url
    qrcodeMask: function (url) {
        // 窗口附上二维码
        $('#payCode_J img').attr('src', url);
        // 关闭弹窗事件
        $('#payCode_J .close').on('click', function () {
            $('#payCode_J').css('display', 'none');
        });
        $('#payCode_J').css({'display': 'block'})
    }
};
