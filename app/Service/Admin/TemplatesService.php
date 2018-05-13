<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\TemplatesRepositoryEloquent;
use App\Repositories\Eloquent\Templates_answerRepositoryEloquent;
use App\Service\Admin\Templates_question_typeService;
use App\Service\Admin\BaseService;
use App\Models\Templates;
use Illuminate\Http\Request;
use App\Traits\ActionButtonAttributeTrait;
use Storage;
use Exception;
/**
* 角色service
*/
class TemplatesService extends BaseService
{
	use ActionButtonAttributeTrait;
	private $templates;
	private $action;
	private $Templates_answer;
	function __construct(TemplatesRepositoryEloquent $templates,Templates_answerRepositoryEloquent $Templates_answer)
	{
		$this->templates =  $templates;
		$this->Templates_answer =  $Templates_answer;
	}
	/**
	 * datatables获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function ajaxLists($where=[],$action='form')
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
		$result = $this->templates->getTemplatesList($start,$length,$search,$order);
		// /var_dump($result['roles']);die;
		$this->action = $action;
		if ($result['roles']) {
			foreach ($result['roles'] as $k=>$v) {
				$this->id = $v->id;
				//$result['roles'][$k]['actionButton'] = $this->getActionButtonAttribute(false);
				$result['roles'][$k]['action'] = $this->getActionButtonAttribute(false);
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
	public function storeAnswer(Request $request)
	{

		$formData = $request->all();
		$parm = [];
//		var_dump($formData);die;
		if ($formData['node'] && is_array($formData['node'])) {
			foreach ($formData['node'] as $k => $v) {
				switch ($formData['type'.$v]) {
					case '6':
						$img1 = $request->file('node'.$v);
				        if ($img1) { 
				            //扩展名  
				            $ext = $img1->getClientOriginalExtension();  
				            //临时绝对路径  
				            $realPath = $img1->getRealPath();  
					        // 使用 store 存储文件
					        $path = $img1->store(date('Ymd'));
				            $parm['val'.intval($k+1)] = '/uploads/'.$path;
				        }
						break;
					case '5':
						$filePath =[];  // 定义空数组用来存放图片路径
						if (isset($formData['node'.$v]) && is_array($formData['node'.$v])) {
							foreach ($formData['node'.$v] as $key => $value) {
								$file = $request->file($v);
							  // 判断图片上传中是否出错
								   // if (!$value->isValid()) {
								   //    exit("上传图片出错，请重试！");
								   // }
							    if(!empty($value)){//此处防止没有多文件上传的情况
									// $allowed_extensions = ["png", "jpg", "gif"];
									// if ($value->getClientOriginalExtension() && !in_array($value->getClientOriginalExtension(), $allowed_extensions)) {
									//     exit('您只能上传PNG、JPG或GIF格式的图片！');
									// }
									$path = $value->store(date('Ymd'));
					            	$files[] = '/uploads/'.$path;
					            	$parm['val'.intval($k+1)] = json_encode($files);
							    }
							}
						}
						break;
					case '1':
						$parm['val'.intval($k+1)] = json_encode($formData['node'.$v]);
						break;
					default:
						$parm['val'.intval($k+1)] = $formData['node'.$v];
						break;
				}
			}
		}
		return $this->Templates_answer->store($parm);
	}
	
	/**
	 * 创建基础模版
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $formData [表单中所有的数据]
	 * @return [type]                             [Boolean]
	 */
	public function storeTemplates(Request $request)
	{
		$formData = $request->all();
		// var_dump($formData);die;
		$form['title'] = $formData['title'];
		$form['desc'] = $formData['desc'];
		$form['created_at'] = date('Y-m-d H:i:s',time());
		$form['templates_type_id'] = $formData['templates_type_id'];
		//处理背景图片
		// $img1 = $request->file('base_img');
  //       if ($img1) { 
  //           //扩展名  
  //           $ext = $img1->getClientOriginalExtension();  
  //           //临时绝对路径  
  //           $realPath = $img1->getRealPath();  
	 //        // 使用 store 存储文件
	 //        $path = $img1->store(date('Ymd'));
  //           $form['base_img'] = '/uploads/'.$path;
  //       }
		$form['base_img'] = $formData['base_img'];
		//处理数据，保存json
		if (isset($formData['node']) && is_array($formData['node'])) {
			foreach ($formData['node'] as $k => $v) {
				$parm[$k+1]['top'] = $formData['top'.$v];
				$parm[$k+1]['left'] = $formData['left'.$v];
				$parm[$k+1]['biaoti_title'] = $formData['biaoti_title'.$v];
				//当前类型
				$parm[$k+1]['type'] = $formData['type'.$v];
				if (isset($formData['is_required'.$v])) {//存在则必填
					$parm[$k+1]['is_required'] = 1;
				}else{
					$parm[$k+1]['is_required'] = 2;
				}
				switch ($parm[$k+1]['type']) {
					//多选下的选项
					case 15:
					case 1:
						if (isset($formData['duoxuan_option'.$v])) {
							$parm[$k+1]['duoxuan_option'] = $formData['duoxuan_option'.$v];
							
						}
						break;
					default:
						# code...
						break;
				}
			}
			$form['content_text'] = json_encode($parm);
		}else{
			$form['content_text'] = '';
		}
		$form['typeid'] = $formData['typeid'] ;
		$result = $this->templates->store($form);
	}
	/**
	 * 编辑模版所需数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [description]
	 */
	public function editTemplates(Request $request)
	{
		$formData = $request->all();
			  //var_dump($formData);die;
		$form['title'] = $formData['title'];
		$form['desc'] = $formData['desc'];
		$form['updated_at'] = date('Y-m-d H:i:s',time());
		//处理背景图片
		// $img1 = $request->file('base_img');
  //       if ($img1) { 
  //           //扩展名  
  //           $ext = $img1->getClientOriginalExtension();  
  //           //临时绝对路径  
  //           $realPath = $img1->getRealPath();  
	 //        // 使用 store 存储文件
	 //        $path = $img1->store(date('Ymd'));
  //           $form['base_img'] = '/uploads/'.$path;
  //       }
		$form['base_img'] = $formData['base_img'];
		$form['templates_type_id'] = $formData['templates_type_id'];
		//处理数据，保存json
		if (isset($formData['node']) && is_array($formData['node'])) {
			foreach ($formData['node'] as $k => $v) {
				$parm[$k+1]['top'] = $formData['top'.$v];
				$parm[$k+1]['left'] = $formData['left'.$v];
				$parm[$k+1]['biaoti_title'] = $formData['biaoti_title'.$v];
				//当前类型
				$parm[$k+1]['type'] = $formData['type'.$v];
				if (isset($formData['is_required'.$v])) {//存在则必填
					$parm[$k+1]['is_required'] = 1;
				}else{
					$parm[$k+1]['is_required'] = 2;
				}
				switch ($parm[$k+1]['type']) {
					//多选下的选项
					case 15:
					case 1:
						if (isset($formData['duoxuan_option'.$v])) {
							$parm[$k+1]['duoxuan_option'] = $formData['duoxuan_option'.$v];
							
						}
						break;
					default:
						# code...
						break;
				}
			}
			$form['content_text'] = json_encode($parm);
		}else{
			$form['content_text'] = '';
		}
		$where['id'] = $formData['id'];
		$result = $this->templates->edit($where,$form);
	}
	/**
	 * 根据ID获取模版预览数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findPreviewById($id)
	{
		$parm['id'] = $id;
		$role =  $this->templates->findOne($parm);
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
	 * 重置用户密码
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function resetUserPassword($id)
	{
		$responseData = [
			'status'=> false,
			'msg' 	=> trans('admin/alert.user.reset_error'),
		];
		$result = $this->user->update(['password' => config('admin.global.reset')],$id);
		if ($result) {
			$responseData['status'] = true;
			$responseData['msg'] 	= trans('admin/alert.user.reset_success');
		}
		return $responseData;
	}
}