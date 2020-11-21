"use strict";

/*props={
    pageCount:30,//总页数
    currentPage:1,//当前页
    perPageNum:5,//每页按钮数(非必须,默认5)
}*/

function PageNavCreate(id,props){
    if(id&&props){
        this.id=id;
        this.pageCount = parseInt(props.pageCount),
        this.currentPage = parseInt(props.currentPage),
        this.perPageNum = props.perPageNum || 5,
        this.perPageNum = (this.perPageNum<3 ? 3 : this.perPageNum);//每页按钮数量最小值不能小于3
        this.target = document.getElementById(id);
        this.clickPage = null;
        this.halfPerPage = 3;

    }else{
        console.log("请传入正确参数");
        return false;
    }

    this.target.innerHTML = "";
    $('<div class="page-nav-inner clearfloat">'+
                    '<ul class="pagination">'+
                    '</ul>'+
                    '<div class="page-input-box">'+
                        '<input class="control-input" type="text" values=""/>'+
                        '<button class="btn-green btn btn-default">Go</button>'+
                    '</div>'+
                '</div>').appendTo($(this.target));
    this.pageNavUl =  $(this.target).find("ul.pagination");
    this.pageNavInput = $(this.target).find(".page-input-box");
    
    //总页数写入placeholder
    this.pageNavInput.children('input').val("").attr({"placeholder":this.pageCount,"max":this.pageCount});

    //若是总页数小于每页按钮数
    if(this.pageCount<=this.perPageNum){
        this.pageNavUl.html("");
        $('<li class="page-nav-first">'+
              '<a href="javascript:void(null)" aria-label="First page" pagenum="1" >'+
                '<span aria-hidden="true">&laquo;</span>'+
              '</a>'+
            '</li>'+
            '<li class="page-nav-prev">'+
                '<a href="javascript:void(null)" aria-label="Previous" pagenum="'+
                        (this.currentPage==1 ? 1 : (this.currentPage-1)) +
                        '" >'+
                    '<span aria-hidden="true">&lt;</span>'+
                  '</a>'+
            '</li>').appendTo(this.pageNavUl);

        for(var i =1; i<=this.pageCount; i++){
            $('<li class="pageNum" ><a href="javascript:void(null)"  pagenum="'+i+'" >'+i+'</a></li>').appendTo(this.pageNavUl);
            if(i == this.currentPage){
                this.pageNavUl.children("li.pageNum").last().addClass('active');
            }
        }

        $('<li class="page-nav-next">'+
              '<a href="javascript:void(null)" aria-label="Last page"  pagenum="'+
                (this.currentPage==this.pageCount ? this.pageCount : (this.currentPage+1)) +
                '" >'+
                '<span aria-hidden="true">&gt;</span>'+
              '</a>'+
            '</li>'+
            '<li class="page-nav-last">'+
              '<a href="javascript:void(null)" aria-label="Last page"  pagenum="'+this.pageCount+'" >'+
                '<span aria-hidden="true">&raquo;</span>'+
              '</a>'+
            '</li>').appendTo(this.pageNavUl);
    }else{//总页数大于每页按钮数
        //重写一遍翻页按钮 START
        this.pageNavUl.html("");
        $('<li class="page-nav-first">'+
              '<a href="javascript:void(null)" aria-label="First page" pagenum="1" >'+
                '<span aria-hidden="true">&laquo;</span>'+
              '</a>'+
            '</li>'+
            '<li class="page-nav-prev">'+
                '<a href="javascript:void(null)" aria-label="Previous" pagenum="'+
                        (this.currentPage==1 ? 1 : (this.currentPage-1)) +
                        '" >'+
                    '<span aria-hidden="true">&lt;</span>'+
                  '</a>'+
            '</li>').appendTo(this.pageNavUl);

        for(var i=1; i<=this.perPageNum; i++){
            $('<li class="pageNum" ><a href="javascript:void(null)"  pagenum="'+i+'" >'+i+'</a></li>').appendTo(this.pageNavUl);
            if(i == this.currentPage){
                this.pageNavUl.children("li.pageNum").last().addClass('active');
            }
        }
        $('<li class="disabled">'+
                '<a href="javascript:void(null)">...</a>'+
            '</li>'+
            '<li class="page-nav-next">'+
              '<a href="javascript:void(null)" aria-label="Last page"  pagenum="'+
                (this.currentPage==this.pageCount ? this.pageCount : (this.currentPage+1)) +
                '" >'+
                '<span aria-hidden="true">&gt;</span>'+
              '</a>'+
            '</li>'+
            '<li class="page-nav-last">'+
              '<a href="javascript:void(null)" aria-label="Last page"  pagenum="'+this.pageCount+'" >'+
                '<span aria-hidden="true">&raquo;</span>'+
              '</a>'+
            '</li>').appendTo(this.pageNavUl);
        //重写一遍翻页按钮 END

        //若是目标页小于每页按钮数的一半/有余数+1,偶数+1
        this.halfPerPage = parseInt(this.perPageNum/2)+1;
        this.lastHalfPage = this.perPageNum%2==0 ? (this.perPageNum/2)-1 : parseInt(this.perPageNum/2);
        if(this.currentPage<=this.halfPerPage){
            this.pageNavUl.children("li.disabled").show();
            for(var i =0;i<this.perPageNum;i++){
                this.pageNavUl.children("li.pageNum").eq(i).children('a').attr({"pagenum":i+1}).html(i+1);
            }
            this.pageNavUl.children("li.pageNum").removeClass('active').eq(this.currentPage-1).addClass('active');
            this.pageNavUl.children("li:last-child").children("a").attr({"pagenum":this.pageCount});
        }else if(this.currentPage>=(this.pageCount - this.lastHalfPage)){//若是目标页是倒数每页按钮数一半以内,奇数一半，偶数-1
            for(var i =0;i<this.perPageNum;i++){
                this.pageNavUl.children("li.disabled").hide();
                this.pageNavUl.children("li.pageNum").eq(i).children('a').attr({"pagenum":(this.pageCount-this.perPageNum+1+i)}).html(this.pageCount-this.perPageNum+1+i);
                if((this.pageCount-this.perPageNum+1+i) == this.currentPage){
                    this.pageNavUl.children("li.pageNum").removeClass('active');
                    this.pageNavUl.children("li.pageNum").eq(i).addClass('active');
                }
            }
            this.pageNavUl.children("li:last-child").children("a").attr({"pagenum":this.pageCount});
        }else{
            this.pageNavUl.children("li.disabled").show();
            for(var i =0;i<this.perPageNum;i++){
                this.pageNavUl.children("li.pageNum").eq(i).children('a').attr({"pagenum":(this.currentPage-parseInt(this.perPageNum/2)+i)}).html(this.currentPage-parseInt(this.perPageNum/2)+i);
            }
            this.pageNavUl.children("li.pageNum").removeClass('active').eq(parseInt(this.perPageNum/2)).addClass('active');
            //this.pageNavUl.children("li:last-child").attr({"pagenum":this.pageCount});
        }
    }

}

PageNavCreate.prototype.afterClick = function(func){
    this.pageNavUl.children('li.pageNum').off("click").on("click",function(event){
        if($(this).hasClass('active') != true){
            var clickPage = parseInt($(this).children('a').attr("pagenum"));
            //console.log("pageNum = "+clickPage);
            //翻页按钮点击后触发的回调函数
            func(clickPage);
        }else{
            return false;
        }
    });
    this.pageNavUl.children('li.page-nav-first').off("click").on("click",function(event){
        var clickPage = parseInt($(this).children('a').attr("pagenum"));
        //console.log("prev = "+clickPage);
        //翻页按钮点击后触发的回调函数
        func(clickPage);
    }); 
    this.pageNavUl.children('li.page-nav-prev').off("click").on("click",function(event){
        var clickPage = parseInt($(this).children('a').attr("pagenum"));
        //console.log("prev = "+clickPage);
        //翻页按钮点击后触发的回调函数
        func(clickPage);
    }); 
    this.pageNavUl.children('li.page-nav-next').off("click").on("click",function(event){
        var clickPage = parseInt($(this).children('a').attr("pagenum"));
        //console.log("prev = "+clickPage);
        //翻页按钮点击后触发的回调函数
        func(clickPage);
    }); 
    this.pageNavUl.children('li.page-nav-last').off("click").on("click",function(event){
        var clickPage = parseInt($(this).children('a').attr("pagenum"));
        //console.log("next = "+clickPage);
        //翻页按钮点击后触发的回调函数
        func(clickPage);
    });

    this.pageNavInput.children('button').off("click").on("click",function(event){
        var inputVal = parseInt($(this).siblings('input').val());
        var inputMax = parseInt($(this).siblings('input').attr("max"));
        //console.log("button = "+inputVal);
        if(inputVal && inputVal<=inputMax){
            //翻页按钮点击后触发的回调函数
            func(inputVal);
        }else{
            return false;
        }
    }); 
    this.pageNavInput.children('input').off("keydown").on('keydown', function(event) {
        if(event.which == 13){//若是回车
            var inputVal = parseInt($(this).val());
            var inputMax = parseInt($(this).attr("max"));
            //console.log("input = "+inputVal);
            if(inputVal && inputVal<=inputMax){
                //翻页事件触发的回调函数
                func(inputVal);
            }else{
                return false;
            }
        }
    });

}