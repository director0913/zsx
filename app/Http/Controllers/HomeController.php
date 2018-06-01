<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;

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
        // $openid = $oauthUser->user->openid;
        // // 在这里可以获取到用户在微信的资料
        // dd($oauthUser);

        // 接下来处理相关的业务逻
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
}
