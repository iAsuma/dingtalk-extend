安装 
~~~
./dingtalk-extend/install.sh
~~~

1. 修改composer.json
~~~
"autoload": {
    "classmap":[
        "extend/aliyun"
    ]
},
~~~

2. 配置config
~~~
//钉钉相关配置
'ding_appid' => '',
'ding_appsecret' => '',
~~~

3. 在中间件中InAppCheck使用 function
~~~
public function dingtalk($request)
{
    if($request->get('code')){
        if($request->get('state') == Redis::get('ding_state')){
            $c = new \DingTalkClient(\DingTalkConstant::$CALL_TYPE_OAPI, \DingTalkConstant::$METHOD_POST, \DingTalkConstant::$FORMAT_JSON);
            $req = new \OapiSnsGetuserinfoBycodeRequest;
            $req->setTmpAuthCode($request->get('code'));
            $resp=$c->executeWithAccessKey($req, "https://oapi.dingtalk.com/sns/getuserinfo_bycode", config('this.ding_appid'), config('this.ding_appsecret'));

            Session::set('ding.openid', $resp->user_info->openid);
            Session::set('ding.nick', $resp->user_info->nick);
        }else{
            return view('public/tips', ['type' => 'pride', 'code' => '请不要非法入侵']);
        }
    }else{
        $redirect_uri = http_scheme().'://'.$request->server('SERVER_NAME').$request->server('REQUEST_URI');
        $state = rand(100, 999).'1';
        Redis::set('ding_state', $state, 30);

        $query = array(
            'appid' => config('this.ding_appid'),
            'response_type' => 'code',
            'scope' => 'snsapi_auth',
            'state' => $state,
            'redirect_uri' => $redirect_uri
        );

        $ding_redirect = "https://oapi.dingtalk.com/connect/oauth2/sns_authorize?".http_build_query($query);
        
        header('location:'.$ding_redirect);
        exit(); //执行跳转后进行业务隔离阻断，防止程序继续执行
    }
}
~~~
