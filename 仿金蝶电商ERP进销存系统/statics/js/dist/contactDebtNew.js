define(["jquery", "print"], function(a, b, c) {
	function d() {
		m.matchCon ? k("#matchCon").val(m.matchCon || "请输入客户、供应商或编号查询") : (k("#matchCon").addClass("ui-input-ph"), k("#matchCon").placeholder()), m.customer && k("#customer").attr("checked", !0), m.supplier && k("#supplier").attr("checked", !0), k("#search").on("click", function(a) {
			a.preventDefault();
			var b = "请输入客户、供应商或编号查询" === k("#matchCon").val() ? "" : k.trim(k("#matchCon").val());
			m = {
				matchCon: b,
				customer: k("#customer").is(":checked") ? 1 : "",
				supplier: k("#supplier").is(":checked") ? 1 : ""
			}, j()
		})
	}
	function e() {
		k("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("ContactDebtReport_PRINT") && k("div.ui-print").printTable()
		}), k("#btn-export").click(function(a) {
			a.preventDefault(), Business.verifyRight("ContactDebtReport_EXPORT") && Business.getFile(n, m)
		}), k("#config").click(function(a) {
			p.config()
		})
	}
	function f() {
		var a = !1,
			b = !1,
			c = !1;
		l.isAdmin !== !1 || l.rights.AMOUNT_COSTAMOUNT || (a = !0), l.isAdmin !== !1 || l.rights.AMOUNT_OUTAMOUNT || (b = !0), l.isAdmin !== !1 || l.rights.AMOUNT_INAMOUNT || (c = !0);
		var d = [{
			name: "number",
			label: "往来单位编号",
			width: 80,
			align: "center"
		}, {
			name: "name",
			label: "名称",
			width: 120,
			align: "center"
		}, {
			name: "displayName",
			label: "往来单位性质",
			width: 80,
			align: "center"
		}, {
			name: "receivable",
			label: "应收款余额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "payable",
			label: "应付款余额",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}],
			e = "local",
			f = "#";
		m.autoSearch && (e = "json", f = o), p.gridReg("grid", d), d = p.conf.grids.grid.colModel, k("#grid").jqGrid({
			url: f,
			postData: m,
			datatype: e,
			autowidth: !0,
			gridview: !0,
			colModel: d,
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
					displayName: "合计:"
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
	function j() {
		k(".no-query").remove(), k(".ui-print").show(), k("#grid").clearGridData(!0), k("#grid").jqGrid("setGridParam", {
			datatype: "json",
			postData: m,
			url: o
		}).trigger("reloadGrid")
	}
	var k = a("jquery"),
		l = parent.SYSTEM,
		m = k.extend({
			matchCon: "",
			customer: "",
			supplier: ""
		}, Public.urlParam()),
		n = "../report/contactDebt_exporter?action=exporter",
		o = "../report/contactDebt_detail?action=detail";
	a("print");
	var p = Public.mod_PageConfig.init("contactDebtNew");
	d(), e(), f();
	var q;
	k(window).on("resize", function(a) {
		q || (q = setTimeout(function() {
			g(), q = null
		}, 50))
	})
});