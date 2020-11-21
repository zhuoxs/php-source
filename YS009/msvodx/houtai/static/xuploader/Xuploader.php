<?php
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

/**
 * 文件上传类，基于plupload实现
 * @Author: Dreamer
 * @Date:   2017/11/15
 */

// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/*
*/
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(3000); //only linux can use
//sleep(1);

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
date_default_timezone_set('PRC');
$baseDir= "XResource".DIRECTORY_SEPARATOR.date('Ymd');
$targetDir = dirname(__FILE__). DIRECTORY_SEPARATOR .$baseDir;

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
    @mkdir($targetDir,'0777',true);
}

// Get a file name
if (isset($_REQUEST["name"])) {
    $fileName = $_REQUEST["name"];
    $fileName=XRenameFileName($fileName,$_REQUEST['newFileName']);
} elseif (!empty($_FILES)) {
    $fileName = $_FILES["file"]["name"];
    $fileName=XRenameFileName($fileName,$_REQUEST['newFileName']);
} else {
    $fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks =isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files
if ($cleanupTargetDir) {
    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    }

    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}.part") {
            continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {

    //file exists
    if(!file_exists($filePath)) {
        rename("{$filePath}.part", $filePath);
        $newFilePath=$filePath;
    }else{
        $_tmpArr=explode('.',$fileName);
        $filePrefix=end($_tmpArr);
        $newFileName=str_replace(".{$filePrefix}",'',$fileName).'___'.time().'.'.$filePrefix;
        $newFilePath=$targetDir.'\\'.$newFileName;
        rename("{$filePath}.part",$newFilePath);
        $fileName=$newFileName;
    }

    $httpType = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    $returnData=array(
        'jsonrpc'=>'2.0',
        'result'=>'success',
        'id'=>'id',
        'filePath'=>$httpType.$_SERVER['HTTP_HOST']."/".str_replace('\\','/',$baseDir)."/".str_replace('\\','/',$fileName)
    );



    //if the file is site favicon,must move to the site root.
    if(isset($_REQUEST['isFavicon'])&& $_REQUEST['isFavicon']){
        $favicon=dirname(__FILE__).'/favicon.ico';

        if(file_exists($favicon)) unlink($favicon);

        $rs=rename($newFilePath,$favicon);
        file_put_contents(dirname(__FILE__).'/logs.log',"\n 上传完成后路径：".$newFilePath."\t移到到的位置：{$favicon}\t".var_export($rs,1),FILE_APPEND);
        $returnData['filePath']=$httpType.$_SERVER['HTTP_HOST']."/favicon.ico";
    }


    die(json_encode($returnData));
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');


/**
 * rename file name
 * @param $oldName
 * @param $newName
 * @return string   The end file name
 */
function XRenameFileName($oldName,$newName){
    if(empty($newName)) return $oldName;
    $_tmpArr=explode('.',$oldName);
    $filePrefix=end($_tmpArr);
    return $newName.".{$filePrefix}";

}