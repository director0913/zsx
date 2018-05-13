<?php
namespace App\Repositories\Eloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Form;
/**
 * 角色仓库
 */
class FormRepositoryEloquent extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Form::class;
    }

    /**
     * 查询角色并分页
     * @author 晚黎
     * @date   2016-11-02T15:17:24+0800
     * @param  [type]                   $start  [起始数目]
     * @param  [type]                   $length [读取条数]
     * @param  [type]                   $search [搜索数组数据]
     * @param  [type]                   $order  [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function getUserList($start,$length,$search,$order)
    {
        $role = $this->model;
        if ($search['value']) {
            if($search['regex'] == 'true'){
                $role = $role->where('name', 'like', "%{$search['value']}%")->orWhere('slug','like', "%{$search['value']}%");
            }else{
                $role = $role->where('name', $search['value'])->orWhere('slug', $search['value']);
            }
        }

        $count = $role->count();
        $role = $role->orderBy($order['name'], $order['dir']);

        $roles = $role->offset($start)->limit($length)->get();

        return compact('count','roles');
    }
    /**
     * 查询角色并分页
     * @author 晚黎
     * @date   2016-11-02T15:17:24+0800
     * @param  [type]                   $start  [起始数目]
     * @param  [type]                   $length [读取条数]
     * @param  [type]                   $search [搜索数组数据]
     * @param  [type]                   $order  [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function findOne($formData)
    {
        return $this->model->where($formData)->first();
    }
    /**
     * 查询角色并分页
     * @author 晚黎
     * @date   2016-11-02T15:17:24+0800
     * @param  [type]                   $start  [起始数目]
     * @param  [type]                   $length [读取条数]
     * @param  [type]                   $search [搜索数组数据]
     * @param  [type]                   $order  [排序数组数据]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function create($formData)
    {
        return $this->model->insert($formData);
    }
}
