<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\FormRepositoryEloquent;
use App\Service\Admin\BaseService;
use App\Models\Form;
use Exception;
/**
* 角色service
*/
class FormService extends BaseService
{

	private $form;

	function __construct(FormRepositoryEloquent $form)
	{
		$this->form =  $form;
	}
	/**
	 * datatables获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function ajaxIndex()
	{
		// datatables请求次数
		$draw = request('draw', 1);
		// 开始条数
		$start = request('start', 0);
		// 每页显示数目
		$length = request('length', 10);
		// datatables是否启用模糊搜索
		#$search['regex'] = request('search.regex', false);
		// 搜索框中的值
		$search['value'] = request('search.value', '');
		// 排序
		$order['name'] = request('columns.' .request('order.0.column',0) . '.name','sceneid_bigint');
		$order['dir'] = request('order.0.dir','asc');
		$result = $this->form->getUserList($start,$length,$search,$order);

		$users = [];
		if ($result['roles']) {
			foreach ($result['roles'] as $v) {
				$users[] = $v;
			}
		}
		return [
			'draw' => $draw,
			'recordsTotal' => $result['count'],
			'recordsFiltered' => $result['count'],
			'data' => $users,
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
	 * 添加用户
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $formData [表单中所有的数据]
	 * @return [type]                             [Boolean]
	 */
	public function storeUser($formData)
	{
		try {
			$result = $this->user->create($formData);
			if ($result) {
				// 角色与用户关系
				if ($formData['role']) {
					$result->roles()->sync($formData['role']);
				}
				// 权限与用户关系
				if ($formData['permission']) {
					$result->userPermissions()->sync($formData['permission']);
				}
			}
			flash_info($result,trans('admin/alert.user.create_success'),trans('admin/alert.user.create_error'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
	}
	/**
	 * 编辑用户视图所需数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [description]
	 */
	public function editView($id)
	{
		return [$this->findUserById($id),$this->getAllPermissionList(),$this->getAllRoles()];
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
		$parm['sceneid_bigint'] = $id;
		$role =  $this->user->findOne($parm);
		if ($role) {
			return $role;
		}
		abort(404);
	}
	/**
	 * 用户暂不做状态管理，直接删除
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function destroyUser($id)
	{
		try {
			$result = $this->user->delete($id);
			flash_info($result,trans('admin/alert.user.destroy_success'),trans('admin/alert.user.destroy_error'));
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