<?php
//QQ63779278
class Sale_EweiShopV2Model
{
	/**
     * 全返的自定文字
     * @param bool $echo 是否直接输出
     * @return string|void 不直接输出时返回文字
     * @author cunx
     */
	public function getFullBackText($echo = false)
	{
		$text = '全返';
		$set = m('common')->getSysset('fullback');

		if (!empty($set['text'])) {
			$text = $set['text'];
		}

		if ($echo) {
			echo $text;
			return NULL;
		}

		return $text;
	}

	/**
     * 解析发票抬头
     * @param $invoice_name
     * @param bool $include_title
     * @return array
     * @author cunx
     */
	public function parseInvoiceInfo($invoice_name)
	{
		$invoice_name = (string) $invoice_name;
		$invoice_arr = array('entity' => false, 'company' => false, 'title' => false, 'number' => false);
		$invoice_name = str_replace(array('[', ']', '（', '）', ':'), '', $invoice_name);
		$invoice_info = explode(' ', $invoice_name);
		if (!empty($invoice_info) && ($invoice_info[0] === '电子' || $invoice_info[0] === '纸质')) {
			$invoice_arr['entity'] = $invoice_info[0] === '电子' ? false : true;
			$invoice_arr['title'] = $invoice_info[1];
			$invoice_arr['company'] = $invoice_info[2] === '个人' ? false : true;
			$invoice_arr['number'] = $invoice_info[3] ? $invoice_info[3] : false;
		}

		return $invoice_arr;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
