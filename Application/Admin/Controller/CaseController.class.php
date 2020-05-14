<?php
namespace Admin\Controller;
use Think\Controller;
class CaseController extends Controller {
	//户型
	public function houseType(){
		$res=D('cy_data_attr_value')->where("attr_id=5")->select();
		foreach($res as $k =>$val){
				$result[$k]['title']=$res[$k]['title'];
				$result[$k]['hx_attr_id']=$res[$k]['attr_id'];
				$result[$k]['hx_attr_value_id']=$res[$k]['attr_value_id'];
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$result;
		$this->ajaxReturn($info);
	}
	//风格
	public function type(){
	
		$res=D('cy_data_attr_value')->where("attr_id=4")->select();
	
		foreach($res as $k =>$val){
				$result[$k]['title']=$res[$k]['title'];
				$result[$k]['style_attr_id']=$res[$k]['attr_id'];
				$result[$k]['style_attr_value_id']=$res[$k]['attr_value_id'];
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$result;
		$this->ajaxReturn($info);
	}
	//价格
	public function price(){
		$res=D('cy_data_attr_value')->where("attr_id=6")->select();
			foreach($res as $k =>$val){
				$result[$k]['title']=$res[$k]['title'];
				$result[$k]['price_attr_id']=$res[$k]['attr_id'];
				$result[$k]['price_attr_value_id']=$res[$k]['attr_value_id'];
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$result;
		$this->ajaxReturn($info);
	
	}
	//小区
	public function village(){
		//cy_home
		$page=$_POST['pageNumber']?$_POST['pageNumber']:1;
		$start=($page-1)*10;
		$res=D('cy_home')->field('home_id,title,city_id,area_id')->where("audit=1")->limit($start,10)->select();
        $count=D('cy_home')->where("audit=1")->count();
		//city
		$city=D('cy_data_city')->select();
		foreach($res as $k => $v){
			foreach($city as $key => $val){
				if($res[$k]['city_id']==$city[$key]['city_id']){
					$res[$k]['city_name']=$city[$key]['city_name'];
				}
			}
		}
		//area cy_data_area
		$area=D('cy_data_area')->select();
		foreach($res as $k => $v){
			foreach($area as $key => $val){
				if($res[$k]['area_id']==$area[$key]['area_id']){
					$res[$k]['area_name']=$area[$key]['area_name'];
				}
			}
		}
		foreach($res as $k => $v){
			$result[$k]['home_id']=$res[$k]['home_id'];
			$result[$k]['title']=$res[$k]['title'];
			$result[$k]['city_name']=$res[$k]['city_name'];
			$result[$k]['area_name']=$res[$k]['area_name'];
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['pageCurrent']=$page;
        $info['data']['pageTotal']=ceil($count/10);;
        $info['data']['recordTotal']=$count;
		$info['data']['result']=$result;
		$this->ajaxReturn($info);
	
	}
	//设计师案例管理
	public function caseList(){
		//audit=0 未审核=1已审核
     	$uname=$_SESSION['user']['uname'];
		$userinfo=D('cy_member')->where("uname='".$uname."'")->find();
        $uid=$userinfo['uid'];
		$page=$_POST['pageNumber']?$_POST['pageNumber']:1;
		$start=($page-1)*6;
	
		$res=D('cy_case')->field('case_id,uid,title,photos,audit,dateline')->where("uid='".$uid."' and closed=0")->limit($start,6)->select();
        $count=D('cy_case')->where("uid='".$uid."' and closed=0")->count();
     
		foreach($res as $k => $v){
		
			$res[$k]['dateline']=date('Y-m-d H:i:s',$res[$k]['dateline']);
		}
		if(!$res){
			$res=array();
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']['result']=$res;
		$info['data']['pageCurrent']=$page;
        $info['data']['pageTotal']=ceil($count/6);
     	$info['data']['recordTotal']=$count;	
		$this->ajaxReturn($info);


	}
	//添加
	public function create(){
		//基本信息数据
		$data['title']=$_POST['title'];
		$data['home_name']=$_POST['home_name'];
		$data['home_id']=$_POST['home_id'];
		$data['huxing']=$_POST['huxing'];
		$data['huxing_id']=0;
		$data['photo']='';
		$data['intro']=$_POST['intro'];
		$data['photos']=0;
		$data['orderby']=50;
		$data['audit']=0;
		$data['closed']=0;
		$data['clientip']=$_SERVER["REMOTE_ADDR"];
		$data['dateline']=time();
		$jxx=D('cy_case')->data($data)->add();
		//户型 风格  价格
		$type=array();
		$type[0]['attr_id']=$_POST['hx_attr_id'];
		$type[0]['attr_value_id']=$_POST['hx_attr_value_id'];
		$type[1]['attr_id']=$_POST['style_attr_id'];
		$type[1]['attr_value_id']=$_POST['style_attr_value_id'];
		$type[2]['attr_id']=$_POST['price_attr_id'];
		$type[2]['attr_value_id']=$_POST['price_attr_value_id'];
		foreach($type as $k =>$v){
			$data_attr['case_id']=$jxx;
			$data_attr['attr_id']=$type[$k]['attr_id'];
			$data_attr['attr_value_id']=$type[$k]['attr_value_id'];
			$res=D('cy_case_attr')->data($data_attr)->add();
		}
		//多张图片
		//$case_photo=$_POST['case_photo'];
		$photo = explode(',',$_POST['case_photo']); 

		foreach($photo as $k =>$v){
			$photo_data['case_id']=$jxx;
			$photo_data['title']=$v;
			$photo_data['photo']=$v;
			$photo_data['size']=0;
			$photo_data['views']=0;
			$photo_data['orderby']=50;
			$photo_data['closed']=0;
			$photo_data['clientip']=$_SERVER["REMOTE_ADDR"];
			$photo_data['dateline']=time();
			$photo_add=D('cy_case_photo')->data($photo_data)->add();
			//图片数量递增1
			$much=D('cy_case')->where("case_id='".$jxx."'")->setInc('photos',1); 
			//更新图片
			$arr.=$photo_add.',';
		}
		//更新图片
		$newstr = substr($arr,0,strlen($arr)-1);
		$data_photo['lastphotos']=$newstr;
		$update_photo=D('cy_case')->where("case_id='".$jxx."'")->save($data_photo);
		if($jxx){
			$info['code']=0;
			$info['msg']='success';
			$info['data']['result']=array();
		
		}else{
			$info['code']=100;
			$info['msg']='error';
			$info['data']['result']=array();
		}
		$this->ajaxReturn($info);

	}


	//删除
	public function delte(){
		$case_id=$_POST['case_id'];
		$data['closed']=1;
		$res=D('cy_case')->where("case_id='".$case_id."'")->save($data);
		if($res){
			$info['code']=0;
			$info['msg']='success';
			$info['data']['result']=array();

		}else{
		
			$info['code']=100;
			$info['msg']='error';
			$info['data']['result']=array();

		}
		$this->ajaxReturn($info);
	}
	//修改
	public function update(){
		//基本信息数据
		$case_id=$_POST['case_id'];
		$data['title']=$_POST['title'];
		$data['home_name']=$_POST['home_name'];
		$data['home_id']=$_POST['home_id'];
		$data['huxing']=$_POST['huxing'];
		$data['huxing_id']=0;
		$data['photo']='';
		$data['intro']=$_POST['intro'];
		//图片数量清零
		$data['photos']=0;
		$data['orderby']=50;
		$data['audit']=0;
		$data['closed']=0;
		$data['clientip']=$_SERVER["REMOTE_ADDR"];
		$data['dateline']=time();
		$jxx=D('cy_case')->where("case_id='".$case_id."'")->save($data);
		//户型 风格  价格
		$type=array();
		$type[0]['attr_id']=$_POST['hx_attr_id'];
		$type[0]['attr_value_id']=$_POST['hx_attr_value_id'];
		$type[1]['attr_id']=$_POST['style_attr_id'];
		$type[1]['attr_value_id']=$_POST['style_attr_value_id'];
		$type[2]['attr_id']=$_POST['price_attr_id'];
		$type[2]['attr_value_id']=$_POST['price_attr_value_id'];
		//删除原有数据
		$delete_type=D('cy_case_attr')->where("case_id='".$case_id."'")->delete();
		//循环插入选中
		foreach($type as $k =>$v){
			$data_attr['case_id']=$case_id;
			$data_attr['attr_id']=$type[$k]['attr_id'];
			$data_attr['attr_value_id']=$type[$k]['attr_value_id'];
			$res=D('cy_case_attr')->data($data_attr)->add();
		}
		//多张图片
		//$case_photo=$_POST['case_photo'];
		$photo = explode(',',$_POST['case_photo']); 
		//删除原有图片
		$delete_photo=D('cy_case_photo')->where("case_id='".$case_id."'")->delete();
		
	
		foreach($photo as $k =>$v){
			$photo_data['case_id']=$case_id;
			$photo_data['title']=$v;
			$photo_data['photo']=$v;
			$photo_data['size']=0;
			$photo_data['views']=0;
			$photo_data['orderby']=50;
			$photo_data['closed']=0;
			$photo_data['clientip']=$_SERVER["REMOTE_ADDR"];
			$photo_data['dateline']=time();
			$photo_add=D('cy_case_photo')->data($photo_data)->add();
			//图片数量递增1
			$much=D('cy_case')->where("case_id='".$case_id."'")->setInc('photos',1); 
			//更新图片
			$arr.=$photo_add.',';
		}
		//更新图片
		$newstr = substr($arr,0,strlen($arr)-1);
		$data_photo['lastphotos']=$newstr;
		$update_photo=D('cy_case')->where("case_id='".$case_id."'")->save($data_photo);
		if($case_id){
			$info['code']=0;
			$info['msg']='success';
			$info['data']['result']=array();
		
		}else{
			$info['code']=100;
			$info['msg']='error';
			$info['data']['result']=array();
		}
		$this->ajaxReturn($info);
		
	
	}
	//查询当前数据
	public function caseInfo(){
		$case_id=$_POST['case_id'];
		$infom=D('cy_case')->field('case_id,home_name,home_id,huxing,title,intro')->where("case_id='".$case_id."'")->find();
		$case_attr=D('cy_case_attr')->where("case_id='".$case_id."'")->select();
		foreach($case_attr as $k =>$v){
			if($case_attr[$k]['attr_id']==4){
				$infom['style_attr_value_id']=$case_attr[$k]['attr_value_id'];
			}
			if($case_attr[$k]['attr_id']==5){
				$infom['hx_attr_value_id']=$case_attr[$k]['attr_value_id'];
			}
			if($case_attr[$k]['attr_id']==6){
				$infom['price_attr_value_id']=$case_attr[$k]['attr_value_id'];
			}
			
		}
		$photos=D('cy_case_photo')->field('photo_id,photo')->where("case_id='".$case_id."'")->select();
		foreach($photos as $key =>$val){
			$photos[$key]['photo']='http://'.$_SERVER['HTTP_HOST'].'/uploads/'.$photos[$key]['photo'];
		
		
		}
		$info['code']=0;
		$info['msg']='success';
		$info['data']=$infom;
		$info['data']['result']=$photos;

		$this->ajaxReturn($info);

		
	
	
	}

}