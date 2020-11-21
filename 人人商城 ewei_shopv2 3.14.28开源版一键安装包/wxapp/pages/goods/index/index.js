var t = getApp(), e = t.requirejs("core"), a = t.requirejs("jquery"), s = t.requirejs("biz/diyform"), i = t.requirejs("biz/goodspicker");

t.requirejs("foxui");

Page({
    data: {
        specs: [],
        options: [],
        diyform: {},
        specsTitle: "",
        total: 1,
        active: "",
        slider: "",
        tempname: "",
        buyType: "",
        icons: t.requirejs("icons"),
        isFilterShow: !1,
        listmode: "block",
        listsort: "",
        page: 1,
        loaded: !1,
        loading: !0,
        allcategory: [],
        catlevel: -1,
        opencategory: !1,
        category: {},
        category_child: [],
        category_third: [],
        filterBtns: {},
        isfilter: 0,
        list: [],
        params: {},
        count: 0,
        defaults: {
            keywords: "",
            isrecommand: "",
            ishot: "",
            isnew: "",
            isdiscount: "",
            issendfree: "",
            istime: "",
            cate: "",
            order: "",
            by: "desc",
            merchid: 0
        },
        lastcat: "",
        fromsearch: !1,
        searchRecords: [],
        areas: [],
        limits: !0,
        modelShow: !1
    },
    onLoad: function(e) {
        var s = this;
        if (s.setData({
            imgUrl: t.globalData.approot
        }), setTimeout(function() {
            s.setData({
                areas: t.getCache("cacheset").areas
            });
        }, 3e3), !a.isEmptyObject(e)) {
            var i = e.isrecommand || e.isnew || e.ishot || e.isdiscount || e.issendfree || e.istime ? 1 : 0;
            this.setData({
                params: e,
                isfilter: i,
                filterBtns: e,
                fromsearch: e.fromsearch || !1
            });
        }
        this.initCategory(), e.fromsearch || this.getList(), this.getRecord();
    },
    onShow: function() {
        this.data.fromsearch && this.setFocus();
        var t = this;
        wx.getSetting({
            success: function(e) {
                var a = e.authSetting["scope.userInfo"];
                t.setData({
                    limits: a
                });
            }
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    },
    initCategory: function() {
        var t = this;
        e.get("goods/get_category", {}, function(e) {
            t.setData({
                allcategory: e.allcategory,
                category_parent: e.allcategory.parent,
                category_child: [],
                category_third: [],
                catlevel: e.catlevel,
                opencategory: e.opencategory,
                show: !0
            });
        });
    },
    getList: function() {
        var t = this;
        t.setData({
            loading: !0
        }), t.data.params.page = t.data.page, e.get("goods/get_list", t.data.params, function(e) {
            var a = {
                loading: !1,
                count: e.total,
                show: !0
            };
            e.list || (e.list = []), e.list.length > 0 && (a.page = t.data.page + 1, a.list = t.data.list.concat(e.list), 
            e.list.length < e.pagesize && (a.loaded = !0)), t.setData(a);
        });
    },
    changeMode: function() {
        "block" == this.data.listmode ? this.setData({
            listmode: ""
        }) : this.setData({
            listmode: "block"
        });
    },
    bindSort: function(t) {
        var e = t.currentTarget.dataset.order, a = this.data.params;
        if ("" == e) {
            if (a.order == e) return;
            a.order = "", this.setData({
                listorder: ""
            });
        } else if ("minprice" == e) this.setData({
            listorder: ""
        }), a.order == e ? "desc" == a.by ? a.by = "asc" : a.by = "desc" : a.by = "asc", 
        a.order = e, this.setData({
            listorder: a.by
        }); else if ("sales" == e) {
            if (a.order == e) return;
            this.setData({
                listorder: ""
            }), a.order = "sales", a.by = "desc";
        }
        this.setData({
            params: a,
            page: 1,
            list: [],
            loading: !0,
            loaded: !1,
            sort_selected: e
        }), this.getList();
    },
    showFilter: function() {
        this.setData({
            isFilterShow: !this.data.isFilterShow
        });
    },
    btnFilterBtns: function(t) {
        var e = t.target.dataset.type;
        if (e) {
            var s = this.data.filterBtns;
            s.hasOwnProperty(e) || (s[e] = ""), s[e] ? delete s[e] : s[e] = 1;
            var i = a.isEmptyObject(s) ? 0 : 1;
            this.setData({
                filterBtns: s,
                isfilter: i
            });
        }
    },
    bindFilterCancel: function() {
        this.data.defaults.cate = "";
        var t = this.data.defaults;
        this.setData({
            page: 1,
            params: t,
            isFilterShow: !1,
            lastcat: "",
            cateogry_parent_selected: "",
            category_child_selected: "",
            category_third_selected: "",
            category_child: [],
            category_third: [],
            filterBtns: {},
            loading: !0,
            loaded: !1,
            listorder: "",
            list: []
        }), this.getList();
    },
    bindFilterSubmit: function() {
        var t = this.data.params, e = this.data.filterBtns;
        for (var s in e) t[s] = e[s];
        a.isEmptyObject(e) && (t = this.data.defaults), t.cate = this.data.lastcat, this.setData({
            page: 1,
            params: t,
            isFilterShow: !1,
            filterBtns: e,
            list: [],
            loading: !0,
            loaded: !1
        }), this.getList();
    },
    bindCategoryEvents: function(t) {
        var e = t.target.dataset.id;
        this.setData({
            lastcat: e
        });
        var a = t.target.dataset.level;
        1 == a ? (this.setData({
            category_child: [],
            category_third: []
        }), this.setData({
            category_parent_selected: e,
            category_child: this.data.allcategory.children[e]
        })) : 2 == a ? (this.setData({
            category_third: []
        }), this.setData({
            category_child_selected: e,
            category_third: this.data.allcategory.children[e]
        })) : this.setData({
            category_third_selected: e
        });
    },
    bindSearch: function(t) {
        t.target;
        this.setData({
            list: [],
            loading: !0,
            loaded: !1
        });
        var e = a.trim(t.detail.value), s = this.data.defaults;
        "" != e ? (s.keywords = e, this.setData({
            page: 1,
            params: s,
            fromsearch: !1
        }), this.getList(), this.setRecord(e)) : (s.keywords = "", this.setData({
            page: 1,
            params: s,
            listorder: "",
            fromsearch: !1
        }), this.getList());
    },
    bindInput: function(t) {
        var e = a.trim(t.detail.value), s = this.data.defaults;
        s.keywords = "", s.order = this.data.params.order, s.by = this.data.params.by, "" == e && (this.setData({
            page: 1,
            list: [],
            loading: !0,
            loaded: !1,
            params: s,
            listorder: s.by,
            fromsearch: !0
        }), this.getRecord());
    },
    bindFocus: function(t) {
        "" == a.trim(t.detail.value) && this.setData({
            fromsearch: !0
        });
    },
    bindback: function() {
        wx.navigateBack();
    },
    bindnav: function(t) {
        var e = a.trim(t.currentTarget.dataset.text), s = this.data.defaults;
        s.keywords = e, this.setData({
            params: s,
            page: 1,
            fromsearch: !1
        }), this.getList(), this.setRecord(e);
    },
    getRecord: function() {
        var e = t.getCache("searchRecords");
        this.setData({
            searchRecords: e
        });
    },
    setRecord: function(e) {
        if ("" != e) {
            var s = t.getCache("searchRecords");
            if (a.isArray(s)) {
                var i = [];
                i.push(e);
                for (var r in s) {
                    if (i.length > 20) break;
                    s[r] != e && null != s && "null" != s && i.push(s[r]);
                }
                s = i;
            } else (s = []).push(e);
            t.setCache("searchRecords", s);
        } else t.setCache("searchRecords", []);
        this.getRecord();
    },
    delRecord: function() {
        this.setRecord(""), this.setData({
            fromsearch: !0
        });
    },
    setFocus: function() {
        var t = this;
        setTimeout(function() {
            t.setData({
                focusin: !0
            });
        }, 1e3);
    },
    selectPicker: function(e) {
        t.checkAuth();
        var a = this;
        i.selectpicker(e, a, "goodslist");
    },
    specsTap: function(t) {
        var e = this;
        i.specsTap(t, e);
    },
    chooseGift: function(t) {
        i.chooseGift(t, this);
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            specsTitle: ""
        });
    },
    buyNow: function(t) {
        var e = this;
        i.buyNow(t, e);
    },
    getCart: function(t) {
        var e = this;
        i.getCart(t, e);
    },
    select: function() {
        var t = this;
        i.select(t);
    },
    inputNumber: function(t) {
        var e = this;
        i.inputNumber(t, e);
    },
    number: function(t) {
        var e = this;
        i.number(t, e);
    },
    onChange: function(t) {
        return s.onChange(this, t);
    },
    DiyFormHandler: function(t) {
        return s.DiyFormHandler(this, t);
    },
    selectArea: function(t) {
        return s.selectArea(this, t);
    },
    bindChange: function(t) {
        return s.bindChange(this, t);
    },
    onCancel: function(t) {
        return s.onCancel(this, t);
    },
    onConfirm: function(t) {
        return s.onConfirm(this, t);
    },
    getIndex: function(t, e) {
        return s.getIndex(t, e);
    },
    cancelclick: function() {
        this.setData({
            modelShow: !1
        });
    },
    confirmclick: function() {
        this.setData({
            modelShow: !1
        }), wx.openSetting({
            success: function(t) {}
        });
    }
});