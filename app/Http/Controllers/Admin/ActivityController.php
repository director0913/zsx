<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\Cut_priceService;
class ActivityController extends Controller
{
    private $form;

    function __construct(Cut_priceService $cut_price)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:user');
        $this->cut_price = $cut_price;
    }

    /**
     * 微活动列表
     * @author 王浩
     * @date   2018-04-29
     * @return [type]                   [description]
     */
    public function lists(Request $request,$p=1)
    {
    	$where = [];
        //微活动条件
        //$where['typeid'] = 2;
        $responseData = $this->cut_price->ajaxCutLists($where,$p);
        //var_dump($responseData);die;
        // $templates_typeLists = $this->templates_typeService->findTypeAll();
        return view('admin.activity.lists')->with(compact('responseData'))->with(compact('p'));
    }

    public function ajaxIndex()
    {
        $responseData = $this->user->ajaxIndex();
        return response()->json($responseData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cut_price_lists = $this->cut_price->findCut_priceAll();
        return view('admin.activity.create')->with(compact('cut_price_lists'));
    }

    /**
     *统计详情
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function total($id)
    {   
        $parm['id'] = $id;
        $info = $this->cut_price->getTotalLists($parm);
        if ($info) {
            foreach ($info as $k => $v) {
                $info[$k]['info'] = json_decode($v->info,true);
            }
        }
        return view('admin.activity.total')->with(compact('info'));
    }

    /**
     * 查看用户信息
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function show($id)
    {
        $info = $this->cut_price->findPreviewById($id);
        $typeInfo = $this->templates_question_type->findTypeAll();
        $info['content_text'] =json_decode($info['content_text'],true);
        return view('admin.templates.preview')->with(compact('typeInfo'))->with(compact('info'));
    }
    /**
     * 删除用户
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function destroy($id)
    {
        $this->cut_price->destroyCut_price_temp($id);
        return redirect('admin/activity/lists');
    }
    /**
     * 删除报名用户
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function totalDel($id)
    {
        $this->cut_price->destroyCut_price_collect($id);
        return redirect(url()->previous());
    }
    /**
     * 核销
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function tosign($id)
    {
        $this->cut_price->tosignCut_price_collect($id);
        return redirect(url()->previous());
    }
    /**
     * 撤销核销
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function roolbacksign($id)
    {
        $this->cut_price->roolbacksignCut_price_collect($id);
        return redirect(url()->previous());
    }
    /**
     * 下载excel
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     */
    public function downexcel($id)
    {
        $this->cut_price->downexcel($id);
    }
}
