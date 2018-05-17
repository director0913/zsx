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
    public function create()
    {
        $cut_price_lists = $this->cut_price->findCut_priceAll();
        return view('admin.activity.create')->with(compact('cut_price_lists'));
    }

    /**
     *微活动列表
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function store($request)
    {	
    	$formData = $request->all();
    	$formData['typeid'] = 2;
        $this->user->storeUser($formData);
        return redirect('admin.form.lists');
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
       // var_dump(($info['content_text']));die;
        return view('admin.templates.preview')->with(compact('typeInfo'))->with(compact('info'));
    }
    /**
     * 查看用户信息
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function custom($id)
    {
        $info = $this->cut_price->findPreviewById($id);
        $typeInfo = $this->templates_question_type->findTypeAll();
        $info['content_text'] =json_decode($info['content_text'],true);
       // var_dump(($info['content_text']));die;
        return view('admin.templates.custom')->with(compact('typeInfo'))->with(compact('info'));
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
}
