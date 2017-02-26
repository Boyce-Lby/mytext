<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
	function httpPost($url,$method='get') {  
	    $url = $url;  
	    if (($ch = curl_init($url)) == false) {  
	        throw new Exception(sprintf("curl_init error for url %s.", $url));  
	    }  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	    curl_setopt($ch, CURLOPT_HEADER, 0);  
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);  
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
	    $postResult = @curl_exec($ch);  
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    if ($postResult === false || $http_code != 200 || curl_errno($ch)) {  
	        $error = curl_error($ch);  
	        curl_close($ch);  
	        throw new Exception("HTTP POST FAILED:$error");  
	    } else {  
	        switch (curl_getinfo($ch, CURLINFO_CONTENT_TYPE)) {  
	            case 'application/json':  
	                $postResult = json_decode($postResult);  
	                break;  
	        }  
	        curl_close($ch);  
	        return $postResult;  
	    }  
	}  