<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\Cut_priceRepositoryEloquent;
use App\Repositories\Eloquent\Cut_price_tempRepositoryEloquent;
use App\Repositories\Eloquent\Luckly_logRepositoryEloquent;
use App\Repositories\Eloquent\Cut_price_collectRepositoryEloquent;
use App\Service\Admin\BaseService;
use App\Models\Cut_price;
use Illuminate\Http\Request;
use App\Traits\ActionButtonAttributeTrait;
use Storage;
use Exception;
use Excel;
use Session;
/**
* 大转盘service
*/
class LucklyService extends BaseService
{
	use ActionButtonAttributeTrait;
	private $action = 'activity';
	function __construct(Cut_priceRepositoryEloquent $cut_price,Cut_price_tempRepositoryEloquent $cut_price_temp,Luckly_logRepositoryEloquent $luckly_log,Cut_price_collectRepositoryEloquent $cut_price_collect)
	{
		$this->cut_price =  $cut_price;
		$this->cut_price_temp =  $cut_price_temp;
		$this->cut_price_collect =  $cut_price_collect;
		$this->luckly_log =  $luckly_log;
	}
	/**
	 * datatables获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function ajaxCutLists($where=[],$p=1)
	{
		// datatables请求次数
		$draw = request('id', 1);
		//var_dump($request->id);die;
		// 每页显示数目
		$length = 10;
		// 开始条数
		$start = intval(intval($p)-1)*$length;
		$search = $where;
		// 排序

		$order['name'] = request('columns.' .request('order.0.column',0) . '.name','id');
		$order['dir'] = request('order.0.dir','asc');
		$result = $this->cut_price_temp->getCut_price_tempList($start,$length,$search,$order);
		if ($result['roles']) {
			foreach ($result['roles'] as $k=>$v) {
				$this->id = $v->id;
				//$result['roles'][$k]['actionButton'] = $this->getActionButtonAttribute(false);
				$result['roles'][$k]['action'] = $this->getActionButtonAttribute(true);
				$result['roles'][$k]['info'] = json_decode($v->info,true);
				if (strtotime($result['roles'][$k]['info']['end_at'])<=time()) {
					$result['roles'][$k]['status'] = '已结束！';
				}elseif(strtotime($result['roles'][$k]['info']['end_at'])>time() && strtotime($result['roles'][$k]['info']['start_at'])>time()){
					$result['roles'][$k]['status'] = '未开始！';
				}elseif(strtotime($result['roles'][$k]['info']['end_at'])>time() && strtotime($result['roles'][$k]['info']['start_at'])<time()){
					$result['roles'][$k]['status'] = '进行中！';
				}
			}
		}
		//获取访问量
		$viewsCount = $this->cut_price_temp->sumViews();
		//获取总的报名人数
		$collectCount = $this->cut_price_collect->sumCollect();
		//获取总的报名人数
		$tempCount = $this->cut_price_temp->sumTemp();
		return [
			'draw' => $draw,
			'recordsTotal' => $result['count'],
			'recordsFiltered' => $result['count'],
			'data' => $result['roles'],
			'views' => $viewsCount,
			'collectCount' => $collectCount,
			'tempCount' => $tempCount,
			'length' => ceil($result['count']/$length),
		];
	}
	/**
	 * 创建用户视图数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function createView()
	{
		return [$this->getAllPermissionList(),$this->getAllRoles()];
	}
	/**
	 * 统计详情
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function getTotalLists($formData)
	{
		return  $this->cut_price_collect->findAll(['temp_id'=>$formData['id']]);
		// if ($result) {
		// 	foreach ($result as $k=>$v) {
		// 		$this->id = $v->id;
		// 		$result[$k]['action'] = $this->getActionButtonAttribute(true);
		// 	}
		// }
		// return $result;
		
	}
	/**
	 * 获取所有权限并分组
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function getAllPermissionList()
	{
		return $this->permission->groupPermissionList();
	}
	/**
	 * 获取所有的角色
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function getAllRoles()
	{
		return $this->role->all(['id','name']);
	}
	
	/**
	 * 创建基础模版
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $formData [表单中所有的数据]
	 * @return [type]                             [Boolean]
	 */
	public function store($request)
	{
		$formData = $request->all();
		$parm['title'] = $formData['title']?$formData['title']:'';
		$parm['cut_price_id'] = isset($formData['cut_price_id']) && intval($formData['cut_price_id'])?intval($formData['cut_price_id']):'';
		$form['start_at'] = $formData['start_at'];
		$form['end_at'] = $formData['end_at'];
		//参与人数是否限制，不限制的话为0，限制的话为具体数目
		$form['join_num_limit'] = intval($formData['join_num_limit'])?intval($formData['join_num_limit']):0;
		$form['join_num'] = intval($formData['join_num'])?intval($formData['join_num']):0;
		//参与人数是否显示，显示1，不显示0
		$form['join_num_show'] = $formData['join_num_show']==1?1:0;
		//虚拟人数
		$form['join_num_xuni'] = intval($formData['join_num_xuni'])?intval($formData['join_num_xuni']):0;
		//活动说明
		$form['desc'] = isset($formData['desc']) && $formData['desc']?$formData['desc']:'';
		//派奖方式
		//总的抽奖机会,限制的话是1，不限制为0
		$form['join_num_count'] = intval($formData['join_num_count'])?intval($formData['join_num_count']):0;
		//总共的抽奖机会
		$form['join_num_count_num'] = isset($formData['join_num_count_num']) && intval($formData['join_num_count_num'])?intval($formData['join_num_count_num']):0;
		//每日的抽奖机会
		$form['join_num_count_num_day'] = intval($formData['join_num_count_num_day'])?intval($formData['join_num_count_num_day']):0;
		//每人中奖次数
		$form['winner_num'] = intval($formData['winner_num'])?intval($formData['winner_num']):1;
		//总的中奖率
		$form['winner_percent'] = intval($formData['winner_percent'])?intval($formData['winner_percent']):1;
		//奖项设置
		//各个奖项设置
		//奖项名称
		$form['price_title'] = $formData['price_title'];
		//奖品数量
		$form['price_num'] = $formData['price_num'];
		//奖品有效期
		$form['price_start_at'] = $formData['price_start_at'];
		$form['price_end_at'] = $formData['price_end_at'];
		//客服电话
		$form['price_phone'] = $formData['price_phone'];
		//兑奖须知
		$form['price_notice'] = $formData['price_notice'];
		
		// if (isset($formData['jiangpin_photo']) && $formData['jiangpin_photo']) {
		// 	$files = [];
		// 	foreach ($formData['jiangpin_photo'] as $k => $v) {
		// 	  	// 判断图片上传中是否出错
		// 		   // if (!$value->isValid()) {
		// 		   //    exit("上传图片出错，请重试！");
		// 		   // }
		// 	    if(!empty($v)){//此处防止没有多文件上传的情况
		// 			// $allowed_extensions = ["png", "jpg", "gif"];
		// 			// if ($value->getClientOriginalExtension() && !in_array($value->getClientOriginalExtension(), $allowed_extensions)) {
		// 			//     exit('您只能上传PNG、JPG或GIF格式的图片！');
		// 			// }
		// 			$path = $v->store(date('Ymd'));
	 //            	$files[] = '/uploads/'.$path;
		// 	    }
		// 	}
		// 	$form['jiangpin_photo'] = $files;
		// }
		// //可选必选
		// for ($i=1; $i < 6; $i++) { 
		// 	if (isset($formData['choose'.$i]) && $formData['choose'.$i]==1) {
		// 		$form['choose'.$i] = 1;
		// 	}
		// }
		$parm['created_at'] = date('Y-m-d H:i:s',time());
		$parm['info'] = json_encode($form);
		$parm['user_id'] = isset($formData['now_id']) && intval($formData['now_id'])?intval($formData['now_id']):'';
		$parm['openid'] = session('wx_openid')?session('wx_openid'):'';
		return $this->cut_price_temp->store($parm);
	}
	/**
	 * 根据ID获取模版预览数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findCut_priceAll()
	{
		$role =  $this->cut_price->findAll();
		if ($role) {
			return $role;
		}
		abort(404);
	}
	/**
	 * 获取抽奖次数
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   array
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findLuckly_logAll($formData)
	{
		$role =  $this->cut_price_log->findAll($formData);
		if ($role) {
			return $role;
		}
		return '';
	}
	/**
	 * 插入用户信息收集表
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function storeCut_price_collect($form)
	{
		$parm['phone'] = $form['phone'];
		$data['name'] = $form['name'];
		$data['xinxi1'] = $form['xinxi1'];
		$data['xinxi2'] = $form['xinxi2'];
		$data['xinxi3'] = $form['xinxi3'];
		$parm['info'] = json_encode($data);
		$parm['now_price'] = $form['now_price'];
		$parm['temp_id'] = $form['temp_id'];
		$parm['created_at'] = $form['created_at'];
		$parm['openid'] = $form['openid'];
		$parm['nickname'] = $form['nickname'];
		//var_dump($parm);di
		return $this->cut_price_collect->store($parm);
		
	}
			/**
	 * 核销
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function tosignCut_price_collect($id)
	{
		try {
			$where['id'] = $id;
			$result = $this->cut_price_collect->edit(['is_sign'=>1],$where);
			flash_info($result,trans('核销成功！'),trans('核销失败！'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			//$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
		
	}
				/**
	 *撤销核销
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function roolbacksignCut_price_collect($id)
	{
		try {
			$where['id'] = $id;
			$result = $this->cut_price_collect->edit(['is_sign'=>2],$where);
			flash_info($result,trans('撤销核销成功！'),trans('撤销核销失败！'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			//$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
		
	}
	/**
	 * 重置用户密码
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function downexcel($id)
	{
        $res = $this->cut_price_collect->findAll(['temp_id'=>$id]);
        $temp = $this->cut_price_temp->findOne(['id'=>$id]);
        $callData[] = ['序号','手机号码','姓名','当前价格','状态','完成时间','核销','报名时间'];
       // var_dump($res->toArray());die;
        if ($res) {
        	foreach ($res as $k => $v) {
        		$parm = [];
        		$res[$k]['info'] = json_decode($v->info,true);
        		$parm[] = $v['id'];
        		$parm[] = $v['phone'];
        		if ($res[$k]['info']) {
        			foreach ($res[$k]['info'] as $k1 => $v1) {
        				if ($k1=='name') {
        					$parm[] = $v1;
        				}
        			}
        		}
        		$parm[] = $v['now_price'];
        		$parm[] = $v['is_success']==1?'已完成':'未完成';
        		$parm[] = $v['is_success']==1?$v['finish_at']:'未完成';
        		$parm[] = $v['is_sign']==1?'已核销':'未核销';
        		$parm[] = $v->created_at;
        		$callData[] = $parm;
        	}
        }
        ob_end_clean();
        Excel::create($temp->title.'活动报名表',function($excel) use ($callData){
            $excel->sheet('score', function($sheet) use ($callData){
                $sheet->rows($callData);
            });
        })->export('xls');
	}
	//抽奖按钮
	public function ajaxLucklyButtonCheck($request){
		$parm = $request->all();
        //检查是不是还有抽奖次数
        $join_num = $this->luckly_log->findAllCount(['id'=>$parm['temp_id']]);
        //获取模版信息
        $cut_price_temp = $this->cut_price_temp->findOne(['id'=>$parm['temp_id']]);
        $cut_price_temp['info'] =json_decode($cut_price_temp['info'],true);
        //参与人数是否限制
        if ($join_num < $cut_price_temp['info']['join_num']) {
        	//判断总共抽奖次数
        	$countNum = $this->luckly_log->countNum(['id'=>$parm['temp_id']]);
        	if ($cut_price_temp['info']['join_num_count_num'] > $countNum) {
        		return ['status'=>false,'message'=>'所有的抽奖次数已经用完！'];
        	}else{
        		$start_at = strtotime(date('Ymd'));
        		$end_at = strtotime(date('Ymd'))+86400;
        		// $countNum = $this->luckly_log->countNum(['id'=>$parm['temp_id'],('created_at','>=',$start_at),('created_at','<=',$end_at)]);
        		//今日抽奖次数
        		if ($countNum >= $cut_price_temp['info']['join_num_count_num_day']) {
        			return ['status'=>false,'message'=>'今日的抽奖次数已经用完！'];
        		}
        	}
        	
        }       
        //检查是不是开始砍价了
        if (strtotime($cut_price_temp['info']['start_at']) > time()) {
        	return 	['status'=>false,'message'=>'活动尚未开始！'];
        }
      //  var_dump($cut_price_temp['info']['price_num']);die;
        if (strtotime($cut_price_temp['info']['end_at']) < time()) {
        	return 	['status'=>false,'message'=>'活动已经结束！'];
        }             
        $price = getLuckly($cut_price_temp['info']['winner_percent'],$cut_price_temp['info']['price_num'],$cut_price_temp['info']['price_num']);
        $log['openid'] = session('wx_openid')?session('wx_openid'):'';
        $log['is_luckly'] = $price;
        $log['cut_price_id'] = $parm['temp_id'];
        $res = $this->luckly_log->store($log); 
        if ($price) {
        	return ['status'=>true,'message'=>'恭喜，抽中'.$price.'等奖！','luckly'=>$price];
        }else{
        	return ['status'=>false,'message'=>'没有中奖，再接再厉吧！'];
        }
	}
	//获取有多少人参加了
	public function getJoin_num($parm){
		return $this->luckly_log->findAllCount($parm);
	}
}