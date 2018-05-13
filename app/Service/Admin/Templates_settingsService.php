<?php
namespace App\Service\Admin;
use App\Service\Admin\BaseService;
use App\Models\Templates_settings;
use Exception;
/**
* 招生秀模版问题类型service
*/
class Templates_settingsService extends BaseService
{

	private $user;
	private $role;
	private $permission;

	function __construct(Templates_settings $model)
	{
		$this->model =  $model;
	}
    /**
     * 查询角色并分页
     * @author 王浩
     * @date   2018-04-30
     * @param  [type]                   $formData  [搜索数组数据,]
     * @param  [type]                   $order [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的结果对象]
     */
    public function findTypeAll($formData=[],$order='asc')
    {
        if ($formData) {
            return $this->model->where($formData)->get();
        }
        #echo "string";die;
        return $this->model->orderBy('desc',$order)->get();
    }
    /**
     *修改模版配置
     * @author 王浩
     * @date   2018-04-30
     * @param  [type]                   $formData  [搜索数组数据,]
     * @param  [type]                   $order [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的结果对象]
     */
    public function editSettings($formData=[])
    {
        $parm['available_start_at'] = isset($formData['available_start_at']) && $formData['available_start_at']?$formData['available_start_at']:'';
        $parm['available_end_at'] = isset($formData['available_end_at']) && $formData['available_end_at']? $formData['available_end_at']:'';
        $parm['available_price_max'] = isset($formData['available_price_max']) && intval($formData['available_price_max'])? intval($formData['available_price_max']):'';
        $where['user_id'] = 1;
        return $this->model->where($where)->update($parm);
    }
     /**
     * 查询角色并分页
     * @author 王浩
     * @date   2018-04-30
     * @param  [type]                   $formData  [搜索数组数据,]
     * @param  [type]                   $order [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的结果对象]
     */
    public function findSettingsOne($formData=[])
    {
        
        return $this->model->where($parm)->first();
    }
}