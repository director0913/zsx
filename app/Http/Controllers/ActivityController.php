<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\Cut_priceService;
use App\Service\Admin\LucklyService;
use Illuminate\Support\Facades\Cookie;
use Session;
class ActivityController extends Controller
{
    private $form;

    function __construct(Cut_priceService $cut_price,LucklyService $LucklyService)
    {
        $this->cut_price = $cut_price;
        $this->LucklyService = $LucklyService;
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
        // if (!session('wx_login')) {
        //     return redirect(url('/oauth'));
        // }
        $formData = $request->all();
        $cut_price_lists = $this->cut_price->findCut_priceOne(['id'=>$id]);
        return view('admin.activity.'.$cut_price_lists->tem_name)->with(compact('cut_price_lists'))->with(compact('id'))->with(compact('id1'));
    }

    /**
     *微活动列表
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function store(request $request)
    {	

        $formData = $request->all();
    	$res = $this->cut_price->store($formData,$request);
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
     * 检测是否可参加活动
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function ajaxJoinButton(request $request)
    {
        $parm = $request->all();
        //检查是不是已经到最低价了
        $cut_price_collect_temp = $this->cut_price->findCut_price_tempOne(['id'=>$parm['temp_id']]);
        $cut_price_collect_temp['info'] =json_decode($cut_price_collect_temp['info'],true);
        //检查是不是开始砍价了
        if (strtotime($cut_price_collect_temp['info']['start_at']) > (time()-86400)) {
            return  response()->json(['status' => false, 'message' => '活动尚未开始！']);
        }
        if (strtotime($cut_price_collect_temp['info']['end_at']) < (time()-86400)) {
            return  response()->json(['status' => false, 'message' => '活动已经结束！']);
        }
        return  response()->json(['status' => true, 'message' => '赶快参加活动吧！']);
    }
    /**
     * 前台砍价按钮
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function ajaxCut_priceButton(request $request)
    {
        $parm = $request->all();
        //检查是不是已经到最低价了
        $cut_price_collect_info = $this->cut_price->findCut_price_collectOne(['id'=>$parm['collect_id']]);
        $cut_price_collect_temp = $this->cut_price->findCut_price_tempOne(['id'=>$parm['temp_id']]);
        $cut_price_collect_temp['info'] =json_decode($cut_price_collect_temp['info'],true);
        //检查是不是开始砍价了
        if (strtotime($cut_price_collect_temp['info']['start_at']) > (time()-86400)) {
            return  response()->json(['status' => false, 'message' => '活动尚未开始！']);
        }
        if (strtotime($cut_price_collect_temp['info']['end_at']) < (time()-86400)) {
            return  response()->json(['status' => false, 'message' => '活动已经结束！']);
        }


        if ($cut_price_collect_temp['info']['bottom_price']==$cut_price_collect_temp->now_price) {
            return  response()->json(['status' => false, 'message' => '当前价格已经是底价了，不能再砍价了！']);
        }
        //先检查是不是已经砍过了
        $isCut = $this->cut_price->findCut_price_logOne(['openid'=>session('wx_openid'),'cut_price_id'=>$parm['temp_id']]);
        if ($isCut) {
            if ($isCut->is_onwer==1) {//$cut_price_collect_temp['info']['interval']
                if ((time()-strtotime($isCut->created_at)) <($cut_price_collect_temp['info']['interval']*3600)) {
                   $cha = $cut_price_collect_temp['info']['interval']-ceil((time()-strtotime($isCut->created_at))/3600);
                    return  response()->json(['status' => false, 'message' => '还差'.$cha.'个小时，可以继续砍价！']);
                }
            }
            return  response()->json(['status' => false, 'message' => '您已经砍过价了，不能再砍了！']);
        }               
        //减价的金额计算
        if ($cut_price_collect_info->now_price-$cut_price_collect_temp['info']['bottom_price']<=$cut_price_collect_temp['info']['max_price']) {
            $cut = $cut_price_collect_info->now_price-$cut_price_collect_temp['info']['bottom_price'];
            $log['finish_at'] = date('Y-m-d H:i:s',time());
            $log['is_success'] = 1;
        }else{
            $cut = rand($cut_price_collect_temp['info']['min_price'],$cut_price_collect_temp['info']['max_price']);    
        }
        $log['openid'] = session('wx_openid');
        $log['cut_price'] = $cut;
        $log['cut_price_id'] = $parm['temp_id'];
        $log['is_onwer'] = $cut_price_collect_info['openid']==$log['openid']?1:2;
        $log['created_at'] = date('Y-m-d H:i:s',time());
        $res = $this->cut_price->storeCut_price_log($log); 
        //去收集表中减去砍价的金额 
        $collect['now_price'] = $cut_price_collect_info->now_price-$cut;
        $this->cut_price->updateCut_price_collect($collect,['id'=>$parm['collect_id']]);
        //设置cookie防止再次砍价
        return  response()->json(['status' => true, 'message' => '成功砍价'.$cut.'元！']);
        
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
       // var_dump($info['content_text']);die;
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

    /**
     * 重置用户密码
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function resetPassword($id)
    {
        $responseData = $this->user->resetUserPassword($id);
        return response()->json($responseData);
    }
        /**
     * 查看用户信息
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function show($id,$collect_id='')
    {
        //判断微信是否登录
        // if (!session('wx_login')) {
        //     return redirect(url('/oauth'));
        // }
        $info = $this->cut_price->findCut_price_tempOne(['id'=>$id]);
        $info['info'] =json_decode($info['info'],true);
        //查询需要预览的模版
        $preview = $this->cut_price->findCut_priceOne(['id'=>$info->cut_price_id]);
        //浏览量加1
        $this->cut_price->editCut_price_temp(['views'=>$info->views+1],['id'=>$id]);
        //不同的模版返回不同的数据
        if ($preview->tem_name == 'cut_price') {
            //获取排行榜
            $rank = $this->cut_price->getCut_price_collectRank(['temp_id'=>$id]);
            return view('admin.activity.'.$preview->tem_name.'_preview')->with(compact('info'))->with(compact('collect_id'))->with(compact('rank'));
        }else{
            //获取总共多少人参与了
            $joinNum = $this->LucklyService->getJoin_num(['cut_price_id'=>$info->id]);
            return view('admin.activity.'.$preview->tem_name.'_preview')->with(compact('info'))->with(compact('collect_id'))->with(compact('joinNum'));
        }
    }
}
