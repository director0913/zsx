<?php
namespace App\Service\Admin;
use App\Service\Admin\BaseService;
use App\Models\Templates_question_type;
use Exception;
/**
* 招生秀模版问题类型service
*/
class Templates_question_typeService extends BaseService
{

	private $user;
	private $role;
	private $permission;

	function __construct(Templates_question_type $model)
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
            return $this->model->where($formData)->orderBy($order)->get();
        }
        #echo "string";die;
        return $this->model->orderBy('desc',$order)->get();
    }
     /**
     * 查询角色并分页
     * @author 王浩
     * @date   2018-04-30
     * @param  [type]                   $formData  [搜索数组数据,]
     * @param  [type]                   $order [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的结果对象]
     */
    public function findTypeOne($formData=[],$order=['desc'=>'asc'])
    {
        if ($formData) {
            return $this->model->where($formData)->orderBy($order)->first();
        }
        return $this->model->orderBy($order)->first();
    }
}