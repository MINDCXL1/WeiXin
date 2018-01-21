<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
         $code=I('get.code');

        $userinfourl="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx82dcf28e0b79cdee&secret=e9478dd3dc6d63589f42a7f9b6253361&code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$userinfourl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $objtoken = json_decode(curl_exec($ch),true) ;
        curl_close($ch);

        $access_token=$objtoken['access_token'];
        $openid=$objtoken['openid'];

        $getinfourl="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL,$getinfourl);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, 1);
        $users = json_decode(curl_exec($chh),true) ;
        curl_close($chh);

        $infos=m('user')->where("openid='".$openid."'")->find();
        if($infos){

            $this->assign('openid',$infos);
        }else{
            $inserts=m('user')->add($users);
            $infoss=m('user')->where("openid='".$openid."'")->find();
            $this->assign('openid',$infoss);
        }


        $cid=i('get.cid');
        // $data = M('wechat_news')
        // ->join('ims_wechat_love as b on ims_wechat_news.Id = b.nid')
        // ->join('ims_wechat_pinglun as c on b.nid = c.nid')->count('b.nid');
        //        echo "<pre>";
  //       print_r($data);exit();
        $list=M('wechat_news')->where('uniacid='.$cid)->select();

        // echo "<pre>";
        // print_r($list);exit();
        $this->assign('list',$list);
        $this->display();
    }
    public function content()
    {
        $id=i('get.id');
        $oid=i('get.oid');
        $list=M('wechat_news')->where("id=".$id)->find();
        $pinlun=M('wechat_pinglun')->where('nid='.$id)->select();
        $pingzanshu=M('wechat_pinglun')->where('nid='.$id)->count();
        $dianzanshu=M('wechat_love')->where('nid='.$id)->count();
        $this->assign('pingzanshu',$pingzanshu);
        $this->assign('dianzanshu',$dianzanshu);
        $this->assign('openid',$oid);
        $this->assign('pinlun',$pinlun);
        $this->assign('list',$list);
        $this->display();
    }
        public function dzz()
    {
        $id=i('get.id');

        $redirect_uri=urlencode("http://www.514superhero.cn/wxlist/index.php/Home/index/index/cid/".$id.".html");

        $url="httsps://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dcf28e0b79cdee&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('Location:'.$url);
    }
    public function pinglun(){
        $id=i('get.id');
        $oid=i('get.oid');
        $info=m('user')->where("Id='".$oid."'")->find();
        // echo "<pre>";
        // print_r($info);exit;
        // echo "<pre>";
        // print_r($username);exit;
        $this->assign('info',$info);
        $this->assign('id',$id);
        $this->display();
    }
    public function love(){
        $id=i('get.id');

        $oid=i('get.oid');

        $info=m('user')->where("Id='".$oid."'")->find();

        $openid=$info['openid'];
        if($openid){
        $infos=m('wechat_love')->where("openid='".$openid."' && nid='".$id."'")->find();  //若点赞

        // echo "<pre>";
        // print_r($infos);exit;
        if($infos){
            echo "请勿重复提交";
            $url="http://www.514superhero.cn/wxlist/index.php/Home/index/content/id/".$id.".html";
            header('Location:'.$url);
        }
        else{
                $data=[
                        'nid'=>$id,
                        'zan'=>1,
                        'openid'=>$openid
                    ];
                    $list=M('wechat_love')->add($data);
                    echo "成功";
            $url="http://www.514superhero.cn/wxlist/index.php/Home/index/content/id/".$id.".html";
            header('Location:'.$url);
        }
        }else{
            echo "openid不存在";
        }
    }
    public function do_pinlun(){
        $data=i('post.');
        $data['inputtime']=time();
        // echo "<pre>";
        // print_r($data);exit();
        // echo $data['nid'];exit;
        $list=M('wechat_pinglun')->add($data);
        if($list){
            $url="http://www.514superhero.cn/wxlist/index.php/Home/index/content/id/".$data['nid'].".html";
            header('Location:'.$url);
        }else{
            echo "评论失败";
        }


    }
    public function dz()
    {
        $id=i('get.id');
        $redirect_uri=urlencode("http://www.514superhero.cn/wxlist/index.php/Home/index/baoming");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dcf28e0b79cdee&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('Location:'.$url);
    }

    public function baoming(){
        $code=I('get.code');
        $userinfourl="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx82dcf28e0b79cdee&secret=e9478dd3dc6d63589f42a7f9b6253361&code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$userinfourl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $objtoken = json_decode(curl_exec($ch),true) ;
        curl_close($ch);

        $access_token=$objtoken['access_token'];
        $openid=$objtoken['openid'];

        $getinfourl="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL,$getinfourl);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, 1);
        $users = json_decode(curl_exec($chh),true) ;
        curl_close($chh);
        $infos=m('user')->where("openid='".$openid."'")->find();
        if($infos){

        }else{

            $inserts=m('user')->add($users);
        }
        $this->assign('list',$users->openid);

        $this->display();
    }
    public function newbaoming(){
        $data=i('post.');
        // echo "<pre>";
        // print_r($data);exit;
        $openid=$data['openid'];
        $infos=m('apply')->where("openid='".$openid."'")->find();
        if($infos){
            echo "请勿重复提交";
        }else{
            $info=m('apply')->add($data);
               if($info){
                   $result=[
                            'msg'=>'报名成功',
                            'status'=>1
                        ];
               }else{
                   $result=[
                            'msg'=>'报名失败',
                            'status'=>2
                        ];
               }
            return $this->ajaxReturn($result,'JSON');
        }

    }
    //砍价开始
    public function bargains()
    {
        $redirect_uri=urlencode("http://www.514superhero.cn/wxlist/index.php/Home/index/firstbargain");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dcf28e0b79cdee&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('Location:'.$url);
    }
    public function firstbargain()
    {
        $code=I('get.code');
        $userinfourl="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx82dcf28e0b79cdee&secret=e9478dd3dc6d63589f42a7f9b6253361&code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$userinfourl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $objtoken = json_decode(curl_exec($ch),true) ;
        curl_close($ch);
        $access_token=$objtoken['access_token'];
        $openid=$objtoken['openid'];
        $getinfourl="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL,$getinfourl);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, 1);
        $users = json_decode(curl_exec($chh),true) ;
        curl_close($chh);
        session('openid',$openid);

        $infos=m('user')->where("openid='".$openid."'")->find();
        if($infos){
            $this->assign('openid',$infos);
        }else{
            $inserts=m('user')->add($users);
            $infoss=m('user')->where("openid='".$openid."'")->find();
            $this->assign('openid',$infoss);
        }
        $url="http://www.514superhero.cn/wxlist/index.php/Home/index/bargain/openid/".$openid.".html";
        header('Location:'.$url);
    }
    public function helpbargains()
    {
        $session=I('openid');
        $code=I('get.code');
        $userinfourl="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx82dcf28e0b79cdee&secret=e9478dd3dc6d63589f42a7f9b6253361&code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$userinfourl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $objtoken = json_decode(curl_exec($ch),true) ;
        curl_close($ch);
        $access_token=$objtoken['access_token'];
        $openid=$objtoken['openid'];
        $getinfourl="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL,$getinfourl);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, 1);
        $users = json_decode(curl_exec($chh),true) ;
        curl_close($chh);
        session('openid',$openid);
        $infos=m('user')->where("openid='".$openid."'")->find();
        if($infos){
            $this->assign('openid',$infos);
        }else{
            $inserts=m('user')->add($users);
            $infoss=m('user')->where("openid='".$openid."'")->find();
            $this->assign('openid',$infoss);
        }
        $url="http://www.514superhero.cn/wxlist/index.php/Home/index/bargain/openid/".$session.".html";
        header('Location:'.$url);
    }
    public function bargain(){
        if(session('openid')){
            $session=I('openid');
            if($session==session('openid')){
                $infos=m('user')->where("openid='".session('openid')."'")->find();
                if($infos){
                    $this->assign('nickname',$infos['nickname']);
                }else{
                    echo "未找到该用户";exit;
                }
                $inf=M('bargain')->where("openid='".session('openid')."'")->find();
                $this->assign('kanjiamoney',$inf['money']-$inf['newmoney']);
                $this->assign('bargain',$inf);
                $this->assign('openid',$session);
                $this->display('bargain');
            }else{
                $infos=m('user')->where("openid='".session('openid')."'")->find();
                if($infos){
                    $this->assign('openid',$infos);
                }
                $inf=M('bargain')->where("openid='".$session."'")->find();
                $this->assign('bargain',$inf);
                $usinfo=M('bargainfor')->where("helpopenid='".session('openid')."'")->find();
                $this->assign('money',$usinfo['money']);
                $this->assign('openid',$session);
                $this->display('exbargain');
            }
        }else{
            $session=I('openid');
            $redirect_uri=urlencode("http://www.514superhero.cn/wxlist/index.php/Home/index/helpbargains/openid/".$session."");
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dcf28e0b79cdee&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
            header('Location:'.$url);
        }


    }
    public function do_bargain(){
        if(session('openid')){
            $session=I('openid');
            if(session('openid')==$session){
                $data['openid']=session('openid');
                $info=m('user')->where("openid='".session('openid')."'")->find();
                $data['username']=$info['nickname'];
                $data['money']=800;
                $infos=m('bargain')->where("username='". $data['username']."'")->find();
                if($infos){
//                    $url="http://www.514superhero.cn/wxlist/index.php/Home/index/bargain.html";
//                    header('Location:'.$url);
                    echo "不能重复砍价";
                }else{
                    //http://www.514superhero.cn/wxlist/index.php/Home/index/bargain.html
                    $data['newmoney']=$data['money']-100;
                    $inserts=M('bargain')->add($data);
                    echo "成功砍掉100元";
                }
            }else{
                $infos=M('bargainfor')->where("helpopenid='".session('openid')."' and useropenid='".$session."'")->find();
                if($infos){
                    echo "只能帮砍一次";
                }else{
                    $data['useropenid']=$session;
                    $data['helpopenid']=session('openid');
                    $datas=array();
                    while(count($datas)<100){
                        $val=rand(1,800);
                        $datas[$val]=$val;
                    }
                    $data['money']=$datas[$val];
                    $insert=m('bargainfor')->add($data);
                    echo "成功帮忙砍价";
                }

            }
        }
    }
    //砍价结束
}