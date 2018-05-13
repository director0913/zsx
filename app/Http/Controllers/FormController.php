<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\TemplatesService;
use App\Service\Admin\Form_question_typeService;
use App\Service\Admin\Templates_question_typeService;
use App\Service\Admin\Templates_typeService;
use App\Http\Requests\FormRequest;
class FormController extends Controller
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
}
