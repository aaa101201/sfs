<?php
namespace Admin\Controller;
use Think\Controller;
class AskController extends Controller {
  
	
	
	//一级分类列表 默认0
	public function topCate(){
		$res=D('cy_ask_cate')->field('cat_id,title')->where("parent_id=0")->select();
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$this->ajaxReturn($info);
	}
	//二级分类
	public function secondCate(){
		$parentid=$_POST['cat_id'];
		$res=D('cy_ask_cate')->field('cat_id,title')->where("parent_id='".$parentid."'")->select();
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$this->ajaxReturn($info);
	}
	//添加问题
	public function create(){
		$data['title']=$_POST['title'];
		$data['cat_id']=$_POST['cat_id'];
		$data['intro']=$_POST['intro'];
		$data['dateline']=time();
      	
		//查询用户UID
		$userinfo=D('cy_member')->where("uname='".$_SESSION['user']['uname']."'")->find();
		if(!$userinfo){
				$info['code']=99;
				$info['msg']='未登录';
				$info['data']['result']=array();
		}else{
				$data['uid']=$userinfo['uid'];
				$data['clientip']=$_SERVER["REMOTE_ADDR"]; 
				$data['views']=strlen($_POST['title']);
				$data['audit']=1;
        
				$res=D('cy_ask')->add($data);
				if($res){
					$info['code']=0;
					$info['msg']='success';
					$info['data']['result']=array();
				}else{
					$info['code']=100;
					$info['msg']='error';
					$info['data']['result']=array();
				}
		}
		$this->ajaxReturn($info);
	}
	//装修知识历史问题
	public function oldAsk(){
		//所以问题0 已解决1 未解决2
		$type=$_POST['type']?$_POST['type']:0;

		$page=$_POST['pageNumber']?$_POST['pageNumber']:1;
        $pageSize=$_POST['pageSize'];
       
		//分页
		$start=($page-1)*$pageSize;
     
		if($type==1){
			$res=D('cy_ask')->field('ask_id,title,uid,answer_num,dateline,answer_id')->limit($start,$pageSize)->where("answer_id>0")->select();
            $count=D('cy_ask')->where("answer_id>0")->count();
		}elseif($type==2){
			$res=D('cy_ask')->field('ask_id,title,uid,answer_num,dateline,answer_id')->limit($start,$pageSize)->where("answer_id=0")->select();
            $count=D('cy_ask')->where("answer_id=0")->count();
		}else{
			$res=D('cy_ask')->field('ask_id,title,uid,answer_num,dateline,answer_id')->limit($start,$pageSize)->select();
            $count=D('cy_ask')->count();
		}
		$user=D('cy_member')->select();
		foreach($res as $k =>$v){
		  $res[$k]['dateline']=date("m-d",$res[$k]['dateline']);
          if($res[$k]['answer_id']>0){
          	$res[$k]['type']=true;
          }else{
          	$res[$k]['type']=false;
          }
			foreach($user as $key => $val){
				if($res[$k]['uid']==$user[$key]['uid']){
					$res[$k]['from']=substr_replace($user[$key]['uname'],'****',3,4);
                  if($user[$key]['face']){
                     $res[$k]['headurl']='http://www.whjz365.cn/attachs/'.$user[$key]['face'];
                  }else{
                  	 $res[$k]['headurl']='http://music.shulailo.cn/attachs/face/face.jpg';
                  }
                   
				}
			}
		}
      
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$info['data']['pageCurrent']=$page;
		$info['data']['recordTotal']=$count;
        $info['data']['pageTotal']=ceil($count/10);
		$this->ajaxReturn($info);
	}
	//话题详情 问题+最佳答案
	public function bestAnswer(){
		$ask_id=$_POST['ask_id'];
		//$ask_id=5;
		//ask
		$ask=D('cy_ask')->where("ask_id='".$ask_id."'")->find();
		//bestanswer
        //有最佳回答
      	if($ask['answer_id']){
        	$bestanswer=D('cy_ask_answer')->where("answer_id='".$ask['answer_id']."'")->find();
            //ask user
            $askperson=D('cy_member')->where("uid='".$ask['uid']."'")->find();//uname face
            //answer user
            $answerperson=D('cy_member')->where("uid='".$bestanswer['uid']."'")->find();//uname face

            $result=array();
            $result['askId']=$ask['ask_id'];
            $result['title']=$ask['title'];
            $result['intro']=$ask['intro'];
            $result['askTime']=date('Y-m-d H:i:s',$ask['dateline']);
            if($askperson['face']){
            	 $result['askHead']='http://www.whjz365.cn/attachs/'.$askperson['face'];
            }else{
            	$result['askHead']='http://music.shulailo.cn/attachs/face/face.jpg';
            }
           if($answerperson['face']){
             $result['answerHead']='http://www.whjz365.cn/attachs/'.$answerperson['face'];
           }else{
          		 $result['answerHead']='http://music.shulailo.cn/attachs/face/face.jpg';
           }
           
            $result['askUname']=substr_replace($askperson['uname'],'****',3,4);
           
            $result['answerUname']=substr_replace($answerperson['uname'],'****',3,4);
            $result['answerTime']=date('Y-m-d H:i:s',$bestanswer['dateline']);
            $result['answer']=$bestanswer['contents'];
            $info['code']=0;
            $info['msg']='success';
            $info['data']['result']=$result;

        }else{
          	$askperson=D('cy_member')->where("uid='".$ask['uid']."'")->find();//uname face
        	$result=array();
            $result['askId']=$ask['ask_id'];
            $result['title']=$ask['title'];
            $result['intro']=$ask['intro'];
            $result['askTime']=date('Y-m-d H:i:s',$ask['dateline']);
          	if($askperson['face']){
            	 $result['askHead']='http://www.whjz365.cn/attachs/'.$askperson['face'];
            }else{
            	 $result['askHead']='http://music.shulailo.cn/attachs/face/face.jpg';
            
            }
           
            $result['askUname']=substr_replace($askperson['uname'],'****',3,4);
            $info['code']=100;
            $info['msg']='success';
            $info['data']['result']=$result;
        }
		
		$this->ajaxReturn($info);
	}
	//其他回答
	public function otherAnswer(){
	
		$ask_id=$_POST['ask_id'];
	    //$ask_id=5;
		$ask=D('cy_ask')->where("ask_id='".$ask_id."'")->find();
		$res=D('cy_ask_answer')->field('answer_id,uid,contents,dateline')->where("ask_id='".$ask_id."' and answer_id!='".$ask['answer_id']."'")->select();
		$number=D('cy_ask_answer')->field('answer_id,uid,contents')->where("ask_id='".$ask_id."'")->count();
		$user=D('cy_member')->select();
		foreach($res as $k =>$v){
			foreach($user as $key => $val){
				if($res[$k]['uid']==$user[$key]['uid']){
                   if($res[$k]['askHead']){
                      $res[$k]['answerHead']='http://www.whjz365.cn/attachs/'.$user[$key]['face'];
                  }else{
                    	$res[$k]['answerHead']='http://music.shulailo.cn/attachs/face/face.jpg';
                  
                  }
					
					$res[$k]['answerUname']=substr_replace($user[$key]['uname'],'****',3,4);
				}
			}
			$res[$k]['answerTime']=date('Y-m-d H:i:s',$res[$k]['dateline']);
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$info['data']['answerNum']=$number;
		$this->ajaxReturn($info);
	}
	//其他热门问题
	public function otherAsk(){
		$ask_id=$_POST['ask_id'];
		//$ask_id=5;
		//去掉当前问题
		$ask=D('cy_ask')->where("ask_id='".$ask_id."'")->find();
		$res=D('cy_ask')->field('ask_id,title,uid,dateline')->order("answer_num desc")->limit(3)->where("answer_id!='".$ask['answer_id']."'")->select();
		$user=D('cy_member')->select();
		foreach($res as $k =>$v){
			foreach($user as $key => $val){
				if($res[$k]['uid']==$user[$key]['uid']){
                  if($res[$k]['askHead']){
                  	$res[$k]['askHead']='http://www.whjz365.cn/attachs/'.$user[$key]['face'];
                  }else{
                  	$res[$k]['askHead']='http://music.shulailo.cn/attachs/face/face.jpg';
                  
                  }
					
					$res[$k]['askUname']=substr_replace($user[$key]['uname'],'****',3,4);
				}
			}
			$res[$k]['askTime']=date('Y-m-d H:i:s',$res[$k]['dateline']);
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$this->ajaxReturn($info);
	}
	//回答问题
	public function answer(){
		$ask_id=$_POST['ask_id'];
		//$ask_id=5;
		//ask
		$ask=D('cy_ask')->where("ask_id='".$ask_id."'")->find();
		//bestanswer
		$bestanswer=D('cy_ask_answer')->where("answer_id='".$ask['answer_id']."'")->find();
		//ask user
		$askperson=D('cy_member')->where("uid='".$ask['uid']."'")->find();//uname face
		//answer user

		$result=array();
		$result['askId']=$ask['ask_id'];
		$result['title']=$ask['title'];
		$result['intro']=$ask['intro'];
		$result['askTime']=date('Y-m-d H:i:s',$ask['dateline']);
      if($askperson['face']){
      	$result['askHead']='http://www.whjz365.cn/attachs/'.$askperson['face'];
      }else{
      	$result['askHead']='http://music.shulailo.cn/attachs/face/face.jpg';
      }
		
		$result['askUname']=substr_replace($askperson['uname'],'****',3,4);
		
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$result;
		$this->ajaxReturn($info);
	
	}
	public function answerAsk(){
		//要回答的问题
		$ask_id=$_POST['ask_id'];
		//$ask_id=5;
		$userinfo=D('cy_member')->where("uname='".$_SESSION['user']['uname']."'")->find();
		if(!$userinfo){
				$info['code']=99;
				$info['msg']='未登录';
				$info['data']['result']=array();
		}else{
			$data['ask_id']=$ask_id;
			$data['contents']=$_POST['contents'];
			$data['uid']=$userinfo['uid'];
			$data['audit']=1;
			$data['dateline']=time();
			$data['clientip']=$_SERVER["REMOTE_ADDR"]; 
			$add=D('cy_ask_answer')->add($data);
			if($add){
				$info['code']=0;
				$info['msg']='success';
				$info['data']['result']=array();
			}else{
				$info['code']=100;
				$info['msg']='error';
				$info['data']['result']=array();
			}
		}
		$this->ajaxReturn($info);
	}
 	 public function send(){
     	$phone=$_POST['phone'];
        $res=D('cy_member')->where("uname='".$phone."'")->find();
        if(!$res){
          $info['code']=99;
          $info['msg']='error';
          $info['data']['result']=array();
        
        }
        $password=md5('aideguodu');
        $code=$yzm = mt_rand(1000,9999);
		$cont=urlencode("【威海家装助手】您的验证码为".$code."，在5分钟内有效,重置密码后默认为123456请及时修改!");

		$url="http://api.smsbao.com/sms?u=qltko17&p=".$password."&m=".$phone."&c=".$cont."";

		$res=file_get_contents($url);
		if($res==0){
          $info['code']=0;
          $info['msg']='success';
          $info['data']['result']=array();
          session('code',$code);
        
        }else{
          $info['code']=100;
          $info['msg']='error';
          $info['data']['result']=array();
        }
		$this->ajaxReturn($info);
	
	}
  public function check(){
  	
    $code=$_POST['code'];
    if($code==$_SESSION['code']){
    	  $info['code']=0;
          $info['msg']='success';
          $info['data']['result']=array();
          session('code',null);
    }else{
    	  $info['code']=100;
          $info['msg']='error';
          $info['data']['result']=array();
          
    }
    
  	$this->ajaxReturn($info);
  }
  public function resetPassword(){
      $uname=$_POST['phone'];
      $data['passwd']=md5('123456');
      $res=D('cy_member')->where("uname='".$uname."'")->save($data);
      $info['code']=0;
      $info['msg']='success';
      $info['data']['result']=array();
      $this->ajaxReturn($info);
  
  }

}