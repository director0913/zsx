<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('Wechat');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    # 用户点击微信登录按钮后，调用此方法请求微信接口
    public function oauth(Request $request)
    {
        session(['oauth_url'=>url()->previous()]);
        return \Socialite::with('weixin')->redirect();
    }
    # 微信的回调地址
    public function callback(Request $request)
    {
        $oauthUser = \Socialite::with('weixin')->user();
        if ($oauthUser) {
            session(['wx_login'=>true]);
            session(['wx_openid'=>$oauthUser->user['openid']]);
            session(['wx_nickname'=>$oauthUser->user['nickname']]);
            return redirect(session('oauth_url'));
        }
    }
    public function tokenSignature(request $request)
    {
       //1.将timestamp,nonce,token按字典序排序
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $token     = 'weixin';
        $signature = $_get['signature'];
        $array[] = $timestamp;
        $array[] = $nonce;
        $array[] = $token;
        //$array     = [$timestamp,$nonce,$token];
        sort($array);
        //2.将排序后的三个参数拼接之后用sha1加密
        $tmpstr = implode('',$array);//join
        $tmpstr = sha1($tmpstr);
        //3.将加密后的字符串与signature进行对比，判断该请求是否来自微信
        if($tmpstr == $signature){
           echo $_GET['echostr'];
           exit;
        }
    }
    //首页登录
    public function toLogin(request $request){
         $rule = [  
            'username' => 'required',  
            'password' => 'required',  
        ];  
        $message = [  
            'username.required' => '请输入用户名！',
            'password.required' => '请输入密码！'  
        ];  
        $validate = Validator::make($request->all(), $rule, $message);  
        if (!$validate->passes()) {  
            return back()->withErrors($validate);  
        }  
        $allData = $request->all();
        $phone = $allData['username'];
        $pwd = md5($allData['password']);
        $parm = '{"phone":"".$phone."","pwd":"".$pwd."","loginType":"1","deviceType":"ios"}';
        $res = getUrl(env('FEICUI_API_LOGIN_TOKENS'),'',true);
    }
}
