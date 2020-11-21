

	var app = angular.module('mihuaapp',['ng.ueditor']);
	app.controller('custom',['$scope',function($scope){
		//模块列表
		$scope.modules = [
             {
				id:'topbar',
				name:'主页面',
				params:{
					topleftcolor:'#ff5f27',
					toprightcolor:'#999999',
					botcolor : '#ffffff',
					topbgcolor:'#f3f4f9',
					botbgcolor : '#65cbd0',
					padding:'2'
				},
				data : []
			},
			{
				id:'solid1',name:'幻灯片',
				params:{shape:'shape2',align:'center',scroll:'2',color:''},
				data:[
                   {id:'B01',imgurl:'../addons/mihua_mall/recouse/images/slide01.jpg',hrefurl:'',sysurl:'url'},
                   {id:'B02',imgurl:'../addons/mihua_mall/recouse/images/slide01.jpg',hrefurl:'',sysurl:'url'},
                   {id:'B03',imgurl:'../addons/mihua_mall/recouse/images/slide01.jpg',hrefurl:'',sysurl:'url'},
                   {id:'B04',imgurl:'../addons/mihua_mall/recouse/images/slide01.jpg',hrefurl:'',sysurl:'url'}
				]
			},
            {
				id: "cube",name: "图片魔方",
				params: {bgcolor:'',layout: {},showIndex: 0,selection: {},currentPos: {},currentLayout: {isempty: !0}},
				data:[]
			},
            {
				id:'notice',name:'公告模块',
				params:{imgurl:'../addons/mihua_mall/recouse/images/notice.png',color:'#000000',bgcolor:'#ffffff',horncolor:'',shownum:1,padding:0,bottomcolor:'#f3f4f9',timer:3},
				data:[]
			},
            {
				id:'title',name:'标题模块',
				params:{
					title1:'',
					title2:'',
					showtitle2:'1',
					fontsize1:'18',
					fontsize2:'14',
					incosize : 14,
					align:'left',
					color:'#000',
					incoshow:'0',
					inco:'',
					incoheight : 14,
					titlehref:'',
					paddingsize : '5',
					bgcolor : '#ffffff'
				}
			},
			{
				id:'search',name:'搜索框',
				params:{
					placeholder:'请输入商品标题',
					style:'style1',
					color:'#400000',
					bgcolor:'#f3f4f9',
					border : 0,
					padding : 5
				}
			},
            {
				id:'blank',name:'辅助空白',
				params:{
					height:'20',bgcolor:''
				}
			},
            {
				id:'goods1',name:'商品模块',
				params:{
					style:'49.5%',
					onetyle:'onetyle-1',
					onebuysub : '',
					onesubfont : '立即购买',
					onesubcolor : '',
					onesubbordcolor : '',
					onesubbackcolor : '',
					twobuysub : '',
					pricecolor:'',
					pricesize:'16',
					iconposition : 'left',
					iconsize : '40px',
					hpline : 'solid',
					hplinecolor : '#dddddd',
					bgcolor:'#ffffff',
					showname:'1',
					option:'',
					buysub:'buy-3',
					price:'1',
					hpstyle:'1',
					goodhref: window.sysinfo.siteroot + 'app/index.php?i='+window.sysinfo.uniacid+'&c=entry&do=detail&m=mihua_mall'

				},
				data:[]
			},
            {
				id:'menu',
				name:'导航模块',
				params:{
					num:'20%',
					style:'0',
					bgcolor:'#ffffff',
					color : '',
					fontsize:'15',
					menuImgFloat:'left',
					position:'1',
					space:'5',
					padding : 3
				},
                data:[
				]
            },
            {
				id:'richtext1',
				name:'富文本',
				params:{
					bgcolor:''
				},
				content:''
			},
            {
				id:'link',
				name:'连接模块',
				params:{
					bgcolor:'#ffffff',
					padding : '2',
					fontcolor : '',
					line : '',
					linecolor : ''
				},
				data : [
					{id:'L0000000000001',titleleft:'',titleright:'',href:''}
				]
			},
            {
				id:'line',
				name:'辅助线',
				params:{
					height:'1',
					style:'solid',
					color:'#000',
					bgcolor:'#ffffff',
					padding:'2'
				}
			},
             {
			 	id:'card',
			 	name:'优惠券',
			 	params:{
			 		topleftcolor:'#ff5f27',
			 		toprightcolor:'#999999',
			 		botcolor : '#ffffff',
			 		topbgcolor:'#f3f4f9',
			 		botbgcolor : '#65cbd0',
			 		padding:'2'
			 	},
			 	data : []
			 },
		];

		$scope.isweb = true;//判断是后台还是前台
		$scope.pages = pageparams.basicparams;//页面颜色等

		$scope.pagename = pageparams.pagename;
		$scope.pagetype = pageparams.pagetype;
		$scope.uniacid = window.sysinfo.uniacid;
		$scope.appItemShow = false; //展示模块
		$scope.focus = 'M0'; //当前焦点
		$scope.Items = pageparams.params; //初始化数据
		$scope.imgsrc = 'ng-src';

		$scope.isgeturl = 0; //是否获取链接

		//导航模块浮动
		$scope.changenum = function(id, Num){
			angular.forEach($scope.Items, function(im,index) {
				if(id == im.id){
					if(Num == '28%'){
						im.params.menuImgFloat = '111';
					}else{
						im.params.menuImgFloat = 'left';
					}
				}
			})
		}

		$scope.checkCubeBorder = function(type,value,mid){
			//console.log(value);
				angular.forEach($scope.Items, function(i,index) {

					if(i.id == mid){
						if(type == 'topborder'){
							if(value){
								i.params.currentLayout.topborder = 'solid';
							}else{
								i.params.currentLayout.topborder = false;
							}
						}
						if(type == 'rightborder'){
							if(value){
								i.params.currentLayout.rightborder = 'solid';
							}else{
								i.params.currentLayout.rightborder = false;
							}
						}
						if(type == 'bottomborder'){
							if(value){
								i.params.currentLayout.bottomborder = 'solid';
							}else{
								i.params.currentLayout.bottomborder = false;
							}
						}
						if(type == 'leftborder'){
							if(value){
								i.params.currentLayout.leftborder = 'solid';
							}else{
								i.params.currentLayout.leftborder = false;
							}
						}
					}
				})

		}

		//添加模块处理
		$scope.addModule = function(Nid){
            var Mid = 'M'+new Date().getTime();
            var modules = $scope.modules;

            angular.forEach(modules, function(n,index) {
                if(n.id==Nid){
                    newparams = clone(n.params)?clone(n.params):'';
                    newdata = n.data?cloneArr(n.data):'';

                    newother = !clone(n.other)?'':clone(n.other);
                    newcontent = !clone(n.content)?'':clone(n.content);
                    if(Nid=='cube'){
                        for (row = 0; row < 4; row++) {
                            for (newparams.layout[row] = {}, col = 0; col < 4; col++) {
                                newparams.layout[row][col] = {cols: 1,rows: 1,isempty: !0,imgurl: "",bordercolor:'',topborder:'',rightborder:'',bottomborder:'',leftborder:'',classname: ""};
                            }
                        }
                    }
                    var newitem = {id:Mid,temp:Nid,params:newparams,data:newdata,other:newother,content:newcontent};
                    var insertindex = -1;


					//$scope.focus当前焦点模块 ,获取将要插入的位置
                    if($scope.focus!=''){
                          var Items = $scope.Items;
                            angular.forEach(Items, function(a,index) {
                                if(a.id==$scope.focus){
                                    insertindex = index;
                                }
                          });
                    }
					//如果没有选择，直接加载在后面
                    if(insertindex==-1){
                        $scope.Items.push(newitem);
                    }
					//如果选择了模块在模块后插入
                    else{
                       $scope.Items.splice(insertindex+1, 0, newitem);
                    }

					//重置焦点
                    setTimeout(function(){
						$scope.setfocus(newitem.id,null);
                    },50);

                }

            });

		};

		//删除选定的模块
        $scope.delItem = function(id){
            if(confirm("确认删除吗？")){
                var Items = $scope.Items;
                angular.forEach(Items, function(a,index) {
                    if(a.id==id){
                        Items.splice(index,1);
                        $scope.focus = '';

                    }
                });
            }
        }

		//显示与隐藏删除按钮
        $scope.over = function(id){$("div[id="+id+"]").parent().find(".app-mod-del").stop().show();}
        $scope.out = function(id){$("div[id="+id+"]").parent().find(".app-mod-del").stop().hide();}

		//处理对象
	   function clone(myObj){
			//参数不是对象原样返回。
			if(typeof(myObj) != 'object' || myObj == null) return myObj;
			var newObj = new Object();
			for(var i in myObj){
				newObj[i] = clone(myObj[i]);
			}
			return newObj;
		}

		function cloneArr(arr){
			var newArr = [];
			$(arr).each(function(i,val){
				newArr.push(clone(val));
			});
			return newArr;
		}

		//重置焦点
		$scope.setfocus = function(Mid,e){

			$scope.focus = Mid;
			ccc = $("div[id="+Mid+"]").offset().top;
			ddd = (ccc-280)>=0?(ccc-280):0;
			$(".app-panel-editor").css("margin-top",ddd+"px");
			$(document.body).animate({scrollTop:ccc-100},500);
			$scope.initSlider();
		}

		//上传图片，获取到url，赋值给pages参数 type为封面图或者客服图
        $scope.pageImg = function(Mid,type){
            require(['jquery', 'util'], function($, util){
                util.image('',function(data){
                    if(type=='floatimg'){
                        $scope.pages[0].params.floatimg = data['url'];
                    }else if(type=='totopimg'){
						$scope.pages[0].params.totopimg = data['url'];
					}else if(type=='qiandaoimg'){
						$scope.pages[0].params.qiandaoimg = data['url'];
					}else{
                        var Items = $scope.Items;
                        angular.forEach(Items, function(m,index) {
                            if(m.id==Mid){
                                m.params[type] = data['url'];
								$scope.$apply();
                            }
                        });
						//$scope.pages[0].params.inco = data['url'];
                        //$scope.pages[0].params.img = data['url'];//封面图
                    }
					//处理图片后重置焦点到当前模块
                   $("div[mid="+Mid+"]").trigger("click");
                });
            });
        }

		//魔方和幻灯片图片上传
        $scope.uploadImgChild = function(Mid,Cid,Type){
            require(['jquery', 'util'], function($, util){
                util.image('',function(data){
				//console.log(Mid);
                        var Items = $scope.Items;
                        angular.forEach(Items, function(m,index1) {
                            if(m.id==Mid){
                                if(Type=='cube'){

                                    m.params.currentLayout.imgurl = data['url'];

                                }else{
                                    angular.forEach(m.data, function(c,index2) {

                                        if(c.id==Cid){
                                            c.imgurl = data['url'];
											//console.log(Items);
                                        }
                                    });
                                }
								 $scope.$apply();
                            }
                        });
                });
            });
		}

		//删除幻灯片
        $scope.delItemChild = function(Mid,Cid){
		console.log($scope.Items)
            if(confirm("确认删除吗？")){
                var Items = $scope.Items;
                angular.forEach(Items, function(m,index1) {
                    if(m.id==Mid){
                        angular.forEach(m.data, function(c,index2) {

                            if(c.id==Cid){
                               m.data.splice(index2,1);
                            }
                        });
                    }
                });
            }
        }

		//添加幻灯片
        $scope.addItemChild =function(type,Mid){
            if(type && Mid){
                t = '';
                if(type=='good'){t = 'G';}
                else if(type=='picture'){t = 'P';}
                else if(type=='banner'){t = 'B';}
				else if(type=='link'){t = 'L';}
				else if(type=='notice'){t = 'N';}
				else if(type=='menu'){t = 'M';}
                var var_id = t+new Date().getTime();
                var push = {
                    banner:{id:var_id,imgurl:'',hrefurl:'',sysurl:'url'},
                    link:{id:var_id,titleleft:'',titleright:'',href:''},
					notice:{id:var_id,title:'',url:''},
                    good:{},
					menu:{id:var_id,imgurl:'',text:'',hrefurl:''}
                };
                var Items = $scope.Items;
                angular.forEach(Items, function(m,index) {
                    if(m.id==Mid){
                        m.data.push(push[type]);
                    }
                });
            }
        }

		//读取内容
		$scope.searchItem = function(type){
			$scope.geturlshow = 'block';
			$scope.showtype = type;
			if(type == 'good'){
				$scope.searchName = '商品';
			}
			 if(type == 'card'){
			 	$scope.searchName = '卡券';
			 }
			if(type == 'page'){
				$scope.searchName = '装修页面链接';
			}
			if(type == 'url'){
				$scope.searchName = '在这里选择查找的类型';
			}
			$scope.searchpage = 0;
			$scope.tosearch(type,'add');
		}

		//删除商品
        $scope.delGood = function(Mid,Gid){
            if(confirm("确认删除此商品？")){
                var Items = $scope.Items;
                angular.forEach(Items, function(m,index1) {
                    if(m.id==Mid){
                        angular.forEach(m.data, function(g,index2) {
                            if(g.id==Gid){
                                m.data.splice(index2,1);
                            }
                        });
                    }
                });
            }
        }

		//搜索需选取的内容
		$scope.tosearch = function(type,addOrMinus){
			if(addOrMinus == 'add'){
				$scope.searchpage ++;
			}else{
				$scope.searchpage --;
			}
            $.ajax({
                type: 'post',
                dataType:'json',
                url: window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=customsearch&do=ajax&m=mihua_mall',
                data: {page:$scope.searchpage,type:$scope.showtype}, //type 1商品 2分类
                success: function(data){
                    // var description = "";  for(var i in data){  var property=data[i];  description+=i+" = "+property+"\n";  }
                    // alert(description);

					$scope.searchResult = [];
					$scope.getpager = data.pager;

                        angular.forEach(data.list,function(d,i){
						if(type == 'good'){
							$scope.searchResult.push({id:d.id,title:d.title,url:d.url,img:d.thumpic,realprice:d.marketprice,oldprice:d.productprice,groupnum:d.groupnum,groupprice:d.groupprice,sales:d.sales});

						}
						 if(type == 'card'){
						 	$scope.searchResult.push({id:d.id,cardname:d.cardname,cardvalue:d.cardvalue,fullmoney:d.fullmoney,cardtype:d.cardtype,needcredit:d.needcredit});
						 }
						if(type == 'page'){
							$scope.searchResult.push({id:d.id,pagename:d.pagename,url:d.url});
						}
					})
					$scope.$apply();
                },
                error: function(){
                    alert('查询失败！');
                }
            });
		}

		//将内容添加至数组中
        $scope.pushIntoFocus = function(Mid,Sid){
            angular.forEach($scope.Items, function(m,index1) {
                if(m.id==Mid){
                    angular.forEach($scope.searchResult, function(s,index2) {
                        if(s.id==Sid){
                            var Gid = 'G'+new Date().getTime();
							if($scope.showtype == 'good'){
								m.data.push({id:Gid,gid:s.id,img:s.img,title:s.title,price:s.realprice,oldprice:s.oldprice,groupnum:s.groupnum,groupprice:s.groupprice,sales:s.sales});

								$('.app-mod-8-main-img img').each(function(){  //改变图片尺寸
									$(this).height($(this).width());
								});
							}

							if($scope.showtype == 'card')
								m.data.push({id:Gid,cardid:s.id,cardname:s.cardname,cardtype:s.cardtype,cardvalue:s.cardvalue,fullmoney:s.fullmoney,needcredit:s.needcredit});
                        }
                    });
                }
            });
        }

		$scope.copyit = function(){
			require(['jquery.zclip'], function(){
				$('.copyurl').zclip({
					path: './resource/components/zclip/ZeroClipboard.swf',
					copy: function(){
						return $(this).attr('data-url');
					},
					afterCopy: function(){
						$('.copyurl').off();
						alert('复制成功');
					}
				});
			});
		};

		//拖动模块
        $scope.drag = function(Mid){
            var container = $(".app-content");
            var del = container.find(".app-mod-move");//
            //按下鼠标
            del.off("mousedown").mousedown(function(e) {
                $scope.focus = Mid;
                if(e.which != 1 || $(e.target).is("textarea") || window.kp_only) return;
                e.preventDefault();
                var x = e.pageX;
                var y = e.pageY;
                var _this = $(this).parent();
                var w = _this.width();
                var h = _this.height();
                var w2 = w/2;
                var h2 = h/2;
                var p = _this.position();
                var left = p.left;
                var top = p.top;
                window.kp_only = true;
                _this.before('<div id="kp_widget_holder"></div>');
                var wid = $("#kp_widget_holder");
                var nod = $(".app-mod-nodrag");
                wid.css({"border":"2px dashed #ccc", "height":_this.outerHeight(true)});
                _this.css({"width":w, "height":h, "position":"absolute", opacity: 0.8, "z-index": 900, "left":left, "top":top});
                del.mousemove(function(e) {
                    $scope.focus = Mid;
                    e.preventDefault();
                    var l = left + e.pageX - x;
                    var t = top + e.pageY - y;
                    _this.css({"left":l, "top":t});
                    var ml = l+w2;
                    var mt = t+h2;
                    del.parent().not(_this).not(wid).each(function(i) {
                        var obj = $(this);
                        var p = obj.position();
                        var a1 = p.left;
                        var a2 = p.left + obj.width();
                        var a3 = p.top;
                        var a4 = p.top + obj.height();
                        if(a1 < ml && ml < a2 && a3 < mt && mt < a4) {
                            if(!obj.next("#kp_widget_holder").length) {
                                wid.insertAfter(this);
                            }else{
                                wid.insertBefore(this);
                            }
                            return;
                        }
                    });
                });
                del.mouseup(function() {
                    del.off('mouseup').off('mousemove');
                    $(container).each(function() {
                        var obj = $(this).children();
                        var len = obj.length;
                        if(len == 1 && obj.is(_this)) {
                            $("<div></div>").appendTo(this).attr("class", "kp_widget_block").css({"height":100});
                        }
                        else if(len == 2 && obj.is(".kp_widget_block")){
                            $(this).children(".kp_widget_block").remove();
                        }
                    });
                    var p = wid.position();
                    _this.animate({"left":p.left, "top":p.top}, 100, function() {
                        _this.removeAttr("style");
                        wid.replaceWith(_this);
                        window.kp_only = null;
                        var arr = [];
                        $(".app-mod-repeat").find(".app-mod-parent").each(function(i,val) {
                            arr[i] = val.id;
                        });
                        var newarr = [];
                        angular.forEach(arr, function(aid){
                            angular.forEach($scope.Items, function(obj){
                                if(obj.id== aid){
                                    newarr.push(obj);
                                    return false;
                                }
                            });
                        });
                        $scope.Items = newarr;
                    });
                });
            });
        }


        /**************<!-- 魔方处理 -->*************/

        $scope.hasCube = function(Item){
        	 var has = false;
             var row=0,col = 0;
        	 for(var i=row;i<4;i++){
                for(var j=col;j<4;j++){
                  if (Item.params.layout[i][j] && !Item.params.layout[i][j].isempty) {
                      has = true;
                      break;
                  }
                }
            }
            return has;
        }

        $scope.showSelection = function(Edit, row,col){

            Edit.params.currentPos = {row: row,col: col};
            Edit.params.selection = {};
            var maxrow = 4,maxcol = 4,end =false;

            for(var i=row;i<=3;i++){

                if (!Edit.params.layout[i][col] || Edit.params.layout[i][col] && !Edit.params.layout[i][col].isempty) {
                    maxrow = i;
                    end =true;
                }
                if(end){
                    break;
                }
            }

            end =false;
            for(var j=col;j<=3;j++){
                if ( !Edit.params.layout[row][j] || Edit.params.layout[row][j] && !Edit.params.layout[row][j].isempty) {
                    maxcol = j;
                    end =true;
                }
                if(end){
                    break;
                }
            }

            var f = -1,g = 1;

            for (var i = row; i < maxrow; i++) {

                var y = 1;
                Edit.params.selection[g] = {};
                for (var j = col; j < maxcol; j++) {
                  if( f >= 0 && f < j || (Edit.params.layout[i][j] && Edit.params.layout[i][j].isempty   )){
                      Edit.params.selection[g][y] = {
                        rows: g,
                        cols: y
                      };
                      y++;
                  }
                  else{
                      f = j - 1
                  }
                }
                g++;
            }

            $(".layout-table li").removeClass("selected");
            $scope.modalobj = $("#"+Edit.id+"-modal-cube-layout").modal({show:true});
            $('#'+Edit.id+'-modal-cube-layout').find(".layout-table").unbind('mouseover').mouseover(function(a) {
                if ("LI" == a.target.tagName) {
                    $(".layout-table li").removeClass("selected");
                    var c = $(a.target).attr("data-rows"),
                          d = $(a.target).attr("data-cols");
                    $(".layout-table li").filter(function(a, e) {
                        return $(e).attr("data-rows") <= c && $(e).attr("data-cols") <= d
                    }).addClass("selected")
                }
            });

            return true;
        }

        $scope.selectLayout = function(Edit, currentRow, currentCol, rows, cols) {
            if( !rows ) {rows= 0;}
            if( !cols ) {cols = 0;}
            Edit.params.layout[currentRow][currentCol] = {
                cols: cols,
                rows: rows,
                isempty: false,
				bordercolor: '',
				topborder: '',
				rightborder: '',
				bottomborder: '',
				leftborder: '',
                imgurl: "",
                classname: "index-" + Edit.params.showIndex
            };
            for (var i = parseInt(currentRow); i < parseInt(currentRow) + parseInt(rows); i++){
                for (var j = parseInt(currentCol); j < parseInt(currentCol) + parseInt(cols); j++) {
                    if( currentRow != i || currentCol != j)  {
                        delete Edit.params.layout[i][j];
                    }
        	}
            }
            Edit.params.showIndex++;
            $scope.modalobj.modal('hide');
            $scope.changeItem(Edit, currentRow,currentCol);
            return true;
        }
/*************<!-- 魔方处理end -->*************/


		//改变
        $scope.changeItem = function(Edit,row,col){
            $("#cube-editor td").removeClass("current").filter(function(a, e) {
                return $(e).attr("x") == row && $(e).attr("y") == col
            }).addClass("current");
            $("#cube_thumb").attr("src", "");
            Edit.params.currentLayout = Edit.params.layout[row][col];
        }
		//删除魔方
         $scope.delCube = function(Edit,Cid,cols,rows){
            if(Edit && Cid && cols && rows){
                var len = Edit.params.layout.length;
                $.each(Edit.params.layout,function(row,a){
                    $.each(Edit.params.layout[row],function(col,b){
                        if(col!='$$hashKey'){
                            if(b.classname==Edit.params.currentLayout.classname){
                                row  =parseInt(row);col = parseInt(col);
                                rows  =parseInt(rows);cols = parseInt(cols);
                                 for(var i = row;i<row+rows;i++){
                                     for(var j=col;j<col+cols;j++){
                                        Edit.params.layout[i][j] = {cols: 1,rows: 1,isempty: true,imgurl: "",classname: ""};
                                     }
                                 }
                            }
                        }
                    });

                });
            }
        }

		//选择图标
		$scope.addInco = function(Mid){
			require(['jquery','util'], function($, util){
				$(function(){
					util.iconBrowser(function(ico){
                        angular.forEach($scope.Items, function(m,index1) {
                            if(m.id==Mid){

								m.params.inco = ico;
								$scope.$apply();
                            }
                        });
					});
				});
			});
		}

		//保存设置
        $scope.save = function(n){
           var pageid = pageparams.pageid;
           var items = cloneArr($scope.Items );//最后的数据
		   //处理富文本
           angular.forEach(items, function(m,index1) {
               if(m.temp=='richtext'){
                    m.content = escape(m.content);
               }
           });
		   //转为jason格式
           var datas = angular.toJson(items);
           var basicparams = angular.toJson($scope.pages);
		   //页面名称、页面类型
           var pagename = $("input[name=pagename]").val();
           var pagetype = $("select[name=pagetype]").val();

			if(pagetype == 0){
               alert('请选择页面类型');
               return;
			}

			if(datas == '[]'){
               alert('您还没有添加模块');
               return;
			}

            $.ajax({
                type: 'POST',
                url: window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=savecustom&do=ajax&m=mihua_mall',
                data: {pageid: pageid,params:datas,pagetype:pagetype,pagename:pagename,basicparams:basicparams},
                success: function(data){
                    if(data == 1){
                        alert("保存成功！");
						if(pageid){
							location.href = "";
						}else{
							location.href = window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=list&do=custom&m=mihua_mall';
						}

                    }else{
                         alert(data);
                        alert("保存失败");
                    }
                }
                ,error: function(){
                    alert('保存失败请重试');
                }
            });
        }

		//加载完后调整
		$scope.$on('ngRepeatFinished',function(){

			 $('.app-mod-8-main-img img').each(function(){
				 $(this).height($(this).width());
			 });
			 $('.app-mod-cube table  tr').each(function(){
				if( $(this).children().length<=0){
					$(this).html('<td></td>');
				}
			 });

		});

		//滑块
		$scope.initSlider = function(){
			require(['jquery.ui'],function(){
				$('.app .slider').each(function(){
					var thisvalue = parseInt( $(this).attr('data-value'), 10 ),
						name = $(this).attr('data-name'),
						max =  parseInt( $(this).attr('data-max'), 10 ),
						min =  parseInt( $(this).attr('data-min'), 10 ),
						thisid = $(this).attr('data-id');
					$(this).slider({
						min: min,
						max: max,
						value : thisvalue,
						slide : function(event,ui){
							var slidertemp = [];
							slidertemp.push($scope.pages[0]);
							for(t in $scope.Items){
								slidertemp.push($scope.Items[t]);
							}
							angular.forEach(slidertemp, function(m,index) {
								if(m.id==thisid){
									m.params[name] = ui.value;
									//$(this).attr('data-value',ui.value);
									$scope.$apply();
								}
							});
						}
					});
					$(this).find('a').removeAttr('href');
				});
			});
		};
		$scope.initSlider();

	}]);

var nowurl="http://"+window.location.host;
	//获取链接
	app.directive("ngMyLinker", ["$http", function (a) {
        var d = {
            template: '<div class="dropdown link">	<div class="input-group">		<input type="text" value="" placeholder='+ nowurl+' ng-model="url" class="form-control">		<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="">选择链接 <i class="fa fa-caret-down"></i></button></span>	</div>	<ul class="dropdown-menu" role="menu" style="left: 0; right:0;">		<li><a href="javascript:;" ng-click="searchSystemLinker()">系统菜单</a></li></ul></div>',
            scope: {
                url: "=ngMyUrl",
                title: "=ngMyTitle"
            },
            link: function (d, e, f) {
                e.find(".input-group-btn").mouseover(function (a) {
                    clearTimeout(d.timer),
                    e.find(".dropdown-menu").show()
                }).mouseout(function () {
                    d.timer = setTimeout(function () {
                        e.find(".dropdown-menu").hide()
                    }, 50)
                }),
                e.find(".dropdown-menu").mouseover(function () {
                    clearTimeout(d.timer),
                    e.find(".dropdown-menu").show()
                }).mouseout(function () {
                    d.timer = setTimeout(function () {
                        e.find(".dropdown-menu").hide()
                    }, 50)
                }),
                d.addLink = function (a, b) {
                    d.url = a,
                    b && (d.title = b)
                },
                d.searchSystemLinker = function () {
                    d.modalobj = util.dialog("请选择链接", ["./index.php?c=utility&a=link&callback=selectLinkComplete"], "", {
                        containerName: "link-search-system"
                    }),
                    d.modalobj.modal({
                        keyboard: !1
                    }),
                    d.modalobj.find(".modal-body").css({
                        height: "480px",
                        "overflow-y": "auto"
                    }),
                    d.modalobj.modal("show"),
                    window.selectLinkComplete = function (a, b) {
                        d.addLink(a, b),
                        d.$apply("url", "title"),
                        d.modalobj.modal("hide")
                    }
                }
            }
        };
        return d
    }]);

	//监控富文本变化并赋值
    app.directive('stringHtml' , function(){
        return function(scope , el , attr){
            if(attr.stringHtml){
                scope.$watch(attr.stringHtml , function(html){
                    el.html(html || '');
                });
            }
        };
    });

    app.directive("finishRenderFilters",function($timeout){
        return{
            restrict: 'A',
            link: function(scope,element,attr){
                if(scope.$last === true){
                    $timeout(function(){
                        scope.$emit('ngRepeatFinished');
                    });
                }
            }
        };
    });
	
	
	