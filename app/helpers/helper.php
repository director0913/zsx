<?php
if(!function_exists('flash_info')){
	function flash_info($result,$successMsg = 'success !',$errorMsg = 'something error !')
	{
		return $result ? flash($successMsg,'success')->important() : flash($errorMsg,'danger')->important();
	}
}

if(!function_exists('getUser')){
	function getUser($guards='')
	{
		return auth($guards)->user();
	}
}

if(!function_exists('getUerId')){
	function getUerId()
	{
		return getUser()->id;
	}
}
/**
	 * 抽奖
	 * @author 王浩
	 * @date  2018-04-29
	 * @percent  [type]            int    概率
	 * @luckly  [type]             array   各个奖项的数组
	 * @level_num  [type]                   总的人数
	 * @return [type]                  中奖，则是第几，不中，返回0
	 */
if(!function_exists('getLuckly')){
	function getLuckly($percent,$level,$level_num)
	{
		//计算总的奖品数目
		$allLevel = 0;
		for ($i=1; $i <count($level)+1 ; $i++) { 
			$allLevel += $level_num[$i-1]*$i;
		}
		$rand = rand(1,(100/$percent)*$allLevel);
		for ($i=1; $i <count($level)+1 ; $i++) { 
			if (1 <= $rand && $rand <= $level_num[$i-1]*$i) {
				return $i;
			}
		}
		return 0;
	}
}
/**
* @param $getUrl 请求网址
 * @param bool $params 请求参数
 * @param int $ispost 请求方式
 * @param int $https https协议
 * @return bool|mixed
 */
if(!function_exists('getUrl')){
	function getUrl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json'));
        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}
    