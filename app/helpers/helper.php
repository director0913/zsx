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
	 * @num  [type]                   总的人数
	 * @return [type]                  中奖，则是第几，不中，返回0
	 */
if(!function_exists('getLuckly')){
	function getLuckly($percent,$level,$level_num)
	{
		//计算总的奖品数目
		for ($i=1; $i <count($level)+1 ; $i++) { 
			$allLevel += $level_num[$i]*$i;
		}
		$rand = rand(1,(100/$percent)*$allLevel);
		for ($i=1; $i <count($level)+1 ; $i++) { 
			if (1 <= $rand && $rand <= $level_num[$i]*$i) {
				return $i;
			}
		}
		return 0;
	}
}