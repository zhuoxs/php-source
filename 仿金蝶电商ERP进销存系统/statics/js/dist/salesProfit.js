define(["jquery", "print"], function(a, b, c) {
	function d() {
		Business.filterCustomer(), Business.filterGoods(), Business.filterStorage(), Business.filterSaler(), Business.moreFilterEvent(), k("#conditions-trigger").trigger("click"), k("#filter-fromDate").val(m.beginDate || ""), k("#filter-toDate").val(m.endDate || ""), k("#filter-customer input").val(m.customerNo || ""), k("#filter-saler input").val(m.salesNo || ""), k("#filter-goods input").val(m.goodsNo || ""), k("#filter-storage input").val(m.storageNo || ""), m.beginDate && m.endDate && (k("#selected-period").text(m.beginDate + "至" + m.endDate), k("div.grid-subtitle").text("日期: " + m.beginDate + " 至 " + m.endDate)), k("#filter-fromDate, #filter-toDate").datepicker(), Public.dateCheck(), "1" === m.profit && k('#profit-wrap input[name="profit"]').attr("checked", !0), "1" === m.showSku && k('#profit-wrap input[name="showSku"]').attr("checked", !0), parent.SYSTEM.enableAssistingProp || k('#profit-wrap input[name="showSku"]').parent().hide();
		var a = parent.SYSTEM;
		a.rights.SAREPORTINV_COST || a.isAdmin ? k('#profit-wrap input[name="profit"]').parent().show() : k('#profit-wrap input[name="profit"]').parent().hide();
		var b = k("#profit-wrap").show().cssCheckbox();
		k("#filter-submit").on("click", function(a) {
			a.preventDefault();
			var c = k("#filter-fromDate").val(),
				d = k("#filter-toDate").val();
			if (c && d && new Date(c).getTime() > new Date(d).getTime()) return void parent.Public.tips({
				type: 1,
				content: "开始日期不能大于结束日期"
			});
			m = {
				beginDate: c,
				endDate: d,
				customerNo: k("#filter-customer input").val() || "",
				goodsNo: k("#filter-goods input").val() || "",
				storageNo: k("#filter-storage input").val() || "",
				profit: 1,
				showSku: 0,
				salesNo: k("#filter-saler input").val() || "",
			}, chkVals = b.chkVal();
			for (var e = 0, f = chkVals.length; f > e; e++) m[chkVals[e]] = 1;
			k("#selected-period").text(c + "至" + d), k("div.grid-subtitle").text("日期: " + c + " 至 " + d), j(+m.profit), k("#filter-menu").removeClass("ui-btn-menu-cur")
		}), k("#filter-reset").on("click", function(a) {
			a.preventDefault(), k("#filter-fromDate").val(m.beginDate), k("#filter-toDate").val(m.endDate), k("#filter-customer input").val(""), k("#filter-goods input").val(""), k("#filter-storage input").val(""), b.chkNot()
		})
	}
	function e() {
		k("#refresh").on("click", function(a) {
			a.preventDefault(), k("#filter-submit").trigger("click")
		}), k("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTINV_PRINT") && k("div.ui-print").printTable()
		}), k("#btn-export").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTINV_EXPORT") && Business.getFile(o, m)
		}), k("#config").click(function(a) {
			p.config()
		})
	}
	function f() {
		var a = !1;
		l.isAdmin !== !1 || l.rights.AMOUNT_OUTAMOUNT || (a = !0);
		var b = [{
			name: "billDate",
			label: "单据日期",
			width: 100,
			frozen: !0
		}, {
			name: "contactName",
			label: "客户",
			width: 120,
			frozen: !0
		}, {
			name: "salesName",
			label: "销售人员",
			width: 80,
			frozen: !0
		}, {
			name: "billNo",
			label: "单据编号",
			width: 130,
			frozen: !0
		}, {
			name: "transTypeName",
			label: "业务类型",
			width: 60,
			frozen: !0
		}, {
			name: "contactNo",
			label: "客户",
			hidden: !0,
			width: 0
		}, {
			name: "salesNo",
			label: "销售人员",
			hidden: !0,
			width: 0
		}, {
			name: "totalQty",
			label: "数量",
			width: 50,
			align: "right",
			sortable: !0
		}, {
			name: "totalAmount",
			label: "销售收入",
			width: 80,
			align: "right"
		}, {
			name: "totalCost",
			label: "销售成本",
			width: 80,
			align: "right"
		}, {
			name: "saleProfit",
			label: "销售毛利<br/>(销售收入-销售成本)",
			width: 130,
			align: "right"
		}, {
			name: "salepPofitRate",
			label: "毛利率",
			width: 80,
			align: "right"
		}, {
			name: "disAmount",
			label: "优惠金额",
			width: 80,
			align: "right"
		}, {
			name: "pureProfit",
			label: "销售净利润<br/>(销售毛利-优惠金额)",
			width: 130,
			align: "right"
		}, {
			name: "pureProfitRate",
			label: "净利润率",
			width: 80,
			align: "right",
		}, {
			name: "amount",
			label: "优惠后金额",
			width: 80,
			align: "right",
		}, {
			name: "ysAmount",
			label: "应收金额",
			width: 80,
			align: "right",
		}, {
			name: "rpAmount",
			label: "已收款金额",
			width: 80,
			align: "right",
		}, {
			name: "description",
			label: "整单备注",
			width: 80,
			align: "right",
		}],
			c = "local",
			d = "#";
		m.autoSearch && (c = "json", d = n), p.gridReg("grid", b), b = p.conf.grids.grid.colModel, k("#grid").jqGrid({
			url: d,
			postData: m,
			datatype: c,
			autowidth: !0,
			gridview: !0,
			colModel: b,
			cmTemplate: {
				sortable: !1,
				title: !1
			},
			page: 1,
			sortname: "date",
			sortorder: "desc",
			rowNum: 1e6,
			loadonce: !1,
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !0,
			footerrow: !0,
			userDataOnFooter: !0,
			jsonReader: {
				root: "data.rows",
				records: "data.records",
				total: "data.total",
				userdata: "data.userdata",
				repeatitems: !1,
				id: "0"
			},
			onCellSelect: function(a) {
				if (Business.verifyRight("SAREPORTDETAIL_QUERY")) {
					var b = k("#grid").getRowData(a),
						c = b.contactNo,
						d = b.invNo,
						e = b.locationNo;
					parent.tab.addTabItem({
						tabid: "report-salesDetail",
						text: "销售明细表",
						url: "../report/sales_detail?autoSearch=true&beginDate=" + m.beginDate + "&endDate=" + m.endDate + "&customerNo=" + c + "&profit=1" + "&salesId=" + b.salesNo
					})
				}
			},
			loadComplete: function(a) {
				var b, c = k("#grid").getGridParam("sortname"),
					d = k("#grid").getGridParam("sortorder");
				if (m.sidx = c, m.sord = d, a && a.data) {
					var e = a.data.rows.length;
					b = e ? 31 * e : 1
				}
				g(b)
			},
			gridComplete: function() {
				k("#grid").footerData("set", {
					transTypeName: "合计:"
				}), k("table.ui-jqgrid-ftable").find('td[aria-describedby="grid_transTypeName"]').prevUntil().css("border-right-color", "#fff")
			},
			resizeStop: function(a, b) {
				p.setGridWidthByIndex(a, b + 1, "grid")
			}
		}).jqGrid("setFrozenColumns"), m.autoSearch ? (k(".no-query").remove(), k(".ui-print").show()) : k(".ui-print").hide()
	}
	function g(a) {
		a && (g.h = a);
		var b = h(),
			c = g.h,
			d = i(),
			e = k("#grid");
		c > d && (c = d), b < e.width() && (c += 17), k("#grid-wrap").height(function() {
			return document.body.clientHeight - this.offsetTop - 36 - 5
		}), e.jqGrid("setGridHeight", c+230), e.jqGrid("setGridWidth", b, !1)
	}
	function h() {
		return k(window).width() - k("#grid-wrap").offset().left - 36 - 20
	}
	function i() {
		return k(window).height() - k("#grid").offset().top - 36 - 16
	}
	function j(a) {
		k(".no-query").remove(), k(".ui-print").show(), "number" == typeof a && (k("#grid").jqGrid(1 ? "showCol" : "hideCol", ["unitCost", "cost", "saleProfit", "salepPofitRate"]), g()), k("#grid").clearGridData(!0), k("#grid").jqGrid("setGridParam", {
			datatype: "json",
			postData: m,
			url: n
		}).trigger("reloadGrid")
	}
	var k = a("jquery"),
		l = parent.SYSTEM,
		m = k.extend({
			beginDate: "",
			endDate: "",
			customerNo: "",
			goodsNo: "",
			storageNo: "",
			profit: 0,
			showSku: 0,
			salesNo: ""
		}, Public.urlParam()),
		n = "../report/salesProfit_inv?action=inv",
		o = "../report/salesProfit_invExporter?action=invExporter";
	a("print");
	var p = Public.mod_PageConfig.init("salesSummary");
	d(), e(), f();
	var q;
	k(window).on("resize", function(a) {
		q || (q = setTimeout(function() {
			g(), q = null
		}, 50))
	})
});