var curRow, curCol, loading, SYSTEM = system = parent.SYSTEM,
	billRequiredCheck = system.billRequiredCheck,
	requiredMoney = system.requiredMoney,
	taxRequiredCheck = system.taxRequiredCheck,
	taxRequiredInput = system.taxRequiredInput,
	hiddenAmount = !1,
	urlParam = Public.urlParam(),
	disEditable = urlParam.disEditable,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	defaultPage = Public.getDefaultPage(),
	THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("salesOrder"), SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_OUTAMOUNT || (hiddenAmount = !0, $("#amountArea").hide()), this.initDom(a), this.loadGrid(a), this.initCombo(), a.id > 0 && a.checked ? this.disableEdit() : (this.editable = !0, $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			})), this.addEvent(), setTimeout(function() {
				$("#grid").jqGrid("nextCell", 1, 1)
			}, 10), $.cookie("BarCodeInsert") && THISPAGE.$_barCodeInsert.addClass("active"), this.goodsEdittypeInit()
		},
		initDom: function(a) {
			var b = this;
			if (this.$_customer = $("#customer"), this.$_date = $("#date").val(system.endDate), this.$_deliveryDate = $("#deliveryDate").val(system.endDate), this.$_number = $("#number"), this.$_classes = $("#classes"), this.$_note = $("#note"), this.$_discountRate = $("#discountRate"), this.$_deduction = $("#deduction"), this.$_discount = $("#discount"), this.$_payment = $("#payment"), this.$_arrears = $("#arrears"), this.$_totalArrears = $("#totalArrears"), this.$_toolTop = $("#toolTop"), this.$_toolBottom = $("#toolBottom"), this.$_paymentTxt = $("#paymentTxt"), this.$_accountInfo = $("#accountInfo"), this.$_userName = $("#userName"), this.$_modifyTime = $("#modifyTime"), this.$_createTime = $("#createTime"), this.$_checkName = $("#checkName"), this.customerArrears = 0, this.$_note.placeholder(), "add" !== a.status || a.salesId) var c = ["id", a.salesId];
			else var c = 0;
			if (this.salesCombo = Business.billSalesCombo($("#sales"), {
				defaultSelected: c
			}), this.customerCombo = Business.billCustomerCombo($("#customer"), {
				defaultSelected: -1,
				callback: {
					onChange: function(a) {
						a ? ($("#customer").data("contactInfo", a), b.setSaleByContact(a)) : $("#customer").removeData("contactInfo")
					}
				}
			}), "add" !== a.status || a.buId) {
				var d = {
					id: a.buId,
					name: a.contactName,
					cLevel: a.cLevel
				};
				this.$_customer.data("contactInfo", d), this.customerCombo.input.val(a.contactName);
				for (var e = 0; e < SYSTEM.salesInfo.length; e++) if (SYSTEM.salesInfo[e].id === a.salesId) {
					this.salesCombo.input.val(SYSTEM.salesInfo[e].name);
					break
				}
			} else Public.ajaxPost("../basedata/contact/getRecentlyContact?action=getRecentlyContact", {
				transType: originalData.transType,
				billType: "SO"
			}, function(a) {
				if ("" == b.customerCombo.input.val()) {
					a = a.data;
					var c = {
						id: a.buId,
						name: a.contactName,
						cLevel: a.cLevel
					};
					b.$_customer.data("contactInfo", c), b.customerCombo.input.val(a.contactName), b.setSaleByContact(c)
				}
			});
			$("#customer").data("callback", function(a) {
				b.setSaleByContact(a)
			}), this.$_date.datepicker({
				onSelect: function(a) {
					if (!(originalData.id > 0)) {
						var c = a.format("yyyy-MM-dd");
						b.$_number.text(""), Public.ajaxPost("../basedata/systemProfile/generateDocNo?action=generateDocNo", {
							billType: "SO",
							billDate: c
						}, function(a) {
							200 === a.status ? b.$_number.text(a.data.billNo) : parent.Public.tips({
								type: 1,
								content: a.msg
							})
						})
					}
				}
			}), this.$_deliveryDate.datepicker(), this.classBox = this.$_classes.cssRadio({
				callback: function(a) {
					"150601" == a.find("input").val() ? b.$_paymentTxt.text("本次收款:") : b.$_paymentTxt.text("本次退款:")
				}
			}), 150601 == a.transType ? this.classBox.setValue(0) : this.classBox.setValue(1), a.description && this.$_note.val(a.description), this.$_discountRate.val(a.disRate), this.$_deduction.val(a.disAmount), this.$_discount.val(a.amount), this.$_payment.val(a.rpAmount), this.$_arrears.val(a.arrears), requiredMoney && ($("#accountWrap").show(), this.accountCombo = Business.accountCombo($("#account"), {
				width: 112,
				height: 300,
				emptyOptions: !0,
				addOptions: {
					text: "多账户",
					value: -1
				},
				callback: {
					onChange: function(a) {
						if (-1 === this.getValue()) b.chooseAccount();
						else {
							var c = [];
							c.push({
								accId: this.getValue(),
								account: "",
								payment: b.$_payment.val(),
								wayId: 0,
								way: "",
								settlement: ""
							}), b.$_accountInfo.data("accountInfo", c).hide(), b.$_payment.removeAttr("disabled").removeClass("ui-input-dis")
						}
					}
				}
			}), this.accountCombo.selectByValue(a.accId, !1));
			var f = '<a id="savaAndAdd" class="ui-btn ui-btn-sp">保存并新增</a><a id="save" class="ui-btn">保存</a>',
				g = '<a id="add" class="ui-btn ui-btn-sp">新增</a><a href="../scm/invSo/toPdf?action=toPdf&id=' + a.id + '" target="_blank" id="print" class="ui-btn">打印</a><a id="edit" class="ui-btn">保存</a>',
				h = '<a id="add" class="ui-btn ui-btn-sp">新增</a><a href="../scm/invSo/toPdf?action=toPdf&id=' + a.id + '" target="_blank" id="print" class="ui-btn">打印</a>',
				i = "",
				j = "",
				k = "150602" == originalData.transType ? "生成退货单" : "生成销货单",
				l = '<a id="turn" class="ui-btn ' + (2 == a.billStatus ? "ui-btn-dis" : "ui-btn-sc") + '">' + k + "</a>",
				m = '<a class="ui-btn" id="close">关闭</a>',
				n = '<a class="ui-btn" id="open">开启</a>';
			billRequiredCheck ? (i = '<a class="ui-btn" id="audit">审核</a>', j = '<a class="ui-btn" id="reAudit">反审核</a>') : (g = l + g, this.$_checkName.parent().hide());
			var o = '<a class="ui-btn-prev" id="prev" title="上一张"><b></b></a><a class="ui-btn-next" id="next" title="下一张"><b></b></a>';
			if (this.btn_edit = g, this.btn_audit = i, this.btn_view = h, this.btn_reaudit = j, this.btn_turn = l, this.btn_close = m, this.btn_open = n, a.id > 0) {
				if (this.$_number.text(a.billNo), this.$_date.val(a.date), this.$_deliveryDate.val(a.deliveryDate), this.$_totalArrears.val(a.totalArrears), this.$_accountInfo.data("accountInfo", a.accounts), -1 === a.accId && (this.$_accountInfo.show(), b.$_payment.attr("disabled", "disabled").addClass("ui-input-dis")), $("#grid").jqGrid("footerData", "set", {
					qty: a.totalQty,
					amount: a.totalAmount
				}), "list" !== urlParam.flag && (o = ""), a.isDelete && $("#mark").addClass("has-closed"), "edit" === a.status) {
					var p = g + i;
					a.isDelete ? p = h + n : p += billRequiredCheck ? a.checked ? m : "" : m, this.$_toolBottom.html('<span id="groupBtn">' + p + "</span>" + o)
				} else if (a.checked) {
					$("#mark").addClass("has-audit");
					var p = l + h + j;
					a.isDelete ? p = h + n : p += m, this.$_toolBottom.html('<span id="groupBtn">' + p + "</span>" + o)
				} else {
					var p = h;
					p += a.isDelete ? n : billRequiredCheck ? a.checked ? m : "" : m, this.$_toolBottom.html('<span id="groupBtn">' + p + "</span>" + o)
				}
				this.idList = parent.cacheList.salesOrderId || [], this.idPostion = $.inArray(String(a.id), this.idList), this.idLength = this.idList.length, 0 === this.idPostion && $("#prev").addClass("ui-btn-prev-dis"), this.idPostion === this.idLength - 1 && $("#next").addClass("ui-btn-next-dis"), this.$_userName.html(a.userName), this.$_modifyTime.html(a.modifyTime), this.$_createTime.html(a.createTime), this.$_checkName.html(a.checkName)
			} else billRequiredCheck ? this.$_toolBottom.html('<span id="groupBtn">' + f + i + "</span>") : this.$_toolBottom.html('<span id="groupBtn">' + f + "</span>"), this.$_userName.html(system.realName || ""), this.$_modifyTime.parent().hide(), this.$_createTime.parent().hide(), this.$_checkName.parent().hide();
			disEditable && (THISPAGE.disableEdit(), this.$_toolBottom.hide())
		},
		loadGrid: function(a) {
			function b(a) {
				if (taxRequiredCheck) {
					var b = $("#grid").jqGrid("getRowData", a),
						c = parseFloat(b.taxRate);
					if ($.isNumeric(c)) {
						var d = parseFloat(b.amount),
							e = d * c / 100,
							f = d + e;
						$("#grid").jqGrid("setRowData", a, {
							tax: e,
							taxAmount: f
						})
					}
				}
			}
			function c(a, b, c) {
				return a ? (p(b.rowId), a) : c.invNumber ? c.invSpec ? c.invNumber + " " + c.invName + "_" + c.invSpec : c.invNumber + " " + c.invName : "&#160;"
			}
			function d(a, b) {
				var c = $(".skuAuto")[0];
				return c
			}
			function e(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".skuAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("skuInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function f() {
				$("#initCombo").append($(".skuAuto").val(""))
			}
			function g(a, b) {
				var c = $(".storageAuto")[0];
				return c
			}
			function h(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".storageAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("storageInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function i() {
				$("#initCombo").append($(".storageAuto").val(""))
			}
			function j(a, b) {
				var c = $(".unitAuto")[0];
				return c
			}
			function k(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".unitAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr"),
						e = d.data("unitInfo") || {};
					return THISPAGE.unitCombo.selectByIndex(e.unitId || e.id), e.name || ""
				}
				"set" === b && $("input", a).val(c)
			}
			function l() {
				$("#initCombo").append($(".unitAuto").val(""))
			}
			function m(a, b) {
				var c = $(".priceAuto")[0];
				return c
			}
			function n(a, b, c) {
				if ("get" === b) {
					var d = a.val().split("：")[1];
					return d || a.val()
				}
				"set" === b && $("input", a).val(c)
			}
			function o() {
				$("#initCombo").append($(".priceAuto").val(""))
			}
			function p(a) {
				var b = $("#" + a).data("goodsInfo");
				if (b) {
					if (!b.price) {
						var c = q.$_customer.data("contactInfo");
						if (c && c.id) {
							var d = b.salePrice,
								e = [b.salePrice, b.retailPrice, b.salePrice1, b.salePrice2, b.salePrice3];
							d = c.cLevel < 3 ? e[c.cLevel] : (1e4 * b.salePrice * e[c.cLevel] / 1e6).toFixed(2), b.price = d
						}
					}
					var f = {
						skuName: b.skuName || "",
						mainUnit: b.mainUnit || b.unitName,
						unitId: b.unitId,
						qty: b.qty || 1,
						price: b.price || b.salePrice,
						discountRate: b.discountRate || 0,
						deduction: b.deduction || 0,
						amount: b.amount,
						locationName: b.locationName,
						taxRate: b.taxRate || taxRequiredInput,
						safeDays: b.safeDays
					};
					f.amount = f.amount ? f.amount : f.price * f.qty;
					var g = Number(f.amount);
					if (taxRequiredCheck) {
						var h = f.taxRate,
							i = g * h / 100,
							j = g + i;
						f.tax = b.tax || i, f.taxAmount = b.taxAmount || j
					}
					var k = $("#grid").jqGrid("setRowData", a, f);
					k && THISPAGE.calTotal()
				}
			}
			var q = this;
			if (a.id) {
				var r = 8 - a.entries.length;
				if (r > 0) for (var s = 0; r > s; s++) a.entries.push({})
			}
			q.newId = 9;
			var t = [{
				name: "operating",
				label: " ",
				width: 60,
				fixed: !0,
				formatter: Public.billsOper_goods,
				align: "center"
			}, {
				name: "goods",
				label: "商品",
				nameExt: '<span id="barCodeInsert">扫描枪录入</span>',
				width: 300,
				classes: "goods",
				formatter: c,
				editable: !0,
				enterCallback: function() {
					if (THISPAGE.$_barCodeInsert.hasClass("active")) {
						var a = function(a) {
								var b = $("#" + a),
									c = b.next(),
									d = b.index() + 1;
								return 0 == c.length ? ($("#grid").jqGrid("addRowData", THISPAGE.newId, {}, "last"), THISPAGE.newId++, $("#" + (THISPAGE.newId - 1)).index()) : c.data("goodsInfo") ? arguments.callee(d) : d
							}(THISPAGE.curID);
						$("#grid").jqGrid("nextCell", a, 1)
					} else 0 != $("#grid")[0].p.savedRow.length && $("#grid").jqGrid("nextCell", $("#grid")[0].p.savedRow[0].id, $("#grid")[0].p.savedRow[0].ic)
				}
			}, {
				name: "skuId",
				label: "属性ID",
				hidden: !0
			}, {
				name: "skuName",
				label: "属性",
				width: 100,
				classes: "ui-ellipsis skuInfo",
				hidden: !SYSTEM.enableAssistingProp,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: d,
					custom_value: e,
					handle: f,
					trigger: "ui-icon-ellipsis"
				}
			}, {
				name: "mainUnit",
				label: "单位",
				width: 80,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: j,
					custom_value: k,
					handle: l,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "unitId",
				label: "单位Id",
				hidden: !0
			}, {
				name: "locationName",
				label: "仓库",
				nameExt: '<small id="batchStorage">(批量)</small>',
				width: 100,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: g,
					custom_value: h,
					handle: i,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "qty",
				label: "数量",
				width: 80,
				align: "right",
				formatter: "number",
				formatoptions: {
					decimalPlaces: qtyPlaces
				},
				editable: !0
			}, {
				name: "price",
				label: "销售单价",
				hidden: hiddenAmount,
				width: 100,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: pricePlaces
				},
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: m,
					custom_value: n,
					handle: o,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "discountRate",
				label: "折扣率(%)",
				hidden: hiddenAmount,
				width: 70,
				fixed: !0,
				align: "right",
				formatter: "integer",
				editable: !0
			}, {
				name: "deduction",
				label: "折扣额",
				hidden: hiddenAmount,
				width: 70,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: amountPlaces
				},
				editable: !0
			}, {
				name: "amount",
				label: "销售金额",
				hidden: hiddenAmount,
				width: 100,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: amountPlaces
				},
				editable: !0
			}];
			this.calAmount = "amount", taxRequiredCheck && (t.pop(), t.push({
				name: "amount",
				label: "金额",
				hidden: hiddenAmount,
				width: 100,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: amountPlaces
				},
				editable: !0
			}, {
				name: "taxRate",
				label: "税率(%)",
				hidden: hiddenAmount,
				width: 70,
				fixed: !0,
				align: "right",
				formatter: "integer",
				editable: !0
			}, {
				name: "tax",
				label: "税额",
				hidden: hiddenAmount,
				width: 70,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: amountPlaces
				},
				editable: !0
			}, {
				name: "taxAmount",
				label: "价税合计",
				hidden: hiddenAmount,
				width: 100,
				fixed: !0,
				align: "right",
				formatter: "currency",
				formatoptions: {
					showZero: !0,
					decimalPlaces: amountPlaces
				},
				editable: !0
			}), this.calAmount = "taxAmount"), t.push({
				name: "description",
				label: "备注",
				width: 150,
				title: !0,
				editable: !0
			});
			var u = "grid";
			q.mod_PageConfig.gridReg(u, t), t = q.mod_PageConfig.conf.grids[u].colModel, $("#grid").jqGrid({
				data: a.entries,
				datatype: "clientSide",
				autowidth: !0,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: t,
				cmTemplate: {
					sortable: !1,
					title: !1
				},
				shrinkToFit: !0,
				forceFit: !1,
				rowNum: 1e3,
				cellEdit: !1,
				cellsubmit: "clientArray",
				localReader: {
					root: "rows",
					records: "records",
					repeatitems: !1,
					id: "id"
				},
				jsonReader: {
					root: "data.entries",
					records: "records",
					repeatitems: !1,
					id: "id"
				},
				loadComplete: function(a) {
					if (THISPAGE.$_barCodeInsert = $("#barCodeInsert"), urlParam.id > 0) {
						var b = a.rows,
							c = b.length,
							d = "";
						q.newId = c + 1;
						for (var e = {}, f = 0; c > f; f++) {
							var g = f + 1,
								h = b[f];
							if ($.isEmptyObject(b[f])) break;
							d += d ? "," + g : g, e[h.invId] = g;
							var i = $.extend(!0, {
								id: h.invId,
								number: h.invNumber,
								name: h.invName,
								spec: h.invSpec,
								unitId: h.unitId,
								unitName: h.mainUnit
							}, h);
							Business.cacheManage.getGoodsInfoByNumber(i.number, function(a) {
								i.isSerNum = a.isSerNum, i.isWarranty = h.isWarranty = a.isWarranty, i.safeDays = h.safeDays = a.safeDays, i.invSkus = a.invSkus, i.id = h.invId, $("#" + g).data("goodsInfo", i).data("storageInfo", {
									id: h.locationId,
									name: h.locationName
								}).data("unitInfo", {
									unitId: h.unitId,
									name: h.mainUnit
								}).data("skuInfo", {
									name: h.skuName,
									id: h.skuId
								})
							})
						}
					}
				},
				gridComplete: function() {
					setTimeout(function() {
						Public.autoGrid($("#grid"))
					}, 10)
				},
				afterEditCell: function(a, b, c, d, e) {
					function f() {
						var b = $("#" + a).data("goodsInfo");
						if (b) {
							var c = $("#grid").jqGrid("getRowData", a);
							b = $.extend(!0, {}, b), b.skuName = c.skuName, b.mainUnit = c.mainUnit, b.unitId = c.unitId, b.qty = c.qty, b.price = c.price, b.discountRate = c.discountRate, b.deduction = c.deduction, b.amount = c.amount, b.taxRate = c.taxRate, b.tax = c.tax, b.taxAmount = c.taxAmount, b.locationName = c.locationName, $("#" + a).data("goodsInfo", b)
						}
					}
					if (THISPAGE.curID = a, "goods" === b && (f(), $("#" + d + "_goods", "#grid").val(c), THISPAGE.goodsCombo.selectByText(c)), "skuName" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g || !g.invSkus || !g.invSkus.length) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, $("#grid").jqGrid("nextCell", d, e + 1), void THISPAGE.skuCombo.loadData([]);
						"string" == typeof g.invSkus && (g.invSkus = $.parseJSON(g.invSkus)), $("#" + d + "_skuName", "#grid").val(c), THISPAGE.skuCombo.loadData(g.invSkus || [], 1, !1), THISPAGE.skuCombo.selectByText(c)
					}
					if ("price" === b && $("#" + d + "_price", "#grid").val(c), "locationName" === b && ($("#" + d + "_locationName", "#grid").val(c), THISPAGE.storageCombo.selectByText(c)), "mainUnit" === b) {
						$("#" + d + "_mainUnit", "#grid").val(c);
						var h = $("#" + a).data("unitInfo") || {};
						if (!h.unitId || "0" === h.unitId) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#grid").jqGrid("nextCell", d, e + 1);
						THISPAGE.unitCombo.enable(), THISPAGE.unitCombo.loadData(function() {
							for (var a = {}, b = 0; b < SYSTEM.unitInfo.length; b++) {
								var c = SYSTEM.unitInfo[b],
									d = h.unitId;
								h.unitId == c.id && (h = c), h.unitId = d;
								var e = c.unitTypeId || b;
								a[e] || (a[e] = []), a[e].push(c)
							}
							return h.unitTypeId ? a[h.unitTypeId] : [h]
						}), THISPAGE.unitCombo.selectByText(c)
					}
				},
				formatCell: function(a, b, c, d, e) {},
				beforeSubmitCell: function(a, b, c, d, e) {},
				beforeSaveCell: function(a, b, c, d, e) {
					switch (b) {
					case "goods":
						var f = $("#" + a).data("goodsInfo");
						if (!f) {
							q.skey = c;
							var g, h = function(b) {
									$("#" + a).data("goodsInfo", b).data("storageInfo", {
										id: b.locationId,
										name: b.locationName
									}).data("unitInfo", {
										unitId: b.unitId,
										name: b.unitName
									}), g = Business.formatGoodsName(b)
								};
							return THISPAGE.$_barCodeInsert.hasClass("active") ? Business.cacheManage.getGoodsInfoByBarCode(c, h, !0) : Business.cacheManage.getGoodsInfoByNumber(c, h, !0), g ? g : ($.dialog({
								width: 775,
								height: 510,
								title: "选择商品",
								content: "url:../settings/goods_batch",
								data: {
									skuMult: SYSTEM.enableAssistingProp,
									skey: q.skey,
									callback: function(a, b, c) {
										"" === b && ($("#grid").jqGrid("addRowData", a, {}, "last"), q.newId = a + 1), setTimeout(function() {
											$("#grid").jqGrid("editCell", c, 2, !0)
										}, 10), q.calTotal()
									}
								},
								init: function() {
									q.skey = ""
								},
								lock: !0,
								button: [{
									name: "选中",
									defClass: "ui_state_highlight fl",
									focus: !0,
									callback: function() {
										return this.content.callback && this.content.callback("purchase"), !1
									}
								}, {
									name: "选中并关闭",
									defClass: "ui_state_highlight",
									callback: function() {
										return this.content.callback("purchase"), this.close(), !1
									}
								}, {
									name: "关闭",
									callback: function() {
										return !0
									}
								}]
							}), setTimeout(function() {
								$("#grid").jqGrid("editCell", curRow, 2, !0), $("#grid").jqGrid("setCell", curRow, 2, "")
							}, 10), "&#160;")
						}
					}
					return c
				},
				afterSaveCell: function(a, c, d, e, f) {
					switch (c) {
					case "goods":
						break;
					case "qty":
						var d = parseFloat(d),
							g = parseFloat($("#grid").jqGrid("getCell", a, f + 1)),
							h = parseFloat($("#grid").jqGrid("getCell", a, f + 2));
						if ($.isNumeric(g)) if ($.isNumeric(h)) var i = d * g * h / 100,
							j = d * g - i,
							k = $("#grid").jqGrid("setRowData", a, {
								deduction: i,
								amount: j
							});
						else var k = $("#grid").jqGrid("setRowData", a, {
							amount: d * g
						});
						b(a), k && THISPAGE.calTotal();
						break;
					case "price":
						var d = parseFloat(d),
							l = parseFloat($("#grid").jqGrid("getCell", a, f - 1)),
							h = parseFloat($("#grid").jqGrid("getCell", a, f + 1));
						if ($.isNumeric(l)) if ($.isNumeric(h)) var i = d * l * h / 100,
							j = d * l - i,
							k = $("#grid").jqGrid("setRowData", a, {
								deduction: i,
								amount: j
							});
						else var k = $("#grid").jqGrid("setRowData", a, {
							amount: d * l
						});
						b(a), k && THISPAGE.calTotal();
						break;
					case "discountRate":
						var d = parseFloat(d),
							l = parseFloat($("#grid").jqGrid("getCell", a, f - 2)),
							g = parseFloat($("#grid").jqGrid("getCell", a, f - 1));
						if ($.isNumeric(l) && $.isNumeric(g)) var m = l * g,
							i = m * d / 100,
							j = m - i,
							k = $("#grid").jqGrid("setRowData", a, {
								deduction: i,
								amount: j
							});
						b(a), k && THISPAGE.calTotal();
						break;
					case "deduction":
						var d = parseFloat(d),
							l = parseFloat($("#grid").jqGrid("getCell", a, f - 3)),
							g = parseFloat($("#grid").jqGrid("getCell", a, f - 2));
						if ($.isNumeric(l) && $.isNumeric(g)) var m = l * g,
							j = m - d,
							h = m ? (100 * d / m).toFixed(amountPlaces) : 0,
							k = $("#grid").jqGrid("setRowData", a, {
								discountRate: h,
								amount: j
							});
						b(a), k && THISPAGE.calTotal();
						break;
					case "amount":
						var d = parseFloat(d),
							n = $("#grid").jqGrid("getRowData", a),
							i = parseFloat(n.deduction),
							l = parseFloat($("#grid").jqGrid("getCell", a, f - 3));
						if ($.isNumeric(d)) {
							var o = parseFloat(n.qty),
								g = (d + i) / o;
							if ($.isNumeric(l) && $.isNumeric(g)) {
								var m = l * g,
									h = m ? (100 * i / m).toFixed(amountPlaces) : 0;
								$("#grid").jqGrid("setRowData", a, {
									discountRate: h
								})
							}
							$("#grid").jqGrid("setRowData", a, {
								discountRate: h,
								price: g
							})
						}
						b(a), THISPAGE.calTotal();
						break;
					case "taxRate":
						var p = d,
							d = parseFloat(d),
							n = $("#grid").jqGrid("getRowData", a),
							j = parseFloat(n.amount);
						if ($.isNumeric(d)) {
							var q = j * d / 100,
								r = j + q,
								k = $("#grid").jqGrid("setRowData", a, {
									tax: q,
									taxAmount: r
								});
							k && THISPAGE.calTotal();
							break
						}
						if ("" === p) {
							var k = $("#grid").jqGrid("setRowData", a, {
								tax: "",
								taxAmount: j
							});
							k && THISPAGE.calTotal();
							break
						}
					case "tax":
						var d = parseFloat(d),
							n = $("#grid").jqGrid("getRowData", a);
						if ($.isNumeric(d)) {
							var j = parseFloat(n.amount),
								r = j + d,
								k = $("#grid").jqGrid("setRowData", a, {
									taxAmount: r
								});
							k && THISPAGE.calTotal()
						}
						break;
					case "taxAmount":
						var d = parseFloat(d),
							n = $("#grid").jqGrid("getRowData", a);
						if ($.isNumeric(d)) {
							var i = parseFloat(n.deduction),
								s = parseFloat(n.taxRate) / 100,
								j = d / (1 + s),
								h = (100 * i / (j + i)).toFixed(amountPlaces),
								o = parseFloat(n.qty),
								g = (j + i) / o,
								q = d - j,
								k = $("#grid").jqGrid("setRowData", a, {
									discountRate: h,
									price: g,
									amount: j,
									tax: q
								});
							k && THISPAGE.calTotal()
						}
					}
				},
				loadonce: !0,
				resizeStop: function(a, b) {
					q.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
				},
				footerrow: !0,
				userData: {
					goods: "合计：",
					qty: a.totalQty,
					deduction: a.totalDiscount,
					amount: a.totalAmount,
					tax: a.totalTax,
					taxAmount: a.totalTaxAmount
				},
				userDataOnFooter: !0,
				loadError: function(a, b, c) {
					Public.tips({
						type: 1,
						content: "Type: " + b + "; Response: " + a.status + " " + a.statusText
					})
				}
			})
		},
		setSaleByContact: function(a) {
			var b = this;
			b.salesCombo && Public.ajaxGet("../scm/invSo/findNearSoEmp?action=findNearSoEmp", {
				buid: a.id
			}, function(a) {
				a.data.empId && b.salesCombo.selectByValue(a.data.empId)
			})
		},
		goodsEdittypeInit: function() {
			function a(a, b) {
				var c = $(".goodsAuto")[0];
				return c
			}
			function b(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".goodsAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("goodsInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function c() {
				$("#initCombo").append($(".goodsAuto").val("").unbind("focus.once"))
			}
			0 != $("#grid")[0].p.savedRow.length && $("#grid").jqGrid("saveCell", $("#grid")[0].p.savedRow[0].id, $("#grid")[0].p.savedRow[0].ic), THISPAGE.$_barCodeInsert.hasClass("active") ? $("#grid").jqGrid("setColProp", "goods", {
				edittype: "text",
				editoptions: null
			}) : $("#grid").jqGrid("setColProp", "goods", {
				edittype: "custom",
				editoptions: {
					custom_element: a,
					custom_value: b,
					handle: c,
					trigger: "ui-icon-ellipsis"
				}
			})
		},
		reloadData: function(a) {
			function b() {
				c.$_customer.data("contactInfo", {
					id: a.buId,
					name: a.contactName
				}), c.customerCombo.input.val(a.contactName), c.salesCombo.selectByValue(a.salesId, !1), c.$_date.val(a.date), c.$_deliveryDate.val(a.deliveryDate), c.$_number.text(a.billNo), 150601 == a.transType ? c.classBox.setValue(0) : c.classBox.setValue(1), c.$_note.val(a.description), c.$_discountRate.val(a.disRate), c.$_deduction.val(a.disAmount), c.$_discount.val(a.amount), c.$_payment.val(a.rpAmount), c.accountCombo.selectByValue(a.accId, !1), c.$_accountInfo.data("accountInfo", a.accounts), -1 === a.accId ? c.$_accountInfo.show() : c.$_accountInfo.hide(), c.$_arrears.val(a.arrears), c.$_totalArrears.val(a.totalArrears), c.$_userName.html(a.userName), c.$_modifyTime.html(a.modifyTime), c.$_createTime.html(a.createTime), c.$_checkName.html(a.checkName)
			}
			$("#grid").clearGridData();
			var c = this;
			originalData = a;
			var d = 8 - a.entries.length;
			if (d > 0) for (var e = 0; d > e; e++) a.entries.push({});
			$("#grid").jqGrid("setGridParam", {
				data: a.entries,
				userData: {
					qty: a.totalQty,
					deduction: a.totalDiscount,
					amount: a.totalAmount,
					tax: a.totalTax,
					taxAmount: a.totalTaxAmount
				}
			}).trigger("reloadGrid"), b(), "edit" === a.status ? this.editable || (c.enableEdit(), $("#groupBtn").html(c.btn_edit + c.btn_audit), $("#mark").removeClass("has-audit")) : this.editable && (c.disableEdit(), $("#groupBtn").html(c.btn_turn + c.btn_view + c.btn_reaudit), $("#mark").addClass("has-audit"))
		},
		initCombo: function() {
			var a = this;
			this.goodsCombo = Business.billGoodsCombo($(".goodsAuto"), {
				disSerNum: !0
			}), this.skuCombo = Business.billskuCombo($(".skuAuto"), {
				data: []
			}), this.storageCombo = Business.billStorageCombo($(".storageAuto")), this.unitCombo = Business.unitCombo($(".unitAuto"), {
				defaultSelected: -1,
				forceSelection: !1
			}), this.priceCombo = $(".priceAuto").combo({
				data: function() {
					if (!this.input) return [];
					var a = $("#customer").data("contactInfo");
					if (!a) return [];
					var b = this.input.closest("tr"),
						c = b.data("goodsInfo");
					if (!c) return [];
					var d = $("#customer").data("priceList")[c.id];
					if (!d || !d.prices) return [];
					if (a.id <= 0) return [];
					var e = [];
					if (d.prices.levelPrice) {
						var f = "";
						a.cLevel < 3 ? f = ["零售", "批发", "VIP"][a.cLevel] + "价：" + d.prices.levelPrice : d.prices.discountRate && (f = ["折扣一", "折扣二"][a.cLevel - 3] + "价：" + d.prices.levelPrice * d.prices.discountRate / 100), f && e.push({
							name: f,
							id: 1
						})
					}
					return d.prices.nearPrice && e.push({
						name: "最近售价：" + d.prices.nearPrice,
						id: 2
					}), e
				},
				text: "name",
				value: "id",
				defaultSelected: 0,
				cache: !1,
				editable: !0,
				trigger: !1,
				defaultFlag: !1,
				forceSelection: !1,
				listWidth: 140,
				callback: {
					onChange: function(a) {},
					onFocus: function() {
						var b = $(".priceAuto ").siblings(".ui-icon-triangle-1-s").hide(),
							c = this.input.closest("tr"),
							d = c.data("goodsInfo");
						if (d) {
							var e = a.$_customer.data("contactInfo"),
								f = a.$_customer.data("priceList");
							if (f || (f = {}, a.$_customer.data("priceList", f)), e && "" !== $.trim(a.$_customer.find("input").val())) {
								var g = function() {
										var a = {
											cId: e.id
										};
										f[d.id] = a, Public.ajaxPost("../basedata/inventory/listBySelected?action=listBySelected", {
											type: "so",
											ids: d.id,
											contactId: e.id
										}, function(c) {
											if (200 === c.status && c.data && c.data.result) {
												for (var d = c.data.result, e = 0, f = d.length; f > e; e++) {
													var g = d[e];
													g.nearPrice && (a.prices = {}, a.prices.nearPrice = g.nearPrice), g.salePrice && (a.prices = a.prices || {}, a.prices.levelPrice = g.salePrice, a.prices.discountRate = g.discountRate)
												}
												a.prices && b.show()
											}
										})
									};
								if (f[d.id]) {
									var h = f[d.id];
									h.cId != e.id ? g() : h.prices && b.show()
								} else g()
							}
						}
					}
				}
			}).getCombo()
		},
		disableEdit: function() {
			this.customerCombo.disable(), this.salesCombo.disable(), this.$_date.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_deliveryDate.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_note.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_discountRate.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_deduction.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_payment.attr("disabled", "disabled").addClass("ui-input-dis"), this.accountCombo.disable(), $("#grid").jqGrid("setGridParam", {
				cellEdit: !1
			}), this.editable = !1
		},
		enableEdit: function() {
			disEditable || (this.salesCombo.enable(), this.customerCombo.enable(), this.$_date.removeAttr("disabled").removeClass("ui-input-dis"), this.$_deliveryDate.removeAttr("disabled").removeClass("ui-input-dis"), this.$_note.removeAttr("disabled").removeClass("ui-input-dis"), this.$_discountRate.removeAttr("disabled").removeClass("ui-input-dis"), this.$_deduction.removeAttr("disabled").removeClass("ui-input-dis"), this.$_payment.removeAttr("disabled").removeClass("ui-input-dis"), this.accountCombo.enable(), $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			}), this.editable = !0)
		},
		chooseAccount: function(a) {
			var b = this;
			b.$_accountInfo.show(), b.$_payment.attr("disabled", "disabled").addClass("ui-input-dis"), $.dialog({
				width: 670,
				height: 250,
				title: "多账户结算",
				content: "url:../settings/choose_account",
				data: {
					accountInfo: a,
					type: "purchase"
				},
				lock: !0,
				ok: function() {
					var a = this.content.callback();
					return a ? (b.$_payment.val(a.payment).trigger("keyup"), b.$_accountInfo.data("accountInfo", a.accounts), b.accountCombo.blur(), void 0) : !1
				},
				cancel: !0
			})
		},
		addEvent: function() {
			var a = this;
			this.customerCombo.input.enterKey(), this.$_date.bind("keydown", function(b) {
				13 === b.which && a.$_deliveryDate.trigger("focus").select()
			}).bind("focus", function(b) {
				a.dateValue = $(this).val()
			}).bind("blur", function(b) {
				var c = /((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/;
				c.test($(this).val()) || (parent.Public.tips({
					type: 2,
					content: "日期格式有误！如：2012-08-08。"
				}), $(this).val(a.dateValue))
			}), this.$_deliveryDate.bind("keydown", function(a) {
				13 === a.which && $("#grid").jqGrid("editCell", 1, 2, !0)
			}).bind("focus", function(b) {
				a.dateValue = $(this).val()
			}).bind("blur", function(b) {
				var c = /((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/;
				c.test($(this).val()) || (parent.Public.tips({
					type: 2,
					content: "日期格式有误！如：2012-08-08。"
				}), $(this).val(a.dateValue))
			}), this.$_note.enterKey(), this.$_discount.enterKey(), this.$_discountRate.enterKey(), $(".grid-wrap").on("click", ".ui-icon-triangle-1-s", function(a) {
				var b = $(this).siblings(),
					c = b.getCombo();
				setTimeout(function() {
					c.active = !0, c.doQuery()
				}, 10)
			}), Business.billsEvent(a, "sales"), this.$_deduction.keyup(function() {
				var b = Number($(this).val()),
					c = Number($("#grid").jqGrid("footerData", "get")[a.calAmount].replace(/,/g, "")),
					d = (c - b).toFixed(amountPlaces);
				if (c) {
					var e = b / c * 100,
						f = d - Number($.trim(a.$_payment.val()));
					THISPAGE.$_discountRate.val(e.toFixed(amountPlaces)), THISPAGE.$_discount.val(d), THISPAGE.$_arrears.val(f)
				}
			}).on("keypress", function(a) {
				Public.numerical(a)
			}).on("click", function() {
				this.select()
			}).blur(function(a) {
				$(this).val() < 0 && (defaultPage.Public.tips({
					content: 2,
					content: "优惠金额不能为负数！"
				}), $(this).focus())
			}), this.$_discountRate.keyup(function() {
				var b = Number($(this).val()),
					c = Number($("#grid").jqGrid("footerData", "get")[a.calAmount].replace(/,/g, "")),
					d = c * (b / 100),
					e = d.toFixed(amountPlaces),
					f = (c - e).toFixed(amountPlaces),
					g = f - Number($.trim(a.$_payment.val()));
				THISPAGE.$_deduction.val(e), THISPAGE.$_discount.val(f), THISPAGE.$_arrears.val(g)
			}).on("keypress", function(a) {
				Public.numerical(a)
			}).on("click", function() {
				this.select()
			}).blur(function(a) {
				$(this).val() < 0 && (defaultPage.Public.tips({
					content: 2,
					content: "优惠率不能为负数！"
				}), $(this).focus())
			}), this.$_payment.keyup(function() {
				var b = $(this).val() || 0,
					c = a.$_discount.val(),
					d = Number(parseFloat(c) - parseFloat(b)),
					e = Number(d + THISPAGE.customerArrears);
				THISPAGE.$_arrears.val(d.toFixed(amountPlaces)), THISPAGE.$_totalArrears.val(e.toFixed(amountPlaces));
				var f = a.$_accountInfo.data("accountInfo");
				f && 1 === f.length && (f[0].payment = b)
			}).on("keypress", function(a) {
				Public.numerical(a)
			}).on("click", function() {
				this.select()
			}), $(".wrapper").on("click", "#save", function(b) {
				b.preventDefault();
				var c = $(this),
					d = THISPAGE.getPostData();
				d && ("edit" === originalData.stata && (d.id = originalData.id, d.stata = "edit"), c.ajaxPost("../scm/invSo/add?action=add", {
					postData: JSON.stringify(d)
				}, function(b) {
					if (200 === b.status) {
						a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), a.$_createTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id;
						var c = a.btn_edit;
						c += billRequiredCheck ? a.btn_audit : a.btn_audit + a.btn_close, a.$_toolBottom.html('<span id="groupBtn">' + c + "</span>"), parent.Public.tips({
							content: "保存成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#savaAndAdd", function(b) {
				b.preventDefault();
				var c = $(this),
					d = THISPAGE.getPostData();
				d && c.ajaxPost("../scm/invSo/addNew?action=addNew", {
					postData: JSON.stringify(d)
				}, function(b) {
					if (200 === b.status) {
						a.$_number.text(b.data.billNo), $("#grid").clearGridData(), $("#grid").clearGridData(!0);
						for (var c = 1; 8 >= c; c++) $("#grid").jqGrid("addRowData", c, {});
						a.newId = 9, a.$_note.val(""), a.$_discountRate.val(originalData.disRate), a.$_deduction.val(originalData.disAmount), a.$_discount.val(originalData.amount), a.$_payment.val(originalData.rpAmount), a.$_arrears.val(originalData.arrears), a.accountCombo.selectByValue(0, !0), parent.Public.tips({
							content: "保存成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: b.msg
					})
				})
			}), $(".wrapper").on("click", "#edit", function(b) {
				if (b.preventDefault(), Business.verifyRight("SO_UPDATE")) {
					var c = $(this),
						d = THISPAGE.getPostData();
					d && c.ajaxPost("../scm/invSo/updateInvSo?action=updateInvSo", {
						postData: JSON.stringify(d)
					}, function(b) {
						200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, parent.Public.tips({
							content: "修改成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#audit", function(b) {
				if (b.preventDefault(), Business.verifyRight("SO_CHECK")) {
					var c = $(this),
						d = THISPAGE.getPostData();
					d && c.ajaxPost("../scm/invSo/checkInvSo?action=checkInvSo", {
						postData: JSON.stringify(d)
					}, function(b) {
						200 === b.status ? (originalData.id = b.data.id, $("#mark").addClass("has-audit"), a.$_checkName.html(SYSTEM.realName).parent().show(), a.disableEdit(), $("#groupBtn").html(a.btn_turn + a.btn_view + a.btn_reaudit + a.btn_close), "150602" == a.classBox.getValue() ? $("#turn").html("生成退货单") : $("#turn").html("生成销货单"), parent.Public.tips({
							content: "审核成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#reAudit", function(b) {
				if (b.preventDefault(), Business.verifyRight("SO_UNCHECK")) {
					var c = $(this);
					c.ajaxPost("../scm/invSo/rsBatchCheckInvSo?action=rsBatchCheckInvSo", {
						id: originalData.id
					}, function(b) {
						200 === b.status ? ($("#mark").removeClass(), a.$_checkName.html(""), a.enableEdit(), $("#groupBtn").html(a.btn_edit + a.btn_audit), parent.Public.tips({
							content: "反审核成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#close", function(b) {
				if (b.preventDefault(), Business.verifyRight("SO_CLOSE")) {
					var c = $(this),
						d = THISPAGE.getPostData();
					d && c.ajaxPost("../scm/invSo/batchClose?action=batchClose", {
						id: originalData.id
					}, function(b) {
						200 === b.status && b.msg && b.msg.length ? 1 == b.msg[0].isSuccess ? ($("#mark").addClass("has-closed"), a.disableEdit(), $("#groupBtn").html(a.btn_view + a.btn_open), "150602" == a.classBox.getValue() ? $("#turn").html("生成退货单") : $("#turn").html("生成销货单"), parent.Public.tips({
							content: "关闭成功！"
						})) : parent.Public.tips({
							type: 1,
							content: "关闭失败：" + b.msg[0].msg || ""
						}) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#open", function(b) {
				if (b.preventDefault(), Business.verifyRight("SO_UNCLOSE")) {
					var c = $(this);
					c.ajaxPost("../scm/invSo/rebatchClose?action=rebatchClose", {
						id: originalData.id
					}, function(b) {
						200 === b.status && b.msg && b.msg.length ? 1 == b.msg[0].isSuccess ? ($("#mark").removeClass("has-closed"), a.enableEdit(), $("#groupBtn").html((billRequiredCheck ? a.btn_turn : "") + a.btn_edit + a.btn_audit + a.btn_close), "150602" == a.classBox.getValue() ? $("#turn").html("生成退货单") : $("#turn").html("生成销货单"), parent.Public.tips({
							content: "开启成功！"
						})) : parent.Public.tips({
							type: 1,
							content: "开启失败：" + b.msg[0].msg || ""
						}) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#add", function(a) {
				a.preventDefault(), Business.verifyRight("SO_ADD") && parent.tab.overrideSelectedTabItem({
					tabid: "sales-salesOrder",
					text: "销售订单",
					url: "../scm/invSo?action=initSo"
				})
			}), $(".wrapper").on("click", "#print", function(a) {
				a.preventDefault(), Business.verifyRight("SO_PRINT") && Public.print({
					title: "销货订单列表",
					$grid: $("#grid"),
					pdf: "../scm/invSo/toPdf?action=toPdf",
					billType: 10303,
					filterConditions: {
						id: originalData.id
					}
				})
			}), this.$_accountInfo.click(function() {
				var b = $(this).data("accountInfo");
				a.chooseAccount(b)
			}), $(".wrapper").on("click", "#turn", function(b) {
				if (b.preventDefault(), $(this).hasClass("ui-btn-dis")) return void parent.Public.tips({
					type: 1,
					content: "该订单已全部入库，不能生成销货单！"
				});
				var c = "销货单",
					d = "sales-sales",
					e = a.classBox.getValue();
				if ("150602" == e) var c = "销货退货单",
					d = "sales-salesBack";
				parent.tab.addTabItem({
					tabid: d,
					text: c,
					url: "../scm/invSa?action=initSale&id=" + originalData.id + "&flag=list&turn&transType=" + e
				}), parent.tab.reload(d)
			}), $("#prev").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-prev-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有上一张了！"
				}), !1) : (a.idPostion = a.idPostion - 1, 0 === a.idPostion && $(this).addClass("ui-btn-prev-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invSo/update?action=update", {
					id: a.idList[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#next").removeClass("ui-btn-next-dis"), loading && loading.close()
				}), void 0)
			}), $("#next").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-next-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有下一张了！"
				}), !1) : (a.idPostion = a.idPostion + 1, a.idLength === a.idPostion + 1 && $(this).addClass("ui-btn-next-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invSo/update?action=update", {
					id: a.idList[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#prev").removeClass("ui-btn-prev-dis"), loading && loading.close()
				}), void 0)
			}), THISPAGE.$_barCodeInsert.click(function(b) {
				var c = 1;
				THISPAGE.$_barCodeInsert.hasClass("active") ? (THISPAGE.$_barCodeInsert.removeClass("active"), c = null) : THISPAGE.$_barCodeInsert.addClass("active"), a.goodsEdittypeInit(), $.cookie("BarCodeInsert", c)
			}), $("#config").show().click(function(b) {
				a.mod_PageConfig.config()
			}), $(window).resize(function(a) {
				Public.autoGrid($("#grid"))
			})
		},
		resetData: function() {
			var a = this;
			$("#grid").clearGridData();
			for (var b = 1; 8 >= b; b++) $("#grid").jqGrid("addRowData", b, {}), $("#grid").jqGrid("footerData", "set", {
				qty: 0,
				amount: 0
			});
			a.$_note.val(""), a.$_discountRate.val(originalData.disRate), a.$_deduction.val(originalData.disAmount), a.$_discount.val(originalData.amount), a.$_payment.val(originalData.rpAmount), a.$_arrears.val(originalData.arrears)
		},
		calTotal: function() {
			for (var a = $("#grid").jqGrid("getDataIDs"), b = 0, c = 0, d = 0, e = 0, f = 0, g = 0, h = a.length; h > g; g++) {
				var i = a[g],
					j = $("#grid").jqGrid("getRowData", i);
				j.qty && (b += parseFloat(j.qty)), j.deduction && (c += parseFloat(j.deduction)), j.amount && (d += parseFloat(j.amount)), j.tax && (e += parseFloat(j.tax)), j.taxAmount && (f += parseFloat(j.taxAmount))
			}
			if ($("#grid").jqGrid("footerData", "set", {
				qty: b,
				deduction: c,
				amount: d,
				tax: e,
				taxAmount: f
			}), taxRequiredCheck) var k = (f - Number(this.$_deduction.val())).toFixed(2);
			else var k = (d - Number(this.$_deduction.val())).toFixed(2);
			var l = (k - Number(this.$_payment.val())).toFixed(2);
			l = Number(l) ? l : "0.00", this.$_discount.val(k), this.$_arrears.val(l)
		},
		_getEntriesData: function() {
			for (var a = [], b = $("#grid").jqGrid("getDataIDs"), c = 0, d = b.length; d > c; c++) {
				var e, f = b[c],
					g = $("#grid").jqGrid("getRowData", f);
				if ("" !== g.goods) {
					var h = $("#" + f).data("goodsInfo"),
						i = $("#" + f).data("storageInfo"),
						j = $("#" + f).data("unitInfo") || {},
						k = $("#" + f).data("skuInfo") || {};
					if (h.invSkus && h.invSkus.length > 0 && !k.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的属性！"
					}), $("#grid").jqGrid("editCellByColName", f, "skuName"), !1;
					if (!i || !i.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的仓库！"
					}), $("#grid").jqGrid("editCellByColName", f, "locationName"), !1;
					e = {
						invId: h.id,
						invNumber: h.number,
						invName: h.name,
						invSpec: h.spec || "",
						skuId: k.id || -1,
						skuName: k.name || "",
						unitId: j.unitId || -1,
						mainUnit: j.name || "",
						qty: g.qty,
						price: g.price,
						discountRate: g.discountRate,
						deduction: g.deduction,
						amount: g.amount,
						locationId: i.id,
						locationName: i.name,
						description: g.description
					}, taxRequiredCheck && (e.taxRate = g.taxRate, e.tax = g.tax, e.taxAmount = g.taxAmount), a.push(e)
				}
			}
			return a
		},
		getPostData: function() {
			var a = this,
				b = this;
			null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null);
			var c = b.$_customer.find("input");
			if ("" === c.val()) return b.$_customer.removeData("contactInfo"), parent.Public.tips({
				type: 2,
				content: "请选择客户！"
			}), !1;
			var d = b.$_customer.data("contactInfo");
			if (!d || !d.id) return setTimeout(function() {
				c.focus().select()
			}, 15), parent.Public.tips({
				type: 2,
				content: "当前客户不存在！"
			}), !1;
			var e = this._getEntriesData();
			if (!e) return !1;
			if (e.length > 0) {
				var f = $.trim(a.$_note.val()),
					g = {
						id: originalData.id,
						buId: d.id,
						contactName: d.name,
						salesId: a.salesCombo.getValue(),
						salesName: a.salesCombo.getText(),
						date: $.trim(a.$_date.val()),
						deliveryDate: $.trim(a.$_deliveryDate.val()),
						billNo: $.trim(a.$_number.text()),
						transType: a.classBox.getValue(),
						entries: e,
						totalQty: $("#grid").jqGrid("footerData", "get").qty.replace(/,/g, ""),
						totalDiscount: $("#grid").jqGrid("footerData", "get").deduction.replace(/,/g, ""),
						totalAmount: $("#grid").jqGrid("footerData", "get").amount.replace(/,/g, ""),
						description: f === a.$_note[0].defaultValue ? "" : f,
						disRate: $.trim(a.$_discountRate.val()),
						disAmount: $.trim(a.$_deduction.val()),
						amount: $.trim(a.$_discount.val())
					};
				return taxRequiredCheck && (g.totalTax = $("#grid").jqGrid("footerData", "get").tax.replace(/,/g, ""), g.totalTaxAmount = $("#grid").jqGrid("footerData", "get").taxAmount.replace(/,/g, "")), g
			}
			return parent.Public.tips({
				type: 2,
				content: "商品信息不能为空！"
			}), $("#grid").jqGrid("editCell", 1, 2, !0), !1
		}
	},
	hasLoaded = !1,
	originalData;
$(function() {
	if (urlParam.id) {
		if (!hasLoaded) {
			var a = $(".bills").hide();
			Public.ajaxGet("../scm/invSo/update?action=update", {
				id: urlParam.id
			}, function(b) {
				200 === b.status ? (originalData = b.data, THISPAGE.init(b.data), a.show(), hasLoaded = !0) : parent.Public.tips({
					type: 1,
					content: b.msg
				})
			})
		}
	} else originalData = {
		id: -1,
		status: "add",
		customer: 0,
		transType: 150601,
		entries: [{
			id: "1",
			mainUnit: null
		}, {
			id: "2"
		}, {
			id: "3"
		}, {
			id: "4"
		}, {
			id: "5"
		}, {
			id: "6"
		}, {
			id: "7"
		}, {
			id: "8"
		}],
		totalQty: 0,
		totalDiscount: 0,
		totalAmount: 0,
		totalTax: 0,
		totalTaxAmount: 0,
		disRate: 0,
		disAmount: 0,
		amount: "0.00",
		rpAmount: "0.00",
		arrears: "0.00",
		accId: 0
	}, THISPAGE.init(originalData)
});
