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
/**
* 角色service
*/
class Cut_priceService extends BaseService
{
	use ActionButtonAttributeTrait;
	private $action;
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
	public function ajaxCutLists($where=[],$action='form')
	{
		// datatables请求次数
		$draw = request('id', 1);
		//var_dump($request->id);die;
		// 开始条数
		$start = request('start', 0);
		// 每页显示数目
		$length = request('length', 10);
		// datatables是否启用模糊搜索
		#$search['regex'] = request('search.regex', false);
		// 搜索框中的值
		$search = $where;
		// 排序
		$order['name'] = request('columns.' .request('order.0.column',0) . '.name','id');
		$order['dir'] = request('order.0.dir','asc');
		$result = $this->cut_price->getCut_priceList($start,$length,$search,$order);
		// /var_dump($result['roles']);die;
		$this->action = $action;
		if ($result['roles']) {
			foreach ($result['roles'] as $k=>$v) {
				$this->id = $v->id;
				//$result['roles'][$k]['actionButton'] = $this->getActionButtonAttribute(false);
				$result['roles'][$k]['action'] = $this->getActionButtonAttribute(true);
			}
		}
	//	return $result;
		return [
			'draw' => $draw,
			'recordsTotal' => $result['count'],
			'recordsFiltered' => $result['count'],
			'data' => $result['roles'],
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
		// var_dump($formData);die;
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
	            	$form['jiangpin_photo'] = $files;
			    }
			}
		}
		$parm['created_at'] = date('Y-m-d H:i:s',time());
		$parm['info'] = json_encode($form);
		$parm['user_id'] = isset($formData['now_id']) && intval($formData['now_id'])?intval($formData['now_id']):'';
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
		abort(404);
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
		abort(404);
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
	 * 修改用户
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $attributes [表单数据]
	 * @param  [type]                   $id         [resource路由传递过来的id]
	 * @return [type]                               [Boolean]
	 */
	public function updateUser($attributes,$id)
	{
		// 防止用户恶意修改表单id，如果id不一致直接跳转500
		if ($attributes['id'] != $id) {
			abort(500,trans('admin/errors.user_error'));
		}
		try {
			$result = $this->user->update($attributes,$id);
			if ($result) {
				// 更新用户角色关系
				if (isset($attributes['role'])) {
					$result->roles()->sync($attributes['role']);
				}else{
					$result->roles()->sync([]);
				}
				// 更新用户权限关系
				if (isset($attributes['permission'])) {
					$result->userPermissions()->sync($attributes['permission']);
				}else{
					$result->userPermissions()->sync([]);
				}
			}
			flash_info($result,trans('admin/alert.user.edit_success'),trans('admin/alert.user.edit_error'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
	}
	/**
	 * 直接删除
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function destroyTemplates($id)
	{
		try {
			$where['id'] = $id;
			$result = $this->templates->delete($where);
			flash_info($result,trans('删除模版成功！'),trans('删除模版失败！'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
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
		//var_dump($parm);di
		return $this->cut_price_collect->store($parm);
		
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

		$where['templates_id'] = $id;
        $answer = $this->Templates_answer->findAll($where);
        $where_template['id'] = $id;
        $question = $this->templates->findOne($where_template);
        $new_answer = [];
        $callData = [];
        if ($question->count()) {
        	$question = $question->toArray();
        	$question['content_text'] = json_decode($question['content_text'],true);
        	if ($question['content_text']) {
        		foreach ($question['content_text'] as $k => $v) {
        			$new_question[$k] = $v['biaoti_title'];
        		}
        		$callData[] = $new_question;
        	}
        }
        
        if ($answer->count()) {
        	$answer = $answer->toArray();
        	if ($answer) {
        		//去除多余许答案
        		foreach ($answer as $k => $v) {
        			$callData[] = array_slice($v,2,count($new_question));
        		}
        	}
        }

        ob_end_clean();
        Excel::create($question['title'],function($excel) use ($callData){
            $excel->sheet('score', function($sheet) use ($callData){
                $sheet->rows($callData);
            });
        })->export('xls');
	}
}