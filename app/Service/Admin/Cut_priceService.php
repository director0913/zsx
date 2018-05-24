<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\Cut_priceRepositoryEloquent;
use App\Repositories\Eloquent\Cut_price_tempRepositoryEloquent;
use App\Repositories\Eloquent\Cut_price_logRepositoryEloquent;
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
* 角色service
*/
class Cut_priceService extends BaseService
{
	use ActionButtonAttributeTrait;
	private $action = 'activity';
	function __construct(Cut_priceRepositoryEloquent $cut_price,Cut_price_tempRepositoryEloquent $cut_price_temp,Cut_price_logRepositoryEloquent $cut_price_log,Cut_price_collectRepositoryEloquent $cut_price_collect)
	{
		$this->cut_price =  $cut_price;
		$this->cut_price_temp =  $cut_price_temp;
		$this->cut_price_collect =  $cut_price_collect;
		$this->cut_price_log =  $cut_price_log;
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
	public function store($formData,$request)
	{
		
		$parm['title'] = $formData['title']?$formData['title']:'';
		//间隔时间
		$form['interval'] = isset($formData['interval']) && intval($formData['interval'])?intval($formData['interval']):'';
		$parm['cut_price_id'] = isset($formData['cut_price_id']) && intval($formData['cut_price_id'])?intval($formData['cut_price_id']):'';
		$form['old_price'] = isset($formData['old_price']) && intval($formData['old_price'])?intval($formData['old_price']):'';
		$form['bottom_price'] = isset($formData['bottom_price']) && intval($formData['bottom_price'])?intval($formData['bottom_price']):'';
		$form['min_price'] = isset($formData['min_price']) && intval($formData['min_price'])?intval($formData['min_price']):'';
		$form['max_price'] = isset($formData['max_price']) && intval($formData['max_price'])?intval($formData['max_price']):'';
		$form['cut_price_id'] = isset($formData['cut_price_id']) && intval($formData['cut_price_id'])?intval($formData['cut_price_id']):'';
		$form['jiangpin_num'] = isset($formData['jiangpin_num']) && intval($formData['jiangpin_num'])?intval($formData['jiangpin_num']):'';
		$form['start_at'] = $formData['start_at'];
		$form['end_at'] = $formData['end_at'];
		$form['jiangpin_info'] = $formData['jiangpin_info'];
		$form['rule_info'] = $formData['rule_info'];
		$form['lingjiang_info'] = $formData['lingjiang_info'];
		$form['jigou_info'] = $formData['jigou_info'];
		$form['store_name'] = $formData['store_name'];
		$form['store_addr'] = $formData['store_addr'];
		$form['store_phone'] = $formData['store_phone'];
		$form['name'] = $formData['name'];
		$form['phone'] = $formData['phone'];
		$form['xinxi1'] = $formData['xinxi1'];
		$form['xinxi2'] = $formData['xinxi2'];
		$form['xinxi3'] = $formData['xinxi3'];
		if (isset($formData['jiangpin_photo']) && $formData['jiangpin_photo']) {
			$files = [];
			foreach ($formData['jiangpin_photo'] as $k => $v) {
			  	// 判断图片上传中是否出错
				   // if (!$value->isValid()) {
				   //    exit("上传图片出错，请重试！");
				   // }
			    if(!empty($v)){//此处防止没有多文件上传的情况
					// $allowed_extensions = ["png", "jpg", "gif"];
					// if ($value->getClientOriginalExtension() && !in_array($value->getClientOriginalExtension(), $allowed_extensions)) {
					//     exit('您只能上传PNG、JPG或GIF格式的图片！');
					// }
					$path = $v->store(date('Ymd'));
	            	$files[] = '/uploads/'.$path;
			    }
			}
			$form['jiangpin_photo'] = $files;
		}
		//可选必选
		for ($i=1; $i < 6; $i++) { 
			if (isset($formData['choose'.$i]) && $formData['choose'.$i]==1) {
				$form['choose'.$i] = 1;
			}
		}
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
	 * 获取是否已经砍价
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findCut_price_logOne($formData)
	{
		$role =  $this->cut_price_log->findOne($formData);
		if ($role) {
			return $role;
		}
		return '';
	}
	/**
	 * 根据ID获取模版预览数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findCut_priceOne($formData)
	{
		$role =  $this->cut_price->findOne($formData);
		if ($role) {
			return $role;
		}
		abort(404);
	}
	/**
	 * 根据ID获取模版预览数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function updateCut_price_collect($formData,$where)
	{
		$role =  $this->cut_price_collect->edit($formData,$where);
		if ($role) {
			return $role;
		}
		abort(404);
	}
	/**
	 * 根据获取收集表，看看是不是已经到最低价格
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   数组
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findCut_price_collectOne($formData)
	{
		$role =  $this->cut_price_collect->findOne($formData);
		if ($role) {
			return $role;
		}
		return '';
	}
	/**
	 * 根据ID获取模版预览数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findCut_price_tempOne($formData)
	{
		$role =  $this->cut_price_temp->findOne($formData);
		if ($role) {
			return $role;
		}
		abort(404);
	}
	/**
	 * 浏览量加一
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $attributes [表单数据]
	 * @param  [type]                   $id         [resource路由传递过来的id]
	 * @return [type]                               [Boolean]
	 */
	public function editCut_price_temp($formData,$where)
	{
		$this->cut_price_temp->edit($formData,$where);
	}
	/**
	 * 获取排行榜
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $search [表单数据]
	 * @param  [type]                  默认获取前十
	 * @return [type]                               [Boolean]
	 */
	public function getCut_price_collectRank($search)
	{
		return $this->cut_price_collect->getCut_price_collectList(0,10,$search);
	}
	/**
	 * 直接删除
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function destroyCut_price_temp($id)
	{
		try {
			$where['id'] = $id;
			$result = $this->cut_price_temp->del($where);
			flash_info($result,trans('删除活动成功！'),trans('删除活动失败！'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			//$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
		
	}
		/**
	 * 直接删除报名用户
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function destroyCut_price_collect($id)
	{
		try {
			$where['id'] = $id;
			$result = $this->cut_price_collect->del($where);
			flash_info($result,trans('删除报名用户成功！'),trans('删除报名用户失败！'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			//$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
		
	}
	/**
	 * 插入砍价表
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function storeCut_price_log($parm)
	{
		return $this->cut_price_log->store($parm);
		
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
        		
        		//var_dump($parm);die;
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
        		//var_dump($parm);die;
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
}