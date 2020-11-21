function init() {
	SYSTEM.ISSERNUM || SYSTEM.enableAssistingProp || SYSTEM.ISWARRANTY || $("#tab").find(".tabItem:eq(2)").hide(), void 0 !== cRowId ? Public.ajaxPost("../basedata/inventory/query?action=query", {
		id: cRowId
	}, function(a) {
		200 === a.status ? (rowData = a.data, initField(), initSkuGrid(rowData.invSkus), initGrid(rowData.propertys), initCombo(), initEvent(),initCombinationGrid(rowData.sonGoods)) : parent.parent.Public.tips({
			type: 1,
			content: a.msg
		})
	}) : (initField(), initSkuGrid(), initGrid(), initCombo(), initEvent(),initCombinationGrid())
}
function initPopBtns() {
	var a = "add" == oper ? ["保存", "关闭"] : ["确定", "取消"];
	api.button({
		id: "confirm",
		name: a[0],
		focus: !0,
		callback: function() {
			return $form.trigger("validate"), !1
		}
	}, {
		id: "cancel",
		name: a[1]
	})
}
function postCustomerData() {
	if ("add" == oper) {
		cancleGridEdit();
		var a = $("#name").val();
		Public.ajaxPost("../basedata/inventory/checkName?action=checkName", {
			name: a
		}, function(b) {
			-1 == b.status ? $.dialog.confirm('商品名称 "' + a + '" 已经存在！是否继续？', function() {
				postData()
			}) : postData()
		})
	} else postData()
}
function postData() {
	var a = "add" == oper ? "新增商品" : "修改商品",
		b = getCustomerData();
	if (b) {
		var c = {};
		c.skuAssistId = b.skuAssistId, c.skuClassId = 0, $itemList.find("input:checkbox").each(function() {
			var a = $(this).parent().text();
			this.checked && (c.skuName = c.skuName ? c.skuName + "+" + a : a)
		}), Public.ajaxPost("../basedata/inventory/" + ("add" == oper ? "add" : "update"), b, function(d) {
			if (200 == d.status) {
				if (parent.parent.Public.tips({
					content: a + "成功！"
				}), b.isWarranty && (d.data.safeDays = b.safeDays, d.data.advanceDay = b.advanceDay), SYSTEM.enableAssistingProp && d.data.skuClassId) {
					for (var e = !0, f = 0, g = SYSTEM.assistPropGroupInfo.length; g > f; f++) SYSTEM.assistPropGroupInfo[f].skuId === d.data.skuClassId && (e = !1);
					e && (c.skuId = d.data.skuClassId, SYSTEM.assistPropGroupInfo.push(c))
				}
				if (callback && "function" == typeof callback) {
					var h = getTempData(d.data);
					callback(h, oper, window)
				}
			} else parent.parent.Public.tips({
				type: 1,
				content: a + "失败！" + d.msg
			})
		})
	}
}
function getCustomerData() {
	var a = getEntriesData();
	var s = getCombinationData().entriesData;
	if (a) {
		var b = {
			id: rowData.id,
			number: $.trim($("#number").val()),
			name: $.trim($("#name").val()),
			categoryId: categoryTree.getValue(),
			spec: $.trim($("#specs").val()),
			locationId: storageCombo.getValue(),
			locationName: 0 === storageCombo.getValue() ? "" : storageCombo.getText(),
			baseUnitId: unitCombo.getValue(),
			purPrice: Public.currencyToNum($("#purchasePrice").val()),
			salePrice: Public.currencyToNum($("#salePrice").val()),
			wholesalePrice: Public.currencyToNum($("#wholesalePrice").val()),
			vipPrice: Public.currencyToNum($("#vipPrice").val()),
			discountRate1: $.trim($("#discountRate1").val()),
			discountRate2: $.trim($("#discountRate2").val()),
			lowQty: Number($("#minInventory").val()) || "",
			highQty: Number($("#maxInventory").val()) || "",
			propertys: JSON.stringify(a),
			remark: $("#note").val() == $("#note")[0].defaultValue ? "" : $("#note").val(),
			barCode: $("#barCode").val(),
			warehouseWarning: 0,
			warehouseWarningSku: 0,
			sonGoods: JSON.stringify(s)
		};
		if (SYSTEM.enableStorage && (b.jianxing = jianxingCombo.getValue(), b.length = $("#length").val(), b.width = $("#width").val(), b.height = $("#height").val(), b.weight = $("#weight").val()), SYSTEM.enableAssistingProp) {
			$itemList.find("input:checkbox").each(function() {
				this.checked && (b.skuAssistId = b.skuAssistId ? b.skuAssistId + "," + this.id : this.id)
			});
			var c = getSkuEntriesData();
			if (!c) return !1;
			b.invSkus = JSON.stringify(c)
		}
		if (SYSTEM.ISSERNUM && (b.isSerNum = $isSerNum[0].checked ? 1 : 0), SYSTEM.ISWARRANTY && (b.isWarranty = $isWarranty[0].checked ? 1 : 0, b.isWarranty && (b.safeDays = $safeDays.val(), b.advanceDay = $advanceDay.val())), $("#warning").find("input")[0].checked) {
			delete b.lowQty, delete b.highQty, b.warehouseWarning = 1;
			var c = getWarningEntriesData();
			if (!c) return !1;
			b.warehousePropertys = JSON.stringify(c), $("#warningSku").find("input")[0].checked && (b.warehouseWarningSku = 1)
		}
		return "edit" == oper && (b.deleteRow = JSON.stringify(deleteRow)), b
	}
}
function hasEntriesData(a, b) {
	for (var c = $grid.jqGrid("getDataIDs"), d = 0, e = c.length; e > d; d++) {
		var f = c[d],
			g = $grid.jqGrid("getRowData", f),
			h = $("#" + f).data("storageInfo"),
			i = $("#" + f).data("skuInfo") || {},
			j = !1;
		switch (a) {
		case "checkQty":
			"" != g.quantity || (j = !0);
			break;
		case "checkSafeDays":
			"" != g.safeDays || (j = !0);
			break;
		case "checkQichuSku":
			i.skuAssistId || (j = !0);
			break;
		default:
			h && "" != g.quantity || (j = !0)
		}
		if (j) break;
		return !0
	}
	return !1
}
function getEntriesData() {
	var a = [],
		b = $grid.jqGrid("getDataIDs");
	cancleGridEdit();
	for (var c = 0, d = b.length; d > c; c++) {
		var e, f = b[c],
			g = $grid.jqGrid("getRowData", f),
			h = $("#" + f).data("storageInfo");
		if (!h || "" == g.quantity || "" == g.unitCost || "" == g.amount) {
			if (!h) break;
			if ("" == g.quantity) return defaultPage.Public.tips({
				type: 2,
				content: "期初数量不能为空！"
			}), void $grid.jqGrid("editCellByColName", f, "quantity")
		}
		if (e = {
			locationId: h.id,
			quantity: g.quantity,
			unitCost: Public.currencyToNum(g.unitCost),
			amount: Public.currencyToNum(g.amount),
			batch: "",
			prodDate: "",
			safeDays: "",
			validDate: ""
		}, SYSTEM.enableAssistingProp) {
			var i = getSkuEntriesData(!0);
			if (i && i.length) {
				var j = $("#" + f).data("skuInfo");
				if (!j || !j.skuAssistId) return defaultPage.Public.tips({
					type: 2,
					content: "属性不能为空"
				}), $grid.jqGrid("editCellByColName", f, "skuName"), !1;
				$.extend(!0, e, {
					skuAssistId: j.skuAssistId
				})
			}
		}
		if (SYSTEM.ISSERNUM && (e.serNum = $("#" + f).data("serNumInfo")), SYSTEM.ISWARRANTY && $isWarranty[0].checked) {
			if (!g.batch && Number($safeDays.val()) <= 0) return defaultPage.Public.tips({
				type: 2,
				content: "期初批次不能为空！"
			}), void $grid.jqGrid("editCellByColName", f, "batch");
			if (e.batch = g.batch, Number($safeDays.val()) > 0) {
				if (!g.prodDate) return defaultPage.Public.tips({
					type: 2,
					content: "期初生产日期不能为空！"
				}), void $grid.jqGrid("editCellByColName", f, "prodDate");
				$.extend(!0, e, {
					prodDate: g.prodDate,
					safeDays: g.safeDays,
					validDate: g.validDate
				})
			}
		}
		"edit" == oper ? e.id = -1 != $.inArray(f, propertysIds) ? f : 0 : e.id = 0, a.push(e)
	}
	return a
}
function getCombinationData() {
	cancleGridEdit();
	for (var a = {}, b = [], c = $gridCombination.jqGrid("getDataIDs"), e = 0, f = c.length; f > e; e++) {
		var g, h = c[e],i = $gridCombination.jqGrid("getRowData", h);
		if ("" == i.number) break;
		g = {
			number: i.number,
			name: i.name,
			spec: i.spec,
			unitName: i.unitName,
			qty: i.qty,
			salePrice: i.salePrice,
			gid:i.gid
		};
		b.push(g)
	}
	return a.entriesData = b, a
}
function getWarningEntriesData() {
	var a = [],
		b = $gridWarning.jqGrid("getDataIDs"),
		c = $("#warningSku").find("input")[0].checked;
	cancleGridEdit();
	for (var d = 0, e = b.length; e > d; d++) {
		var f, g = b[d],
			h = $gridWarning.jqGrid("getRowData", g),
			i = $("#" + g).data("storageInfo");
		if (i && (h.lowQty || h.highQty)) {
			if (f = {
				locationId: i.id,
				locationName: i.name,
				highQty: Number(h.highQty) || "",
				lowQty: Number(h.lowQty) || ""
			}, c) {
				var j = $("#" + g).data("skuInfo");
				if (!j || !j.skuAssistId) return defaultPage.Public.tips({
					type: 2,
					content: "预警属性不能为空"
				}), THISPAGE.warningGrid.jqGrid("editCellByColName", g, "skuName"), !1;
				$.extend(!0, f, {
					skuAssistId: j.skuAssistId
				})
			}
			a.push(f)
		}
	}
	return a
}
function getSkuEntriesData(a, b) {
	var c = [],
		d = $gridSku.jqGrid("getDataIDs"),
		e = {},
		f = {};
	!b && cancleGridEdit();
	for (var g = 0, h = d.length; h > g; g++) {
		for (var i, j, k = d[g], l = $gridSku.jqGrid("getRowData", k), m = $.trim(l.skuNumber), n = $.trim(l.curSkuNumber), o = [], p = [], q = 0; q < $gridSku[0].p.colModel.length; q++) {
			var r = $gridSku[0].p.colModel[q];
			if ($.trim(r.label) && !r.hidden && "skuNumber" != r.name) {
				!j && (j = r);
				var s = $("#" + k).find("td:eq(" + q + ")"),
					t = s.data("skuPropInfo");
				if (!t) return a || ($gridSku.jqGrid("editCellByColName", k, s.attr("aria-describedby").split("_")[1]), defaultPage.Public.tips({
					type: 2,
					content: "该属性不能为空！"
				})), !1;
				t && (o.push(t.id), p.push(t.name))
			}
		}
		if (o.length) {
			if (e[o]) return a || ($gridSku.jqGrid("editCellByColName", k, j.name), defaultPage.Public.tips({
				type: 2,
				content: "该组合已经存在！"
			})), !1;
			if (e[o] = 1, !m) return a || ($gridSku.jqGrid("editCellByColName", k, "skuNumber"), defaultPage.Public.tips({
				type: 2,
				content: "该编号不能为空！"
			})), !1;
			if (f[m]) return a || ($gridSku.jqGrid("editCellByColName", k, "skuNumber"), defaultPage.Public.tips({
				type: 2,
				content: "该编码已经存在！"
			})), !1;
			f[m] = 1, i = {
				skuNumber: m,
				curSkuNumber: n,
				skuAssistId: o.join(),
				skuBarCode: "",
				skuId: "",
				skuName: p.join("/")
			}, c.push(i)
		}
	}
	return c
}
function getTempData(a) {
	var b, c, d, e, f = 0,
		g = 0,
		h = a.propertys;
	c = categoryTree.getText() || "", unitData[a.baseUnitId] && (d = unitData[a.baseUnitId].name || "");
	for (var i = 0; i < h.length; i++) h[i].quantity && (f += h[i].quantity), h[i].amount && (g += h[i].amount);
	return f && g && (e = g / f), b = $.extend({}, a, {
		categoryName: c,
		unitName: d,
		quantity: f,
		unitCost: e,
		amount: g
	})
}
function initField() {
	$("#note").placeholder(), "edit" == oper ? ($("#number").val(rowData.number), $("#name").val(rowData.name), $category.data("defItem", rowData.categoryId), $("#specs").val(rowData.spec), $("#storage").data("defItem", rowData.locationId), $("#unit").data("defItem", ["id", rowData.baseUnitId]), void 0 != rowData.purPrice && $("#purchasePrice").val(Public.numToCurrency(rowData.purPrice, pricePlaces)), void 0 != rowData.salePrice && ($("#salePrice").val(Public.numToCurrency(rowData.salePrice, pricePlaces)), $("#wholesalePrice").val(Public.numToCurrency(rowData.wholesalePrice, pricePlaces)), $("#vipPrice").val(Public.numToCurrency(rowData.vipPrice, pricePlaces)), $("#discountRate1").val(rowData.discountRate1), $("#discountRate2").val(rowData.discountRate2)), $("#minInventory").val(rowData.lowQty), $("#maxInventory").val(rowData.highQty), rowData.remark && $("#note").val(rowData.remark), $("#barCode").val(rowData.barCode), $("#length").val(rowData.length), $("#width").val(rowData.width), $("#height").val(rowData.height), $("#weight").val(rowData.weight), rowData.isSerNum && ($isSerNum[0].checked = !0), rowData.isWarranty && ($isWarranty[0].checked = !0, $(".isWarrantyIn").show(), $safeDays.val(rowData.safeDays), $advanceDay.val(rowData.advanceDay))) : $("#storage").data("defItem", 0), api.opener.parent.SYSTEM.isAdmin || (rights.AMOUNT_INAMOUNT || $("#purchasePrice").closest("li").hide(), rights.AMOUNT_OUTAMOUNT || ($("#salePrice").closest("li").hide(), $("#wholesalePrice").closest("li").hide(), $("#vipPrice").closest("li").hide(), $("#discountRate1").closest("li").hide(), $("#discountRate2").closest("li").hide())), SYSTEM.enableStorage && $("#jdInfo").show(), SYSTEM.enableAssistingProp && ($(".prop-wrap").show().on("click", "input", function(a) {
		var b = $(this);
		if (hasEntriesData()) return a.preventDefault(), void defaultPage.Public.tips({
			type: 2,
			content: "设置了期初，不能修改该属性！"
		});
		if ($("#warningSku").find("input")[0].checked) return a.preventDefault(), void defaultPage.Public.tips({
			type: 2,
			content: "库存预警启用了‘根据属性设置’，不能修改该属性！"
		});
		if (this.checked) {
			var c = "gridSku_" + this.id;
			if ($("#" + c).length) $gridSku.jqGrid("showCol", "" + this.id);
			else {
				var d = customRow.shift();
				if (!d) return void defaultPage.Public.tips({
					type: 2,
					content: "无法继续扩展了！请尝试重新打开页面！"
				});
				var e = {
					name: this.id + "",
					label: b.parent().text()
				};
				$gridSku.jqGrid("setColProp", d.name, e), $("#gridSku_" + d.name).html(e.label).attr("id", "gridSku_" + e.name), $gridSku.jqGrid("showCol", this.id + "")
			}
		} else $gridSku.jqGrid("hideCol", this.id + "");
		$gridSku.jqGrid("setGridWidth", 720)
	}), initSkuField()), SYSTEM.ISSERNUM && ($isSerNum.parent().show(), $isSerNum.click(function(a) {
		hasEntriesData("checkQty") && (a.preventDefault(), defaultPage.Public.tips({
			type: 2,
			content: "期初中设置了数量的分录，不能修改该属性！"
		}))
	})), SYSTEM.ISWARRANTY && ($(".qur-wrap").show(), $isWarranty.click(function(a) {
		hasEntriesData("checkSafeDays") ? (a.preventDefault(), defaultPage.Public.tips({
			type: 2,
			content: "期初中设置了保质期的分录，不能修改该属性！"
		})) : ($(".isWarrantyIn").toggle(), this.checked ? $grid.jqGrid("showCol", "batch") : $grid.jqGrid("hideCol", "batch"))
	}), $safeDays.blur(function(a) {
		var b = $.trim($(this).val());
		Number(b) > 0 ? $.each(["prodDate", "safeDays", "validDate"], function(a, b) {
			$grid.jqGrid("showCol", b)
		}) : $.each(["prodDate", "safeDays", "validDate"], function(a, b) {
			$grid.jqGrid("hideCol", b)
		})
	}))
}
function initSkuField() {
	var a = [];
	if (SYSTEM.assistPropTypeInfo) {
		var b = {};
		if ("edit" == oper) for (var c = 0, d = SYSTEM.assistPropGroupInfo.length; d > c; c++) if (SYSTEM.assistPropGroupInfo[c].skuId === rowData.skuClassId) for (var e = SYSTEM.assistPropGroupInfo[c].skuAssistId.split(","), c = 0, d = e.length; d > c; c++) b[e[c]] = !0;
		for (var c = 0, d = SYSTEM.assistPropTypeInfo.length; d > c; c++) {
			var f = SYSTEM.assistPropTypeInfo[c],
				g = b[f.id] ? "checked" : "";
			a.push('<label><input type="checkbox" id="' + f.id + '" ' + g + ">" + f.name + "</label>")
		}
	}
	a.push('<label id="createSku">+</label>'), $itemList.html(a.join(""))
}
function initCombo() {
	storageCombo = $("#storage").combo({
		data: function() {
			for (var a = Public.getDefaultPage(), b = [], c = 0; c < a.SYSTEM.storageInfo.length; c++) {
				var d = a.SYSTEM.storageInfo[c];
				d["delete"] || b.push(d)
			}
			return b
		},
		value: "id",
		text: "name",
		width: comboWidth,
		defaultSelected: 0,
		cache: !1,
		editable: !1,
		emptyOptions: !0,
		extraListHtml: '<a href="#" class="quick-add-link" onclick="addStorage();return false;"><i class="ui-icon-add"></i>新增</a>'
	}).getCombo(), storageCombo.selectByValue($("#storage").data("defItem")), unitCombo = $("#unit").combo({
		data: getBaseUnit(),
		value: "id",
		text: "name",
		formatText: function(a) {
			if (a.unitTypeId) {
				for (var b = 0; b < SYSTEM.unitGroupInfo.length; b++) if (a.unitTypeId === SYSTEM.unitGroupInfo[b].id) return a.name + "(" + SYSTEM.unitGroupInfo[b].name + ")";
				return a.name + "_"
			}
			return a.name
		},
		width: comboWidth,
		defaultSelected: $("#unit").data("defItem") || 0,
		extraListHtml: '<a href="#" class="quick-add-link" onclick="addUnit();return false;"><i class="ui-icon-add"></i>新增</a>'
	}).getCombo(), gridStoCombo = Business.storageCombo($(".storageAuto"), {
		data: function() {
			for (var a = Public.getDefaultPage(), b = [], c = 0; c < a.SYSTEM.storageInfo.length; c++) {
				var d = a.SYSTEM.storageInfo[c];
				d["delete"] || b.push(d)
			}
			return b
		},
		callback: {
			onChange: function(a) {
				var b = this.input.parents("tr"),
					c = b.data("storageInfo") || {};
				a ? a.id != c.id && b.data("storageInfo", a) : b.data("storageInfo", null)
			}
		}
	}), gridStoCombo_warning = Business.storageCombo($(".storageAuto_warning"), {
		data: function() {
			for (var a = Public.getDefaultPage(), b = [], c = 0; c < a.SYSTEM.storageInfo.length; c++) {
				var d = a.SYSTEM.storageInfo[c];
				d["delete"] || b.push(d)
			}
			return b
		},
		callback: {
			onChange: function(a) {
				var b = this.input.parents("tr"),
					c = b.data("storageInfo") || {};
				a ? a.id != c.id && b.data("storageInfo", a) : b.data("storageInfo", null)
			}
		}
	}), skuCombo = $(".skuAuto").combo({
		data: function() {
			var a = getSkuEntriesData(!0, !0);
			return a ? a : []
		},
		text: "skuName",
		value: "skuAssistId",
		defaultSelected: -1,
		editable: !0,
		maxListWidth: 500,
		cache: !1,
		maxFilter: 20,
		trigger: !1,
		callback: {
			onChange: function(a) {
				var b = this.input.parents("tr"),
					c = b.data("skuInfo") || {};
				a ? a.skuAssistId != c.skuAssistId && b.data("skuInfo", a) : b.data("skuInfo", null)
			}
		}
	}).getCombo(), skuPropCombo = $(".skuPropAuto").combo({
		data: THISPAGE.handle.getskuPropComboData,
		extraListHtml: '<a href="javascript:void(0);" id="quickAddSkuProp" class="quick-add-link"><i class="ui-icon-add"></i>新增属性</a>',
		text: "name",
		value: "id",
		defaultSelected: -1,
		editable: !0,
		maxListWidth: 500,
		cache: !1,
		forceSelection: !0,
		maxFilter: 20,
		trigger: !1,
		callback: {
			onChange: function(a) {
				var b = this.input.parents("td"),
					c = b.data("skuPropInfo") || {};
				a ? a.id != c.id && b.data("skuPropInfo", a) : b.data("skuPropInfo", null)
			}
		}
	}).getCombo(),
	this.goodsCombo = Business.billGoodsCombo($(".goodsAuto"), {
		userData: {
			
		}
	})
}
function initEvent() {
	var a = /[^\\<\\>\\&\\\\\']+/;
	Public.limitInput($("#number"), a), $("#name").blur(function() {});
	var b = {
		width: 200,
		inputWidth: 145,
		defaultSelectValue: rowData.categoryId || "",
		showRoot: !1
	};
	categoryTree = Public.categoryTree($category, b), $("#specs").blur(function() {
		var a = $.trim(this.value);
		"" == a || "edit" == oper && a == rowData.spec || Public.ajaxPost("../basedata/inventory/checkSpec?action=checkSpec", {
			spec: a
		}, function(b) {
			-1 == b.status && parent.parent.Public.tips({
				type: 2,
				content: '规格型号 "' + a + '" 已经存在！'
			})
		})
	}), THISPAGE.cellPikaday = new Pikaday({
		field: $(".dateAuto")[0],
		editable: !1
	}), $(".money").keypress(Public.numerical).focus(function() {
		var a = $(this);
		this.value = Public.currencyToNum(this.value), setTimeout(function() {
			a.select()
		}, 10)
	}).blur(function() {
		this.value = Public.numToCurrency(this.value, pricePlaces).replace("-", "")
	}), $(".rate").keypress(Public.numerical).focus(function() {
		var a = $(this);
		setTimeout(function() {
			a.select()
		}, 10)
	}), $("#minInventory, #maxInventory").keypress(Public.numerical), $(".grid-wrap").on("click", ".ui-icon-triangle-1-s", function(a) {
		var b = $(this).siblings("input"),
			c = b.getCombo();
		setTimeout(function() {
			c.active = !0, c.doQuery()
		}, 10)
	}), $("#tab").find("li").each(function(a) {
		var b = $(this),
			c = $(".manage-wrapper");
		b.click(function(d) {
			if (!b.hasClass("cur")) {
				switch ($("#tab").find(".cur").text()) {
				case "高级":
					if (getSkuEntriesData()) break;
					return d.preventDefault(), !1
				}
				b.addClass("cur").siblings().removeClass("cur"), $(c[a]).show().siblings(".manage-wrapper").hide()
			}
		})
	}), $(document).bind("click.cancel", function(a) {
		null !== curRow && null !== curCol && (!$(a.target).closest("#gridCombination").length > 0 && !$(a.target).closest("#grid").length > 0 && !$(a.target).closest(".pika-single").length > 0 && $gridCombination.jqGrid("saveCell", curRow, curCol),$grid.jqGrid("saveCell", curRow, curCol), !$(a.target).closest("#gridWarning").length > 0 && $gridWarning.jqGrid("saveCell", curRow, curCol), !$(a.target).closest("#gridSku").length > 0 && $gridSku.jqGrid("saveCell", curRow, curCol))
	}), $("#createSku").click(function(a) {
		if (Business.verifyRight("FZSX_ADD")) {
			var b = function() {
					var a = $.trim($("#assistingName").val());
					a && Public.ajaxPost("../basedata/assistType/add?action=add", {
						name: a
					}, function(a) {
						200 == a.status ? (defaultPage.Public.tips({
							content: "保存成功！"
						}), $("#assistingName").val("").focus(), defaultPage.SYSTEM.assistPropTypeInfo.push(a.data), $("#createSku").before('<label><input type="checkbox" id="' + a.data.id + '">' + a.data.name + "</label>")) : defaultPage.Public.tips({
							type: 1,
							content: a.msg
						})
					})
				},
				c = ['<div class="manage-wrap assisting-manage" id="manage-wrap">', '<form action="#" id="manage-form">', '<ul class="mod-form-rows">', '<li class="row-item">', '<div class="label-wrap fl">', '<label for="assistingName">名称：</label>', "</div>", '<div class="ctn-wrap fl">', '<input type="text" id="assistingName" name="assistingName" class="ui-input" value="" />', "</div>", "</li>", "</ul>", "</form>", "<div>"].join("");
			manageDialog = $.dialog({
				title: "新增分类",
				width: 320,
				height: 100,
				content: c,
				min: !1,
				max: !1,
				lock: !1,
				init: function() {
					$("#assistingName").on("keypress", function(a) {
						return "13" == a.keyCode ? (a.stopPropagation(), b(), !1) : void 0
					}).focus()
				},
				ok: function() {
					return b(), !1
				}
			})
		}
	}), initValidator(), bindEventForEnterKey(), 
	$("#grid").on("click", ".ui-icon-plus", function(a) {
		cancleGridEdit();
		var b = $(this).parent().data("id"),
			c = ($("#grid tbody tr").length, {
				id: "num_" + THISPAGE.newId
			}),
			d = $("#grid").jqGrid("addRowData", "num_" + THISPAGE.newId, c, "before", b);
		d && ($(this).parents("td").removeAttr("class"), $(this).parents("tr").removeClass("selected-row ui-state-hover"), $("#grid").jqGrid("resetSelection"), THISPAGE.newId++)
	}), $("#grid").on("click", ".ui-icon-trash", function(a) {
		if (cancleGridEdit(), 2 === $("#grid tbody tr").length) return parent.parent.Public.tips({
			type: 2,
			content: "至少保留一条分录！"
		}), !1;
		var b = $(this).parent().data("id"),
			c = $("#grid").jqGrid("delRowData", b);
		c && (Number(b) > 0 && deleteRow.push(b), setGridFooter())
	}), $("#gridCombination").on("click", ".ui-icon-plus", function(a) {
		cancleGridEdit();
		var b = $(this).parent().data("id"),
			c = ($("#gridCombination tbody tr").length, {
				id: "sonnum_" + newSonId
			}),
			d = $("#gridCombination").jqGrid("addRowData", "sonnum_" + newSonId, c, "before", b);
		d && ($(this).parents("td").removeAttr("class"), $(this).parents("tr").removeClass("selected-row ui-state-hover"), $("#gridCombination").jqGrid("resetSelection"), curSonId = newSonId++)
	}), $("#gridCombination").on("click", ".ui-icon-trash", function(a) {
		var b = $(this).parent().data("id"),
			c = $("#gridCombination").jqGrid("delRowData", b);
	}), $("#gridWarning").on("click", ".ui-icon-plus", function(a) {
		cancleGridEdit();
		var b = $(this).parent().data("id"),
			c = $("#gridWarning tbody tr").length;
		THISPAGE.newId_warning = c + 1;
		var d = {
			id: "num_" + THISPAGE.newId_warning
		},
			e = $("#gridWarning").jqGrid("addRowData", "num_" + THISPAGE.newId_warning, d, "before", b);
		e && ($(this).parents("td").removeAttr("class"), $(this).parents("tr").removeClass("selected-row ui-state-hover"), $("#gridWarning").jqGrid("resetSelection"), THISPAGE.newId_warning++)
	}), $("#gridWarning").on("click", ".ui-icon-trash", function(a) {
		if (cancleGridEdit(), 2 === $("#gridWarning tbody tr").length) return parent.parent.Public.tips({
			type: 2,
			content: "至少保留一条分录！"
		}), !1;
		var b = $(this).parent().data("id");
		$("#gridWarning").jqGrid("delRowData", b)
	}), $("#gridSku").on("click", ".ui-icon-plus", function(a) {
		cancleGridEdit();
		var b = $(this).closest("tr")[0].id,
			c = $("#gridSku tbody tr").length;
		THISPAGE.newId_sku = c;
		var d = {
			id: THISPAGE.newId_sku
		},
			e = $("#gridSku").jqGrid("addRowData", THISPAGE.newId_sku, d, "before", b);
		e && ($(this).parents("td").removeAttr("class"), $(this).parents("tr").removeClass("selected-row ui-state-hover"), $("#gridSku").jqGrid("resetSelection"), THISPAGE.newId_sku++)
	}), $("#gridSku").on("click", ".ui-icon-trash", function(a) {
		if (cancleGridEdit(), 2 === $("#gridSku tbody tr").length) return parent.parent.Public.tips({
			type: 2,
			content: "至少保留一条分录！"
		}), !1;
		var b = $(this).closest("tr")[0].id,
			c = $("#gridSku").jqGrid("getRowData", b);
		if (c && c.skuId && "edit" == oper) $.dialog.confirm("删除的分录将不能恢复，请确认是否删除？", function() {
			Public.ajaxPost("../basedata/inventory/deleteSku?action=deleteSku", {
				invId: rowData.id,
				skuId: c.skuId
			}, function(a) {
				if (200 === a.status) {
					$("#gridSku").jqGrid("delRowData", b)
				} else defaultPage.Public.tips({
					type: 2,
					content: "删除失败 : " + a.msg
				})
			})
		});
		else {
			$("#gridSku").jqGrid("delRowData", b)
		}
	}), SYSTEM.enableStorage && (jianxingCombo = $("#jianxing").combo({
		data: [{
			id: "0",
			name: "免费"
		}, {
			id: "1",
			name: "超大件"
		}, {
			id: "2",
			name: "超大件半件"
		}, {
			id: "3",
			name: "大件"
		}, {
			id: "4",
			name: "大件半件"
		}, {
			id: "5",
			name: "中件"
		}, {
			id: "6",
			name: "中件半件"
		}, {
			id: "7",
			name: "小件"
		}, {
			id: "8",
			name: "超小件"
		}],
		value: "id",
		text: "name",
		width: comboWidth,
		defaultSelected: rowData.jianxing || void 0,
		editable: !1
	}).getCombo()), $("#itemList").on("click", "input", function(a) {
		var b = $(this),
			c = b.closest("div").find("input:checked");
		return c.length > 5 ? (parent.parent.Public.tips({
			type: 2,
			content: "辅助属性不能多于5个！"
		}), !1) : void 0
	}), $("#warning").find("input").change(function(a) {
		this.checked ? ($("#minInventory").closest("ul").hide(), $("#warningSku").show(), initWarningGrid()) : ($("#minInventory").closest("ul").show(), $("#warningSku").hide(), THISPAGE.warningGrid && THISPAGE.warningGrid.closest(".grid-wrap").hide())
	}), $("#warningSku").on("click", "input", function(a) {
		function b(a, b) {
			var c = $(".storageAuto_warning")[0];
			return c
		}
		function c(a, b, c) {
			if ("get" === b) {
				if ("" !== $(".storageAuto_warning").getCombo().getValue()) return $(a).val();
				var d = $(a).parents("tr");
				return d.removeData("storageInfo"), ""
			}
			"set" === b && $("input", a).val(c)
		}
		function d() {
			$("#initCombo").append($(".storageAuto_warning").val(""))
		}
		var e = $(this),
			f = 720;
		if (cancleGridEdit(), THISPAGE.skuGrid) {
			var g = getSkuEntriesData(!0);
			if (!g || !g.length) return defaultPage.Public.tips({
				type: 2,
				content: "请先设置辅助属性组合！"
			}), void a.preventDefault()
		}
		this.checked ? THISPAGE.warningGrid && (THISPAGE.warningGrid.jqGrid("showCol", "skuName"), THISPAGE.warningGrid.jqGrid("showCol", "operating"), THISPAGE.warningGrid.jqGrid("setGridWidth", f), THISPAGE.warningGrid.jqGrid("setColProp", "name", {
			editable: !0,
			edittype: "custom",
			editoptions: {
				custom_element: b,
				custom_value: c,
				handle: d,
				trigger: "ui-icon-triangle-1-s"
			}
		})) : (a.preventDefault(), $.dialog.confirm("取消后会清空预警表的属性列，是否继续？", function() {
			e[0].checked = !1, THISPAGE.warningGrid && (THISPAGE.warningGrid.jqGrid("hideCol", "skuName"), THISPAGE.warningGrid.jqGrid("hideCol", "operating"), THISPAGE.warningGrid.jqGrid("setGridWidth", f), THISPAGE.warningGrid.jqGrid("setColProp", "name", {
				editable: !1,
				editoptions: null
			}), THISPAGE.warningGrid.find(".skuCell").html("").closest("tr").removeData("skuInfo"))
		}), $gridSku.jqGrid("setGridParam", {
			cellEdit: !0
		}))
	}), "edit" == oper && rowData.warehouseWarning && ($("#warning").find("input").trigger("click"), "edit" == oper && rowData.warehouseWarningSku && $("#warningSku").find("input").trigger("click")), $("#quickAddSkuProp").on("click", function(a) {
		if (skuPropCombo) var b = skuPropCombo.input[0].id.split("_")[1],
			c = "新增" + $("#jqgh_gridSku_" + b).text(),
			d = parent.$.dialog({
				title: c,
				content: "url:propManage.jsp",
				data: {
					oper: "add",
					typeNumber: b,
					callback: function(a, b) {
						skuPropCombo.loadData(THISPAGE.handle.getskuPropComboData, "-1", !1), skuPropCombo.selectByValue(a.id), d.close()
					}
				},
				width: 280,
				height: 90,
				max: !1,
				min: !1,
				cache: !1,
				lock: !1
			})
	}), 
	Business.queryGoodEvent(this)//add by michen 20170717
}
function addStorage(a) {
	parent.$.dialog({
		title: "新增仓库",
		content: "url:../settings/storage_manage",
		data: {
			oper: "add",
			callback: function(a, b, c) {
				Public.ajaxPost("../basedata/invlocation?action=list", {}, function(b) {
					if (b && 200 == b.status) {
						var c = b.data.rows;
						parent.parent.SYSTEM.storageInfo = c
					} else {
						var c = [];
						parent.parent.Public.tips({
							type: 1,
							content: "获取仓库信息失败！" + b.msg
						})
					}
					storageCombo.loadData(c, "-1", !1), storageCombo.selectByValue(a.id)
				}), c && c.api.close()
			}
		},
		width: 400,
		height: 160,
		max: !1,
		min: !1,
		cache: !1
	})
}
function addUnit() {
	parent.$.dialog({
		title: "新增计量单位",
		content: "url:../settings/unit_manage",
		data: {
			oper: "add",
			callback: function(a, b, c) {
				unitCombo.loadData(getBaseUnit, ["id", a.id]), c && c.api.close()
			}
		},
		width: 400,
		height: 1 === siType ? 100 : 230,
		max: !1,
		min: !1,
		cache: !1,
		lock: !1
	})
}
function bindEventForEnterKey() {
	Public.bindEnterSkip($("#base-form"), function() {
		$("#grid tr.jqgrow:eq(0) td:eq(0)").trigger("click")
	})
}
function initGrid(a) {
	function b(a, b) {
		var c = $(".storageAuto")[0];
		return c
	}
	function c(a, b, c) {
		if ("get" === b) {
			if ("" !== $(".storageAuto").getCombo().getValue()) return $(a).val();
			var d = $(a).parents("tr");
			return d.removeData("storageInfo"), ""
		}
		"set" === b && $("input", a).val(c)
	}
	function d() {
		$("#initCombo").append($(".storageAuto").val(""))
	}
	function e(a, b) {
		var c = $(".dateAuto")[0];
		return c
	}
	function f(a, b, c) {
		return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
	}
	function g() {
		$("#initCombo").append($(".dateAuto").val(""))
	}
	function h(a, b, c) {
		if (a > 0) {
			var d = $grid.jqGrid("getCell", b.rowId, "prodDate");
			if (d) {
				var e = d.split("-");
				e.length > 0 && (d = new Date(e[0], e[1] - 1, e[2]), d.addDays(Number(a)), $grid.jqGrid("setCell", b.rowId, "validDate", d.format()))
			}
		}
		return a || "&#160;"
	}
	a || (a = []);
	var i = THISPAGE.newId - 1;
	if (a.length < i) for (var j = i - a.length, k = 0; j > k; k++) a.push({
		id: "num_" + (i - k)
	});
	else THISPAGE.newId = a.length + 1;
	var l = api.opener.parent.SYSTEM.rights,
		m = !(api.opener.parent.SYSTEM.isAdmin || l.AMOUNT_COSTAMOUNT),
		n = $(".manage-wrap").width() - 2;
	$grid.jqGrid({
		data: a,
		datatype: "clientSide",
		width: n,
		height: 264,
		rownumbers: !0,
		gridview: !0,
		onselectrow: !1,
		colModel: [{
			name: "operating",
			label: " ",
			width: 40,
			fixed: !0,
			formatter: Public.billsOper,
			align: "center",
			hidden: rowData["delete"] ? !0 : !1
		}, {
			name: "locationName",
			label: "仓库",
			width: 120,
			title: !1,
			editable: !0,
			edittype: "custom",
			editoptions: {
				custom_element: b,
				custom_value: c,
				handle: d,
				trigger: "ui-icon-triangle-1-s"
			}
		}, {
			name: "skuAssistId",
			label: "skuAssistId",
			hidden: !0
		}, {
			name: "skuId",
			label: "属性ID",
			hidden: !0
		}, {
			name: "skuName",
			label: "属性",
			width: 100,
			classes: "ui-ellipsis",
			hidden: !SYSTEM.enableAssistingProp,
			formatter: function(a, b, c) {
				if (!a && c.skuId) {
					if (tempAssistPropGroupInfo[c.skuId]) return tempAssistPropGroupInfo[c.skuId].skuName;
					for (var d = 0, e = SYSTEM.assistPropGroupInfo.length; e > d; d++) {
						var f = SYSTEM.assistPropGroupInfo[d];
						if (tempAssistPropGroupInfo[f.skuId] = f, f.skuId == c.skuId) return f.skuName
					}
				}
				return a || "&#160;"
			},
			editable: !0,
			edittype: "custom",
			editoptions: {
				custom_element: skuElem,
				custom_value: skuValue,
				handle: skuHandle,
				trigger: "ui-icon-triangle-1-s"
			}
		}, {
			name: "batch",
			label: "批次",
			width: 90,
			hidden: !(SYSTEM.ISWARRANTY && rowData.isWarranty),
			title: !1,
			editable: !0,
			align: "left"
		}, {
			name: "prodDate",
			label: "生产日期",
			width: 90,
			hidden: !(SYSTEM.ISWARRANTY && rowData.isWarranty),
			title: !1,
			editable: !0,
			edittype: "custom",
			edittype: "custom",
			editoptions: {
				custom_element: e,
				custom_value: f,
				handle: g
			}
		}, {
			name: "safeDays",
			label: "保质期(天)",
			width: 90,
			hidden: !(SYSTEM.ISWARRANTY && rowData.isWarranty),
			title: !1,
			align: "left",
			formatter: h
		}, {
			name: "validDate",
			label: "有效期至",
			width: 90,
			hidden: !(SYSTEM.ISWARRANTY && rowData.isWarranty),
			title: !1,
			align: "left"
		}, {
			name: "quantity",
			label: "期初数量",
			width: 90,
			title: !1,
			formatter: "number",
			formatoptions: {
				decimalPlaces: qtyPlaces
			},
			editable: !0,
			align: "right"
		}, {
			name: "unitCost",
			label: "单位成本",
			width: 90,
			title: !1,
			formatter: "currency",
			formatoptions: {
				showZero: !0,
				decimalPlaces: pricePlaces
			},
			editable: !0,
			align: "right",
			hidden: m
		}, {
			name: "amount",
			label: "期初总价",
			width: 90,
			title: !1,
			formatter: "currency",
			formatoptions: {
				showZero: !0,
				decimalPlaces: amountPlaces
			},
			align: "right",
			hidden: m
		}],
		cmTemplate: {
			sortable: !1
		},
		shrinkToFit: !1,
		forceFit: !0,
		cellEdit: rowData["delete"] ? !1 : !0,
		cellsubmit: "clientArray",
		rowNum: 1e4,
		localReader: {
			root: "items",
			records: "records",
			repeatitems: !0,
			id: "id"
		},
		footerrow: !0,
		loadComplete: function() {},
		gridComplete: function() {
			if ("add" != oper) {
				$grid.footerData("set", {
					locationName: "合计:",
					quantity: rowData.quantity,
					amount: rowData.amount
				}), propertysIds = [];
				for (var b, c = 0; c < a.length; c++) b = a[c], $.isNumeric(b.id) && (propertysIds.push(b.id + ""), $("#" + b.id).data("storageInfo", {
					id: b.locationId,
					name: b.locationName,
					skuId: b.skuId,
					skuName: b.skuName
				}).data("skuInfo", {
					skuId: b.skuId,
					skuName: b.skuName,
					skuAssistId: b.skuAssistId
				}).data("serNumInfo", b.invSerNumList))
			}
		},
		afterEditCell: function(a, b, c, d, e) {
			switch (THISPAGE.curID = a, b) {
			case "locationName":
				$("#" + d + "_locationName", "#grid").val(c), storageCombo.selectByText(c);
				break;
			case "skuName":
				$("#" + d + "_skuName", "#grid").val(c), skuCombo.selectByText(c);
				break;
			case "prodDate":
				c && THISPAGE.cellPikaday.setDate(c);
				break;
			case "quantity":
				if (SYSTEM.ISSERNUM && $isSerNum[0].checked) {
					$grid.jqGrid("restoreCell", d, e);
					var f = $("#" + a).data("serNumInfo"),
						g = $("#" + a).data("storageInfo"),
						h = $grid.jqGrid("getRowData", a),
						i = {
							width: 650,
							height: 400,
							title: "序列号录入",
							content: "url:/settings/serNumBatch.jsp",
							data: {
								serNumUsedList: f,
								creatable: !0,
								storageInfo: g,
								callback: function(b, c) {
									var d = !0;
									if ($("#" + a).siblings(".jqgrow").each(function(a) {
										var c = $(this).data("serNumInfo");
										if (c) for (var a = c.length - 1; a >= 0; a--) for (var e = b.length - 1; e >= 0; e--) b[e].serNum === c[a].serNum && (defaultPage.Public.tips({
											type: 2,
											content: "期初分录中已存在序列号：[" + b[e].serNum + "]"
										}), d = !1)
									}), d) {
										if (b.length) {
											$("#" + a).data("serNumInfo", b);
											var e, f = b.length,
												g = parseFloat(Public.currencyToNum(h.unitCost));
											isNaN(f) || isNaN(g) || (e = f * g), $grid.jqGrid("setRowData", a, {
												quantity: f,
												amount: e
											})
										}
										setGridFooter(), c.close()
									}
								}
							},
							init: function() {},
							lock: !0,
							ok: !1,
							cancle: !1
						};
					parent.$.dialog($.extend(!0, {}, i))
				}
			}
		},
		beforeSaveCell: function(a, b, c, d, e) {},
		afterSaveCell: function(a, b, c, d, e) {
			if ("quantity" == b || "unitCost" == b) {
				var f = floatCheck(c, b);
				if (f[0]) {
					var g, h = $grid.jqGrid("getRowData", a),
						i = parseFloat(h.quantity),
						j = parseFloat(Public.currencyToNum(h.unitCost));
					isNaN(i) || isNaN(j) || (g = i * j, $grid.jqGrid("setCell", a, "amount", g))
				} else parent.parent.Public.tips({
					type: 1,
					content: f[1]
				}), $grid.jqGrid("restoreCell", d, e);
				setGridFooter()
			}
			if ("prodDate" === b) {
				var k = $grid.jqGrid("getRowData", a),
					l = {};
				l.safeDays = k.safeDays || $safeDays.val(), !$.trim(c) && l.safeDays && (l.prodDate = (new Date).format());
				var m = c || l.prodDate;
				if (!m) return;
				var n = m.split("-");
				if (m = new Date(n[0], n[1] - 1, n[2]), "Invalid Date" === m.toString()) return defaultPage.Public.tips({
					type: 2,
					content: "日期格式错误！"
				}), void setTimeout(function() {
					$grid.jqGrid("editCellByColName", a, "prodDate")
				}, 10);
				m && $grid.jqGrid("setCell", a, "safeDays", l.safeDays)
			}
		}
	})
}

//add by michen 20170717
function initCombinationGrid(a){
	a || (a = []);
	var i = newSonId - 1;
	if (a.length < i) 
		for (var j = i - a.length, k = 0; j > k; k++) {
			a.push({
						id: "sonnum_" + (i - k)
					});
			curSonId = "sonnum_" + (i - k);
		}
	else 
		newSonId = a.length + 1;
	
	function fun_element(a, b) {
		var c = $(".goodsAuto")[0];
		return c
	}
	function fun_value(a, b, c) {
		if ("get" === b) {
			if ("" !== $(".goodsAuto").getCombo().getValue()) return $(a).val();
			var d = $(a).parents("tr");
			return d.removeData("goodsInfo"), ""
		}
		"set" === b && $("input", a).val(c)
	}
	function fun_handle() {
		$("#initCombo").append($(".goodsAuto").val("").unbind("focus.once"))
	}
	$gridCombination.jqGrid({
		data: a,
		datatype: "local",
		width: 720,
		height: 264,
		rownumbers: !0,
		gridview: !0,
		onselectrow: !1,
		colModel: [{
			name: "operating",
			label: " ",
			width: 60,
			fixed: !0,
			formatter: Public.billsOper,
			align: "center",
		}, {
			name: "number",
			label: "子商品编号",
			width: 100,
			title: !1,
			editable: !0,
			classes: "goods",
			edittype: "custom",
			editoptions: {
				custom_element: fun_element,
				custom_value: fun_value,
				handle: fun_handle,
				trigger: "ui-icon-ellipsis"
			}
		}, {
			name: "name",
			label: "子商品名称",
			width: 180,
			title: !1,
			editable: !1,
			align: "left"
		}, {
			name: "spec",
			label: "规格型号",
			width: 60,
			title: !1,
			editable: !1,
			align: "left"
		}, {
			name: "unitName",
			label: "单位",
			width: 50,
			title: !1,
			editable: !1,
			align: "left"
		}, {
			name: "qty",
			label: "数量",
			width: 50,
			title: !1,
			editable: !0,
			align: "right"
		}, {
			name: "salePrice",
			label: "售价",
			width: 50,
			hidden: !0,
			title: !1,
			editable: !1,
			align: "right"
		}, {
			name: "gid",
			label: "gid",
			width: 50,
			hidden: !0,
			title: !1,
			editable: !1,
			align: "right"
		}],
		cmTemplate: {
			sortable: !1
		},
		shrinkToFit: !1,
		forceFit: !0,
		cellEdit: !0,
		cellsubmit: "clientArray",
		rowNum: 1e4,
		localReader: {
			root: "items",
			records: "records",
			repeatitems: !0
		},
		loadComplete: function() {},
		gridComplete: function() {
			
		},
		afterEditCell: function(a, b, c, d, e) {
			curSonId = a;
		},
		beforeSaveCell: function(a, b, c, d, e) {},
		afterSaveCell: function(a, b, c, d, e) {
			
		}
	})
}
function initWarningGrid() {
	if (THISPAGE.warningGrid) THISPAGE.warningGrid.closest(".grid-wrap").show();
	else {
		if (!defaultPage.SYSTEM.storageInfo || !defaultPage.SYSTEM.storageInfo.length) return !1;
		var a = [];
		if ("edit" == oper && rowData.warehousePropertys) for (var b = 0; b < defaultPage.SYSTEM.storageInfo.length; b++) {
			for (var c = defaultPage.SYSTEM.storageInfo[b], d = {}, e = 0; e < rowData.warehousePropertys.length; e++) {
				var f = rowData.warehousePropertys[e];
				f.locationId == c.id && (d = $.extend(!0, {}, c, f))
			}
			d.id || (d = c), a.push(d)
		} else a = defaultPage.SYSTEM.storageInfo;
		var g = 720;
		THISPAGE.warningGrid = $gridWarning.jqGrid({
			data: a,
			datatype: "clientSide",
			width: g,
			height: 264,
			rownumbers: !0,
			gridview: !0,
			onselectrow: !1,
			colModel: [{
				name: "operating",
				label: " ",
				width: 40,
				fixed: !0,
				formatter: Public.billsOper,
				align: "center",
				hidden: !0
			}, {
				name: "name",
				label: "仓库",
				width: 120,
				title: !0
			}, {
				name: "id",
				label: "仓库ID",
				hidden: !0
			}, {
				name: "skuAssistId",
				label: "skuAssistId",
				hidden: !0
			}, {
				name: "skuId",
				label: "属性ID",
				hidden: !0
			}, {
				name: "skuName",
				label: "属性",
				hidden: !0,
				width: 100,
				classes: "ui-ellipsis skuCell",
				formatter: function(a, b, c) {
					if (!a && c.skuId) {
						if (tempAssistPropGroupInfo[c.skuId]) return tempAssistPropGroupInfo[c.skuId].skuName;
						for (var d = 0, e = SYSTEM.assistPropGroupInfo.length; e > d; d++) {
							var f = SYSTEM.assistPropGroupInfo[d];
							if (tempAssistPropGroupInfo[f.skuId] = f, f.skuId == c.skuId) return f.skuName
						}
					}
					return a || "&#160;"
				},
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: skuElem,
					custom_value: skuValue,
					handle: skuHandle,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "lowQty",
				label: "最低库存",
				nameExt: '<small id="batchLowQty">(批量)</small>',
				width: 90,
				editable: !0,
				formatter: "integer",
				align: "right"
			}, {
				name: "highQty",
				label: "最高库存",
				nameExt: '<small id="batchHighQty">(批量)</small>',
				width: 90,
				editable: !0,
				formatter: "integer",
				align: "right"
			}],
			cmTemplate: {
				sortable: !1
			},
			shrinkToFit: !0,
			forceFit: !1,
			cellEdit: rowData["delete"] ? !1 : !0,
			cellsubmit: "clientArray",
			rowNum: 1e4,
			localReader: {
				root: "items",
				records: "records",
				repeatitems: !0,
				id: "id"
			},
			gridComplete: function(b) {
				for (var c = 0; c < a.length; c++) {
					var d = a[c];
					$("#" + d.id).data("storageInfo", {
						id: d.id,
						name: d.name
					}).data("skuInfo", {
						skuId: d.skuId,
						skuName: d.skuName,
						skuAssistId: d.skuAssistId
					})
				}
				$("#batchHighQty,#batchLowQty").powerFloat({
					eventType: "click",
					hoverHold: !1,
					reverseSharp: !0,
					target: function() {
						return cancleGridEdit(), _self = this, $t = $('<label><input class="ui-input mrb" type="text"/><span class="ui-btn ui-btn-sp" data-tid="' + this[0].id + '">确定</span></label>'), $t.appendTo($("#patchInputBox").html("")), $t.find(".ui-input").keypress(function(a) {
							Public.numerical(a)
						}), $t.on("click", ".ui-btn", function(a) {
							var b = _self.closest("th").index(),
								c = $(this).siblings("input").val();
							$("#gridWarning").find('tr[role="row"]:gt(0)').each(function(a, d) {
								$(this).find("td:eq(" + b + ")").html(c)
							}), $.powerFloat.hide()
						}), $("#patchInputBox")
					}
				})
			},
			afterEditCell: function(a, b, c, d, e) {
				switch (b) {
				case "name":
					$("#" + d + "_name", "#gridWarning").val(c);
					break;
				case "skuName":
					$("#" + d + "_skuName", "#gridWarning").val(c), skuCombo.selectByText(c)
				}
			}
		})
	}
	return !0
}
function skuElem(a, b) {
	var c = $(".skuAuto")[0];
	return c
}
function skuValue(a, b, c) {
	if ("get" === b) {
		if ("" !== $(".skuAuto").getCombo().getValue()) return $(a).val();
		var d = $(a).parents("tr");
		return d.removeData("skuInfo"), ""
	}
	"set" === b && $("input", a).val(c)
}
function skuHandle() {
	$("#initCombo").append($(".skuAuto").val(""))
}
function initSkuGrid(a) {
	function b(a, b) {
		var c = $(".skuPropAuto")[0];
		return c
	}
	function c(a, b, c) {
		if ("get" === b) {
			if ("" !== $(".skuPropAuto").getCombo().getValue()) return $(a).val();
			var d = $(a).parents("td");
			return d.removeData("skuPropInfo"), ""
		}
		"set" === b && $("input", a).val(c)
	}
	function d() {
		$("#initCombo").append($(".skuPropAuto").val(""))
	}
	if (THISPAGE.skuGrid) THISPAGE.skuGrid.closest(".grid-wrap").show();
	else {
		var e = [{
			name: "operating",
			label: " ",
			width: 40,
			fixed: !0,
			formatter: Public.billsOper,
			align: "center"
		}, {
			name: "skuId",
			label: "skuId",
			hidden: !0
		}];
		if (SYSTEM.assistPropTypeInfo) {
			var f = {};
			//这里报错屏蔽了
			//if ("edit" == oper) for (var g = 0; g < a.length; g++) {
//				for (var h = {
//					id: g + 1
//				}, i = a[g], j = i.skuNumber, k = i.skuId, l = i.skuAssistId.split(","), m = 0; m < l.length; m++) {
//					var n = l[m],
//						o = cache_assistPropInfo[n];
//					if (o) n = o;
//					else for (var p = 0; p < SYSTEM.assistPropInfo.length; p++) {
//						var q = SYSTEM.assistPropInfo[p];
//						if (q.id == n) {
//							n = q;
//							break
//						}
//						cache_assistPropInfo[q.id] = q
//					}
//					h[n.typeNumber] = n, h.skuNumber = j, h.skuId = k, f[n.typeNumber] = !0
//				}
//				a[g] = h
//			}
			for (var g = 0, r = SYSTEM.assistPropTypeInfo.length; r > g; g++) {
				var s = SYSTEM.assistPropTypeInfo[g],
					t = f[s.id] ? !1 : !0;
				e.push({
					name: s.id + "",
					label: s.name,
					formatter: THISPAGE.handle.formatter.skuPropFrm,
					width: 60,
					hidden: t,
					classes: "ui-ellipsis",
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: b,
						custom_value: c,
						handle: d,
						trigger: "ui-icon-triangle-1-s"
					}
				})
			}
		}
		for (var g = 1; 20 >= g; g++) {
			var u = {
				name: "empty_" + g,
				label: "empty",
				formatter: THISPAGE.handle.formatter.skuPropFrm,
				width: 60,
				hidden: !0,
				classes: "ui-ellipsis",
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: b,
					custom_value: c,
					handle: d,
					trigger: "ui-icon-triangle-1-s"
				}
			};
			e.push(u), customRow.push(u)
		}
		e.push({
			name: "skuNumber",
			label: "属性编号",
			width: 60,
			classes: "ui-ellipsis",
			editable: !0
		}), e.push({
			name: "curSkuNumber",
			label: "旧属性编号",
			hidden: !0,
			formatter: function(a, b, c) {
				return c.skuNumber
			}
		});
		var v = 720;
		THISPAGE.skuGrid = $gridSku.jqGrid({
			data: a && a.length ? a : a = [{
				id: 1
			}],
			datatype: "clientSide",
			width: v,
			height: 160,
			idPrefix: "skuCombo_",
			rownumbers: !0,
			gridview: !0,
			onselectrow: !1,
			colModel: e,
			cmTemplate: {
				sortable: !1
			},
			shrinkToFit: !0,
			forceFit: !1,
			cellEdit: rowData["delete"] ? !1 : !0,
			cellsubmit: "clientArray",
			rowNum: 1e4,
			localReader: {
				root: "items",
				records: "records",
				repeatitems: !0,
				id: "id"
			},
			gridComplete: function() {
				$gridSku.trigger("gridComplete")
			},
			afterEditCell: function(a, b, c, d, e) {
				$("#" + d + "_" + b, "#gridSku").val(c), skuPropCombo.loadData(THISPAGE.handle.getskuPropComboData, "-1", !1), skuPropCombo.selectByText(c)
			},
			afterSaveCell: function(a, b, c, d, e) {}
		})
	}
	return !0
}
function floatCheck(a, b) {
	var c = /^[0-9\.]+$/,
		a = $.trim(a);
	return "quantity" == b ? b = "期初数量" : "unitCost" == b && (b = "单位成本"), c.test(a) ? [!0, ""] : "" == a ? [!1, b + "不能为空！（如果不需要该行数据，可以删除行）"] : [!1, "请填写正确的" + b]
}
function setGridFooter() {
	for (var a, b, c = $grid.jqGrid("getRowData"), d = 0, e = 0, f = 0; f < c.length; f++) a = c[f], a.quantity && (d += parseFloat(a.quantity)), a.amount && (e += parseFloat(a.amount));
	d && e && (b = e / d), $grid.footerData("set", {
		locationName: "合计",
		quantity: d || "&#160",
		amount: e || "&#160"
	})
}
function initValidator() {
	var a = /[^\\<\\>\\&\\\\\']+/;
	$form.validator({
		rules: {
			code: [a, "商品编号只能包含<,>,&,,'字符组成"],
			number: function(a, b) {
				var c = $(a).val();
				try {
					return c = Number(c), c >= 0 ? ($(a).val(c), !0) : "字段不合法！请输入数值"
				} catch (d) {
					return "字段不合法！请输入数值"
				}
			},
			checkCode: function(a, b) {
				var c = $(a).val();
				return $.ajax({
					type: "POST",
					url: "../basedata/inventory/checkBarCode?action=checkBarCode",
					data: {
						barCode: c
					},
					dataType: "json",
					async: !1,
					success: function(a, b) {
						return a ? void(c = -1 == a.status ? rowData && rowData.barCode === c ? !0 : "商品条码已经存在！" : !0) : !1
					},
					error: function(a) {
						c = "远程数据校验失败！"
					}
				}), c
			},
			myRemote: function(a, b, c) {
				return c.old.value === a.value || $(a).data("tip") === !1 && a.value.length > 1 ? !0 : $.ajax({
					url: "../basedata/inventory/getNextNo?action=getNextNo",
					type: "post",
					data: "skey=" + a.value,
					dataType: "json",
					success: function(b) {
						if (b.data && b.data.number) {
							var c = a.value.length;
							a.value = b.data.number;
							var d = a.value.length;
							if (a.createTextRange) {
								var e = a.createTextRange();
								e.moveEnd("character", d), e.moveStart("character", c), e.select()
							} else a.setSelectionRange(c, d), a.focus();
							$(a).data("tip", !0)
						} else $(a).data("tip", !1)
					}
				})
			},
			checkInventory: function(a, b, c) {
				var d = $(a).val();
				if ("" !== d) {
					var e = Number($("#minInventory").val()),
						f = Number(d);
					if (e > f) return "最高库存不能小于最低库存"
				}
			}
		},
		messages: {
			required: "请填写{0}",
			checkCode: "{0}",
			name: "{0}"
		},
		fields: {
			number: {
				rule: "add" === oper ? "required; code; myRemote" : "required; code",
				timely: 3
			},
			name: "required",
			barCode: "code;checkCode;",
			maxInventory: "checkInventory",
			length: "number;",
			width: "number;",
			height: "number;",
			weight: "number;"
		},
		display: function(a) {
			return $(a).closest(".row-item").find("label").text()
		},
		valid: function(a) {
			postCustomerData()
		},
		ignore: ":hidden",
		theme: "yellow_bottom",
		timely: 1,
		stopOnError: !0
	})
}
function cancleGridEdit() {
	null !== curRow && null !== curCol && ($grid.jqGrid("saveCell", curRow, curCol),$gridCombination.jqGrid("saveCell", curRow, curCol), $gridWarning.jqGrid("saveCell", curRow, curCol), $gridSku.jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null)
}
function resetForm(a) {
	var b = [{}, {}, {}, {}];
	$("#name").val(""), $("#specs").val(""), $("#purchasePrice").val(""), $("#salePrice").val(""), $("#wholesalePrice").val(""), $("#vipPrice").val(""), $("#discountRate1").val(""), $("#discountRate2").val(""), $("#lowQty").val(""), $("#highQty").val(""), $("#note").val(""), $grid.jqGrid("clearGridData", !0).jqGrid("setGridParam", {
		data: b
	}).trigger("reloadGrid"), gridStoCombo.collapse(), $("#number").val(Public.getSuggestNum(a.number)).focus().select(), $("#barCode").val(""), jianxingCombo && jianxingCombo.selectByIndex(0), $("#length").val(""), $("#width").val(""), $("#height").val(""), $("#weight").val("")
}
function getBaseUnit() {
	var a = {},
		b = [];
	b.push({
		id: 0,
		name: "（空）"
	});
	for (var c = 0; c < SYSTEM.unitInfo.length; c++) {
		var d = SYSTEM.unitInfo[c],
			e = d.unitTypeId || c;
		a[e] || (a[e] = []), a[e].push(d), unitData[d.id] = d
	}
	for (var f in a) {
		var g = a[f];
		if (1 == g.length) b.push(g[0]);
		else for (var c = 0; c < g.length; c++) g[c]["default"] && b.push(g[c])
	}
	return b
}
var curRow, curCol, curArrears, api = frameElement.api,
	oper = api.data.oper,
	cRowId = api.data.rowId,
	rowData = {},
	propertysIds = [],
	deleteRow = [],
	callback = api.data.callback,
	defaultPage = Public.getDefaultPage(),
	siType = defaultPage.SYSTEM.siType,
	categoryTree, storageCombo, unitCombo, gridStoCombo, jianxingCombo, skuPropCombo, skuCombo, comboWidth = 147,
	gridWidth = 970,
	$grid = $("#grid"),
	$gridCombination = $("#gridCombination"),
	newSonId = 4,
	curSonid = 0,
	$gridWarning = $("#gridWarning"),
	$gridSku = $("#gridSku"),
	$itemList = $("#itemList"),
	$form = $("#manage-form"),
	$category = $("#category"),
	$isSerNum = $("#isSerNum"),
	$isWarranty = $("#isWarranty "),
	$safeDays = $("#safeDays"),
	$advanceDay = $("#advanceDay"),
	categoryData = {},
	unitData = {},
	tempAssistPropGroupInfo = {},
	cache_assistPropInfo = {},
	customRow = [],
	SYSTEM = parent.parent.SYSTEM,
	qtyPlaces = Number(SYSTEM.qtyPlaces) || 4,
	pricePlaces = Number(SYSTEM.pricePlaces) || 4,
	amountPlaces = Number(SYSTEM.amountPlaces) || 2,
	format = {
		quantity: function(a) {
			var b = parseFloat(a);
			return isNaN(b) ? "&#160;" : a
		},
		money: function(a, b, c) {
			var a = Public.numToCurrency(a, pricePlaces);
			return a || "&#160;"
		}
	},
	THISPAGE = {
		newId: 9,
		handle: {
			getskuPropComboData: function() {
				if (!skuPropCombo) return [];
				var a = skuPropCombo.input.prop("name");
				if (defaultPage.SYSTEM.assistPropInfo) {
					for (var b = [], c = 0, d = defaultPage.SYSTEM.assistPropInfo.length; d > c; c++) defaultPage.SYSTEM.assistPropInfo[c].typeNumber === a && b.push(defaultPage.SYSTEM.assistPropInfo[c]);
					return b
				}
				return "../basedata/assist?action=list&isDelete=2&typeNumber=" + a
			},
			formatter: {
				skuPropFrm: function(a, b, c) {
					if (a = "undefined" === a ? "" : a, "object" == typeof a) {
						for (var d, e = 0; e < this.p.colNames.length; e++) if (this.p.colNames[e] === b.colModel.label) {
							d = e;
							break
						}
						return $gridSku.on("gridComplete", function() {
							var b = $("#skuCombo_" + c.id).find("td:eq(" + d + ")");
							b.data("skuPropInfo", a)
						}), a.name
					}
					return a || "&#160;"
				}
			}
		}
	},
	rights = api.opener.parent.SYSTEM.rights;
$(function() {
	initPopBtns(), init()
});