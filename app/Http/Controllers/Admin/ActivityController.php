<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\TemplatesService;
use App\Service\Admin\Form_question_typeService;
use App\Service\Admin\Templates_question_typeService;
use App\Service\Admin\Templates_typeService;
use App\Http\Requests\FormRequest;
class ActivityController extends Controller
{
    private $form;

    function __construct(TemplatesService $templates,Templates_question_typeService  $templates_question_type,Templates_typeService $templates_typeService)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:user');
        $this->templates = $templates;
        $this->templates_typeService = $templates_typeService;
        $this->templates_question_type = $templates_question_type;
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
        if (intval($id)) {
            $where['templates_type_id'] = $id;
        }
        //微活动条件
        $where['typeid'] = 2;
        $responseData = $this->templates->ajaxLists($where,$action='activity');
        //var_dump($responseData);die;
        $templates_typeLists = $this->templates_typeService->findTypeAll();
        return view('admin.templates.lists')->with(compact('responseData'))->with(compact('templates_typeLists'));
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
        $templates_typeLists = $this->templates_typeService->findTypeAll();
        $typeInfo = $this->templates_question_type->findTypeAll();
        return view('admin.activity.create')->with(compact('typeInfo'))->with(compact('templates_typeLists'));
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
        $this->templates->storeAnswer($request);
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
        $info = $this->templates->findPreviewById($id);
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
        $info = $this->templates->findPreviewById($id);
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
            $this->templates->editTemplates($request);
        }
        $info = $this->templates->findPreviewById($id);
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
        $this->templates->destroyTemplates($id);
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
