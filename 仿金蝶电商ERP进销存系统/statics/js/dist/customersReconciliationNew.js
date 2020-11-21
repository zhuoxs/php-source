define(["jquery", "print"], function(a, b, c) {
	function d() {
		q.cssCheckbox(), "true" == m.showDetail && (q.find("label").addClass("checked"), r[0].checked = !0), m.beginDate && m.endDate && k("div.grid-subtitle").text("日期: " + m.beginDate + "至" + m.endDate), k("#filter-fromDate").val(m.beginDate), k("#filter-toDate").val(m.endDate), k("#customer input").val(m.customerName), Business.customerCombo(k("#customer"), {
			defaultSelected: 0,
			addOptions: {
				text: t,
				value: 0
			}
		}), Public.dateCheck();
		var a = new Pikaday({
			field: k("#filter-fromDate")[0]
		}),
			b = new Pikaday({
				field: k("#filter-toDate")[0]
			});
		k("#filter-submit").on("click", function(c) {
			c.preventDefault();
			var d = k("#customer input").val();
			if (d === t || "" === d) return void parent.Public.tips({
				type: 1,
				content: t
			});
			var e = k("#filter-fromDate").val(),
				f = k("#filter-toDate").val(),
				g = a.getDate(),
				h = b.getDate(),
				i = window.THISPAGE.$_customer.data("contactInfo").id || "",
				l = window.THISPAGE.$_customer.data("contactInfo").name || "",
				n = r[0].checked ? "true" : "false",
				o = r[0].checked ? !0 : !1;
			return g.getTime() > h.getTime() ? void parent.Public.tips({
				type: 1,
				content: "开始日期不能大于结束日期"
			}) : (m = {
				beginDate: e,
				endDate: f,
				customerId: i,
				customerName: l,
				showDetail: n
			}, k("div.grid-subtitle").html("<p>客户：" + l + "</p><p>日期: " + e + " 至 " + f + "</p>"), void j(o))
		})
	}
	function e() {
		k("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("CUSTOMERBALANCE_PRINT") && k("div.ui-print").printTable()
		}), k("#btn-export").click(function(a) {
			if (a.preventDefault(), Business.verifyRight("CUSTOMERBALANCE_EXPORT")) {
				var b = {};
				for (var c in m) m[c] && (b[c] = m[c]);
				Business.getFile(n, b)
			}
		}), k("#customer").on("click", ".ui-icon-ellipsis", function(a) {
			if (k(this).data("hasInstance")) this.customerDialog.show().zindex();
			else {
				var b = k("#customer").prev().text().slice(0, -1),
					c = "选择" + b;
				if ("供应商" === b || "购货单位" === b) var d = "url:../settings/select_customer?type=10&multiselect=false";
				else var d = "url:../settings/select_customer?multiselect=false";
				this.customerDialog = k.dialog({
					width: 775,
					height: 510,
					title: c,
					content: d,
					data: {
						isDelete: 2
					},
					lock: !0,
					ok: function() {
						return this.content.callback(), this.hide(), !1
					},
					cancel: function() {
						return this.hide(), !1
					}
				}), k(this).data("hasInstance", !0)
			}
		}), k("#config").click(function(a) {
			u.config()
		})
	}
	function f() {
		var a = !1,
			b = !1,
			c = !1;
		l.isAdmin !== !1 || l.rights.AMOUNT_COSTAMOUNT || (a = !0), l.isAdmin !== !1 || l.rights.AMOUNT_OUTAMOUNT || (b = !0), l.isAdmin !== !1 || l.rights.AMOUNT_INAMOUNT || (c = !0);
		var d = [{
			name: "date",
			label: "单据日期",
			width: 80,
			align: "center"
		}, {
			name: "billNo",
			label: "单据编号",
			width: 200,
			align: "center"
		}, {
			name: "transType",
			label: "业务类别",
			width: 60,
			align: "center"
		}, {
			name: "invNo",
			label: "商品编号",
			width: 50,
			align: "center"
		}, {
			name: "invName",
			label: "商品名称",
			width: 100,
			align: "center"
		}, {
			name: "spec",
			label: "规格型号",
			width: 120,
			align: "center"
		}, {
			name: "unit",
			label: "单位",
			width: 60,
			align: "center"
		}, {
			name: "qty",
			label: "数量",
			width: 80,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.qtyPlaces)
			}
		}, {
			name: "price",
			label: "单价",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.pricePlaces)
			}
		}, {
			name: "totalAmount",
			label: "销售金额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "disAmount",
			label: "整单折扣额",
			width: 80,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "amount",
			label: "应收金额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "rpAmount",
			label: "实际收款金额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "inAmount",
			label: "应收款余额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "billId",
			label: "",
			width: 0,
			hidden: !0
		}, {
			name: "billType",
			label: "",
			width: 0,
			hidden: !0
		}],
			e = "local",
			f = "#";
		m.autoSearch && (e = "json", f = o), u.gridReg("grid", d), d = u.conf.grids.grid.colModel, k("#grid").jqGrid({
			url: f,
			postData: m,
			datatype: e,
			autowidth: !0,
			height: "auto",
			gridview: !0,
			colModel: d,
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
			jsonReader: {
				root: "data.list",
				userdata: "data.total",
				repeatitems: !1,
				id: "0"
			},
			onCellSelect: function(a) {
				var b = k("#grid").getRowData(a),
					c = b.billId,
					d = b.billType.toUpperCase();
				switch (d) {
				case "PUR":
					if (!Business.verifyRight("PU_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "purchase-purchase",
						text: "购货单",
						url: "../scm/invPu?action=editPur&id=" + c
					});
					break;
				case "SALE":
					if (!Business.verifyRight("SA_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "sales-sales",
						text: "销售单",
						url: "../scm/invSa?action=editSale&id=" + c
					});
					break;
				case "TRANSFER":
					if (!Business.verifyRight("TF_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-transfers",
						text: "调拨单",
						url: "../scm/invTf?action=editTf&id=" + c
					});
					break;
				case "OI":
					if (!Business.verifyRight("IO_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-otherWarehouse",
						text: "其他入库",
						url: "../scm/invOi?action=editOi&type=in&id=" + c
					});
					break;
				case "OO":
					if (!Business.verifyRight("OO_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-otherOutbound",
						text: "其他出库",
						url: "../scm/invOi?action=editOi&type=out&id=" + c
					});
					break;
				case "CADJ":
					if (!Business.verifyRight("CADJ_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-adjustment",
						text: "成本调整单",
						url: "../scm/invOi?action=editOi&type=cbtz&id=" + c
					});
					break;
				case "PAYMENT":
					if (!Business.verifyRight("PAYMENT_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-payment",
						text: "付款单",
						url: "../scm/payment?action=editPay&id=" + c
					});
					break;
				case "VERIFICA":
					if (!Business.verifyRight("VERIFICA_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-verifica",
						text: "核销单",
						url: "/money/verification.jsp?id=" + c
					});
					break;
				case "RECEIPT":
					if (!Business.verifyRight("RECEIPT_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-receipt",
						text: "收款单",
						url: "../scm/receipt?action=editReceipt&id=" + c
					});
					break;
				case "QTSR":
					if (!Business.verifyRight("QTSR_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-otherIncome",
						text: "其它收入单",
						url: "../scm/ori?action=editInc&id=" + c
					});
					break;
				case "QTZC":
					if (!Business.verifyRight("QTZC_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-otherExpense",
						text: "其它支出单",
						url: "../scm/ori?action=editExp&id=" + c
					})
				}
			},
			loadComplete: function(a) {
				var b;
				if (a && a.data) {
					var c = a.data.list.length;
					b = c ? 31 * c : "auto"
				}
				g(b)
			},
			gridComplete: function() {
				k("#grid").footerData("set", {
					transType: "合计:"
				})
			},
			resizeStop: function(a, b) {
				u.setGridWidthByIndex(a, b + 1, "grid")
			}
		}), m.autoSearch ? (k(".no-query").remove(), k(".ui-print").show()) : k(".ui-print").hide()
	}
	function g(a) {
		a && (g.h = a);
		var b = h(),
			c = g.h,
			d = i(),
			e = k("#grid");
		c > d && (c = d), b < e.width() && (c += 17), e.jqGrid("setGridWidth", b, !1), e.jqGrid("setGridHeight", c), k("#grid-wrap").height(function() {
			return document.body.clientHeight - this.offsetTop - 36 - 5
		})
	}
	function h() {
		return k(window).width() - (h.offsetLeft || (h.offsetLeft = k("#grid-wrap").offset().left)) - 36 - 20
	}
	function i() {
		return k(window).height() - (i.offsetTop || (i.offsetTop = k("#grid").offset().top)) - 36 - 16 - 24
	}
	function j(a) {
		k(".no-query").remove(), k(".ui-print").show(), "undefined" != typeof a && (k("#grid").jqGrid(a ? "showCol" : "hideCol", ["invNo", "invName", "spec", "unit", "qty", "price"]), g()), k("#grid").clearGridData(!0), k("#grid").jqGrid("setGridParam", {
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
			customerId: "",
			customerName: "",
			showDetail: ""
		}, Public.urlParam()),
		n = "../report/customerBalance_exporter?action=exporter",
		o = "../report/customerBalance_detail?action=detail",
		p = k("#customer"),
		q = k("#match"),
		r = k("#match").find("input"),
		s = s || {};
	s.$_customer = p, this.THISPAGE = s;
	var t = "（请选择销货单位）";
	a("print");
	var u = Public.mod_PageConfig.init("customersReconciliationNew");
	d(), e(), f();
	var v;
	k(window).on("resize", function(a) {
		v || (v = setTimeout(function() {
			g(), v = null
		}, 50))
	})
});