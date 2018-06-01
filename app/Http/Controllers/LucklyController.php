<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\LucklyService;
use Illuminate\Support\Facades\Cookie;
use Session;
class LucklyController extends Controller
{
    private $luckly;

    function __construct(LucklyService $luckly)
    {
        $this->luckly = $luckly;
    }

    /**
     * 微活动列表
     * @author 王浩
     * @date   2018-04-29
     * @return [type]                   [description]
     */
    public function lists(Request $request,$id='')
    {
    	$where = [];
        //微活动条件
        $where['typeid'] = 2;
        $responseData = $this->cut_price->ajaxCutLists($where);
        //var_dump($responseData);die;
        // $templates_typeLists = $this->templates_typeService->findTypeAll();
        return view('admin.activity.lists')->with(compact('responseData'));
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
    public function create(request $request,$id,$id1)
    {
        //判断微信是否登录
        if (!session('wx_login')) {
            return redirect(url('/oauth'));
        }
        $formData = $request->all();
        $cut_price_lists = $this->cut_price->findCut_priceOne(['id'=>$id]);
        return view('admin.activity.'.$cut_price_lists->tem_name)->with(compact('cut_price_lists'))->with(compact('id'))->with(compact('id1'));
    }

    /**
     *大转盘
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function store(request $request)
    {	
        $parm = $request->all();
    	$res = $this->luckly->store($request);
        return redirect('/activity/show/'.$res);
    }
     /**
     * 收集答案
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function answer(request $request)
    {
        $this->cut_price->storeAnswer($request);
        return redirect('admin.form.lists');
    }
     /**
     * 收集用户信息
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function collect(request $request)
    {
        //判断微信是否登录
        // if (!session('wx_login')) {
        //     return redirect(url('/oauth'));
        // }
        //return redirect()->back()->withInput()->withErrors('<script>alert(2)</script>');
        $parm = $request->all();
        //查看是否已经报名
        $isCollect = $this->cut_price->findCut_price_collectOne(['temp_id'=>$parm['temp_id'],'openid'=>session('openid')]);
        if ($isCollect) {
            echo "<script>alert('您已经参加过了，不能重复参加！');history.go(-1);</script>";die;
        }
        $temp = $this->cut_price->findCut_price_tempOne(['id'=>$parm['temp_id']]);
        $temp['info'] =json_decode($temp['info'],true);
        $parm['now_price'] = $temp['info']['old_price'];
        $parm['created_at'] = date('Y-m-d H:i:s',time());
        $parm['openid'] = session('wx_openid')?session('wx_openid'):'';
        $parm['nickname'] = session('wx_nickname')?session('wx_nickname'):'';
        $parm['temp_id'] = isset($parm['temp_id']) && intval($parm['temp_id'])?intval($parm['temp_id']):'';
        $res = $this->cut_price->storeCut_price_collect($parm);
        return redirect('/activity/show/'.$parm['temp_id'].'/'.$res);
        //查询需要预览的模版
    }
    /**
     * 前台抽奖按钮
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function ajaxLucklyButton(request $request)
    {
        //检查是不是还有抽奖次数
        $res = $this->luckly->ajaxLucklyButtonCheck($request);
        return  response()->json($res);
        
    }

    /**
     * 修改用户视图
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function edit(Request $request,$id)
    {
        if($request->isMethod('post')){
            $this->cut_price->editTemplates($request);
        }
        $info = $this->cut_price->findPreviewById($id);
        $typeInfo = $this->templates_question_type->findTypeAll();
        $info['content_text'] = json_decode($info['content_text'],true);
        $templates_typeLists = $this->templates_typeService->findTypeAll();
        return view('admin.templates.edit')->with(compact('typeInfo'))->with(compact('info'))->with(compact('templates_typeLists'));
    }

    /**
     * 修改用户
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @param  [type]                   $id      [description]
     * @return [type]                            [description]
     */
    public function update(FormRequest $request, $id)
    {
        $this->user->updateUser($request->all(),$id);
        return redirect('admin/user');
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
        $this->cut_price->destroyTemplates($id);
        return redirect('admin/form/lists');
    }
}
