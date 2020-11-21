define(["jquery", "print"], function(a, b, c) {
	function d() {
		Business.filterCustomer(), Business.filterGoods(), Business.filterStorage(), Business.filterSaler(), Business.moreFilterEvent(), l("#conditions-trigger").trigger("click"), l("#filter-fromDate").val(n.beginDate || ""), l("#filter-toDate").val(n.endDate || ""), l("#filter-customer input").val(n.customerNo || ""), l("#filter-goods input").val(n.goodsNo || ""), l("#filter-storage input").val(n.storageNo || ""), n.beginDate && n.endDate && (l("#selected-period").text(n.beginDate + "至" + n.endDate), l("div.grid-subtitle").text("日期: " + n.beginDate + " 至 " + n.endDate)), l("#filter-fromDate, #filter-toDate").datepicker(), Public.dateCheck();
		var a = parent.SYSTEM;
		a.rights.SAREPORTDETAIL_COST || a.isAdmin ? (l("#profit-wrap").show(), "1" === n.profit && l("#profit-wrap input").attr("checked", !0)) : l("#profit-wrap").hide();
		var b = l("#profit-wrap").cssCheckbox();
		l("#filter-submit").on("click", function(a) {
			a.preventDefault();
			var c = l("#filter-fromDate").val(),
				d = l("#filter-toDate").val();
			return c && d && new Date(c).getTime() > new Date(d).getTime() ? void parent.Public.tips({
				type: 1,
				content: "开始日期不能大于结束日期"
			}) : (n = {
				beginDate: c,
				endDate: d,
				customerNo: l("#filter-customer input").val() || "",
				goodsNo: l("#filter-goods input").val() || "",
				storageNo: l("#filter-storage input").val() || "",
				salesId: l("#filter-saler input").val() || "",
				profit: b.chkVal().length > 0 ? "1" : "0"
			}, l("#selected-period").text(c + "至" + d), l("div.grid-subtitle").text("日期: " + c + " 至 " + d), void k(+n.profit))
		}), l("#filter-reset").on("click", function(a) {
			a.preventDefault(), l("#filter-fromDate").val(n.beginDate), l("#filter-toDate").val(n.endDate), l("#filter-customer input").val(""), l("#filter-goods input").val(""), l("#filter-storage input").val(""), l("#filter-saler input").val(""), b.chkNot()
		})
	}
	function e() {
		var a = n.customer ? n.customer.split(",") : "",
			b = n.goods ? n.goods.split(",") : "",
			c = "";
		a && b ? c = "「您已选择了<b>" + a.length + "</b>个客户，<b>" + b.length + "</b>个商品进行查询」" : a ? c = "「您已选择了<b>" + a.length + "</b>个客户进行查询」" : b && (c = "「您已选择了<b>" + b.length + "</b>个商品进行查询」"), l("#cur-search-tip").html(c)
	}
	function f() {
		l("#refresh").on("click", function(a) {
			a.preventDefault(), k()
		}), l("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTDETAIL_PRINT") && l("div.ui-print").printTable()
		}), l("#btn-export").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTDETAIL_EXPORT") && Business.getFile("../report/salesDetail_detailExporter?action=detailExporter", n)
		}), l("#config").click(function(a) {
			o.config()
		})
	}
	function g() {
		var a = !1,
			b = !0;
		m.isAdmin !== !1 || m.rights.AMOUNT_OUTAMOUNT || (a = !0), "1" === n.profit && (b = !1);
		var c = [{
			name: "date",
			label: "销售日期",
			width: 80,
			fixed: !0,
			align: "center"
		}, {
			name: "billId",
			label: "销售ID",
			width: 0,
			hidden: !0
		}, {
			name: "billNo",
			label: "销售单据号",
			width: 110,
			fixed: !0,
			align: "center"
		}, {
			name: "transType",
			label: "业务类别",
			width: 60,
			fixed: !0,
			align: "center"
		}, {
			name: "salesName",
			label: "销售人员",
			width: 80
		}, {
			name: "buName",
			label: "客户",
			width: 150,
			classes: "ui-ellipsis",
			title: !0
		}, {
			name: "invNo",
			label: "商品编号",
			width: 100
		}, {
			name: "invName",
			label: "商品名称",
			width: 200,
			classes: "ui-ellipsis",
			title: !0
		}, {
			name: "spec",
			label: "规格型号",
			width: 60
		}, {
			name: "unit",
			label: "单位",
			width: 50,
			fixed: !0,
			align: "center"
		}, {
			name: "location",
			label: "仓库",
			width: 60,
			classes: "ui-ellipsis",
			title: !0
		}, {
			name: "qty",
			label: "数量",
			width: 100,
			fixed: !0,
			align: "right"
		}, {
			name: "unitPrice",
			label: "单价",
			width: 100,
			fixed: !0,
			hidden: a,
			align: "right"
		}, {
			name: "amount",
			label: "销售收入",
			width: 100,
			fixed: !0,
			hidden: a,
			align: "right"
		}, {
			name: "unitCost",
			label: "单位成本",
			width: 80,
			fixed: !0,
			hidden: b,
			align: "right"
		}, {
			name: "cost",
			label: "销售成本",
			width: 80,
			fixed: !0,
			hidden: b,
			align: "right"
		}, {
			name: "saleProfit",
			label: "销售毛利",
			width: 80,
			fixed: !0,
			hidden: b,
			align: "right"
		}, {
			name: "salepPofitRate",
			label: "毛利率",
			width: 80,
			fixed: !0,
			hidden: b,
			align: "right"
		}, {
			name: "description",
			label: "备注",
			width: 150
		}],
			d = "local",
			e = "#";
		n.autoSearch && (d = "json", e = "../report/salesDetail_detail?action=detail"), o.gridReg("grid", c), c = o.conf.grids.grid.colModel, l("#grid").jqGrid({
			url: e,
			postData: n,
			datatype: d,
			autowidth: !0,
			gridview: !0,
			colModel: c,
			cmTemplate: {
				sortable: !1,
				title: !1
			},
			page: 1,
			sortname: "date",
			sortorder: "desc",
			rowNum: 3e3,
			loadonce: !0,
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !0,
			footerrow: !0,
			userDataOnFooter: !0,
			cellLayout: 0,
			jsonReader: {
				root: "data.rows",
				records: "data.records",
				total: "data.total",
				userdata: "data.userdata",
				repeatitems: !1,
				id: "0"
			},
			ondblClickRow: function(a) {
				if (Business.verifyRight("SA_QUERY")) {
					var b = l("#grid").getRowData(a).billId;
					parent.tab.addTabItem({
						tabid: "sales-sales",
						text: "销售单",
						url: "../scm/invSa?action=editSale&id=" + b
					})
				}
			},
			loadComplete: function(a) {
				var b;
				if (a && a.data) {
					var c = a.data.rows.length;
					b = c ? 31 * c : 1
				}
				h(b)
			},
			gridComplete: function() {
				l("#grid").footerData("set", {
					location: "合计:"
				}), l("table.ui-jqgrid-ftable").find('td[aria-describedby="grid_location"]').prevUntil().css("border-right-color", "#fff")
			},
			resizeStop: function(a, b) {
				o.setGridWidthByIndex(a, b + 1, "grid")
			}
		}), n.autoSearch ? (l(".no-query").remove(), l(".ui-print").show()) : l(".ui-print").hide()
	}
	function h(a) {
		a && (h.h = a);
		var b = i(),
			c = h.h,
			d = j(),
			e = l("#grid");
		c > d && (c = d), b < e.width() && (c += 17), l("#grid-wrap").height(function() {
			return document.body.clientHeight - this.offsetTop - 36 - 5
		}), e.jqGrid("setGridHeight", c), e.jqGrid("setGridWidth", b, !1)
	}
	function i() {
		return l(window).width() - l("#grid-wrap").offset().left - 36 - 20
	}
	function j() {
		return l(window).height() - l("#grid").offset().top - 36 - 16
	}
	function k(a) {
		l(".no-query").remove(), l(".ui-print").show(), "number" == typeof a && (l("#grid").jqGrid(a ? "showCol" : "hideCol", ["unitCost", "cost", "saleProfit", "salepPofitRate"]), h(), l("#grid").clearGridData(!0)), l("#grid").jqGrid("setGridParam", {
			datatype: "json",
			postData: n,
			url: "../report/salesDetail_detail?action=detail"
		}).trigger("reloadGrid")
	}
	var l = a("jquery"),
		m = parent.SYSTEM,
		n = l.extend({
			beginDate: "",
			endDate: "",
			customerNo: "",
			goodsNo: "",
			storageNo: "",
			profit: "0"
		}, Public.urlParam());
	a("print");
	var o = Public.mod_PageConfig.init("salesDetail");
	d(), e(), f(), g();
	var p;
	l(window).on("resize", function(a) {
		p || (p = setTimeout(function() {
			h(), p = null
		}, 50))
	})
});