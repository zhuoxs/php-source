<?php
class SignatureHelper
{
    public function request($accessKeyId, $accessKeySecret, $domain, $params, $security = false, $method = "POST")
    {
        goto MAt3u;
        MAt3u:
        $apiParams = array_merge(array("SignatureMethod" => "HMAC-SHA1", "SignatureNonce" => uniqid(mt_rand(0, 0xffff), true), "SignatureVersion" => "1.0", "AccessKeyId" => $accessKeyId, "Timestamp" => gmdate("Y-m-d\\TH:i:s\\Z"), "Format" => "JSON"), $params);
        goto O6w2C;
        o690z:
        $sortedQueryStringTmp = '';
        goto Qd91y;
        Qd91y:
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
            eELJi:
        }
        goto TZ8Dh;
        hSkDf:
        try {
            $content = $this->fetchContent($url, $method, "Signature={$signature}{$sortedQueryStringTmp}");
            return json_decode($content);
        } catch (\Exception $e) {
            return false;
        }
        goto oSoWS;
        aeF5m:
        $signature = $this->encode($sign);
        goto PLoK5;
        zZiHI:
        $stringToSign = "{$method}&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));
        goto QB0lz;
        O6w2C:
        ksort($apiParams);
        goto o690z;
        TZ8Dh:
        WHpvY:
        goto zZiHI;
        QB0lz:
        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&", true));
        goto aeF5m;
        PLoK5:
        $url = ($security ? "https" : "http") . "://{$domain}/";
        goto hSkDf;
        oSoWS:
    }
    private function encode($str)
    {
        goto mueS5;
        LcpT_:
        $res = preg_replace("/%7E/", "~", $res);
        goto Yc4Vz;
        kGQmz:
        $res = preg_replace("/\\+/", "%20", $res);
        goto XQnhS;
        Yc4Vz:
        return $res;
        goto vJU2_;
        XQnhS:
        $res = preg_replace("/\\*/", "%2A", $res);
        goto LcpT_;
        mueS5:
        $res = urlencode($str);
        goto kGQmz;
        vJU2_:
    }
    private function fetchContent($url, $method, $body)
    {
        goto LVl93;
        BP1XS:
        if ($method == "POST") {
            goto KV8cc;
        }
        goto cp0rv;
        grFdP:
        curl_setopt($ch, CURLOPT_URL, $url);
        goto Ov9Dp;
        IMGGI:
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        goto EiMby;
        M9s4c:
        trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        goto TD7sv;
        YiuUl:
        KV8cc:
        goto yW3dX;
        RDSRW:
        VLzr0:
        goto grFdP;
        P9bg4:
        $rtn = curl_exec($ch);
        goto BhA7B;
        LVl93:
        $ch = curl_init();
        goto BP1XS;
        TD7sv:
        fEhOD:
        goto AxSpx;
        lCbHt:
        goto VLzr0;
        goto YiuUl;
        cp0rv:
        $url .= "?" . $body;
        goto lCbHt;
        BhA7B:
        if (!($rtn === false)) {
            goto fEhOD;
        }
        goto M9s4c;
        UkDUu:
        W1WUi:
        goto P9bg4;
        Ov9Dp:
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        goto hchxd;
        YLQIT:
        return $rtn;
        goto Wi4rd;
        EiMby:
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        goto UkDUu;
        hchxd:
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        goto UEsNj;
        AxSpx:
        curl_close($ch);
        goto YLQIT;
        UEsNj:
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("x-sdk-client" => "php/2.0.0"));
        goto nZm3o;
        nZm3o:
        if (!(substr($url, 0, 5) == "https")) {
            goto W1WUi;
        }
        goto IMGGI;
        u0kpF:
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        goto RDSRW;
        yW3dX:
        curl_setopt($ch, CURLOPT_POST, 1);
        goto u0kpF;
        Wi4rd:
    }
}