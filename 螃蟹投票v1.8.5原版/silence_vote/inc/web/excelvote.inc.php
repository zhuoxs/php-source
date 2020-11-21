<?php

goto Rnoqs;
IW7z0:
ltkdq:
goto ZE2dd;
PYRWB:
$file_type = $file_types[count($file_types) - 1];
goto K1YID;
wU3Y5:
$temp["createtime"] = time();
goto oHim6;
YVdE5:
$path = MODULE_ROOT . "/temp/{$uniacid}/";
goto GWXNQ;
ZE2dd:
if (!($row <= $highestRow)) {
    goto SYoAp;
}
goto f9icx;
SW2g4:
$lastid = pdo_getall($this->tablevoteuser, array("rid" => $rid, "uniacid" => $_W["uniacid"]), array("noid", "source_id"), '', "noid DESC", array(1));
goto IYZjS;
mF7bx:
$temp["status"] = 1;
goto wU3Y5;
UDM_y:
if ($op == "downe") {
    goto Ma_Ix;
}
goto OHRoS;
qrWcR:
$noid++;
goto jPTga;
f9icx:
$temp["name"] = $sheet->getCell("A" . $row)->getValue();
goto eC0Qh;
Wdq6J:
$sheet = $objPHPExcel->getSheet(0);
goto HPXpg;
TXJvH:
echo $str;
goto Y1lx_;
pIxKO:
$op = $_GPC["op"];
goto prmpO;
L9ghd:
$temp["img2"] = $sheet->getCell("E" . $row)->getValue();
goto p4bi_;
TwiwU:
ZdKEp:
goto hZBSO;
Cfow6:
u0a8M:
goto YVdE5;
PpHI5:
foreach ($dataset as $v) {
    pdo_insert($this->modulename . "_voteuser", $v);
    ZyJdf:
}
goto AsWmC;
ypGsx:
message("excel导入成功", $this->createWebUrl("votelist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto V2V3D;
aDz2W:
$temp["img5"] = $sheet->getCell("H" . $row)->getValue();
goto AgSaf;
LoXfd:
$file = "player.xlsx";
goto NgKKb;
E0ohb:
goto ltkdq;
goto vtuTt;
EzXXI:
$f = fopen($filename, "r");
goto jYUaq;
jPTga:
mXfLd:
goto VOpRw;
tQJ0k:
header("Content-type:application/vnd.ms-excel");
goto UD9Tx;
eC0Qh:
$temp["nickname"] = $sheet->getCell("B" . $row)->getValue();
goto pQSBL;
UD9Tx:
header("Accept-Ranges: bytes");
goto h_6_s;
Rnoqs:
defined("IN_IA") or exit("Access Denied");
goto NEqcA;
prmpO:
$rid = intval($_GPC["rid"]);
goto u6QjX;
u7o3p:
W24ec:
goto dw5Ja;
AsWmC:
bb4QE:
goto rMg2m;
Fgzn7:
$temp["img4"] = $sheet->getCell("G" . $row)->getValue();
goto aDz2W;
pMus6:
$row = 2;
goto IW7z0;
rMg2m:
@unlink($path . $file_name);
goto ypGsx;
h_6_s:
header("Accept-Length: " . filesize($filename));
goto KhcY1;
cRuRY:
$objPHPExcel = PHPExcel_IOFactory::load($path . $file_name);
goto Wdq6J;
B6ENJ:
move_uploaded_file($_FILES["excel"]["tmp_name"], $path . $file_name);
goto glwF6;
xtdT3:
$file_types = explode(".", $_FILES["excel"]["name"]);
goto PYRWB;
NcQer:
$temp["uniacid"] = $uniacid;
goto mF7bx;
p4bi_:
$temp["img3"] = $sheet->getCell("F" . $row)->getValue();
goto Fgzn7;
eySVh:
message("上传文件错误，只支持xls和xlsx文件");
goto u7o3p;
OHRoS:
goto ZdKEp;
goto Cfow6;
riVug:
$temp["img1"] = $sheet->getCell("D" . $row)->getValue();
goto L9ghd;
GWXNQ:
mkdirs($path);
goto xtdT3;
mrb6U:
$datasets = array();
goto SW2g4;
Onck1:
fclose($f);
goto tQJ0k;
Oxj32:
$highestColumm = $sheet->getHighestColumn();
goto mrb6U;
pQSBL:
$temp["avatar"] = $sheet->getCell("C" . $row)->getValue();
goto riVug;
NgKKb:
$filename = MODULE_ROOT . "/template/static/player.xlsx";
goto EzXXI;
LU0PO:
$uniacid = $_W["uniacid"];
goto pIxKO;
K1YID:
if (!(strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx")) {
    goto W24ec;
}
goto eySVh;
MDoxQ:
Ma_Ix:
goto LoXfd;
NEqcA:
global $_W, $_GPC;
goto LU0PO;
vtuTt:
SYoAp:
goto PpHI5;
dw5Ja:
$str = "lastExcel";
goto FA3H2;
AgSaf:
$temp["resume"] = $sheet->getCell("I" . $row)->getValue();
goto Ytgpu;
HPXpg:
$highestRow = $sheet->getHighestRow();
goto Oxj32;
u6QjX:
if ($op == "upload") {
    goto u0a8M;
}
goto UDM_y;
Ytgpu:
$temp["rid"] = $rid;
goto NcQer;
VOpRw:
$row++;
goto E0ohb;
IYZjS:
$noid = $lastid[0]["noid"] + 1;
goto pMus6;
KhcY1:
header("Content-Disposition:filename=" . $file);
goto TXJvH;
glwF6:
include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel.php";
goto cRuRY;
jYUaq:
$str = fread($f, filesize($filename));
goto Onck1;
FA3H2:
$file_name = $str . "." . $file_type;
goto B6ENJ;
oHim6:
$temp["noid"] = $noid;
goto CGXka;
CGXka:
$dataset[] = $temp;
goto qrWcR;
V2V3D:
goto ZdKEp;
goto MDoxQ;
Y1lx_:
exit;
goto TwiwU;
hZBSO:
include $this->template("excelvote");