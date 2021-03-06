<?php
namespace App\Repositories\Eloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Cut_price_temp;
use Storage;
/**
 * 角色仓库
 */
class Cut_price_tempRepositoryEloquent extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cut_price_temp::class;
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
    public function getCut_price_tempList($start,$length,$search,$order='id')
    {
        $role = $this->model;
        // if ($search['value']) {
        //     if($search['regex'] == 'true'){
        //         $role = $role->where('name', 'like', "%{$search['value']}%")->orWhere('slug','like', "%{$search['value']}%");
        //     }else{
        //         $role = $role->where('name', $search['value'])->orWhere('slug', $search['value']);
        //     }
        // }
        $count = $role->join('cut_price', 'cut_price_temp.cut_price_id', '=', 'cut_price.id')->where($search)->count();

        //$role = $role->orderBy($order['name'], $order['dir']);

        $roles = $role->join('cut_price', 'cut_price_temp.cut_price_id', '=', 'cut_price.id')->where($search)->offset($start)->limit($length)->select('cut_price_temp.*','cut_price.title as typename')->get();

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
     * @return [type]     findCut_priceAll                      [查询结果集，包含查询的数量及查询的结果对象]
     */
    public function findAll()
    {
        return $this->model->get();
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
        return $this->model->insertGetId($formData);
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
        return $this->model->where($where)->delete();
    }
    /**
     * 统计访问量
     * @author 王浩
     * res   数字  
     */
    public function sumViews()
    {
        return $this->model->sum('views');
    }
     /**
     * 统计总的活动数目
     * @author 王浩
     * res   数字  
     */
    public function sumTemp()
    {
        return $this->model->count();
    }
}
