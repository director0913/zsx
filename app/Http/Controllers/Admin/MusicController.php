<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Admin\MusicService;

class MusicController extends Controller
{
    private $form;

    function __construct(MusicService $music)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:user');
        $this->music = $music;
    }

    /**
     * 微表单列表
     * @author 王浩
     * @date   2018-04-29
     * @return [type]                   [description]
     */
    public function lists(Request $request,$p=1)
    {
    	$where = [];
        //微表单条件
        $responseData = $this->music->ajaxLists($where,$p);
        //var_dump($info);die;
        return view('admin.music.lists')->with(compact('responseData'))->with(compact('p'));
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
    
        return view('admin.music.create');
    }

    /**
     *微表单列表
     * @author 王浩
     * @date   2018-04-29
     * @param  FormRequest              $request [description]
     * @return [type]                            [description]
     */
    public function store(request $request)
    {
        $this->music->storeMusic($request);
        return redirect('admin/music/lists');
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
        $info = $this->music->findPreviewById($id);
        $typeInfo = $this->music_question_type->findTypeAll();
        $info['content_text'] =json_decode($info['content_text'],true);
        return view('admin.music.preview')->with(compact('typeInfo'))->with(compact('info'));
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
            $this->music->editMusic($request,$id);
        }
        $info = $this->music->findMusicById($id);
       // var_dump($info['content_text']);die;
        return view('admin.music.edit')->with(compact('info'));
        
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
        $this->music->destroyMusic($id);
        return redirect('admin/music/lists');
    }
}
