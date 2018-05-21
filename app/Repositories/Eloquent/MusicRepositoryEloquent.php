<?php
namespace App\Repositories\Eloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Music;
use Storage;
/**
 * 角色仓库
 */
class MusicRepositoryEloquent extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Music::class;
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
    public function getMusicList($start,$length,$search)
    {
        $role = $this->model;
        if ($search) {
            $role = $role->where($search);
        }

        $count = $role->count();
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
    public function store($formData)
    {
        return $this->model->insert($formData);
    }
     /**
     * 查询角色并分页
     * @author 晚黎
     * @date   2016-11-02T15:17:24+0800
     * @param  [type]                   $start  [起始数目]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function edit($formData,$where)
    {
        return $this->model->where($where)->update($formData);
    }
    /**
     * 查询角色并分页
     * @author 晚黎
     * @date   2016-11-02T15:17:24+0800
     * @param  [type]                   $start  [起始数目]
     * @return [type]                           [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function del($where)
    {
        //删除文件
        $info = $this->model->where($where)->first();
        $info->src = substr($info->src,9);
        Storage::delete($info->src);
        return $this->model->where($where)->delete();
    }
}
