<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\MusicRepositoryEloquent;
use App\Service\Admin\BaseService;
use App\Models\Music;
use Illuminate\Http\Request;
use App\Traits\ActionButtonAttributeTrait;
use Storage;
use Exception;
use Excel;
/**
* 角色service
*/
class MusicService extends BaseService
{
	use ActionButtonAttributeTrait;
	private $music;
	private $action;
	function __construct(MusicRepositoryEloquent $music)
	{
		$this->music =  $music;
		$this->action = 'music';
	}
	/**
	 * datatables获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @return [type]                   [description]
	 */
	public function ajaxLists($where=[])
	{
		// datatables请求次数
		$draw = 1;
		//var_dump($request->id);die;
		// 开始条数
		$start = 0;
		// 每页显示数目
		$length = 10;
		// datatables是否启用模糊搜索
		#$search['regex'] = request('search.regex', false);
		// 搜索框中的值
		$search = $where;
		$result = $this->music->getMusicList($start,$length,$search);
		//var_dump($result['roles']);die;
		if ($result['roles']) {
			foreach ($result['roles'] as $k=>$v) {
				$this->id = $v->id;
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
	 * 创建基础模版
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $formData [表单中所有的数据]
	 * @return [type]                             [Boolean]
	 */
	public function storeMusic(Request $request)
	{

		$formData = $request->all();
		$img1 = $request->file('src');
	    if ($img1) { 
	        //扩展名  
	        $ext = $img1->getClientOriginalExtension();  
	        //临时绝对路径  
	        $realPath = $img1->getRealPath();  
	        // 使用 store 存储文件
	        $path = $img1->store(date('Ymd'));
	        $parm['src'] = '/uploads/'.$path;
	    }
	    $parm['name'] = $formData['name'];
	    $parm['desc'] = $formData['desc'];
	    $parm['created_at'] = date('Y-m-d H:i:s',time());
		return $this->music->store($parm);
	}
	/**
	 * 直接删除
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [用户ID]
	 * @return [type]                       [Boolean]
	 */
	public function destroyMusic($id)
	{
		$where['id'] = $id;
		$result = $this->music->del($where);
		flash_info($result,trans('删除音乐成功！'),trans('删除音乐失败！'));
		return $result;	
	}
		/**
	 * 根据ID获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function editMusic(Request $request,$id)
	{
		$where['id'] = intval($id)?intval($id):'';
		if (!$where['id']) {
			return false;
		}
		$formData = $request->all();
		if (isset($formData['src']) && $formData['src']) {
			$parm['src'] = $formData['src'];
		}
		if (isset($formData['name']) && $formData['name']) {
			$parm['name'] = $formData['name'];
		}
		$img1 = $request->file('src');
	    if ($img1) { 
	        //扩展名  
	        $ext = $img1->getClientOriginalExtension();  
	        //临时绝对路径  
	        $realPath = $img1->getRealPath();  
	        // 使用 store 存储文件
	        $path = $img1->store(date('Ymd'));
	        $parm['src'] = '/uploads/'.$path;
	    }
		$role =  $this->music->edit($parm,$where);
		if ($role) {
			return $role;
		}
		abort(404);
	}
		/**
	 * 根据ID获取数据
	 * @author 王浩
	 * @date  2018-04-29
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function findMusicById($id)
	{
		$parm['id'] = intval($id)?intval($id):'';
		$role =  $this->music->findOne($parm);
		if ($role) {
			return $role;
		}
		abort(404);
	}
}