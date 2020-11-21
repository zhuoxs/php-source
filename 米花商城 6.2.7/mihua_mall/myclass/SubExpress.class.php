<?php
 class SubExpress { private $eorder = array(); private $EBusinessID; private $AppKey; private $ReqURL; private $expressno; function __construct($eorder, $type) { goto Ae8n4; qoQC3: if (!($type == 2)) { goto CCVgh; } goto LdIUs; uU852: $this->EBusinessID = $eorder["\105\102\165\163\151\x6e\x65\x73\x73\111\x44"]; goto D0AfU; D0AfU: $this->AppKey = $eorder["\101\x70\160\x4b\x65\171"]; goto sCktY; LdIUs: $this->ReqURL = "\x68\x74\164\x70\72\x2f\57\x61\x70\151\x2e\153\x64\x6e\151\141\x6f\x2e\x63\x6f\155\57\x61\x70\151\57\x64\151\163\164"; goto Jv070; sCktY: unset($eorder["\105\x42\165\163\151\x6e\x65\x73\163\x49\104"], $eorder["\101\x70\x70\x4b\x65\171"]); goto YW8fc; JnLdw: $this->ReqURL = "\150\164\164\160\72\57\x2f\x61\160\x69\x2e\x6b\x64\x6e\x69\x61\x6f\x2e\x63\x6f\x6d\x2f\x45\142\x75\163\151\x6e\x65\x73\x73\57\105\142\x75\x73\151\x6e\145\x73\x73\117\162\x64\145\162\x48\x61\x6e\x64\154\x65\x2e\x61\x73\x70\x78"; goto kCio_; kCio_: W94Cq: goto qoQC3; Ae8n4: $this->eorder = $eorder; goto uU852; Jv070: CCVgh: goto jbMyB; YW8fc: if (!($type == 1)) { goto W94Cq; } goto JnLdw; jbMyB: } function getOrderTracesByJson() { goto tIdx3; w8I03: $datas["\104\141\164\x61\x53\151\x67\156"] = self::encrypt($requestData, $this->AppKey); goto lC7rZ; A0AVp: $datas = array("\x45\x42\165\163\x69\156\145\x73\163\x49\x44" => $this->EBusinessID, "\122\x65\x71\x75\x65\x73\x74\x54\x79\x70\145" => "\61\60\x30\62", "\x52\x65\161\165\x65\x73\x74\x44\141\164\x61" => urlencode($requestData), "\104\x61\x74\141\124\171\160\x65" => "\62"); goto w8I03; nH_0V: return $result; goto au2oO; lC7rZ: $result = Util::HttpPost($this->ReqURL, $datas); goto nH_0V; tIdx3: $requestData = "\173\x27\x4f\162\x64\x65\162\103\157\144\x65\x27\72\47\47\54\47\123\150\x69\x70\x70\145\x72\x43\x6f\x64\145\x27\72\x27{$this->eorder["\x53\x68\151\160\x70\145\162\103\x6f\144\145"]}\47\x2c\x27\114\157\147\151\x73\164\x69\x63\103\x6f\x64\x65\47\72\47{$this->eorder["\x4c\x6f\147\x69\x73\x74\x69\143\x43\x6f\144\x65"]}\47\175"; goto A0AVp; au2oO: } private static function encrypt($data, $appkey) { return urlencode(base64_encode(md5($data . $appkey))); } function orderTracesSubByJson() { goto OxMCz; EosX9: $datas = array("\105\102\165\163\151\x6e\x65\x73\163\x49\x44" => $this->EBusinessID, "\x52\x65\161\165\x65\x73\x74\124\x79\x70\145" => "\x31\x30\x30\70", "\122\145\161\165\145\163\x74\104\x61\164\141" => urlencode($requestData), "\x44\x61\x74\141\124\171\x70\145" => "\62"); goto YKPJn; LgHwS: $result = Util::HttpPost($this->ReqURL, $datas); goto zITZn; YKPJn: $datas["\104\x61\x74\141\123\x69\x67\x6e"] = self::encrypt($requestData, $this->AppKey); goto LgHwS; zITZn: return $result; goto x1lOk; OxMCz: $requestData = <<<div
\t\t{
\t\t\t'OrderCode': '',
\t\t\t'ShipperCode':"{$this->eorder["\123\150\151\160\160\145\x72\x43\x6f\144\145"]}",
\t\t\t'LogisticCode':'{$this->eorder["\x4c\x6f\147\x69\163\x74\x69\x63\103\157\144\145"]}',
\t\t\t'PayType':1,
\t\t\t'ExpType':1,
\t\t\t'IsNotice':0,
\t\t\t'Cost':1.0,
\t\t\t'OtherCost':1.0,
\t\t\t'Sender':'',
\t\t\t'Receiver':'',
\t\t\t'Commodity':'',
\t\t\t'Weight':'',
\t\t\t'Quantity':'',
\t\t\t'Volume':'',
\t\t\t'Remark':''
\t\t}
div;
goto EosX9; x1lOk: } }