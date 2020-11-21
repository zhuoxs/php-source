/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

/**
 * 删除数据
 * url = 请求url
 * ids = {"ids": ['1', '2']}
 * return bool
*/
function funDelete(url, ids, cb) {
	layer.confirm('确定要删除么', {
		offset: '20%',
		btn: ['再想想', '删除'],
		scrollbar: false,
		closeBtn: 0,
	}, function (i) {
		layer.close(i);
	}, function (i) {
		$.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: JSON.stringify({'ids': ids}),
			success: function (rs) {

				if (rs && rs.code.toString() === '0') {
					cb({code: '0', msg: 'ok'});
				} else {
					let data_return = {code: '1', msg: rs.msg};
					cb({code: '1', msg: rs.msg});
				}
			},
			error: function () {
				cb({code: '1', msg: '提交过程发生错误，请与管理员联系'});
			}
		});
	});
}
