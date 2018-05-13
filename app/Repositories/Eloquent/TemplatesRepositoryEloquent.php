<?php
namespace App\Repositories\Eloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Templates;
/**
 * 角色仓库
 */
class TemplatesRepositoryEloquent extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Templates::class;
    }

    /**
     * 查询角色并分页
     * @author 王浩
     * @date   2018-05-08
     * @param  [type]                   $start  [起始数目]
     * @param  [type]                   $length [读取条数]
     * @param  [type]                   $search [搜索数组数据]
     * @param  [type]                   $order  [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function getTemplatesList($start,$length,$search,$order)
    {
        $role = $this->model;
        if ($search) {
            $role = $role->where($search);
        }

        $count = $role->count();
        $role = $role->orderBy($order['name'], $order['dir']);

        $roles = $role->offset($start)->limit($length)->get();

        return compact('count','roles');
    }
    /**
     * 查询角色并分页
     * @author 王浩
     * @date   2018-05-08
     * @param  [type]                   $formData  [条件数组]
     * @param  [type]                   $length [读取条数]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function findOne($formData)
    {
        return $this->model->where($formData)->first();
    }
        /**
     * 插入
     * @author 王浩
     * @date   2018-05-08
     * @param  [type]                   $formData  [数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function store($formData=[])
    {
        return $this->model->insert($formData);
    }
        /**
     * 修改模版列表
     * @author 王浩
     * @date   2018-05-08
     * @param  [type]                   $wehre  [条件数组]
     * @param  [type]                   $formData [数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function edit($where,$formData=[])
    {        
        return $this->model->where($where)->update($formData);
    }
       /**
     * 修改模版列表
     * @author 王浩
     * @date   2018-05-08
     * @param  [type]                   $wehre  [条件数组]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function delete($where)
    {        
        return $this->model->where($where)->delete();
    }
}
