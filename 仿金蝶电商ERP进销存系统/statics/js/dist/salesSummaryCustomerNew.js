define(["jquery", "print"], function(a, b, c) {
	function d() {
		Business.filterCustomer(), Business.filterGoods(), Business.filterStorage(), Business.moreFilterEvent(), k("#conditions-trigger").trigger("click"), k("#filter-fromDate").val(m.beginDate || ""), k("#filter-toDate").val(m.endDate || ""), k("#filter-customer input").val(m.customerNo || ""), k("#filter-goods input").val(m.goodsNo || ""), k("#filter-storage input").val(m.storageNo || ""), m.beginDate && m.endDate && (k("#selected-period").text(m.beginDate + "至" + m.endDate), k("div.grid-subtitle").text("日期: " + m.beginDate + " 至 " + m.endDate)), k("#filter-fromDate, #filter-toDate").datepicker(), Public.dateCheck(), l.rights.SAREPORTBU_COST || l.isAdmin ? (k("#profit-wrap").show(), "1" === m.profit && k("#profit-wrap input").attr("checked", !0)) : k("#profit-wrap").hide(), chkboxes = k("#profit-wrap").cssCheckbox(), k("#filter-submit").on("click", function(a) {
			a.preventDefault();
			var b = k("#filter-fromDate").val(),
				c = k("#filter-toDate").val();
			if (b && c && new Date(b).getTime() > new Date(c).getTime()) return void parent.Public.tips({
				type: 1,
				content: "开始日期不能大于结束日期"
			});
			m = {
				beginDate: b,
				endDate: c,
				customerNo: k("#filter-customer input").val() || "",
				goodsNo: k("#filter-goods input").val() || "",
				storageNo: k("#filter-storage input").val() || "",
				profit: ""
			}, k("#selected-period").text(b + "至" + c), k("div.grid-subtitle").text("日期: " + b + " 至 " + c), chkVals = chkboxes.chkVal();
			for (var d = 0, e = chkVals.length; e > d; d++) m[chkVals[d]] = 1;
			var f = m.profit;
			j(f), k("#filter-menu").removeClass("ui-btn-menu-cur")
		}), k("#filter-reset").on("click", function(a) {
			a.preventDefault(), k("#filter-fromDate").val(m.beginDate), k("#filter-toDate").val(m.endDate), k("#filter-customer input").val(""), k("#filter-goods input").val(""), k("#filter-storage input").val(""), m.customerNo = "", m.goodsNo = "", m.storageNo = ""
		})
	}
	function e() {
		k("#refresh").on("click", function(a) {
			a.preventDefault(), k("#filter-submit").click()
		}), k("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTBU_PRINT") && k("div.ui-print").printTable()
		}), k("#btn-export").click(function(a) {
			a.preventDefault(), Business.verifyRight("SAREPORTBU_EXPORT") && Business.getFile(n, m)
		}), k("#config").click(function(a) {
			p.config()
		})
	}
	function f() {
		var a = !1,
			b = !1,
			c = !1;
		l.isAdmin !== !1 || l.rights.AMOUNT_COSTAMOUNT || (a = !0), l.isAdmin !== !1 || l.rights.AMOUNT_OUTAMOUNT || (b = !0), l.isAdmin !== !1 || l.rights.AMOUNT_INAMOUNT || (c = !0);
		var d = !0;
		1 == m.profit && (d = !1);
		var e = [{
			name: "buName",
			label: "客户",
			width: 80,
			align: "center"
		}, {
			name: "invNo",
			label: "商品编号",
			width: 80,
			align: "center"
		}, {
			name: "invName",
			label: "商品名称",
			width: 200,
			align: "center"
		}, {
			name: "spec",
			label: "规格型号",
			width: 60,
			align: "center"
		}, {
			name: "unit",
			label: "单位",
			width: 100,
			align: "center"
		}, {
			name: "location",
			label: "仓库",
			width: 80,
			align: "center"
		}, {
			name: "qty",
			label: "数量",
			width: 60,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.qtyPlaces)
			}
		}, {
			name: "unitPrice",
			label: "单价",
			width: 60,
			align: "right",
			hidden: b,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.pricePlaces)
			}
		}, {
			name: "amount",
			label: "销售收入",
			width: 60,
			align: "right",
			hidden: b,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "unitCost",
			label: "单位成本",
			width: 60,
			align: "right",
			hidden: d,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.pricePlaces)
			}
		}, {
			name: "cost",
			label: "销售成本",
			width: 60,
			align: "right",
			hidden: d,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "saleProfit",
			label: "销售毛利",
			width: 60,
			align: "right",
			hidden: d,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "salepPofitRate",
			label: "毛利率",
			width: 60,
			align: "right",
			hidden: d,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "buNo",
			label: "",
			width: 0,
			hidden: !0
		}, {
			name: "locationNo",
			label: "",
			width: 0,
			hidden: !0
		}],
			f = "local",
			h = "#";
		m.autoSearch && (f = "json", h = o), p.gridReg("grid", e), e = p.conf.grids.grid.colModel, k("#grid").jqGrid({
			url: h,
			postData: m,
			datatype: f,
			autowidth: !0,
			gridview: !0,
			colModel: e,
			cmTemplate: {
				sortable: !1,
				title: !1
			},
			page: 1,
			sortname: "date",
			sortorder: "desc",
			rowNum: 1e6,
			loadonce: !0,
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !0,
			footerrow: !0,
			userDataOnFooter: !0,
			jsonReader: {
				root: "data.list",
				userdata: "data.total",
				repeatitems: !1,
				id: "0"
			},
			onCellSelect: function(a) {
				if (Business.verifyRight("SAREPORTDETAIL_QUERY")) {
					var b = k("#grid").getRowData(a),
						c = b.buNo,
						d = b.invNo,
						e = b.locationNo;
					parent.tab.addTabItem({
						tabid: "report-salesDetail",
						text: "销售明细表",
						url: "../report/sales_detail?autoSearch=true&beginDate=" + m.beginDate + "&endDate=" + m.endDate + "&customerNo=" + c + "&goodsNo=" + d + "&storageNo=" + e + "&profit=" + m.profit
					})
				}
			},
			loadComplete: function(a) {
				var b;
				if (a && a.data) {
					var c = a.data.list.length;
					b = c ? 31 * c : 1
				}
				g(b)
			},
			gridComplete: function() {
				k("#grid").footerData("set", {
					location: "合计:"
				}), k("table.ui-jqgrid-ftable").find('td[aria-describedby="grid_location"]').prevUntil().css("border-right-color", "#fff")
			},
			resizeStop: function(a, b) {
				p.setGridWidthByIndex(a, b + 1, "grid")
			}
		}), m.autoSearch ? (k(".no-query").remove(), k(".ui-print").show()) : k(".ui-print").hide()
	}
	function g(a) {
		a && (g.h = a);
		var b = h(),
			c = g.h,
			d = i(),
			e = k("#grid");
		c > d && (c = d), b < e.width() && (c += 17), k("#grid-wrap").height(function() {
			return document.body.clientHeight - this.offsetTop - 36 - 5
		}), e.jqGrid("setGridHeight", c), e.jqGrid("setGridWidth", b, !1)
	}
	function h() {
		return k(window).width() - k("#grid-wrap").offset().left - 36 - 20
	}
	function i() {
		return k(window).height() - k("#grid").offset().top - 36 - 16
	}
	function j(a) {
		k(".no-query").remove(), k(".ui-print").show(), "undefined" != typeof a && (k("#grid").jqGrid(a ? "showCol" : "hideCol", ["unitCost", "cost", "saleProfit", "salepPofitRate"]), g()), k("#grid").clearGridData(!0), k("#grid").jqGrid("setGridParam", {
			datatype: "json",
			postData: m,
			url: o
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
			profit: ""
		}, Public.urlParam()),
		n = "../report/salesDetail_customerExporter?action=customerExporter",
		o = "../report/salesDetail_customer?action=customer";
	a("print");
	var p = Public.mod_PageConfig.init("salesSummaryCustomerNew");
	d(), e(), f();
	var q;
	k(window).on("resize", function(a) {
		q || (q = setTimeout(function() {
			g(), q = null
		}, 50))
	})
});