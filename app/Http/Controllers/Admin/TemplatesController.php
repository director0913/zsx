<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\TemplatesService;
use App\Service\Admin\Templates_settingsService;
use App\Service\Admin\Templates_question_typeService;
use App\Http\Requests\TemplatesRequest;
use Storage;
class TemplatesController extends Controller
{
    private $templates,$templates_question_type;

    function __construct(TemplatesService $templates,Templates_question_typeService $templates_question_type,Templates_settingsService $templates_settings)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:user');
        $this->templates = $templates;
        $this->templates_question_type = $templates_question_type;
        $this->templates_settings = $templates_settings;
    }

    /**
     * 用户列表
     * @author 王浩
     * @date   2018-04-29
     * @return [type]                   [description]
     */
    public function index()
    {
        $responseData = $this->templates->ajaxIndex();
        return view('admin.templates.list')->with(compact('responseData'));
    }

    public function ajaxIndex()
    {
        $responseData = $this->templates->ajaxIndex();
        return response()->json($responseData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($permissions,$roles) = $this->templates->createView();
        return view('admin.user.create')->with(compact('permissions','roles'));
    }

    /**
     * 添加用户
     * @author 王浩
     * @date   2018-04-29
     * @param  TemplatesRequest              $request [description]
     * @return [type]                            [description]
     */
    public function store(TemplatesRequest $request)
    {
        $this->templates->storeTemplates($request);
        return redirect('admin/form/lists');
    }

    /**
     * 查看用户信息
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function preview($id)
    {
        $info = $this->templates->findPreviewById($id);
        $typeInfo = $this->templates_question_type->findTypeAll();
        $info['content_text'] =json_decode($info['content_text'],true);
       // var_dump(($info['content_text']));die;
        return view('admin.templates.preview')->with(compact('typeInfo'))->with(compact('info'));
    }

    /**
     * 修改用户视图
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function edit($id)
    {
        $info = $this->templates->findPreviewById($id);
        $typeInfo = $this->templates_question_type->findTypeAll();
        $info['content_text'] =json_decode($info['content_text'],true);
       // var_dump($info['content_text']);die;
        return view('admin.templates.edit')->with(compact('typeInfo'))->with(compact('info'));
    }

    /**
     * 修改用户
     * @author 王浩
     * @date   2018-04-29
     * @param  TemplatesRequest              $request [description]
     * @param  [type]                   $id      [description]
     * @return [type]                            [description]
     */
    public function update(TemplatesRequest $request, $id)
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
        $this->user->destroyUser($id);
        return redirect('admin/user');
    }

    /**
     * 模版配置
     * @author 王浩
     * @date   2018-04-29
     * @param  [type]                   $id [description]
     * @return [type]                       [description]
     */
    public function settings(request $request)
    {
        if($request->isMethod('post')){
            $parmData = $request->all();
            $this->templates_settings->editSettings($parmData);
        }
        $responseData = $this->templates_settings->findSettingsOne(['id'=>1]);
        if ($responseData) {
            $responseData = $responseData->toArray();
        }
        return view('admin.templates.settings')->with(compact('responseData'));
    }
}
