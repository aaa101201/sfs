<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/28
 * Time: 15:09
 */

namespace Admin\Controller;
use OSS\OssClient;
use OSS\Core\OssException;
namespace Admin\Controller;
use Think\Upload\Driver\Qiniu\QiniuStorage;
require_once APP_ROOT.'/vendor/config.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;//引入上传类
use Think\Image;
//use Admin\Service\FileService;
class FileController extends BaseController
{
//    private static $FileService;
//
//    public function _initialize()
//    {
//        parent::_initialize();
//        self::$FileService = new FileService();
//    }
    public function _initialize(){
        $config = array(
            'accessKey'=>'__ODsglZwwjRJNZHAu7vtcEf-zgIxdQAY-QqVrZD',
            'secrectKey'=>'Z9-RahGtXhKeTUYy9WCnLbQ98ZuZ_paiaoBjByKv',
            'bucket'=>'blackwhite',
            'domain'=>'blackwhite.u.qiniudn.com'
        );
        $this->qiniu = new QiniuStorage($config);
        parent:: _initialize();
    }

    //获取文件列表
    public function index(){
        $this->meta_title = '七牛云存储测试';
        $map = array();
        $prefix = trim(I('post.prefix'));
        if($prefix)
            $map['prefix'] = $prefix;
        $list = $this->qiniu->getList($map);
        if(!$list)
            trace($this->qiniu->error);
        $this->assign('qiniu', $this->qiniu);
        $this->assign('_list', $list['items']);
        $this->display();
    }

    public function del(){
        $file = trim(I('file'));
        if($file){
            $result = $this->qiniu->del($file);
            if(false === $result){
                $this->error($this->qiniu->errorStr);
            }else{
                $this->success('删除成功');
            }
        }else{
            $this->error('错误的文件名');
        }
    }

    public function dealImage($key){
        $url = $this->qiniu->dealWithType($key, 'img') ;
        redirect($url);
    }

    public function dealDoc($key){
        $url = $this->qiniu->dealWithType($key, 'doc');
        redirect($url);
    }

    public function rename(){
        $key = I('get.file');
        $new = I('new_name');
        $result = $this->qiniu->rename($key, $new);
        if(false === $result){
            trace($this->qiniu->error);
            $this->error($this->qiniu->errorStr);
        }else{
            $this->success('改名成功');
        }
    }

    public function batchDel(){
        $files = $_GET['key'];
        if(is_array($files) && $files !== array()){
            $files = array_column($files,'value');
            $result = $this->qiniu->delBatch($files);
            if(false === $result){
                $this->error($this->qiniu->errorStr);
            }else{
                $this->success('删除成功');
            }
        }else{
            $this->error('请至少选择一个文件');
        }
    }

    public function detail($key){
        $result = $this->qiniu->info($key);
        if($result){
            if(in_array($result['mimeType'], array('image/jpeg','image/png'))){
                $img = "<img src='{$this->qiniu->downlink($key)}?imageView/2/w/203/h/203'>";
            }else{
                $img = '<img class="file-prev" src="https://dn-portal-static.qbox.me/v104/static/theme/default/image/resource/no-prev.png">';
            }
            $time = date('Y-m-d H:i:s', bcmul(substr(strval($result['putTime']), 0, 11),"1000000000"));
            $filesize = format_bytes($result['fsize']);
            $tpl = <<<tpl
            <div class="right-head">
                {$key}
            </div>
            <div class="right-body">
                <div class="right-body-block">
                    <div class="prev-block">
                        {$img}
                    </div>
                    <p class="file-info-item">
                        外链地址：<input class="file-share-link" type="text" readonly="readonly" value="{$this->qiniu->downlink($key)}">
                    </p>
                    <p class="file-info-item">
                        最后更新时间：<span>{$time}</span>
                    </p>
                    <p class="file-info-item">
                        文件大小：<span class="file-size">{$filesize}</span>
                    </p>
                </div>
            </div>
tpl;
            $this->success('as', '', array('tpl'=>$tpl));
        }else{
            $this->error('获取文件信息失败');
        }

    }

    //上传单个文件 用uploadify
    public function uploadOne(){
        $file = $_FILES['qiniu_file'];
        $file = array(
            'name'=>'file',
            'fileName'=>$file['name'],
            'fileBody'=>file_get_contents($file['tmp_name'])
        );
        $config = array();
        $result = $this->qiniu->upload($config, $file);
        if($result){
            $this->success('上传成功','', $result);
        }else{
            $this->error('上传失败','', array(
                'error'=>$this->qiniu->error,
                'errorStr'=>$this->qiniu->errorStr
            ));
        }
        exit;
    }

    function postDoupload($name,$filePath){
        $filetype = explode('.',$name);//获取文件扩展名 防止有的手机不支持七牛
        $accessKey =Config::AK;
        $secretKey = Config::SK;
        $bucket = Config::BUCKET_IMG_NAME;
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $filePath;
        // 上传到七牛后保存的文件名
        $key =time().mt_rand(1,1000).".".$filetype[1];
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $url=Config::IMG_DOMAIN.$ret['key'];
        return $url;die();
    }

//上传照片接口
    public function test(){
    	$this->display();
    
    }
    //wwb
    public function publicLoad(){
    
    	 $upload = new \Think\Upload();// 实例化上传类
          $upload->maxSize   =     3145728 ;// 设置附件上传大小
          $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
          $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
          $upload->savePath  =     'photo/'; // 设置附件上传（子）目录
          // 上传文件 
          $info   =   $upload->upload();
          if(!$info) {// 上传错误提示错误信息
             $inf['code']=100;
             $inf['msg']='error';
             $inf['data']['result']=array();
          }else{// 上传成功
         
            $url="http://s.shulailo.cn/ajax/Uploads/".$info['file']['savepath'].$info['file']['savename'];
           
            //转存文件
           	
            //创建目录
            $mkdir="mkdir /www/wwwroot/whjz365.com/attachs/".$info['file']['savepath']."";
            exec($mkdir);
            $str="cp -r /www/wwwroot/s.shulailo.cn/ajax/Uploads/".$info['file']['savepath'].$info['file']['savename']."  /www/wwwroot/whjz365.com/attachs/".$info['file']['savepath']."";
         
            exec($str,$result);
          
        
            $size=$info['file']['size'];
            $name=$info['file']['name'];
            $inf['code']=0;
            $inf['msg']='success';
            $inf['data']['result']=array();
            $inf['data']['url']= $url;
            $inf['data']['size']= $size;
            $inf['data']['name']= $name;
          }
    	 $this->ajaxReturn($inf);
    
    }
    public function upload(){
        try{
            $files  =   $_FILES;
            $this->loger("execute", "upload()");
            if(empty($files)){
                $this->error = '没有上传的文件！';
            }
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize  = 7097152;
            $upload->exts     = array ('jpg', 'gif', 'png', 'jpeg','pdf');
            $upload->rootPath = './Uploads/';
            $upload->savePath = 'CompanyLicense/'; // 设置附件上传（子）目录

            // 上传文件
            $info = $upload->upload();
            $this->loger("info", $info);
            if (!$info) {// 上传错误提示错误信息
                $data['code']=2;
                $data['msg']=$upload->getError();
                $this->ajaxReturn($data);
            } else {// 上传成功

                $this->loger("LicenceIMGUpdateinfo", $info);
                // 本地图片
                $localLicence = '/Uploads/' . $info['file']['savepath'] . $info['file']['savename'];
                $this->loger("localLicence", $localLicence);
                // 同步到OSS
                Vendor('OSS.autoload');
                $ossClient = new OssClient(C('OSS_ACCESS_KEY_ID'), C('OSS_ACCESS_KEY_SECRET'), C('OSS_ENDPOINT'));
                //$ossClient->createBucket(C('OSS_BUCKET'));
                $headImgKey = $info['file']['savename'];
                $this->loger("headImgKey", $headImgKey);
                $content = file_get_contents("./".$localLicence);
                $ossClient->putObject(C('OSS_BUCKET'), $headImgKey, $content);

                $license = C('OSS_URL') . $headImgKey;
                $this->loger("license", $license);
                $str="cp -r /www/wwwroot/m.shulailo.cn/".$localLicence." /www/wwwroot/music.shulailo.cn/attachs/photo/".$info['file']['savepath'];
                exec($str);
                $localLicence = 'http://music.shulailo.cn/attachs/photo/' . $info['file']['savepath'] . $info['file']['savename'];
                $data['code']=0;
                $data['localLicence']= $localLicence;
                $data['msg']="上传成功";
                $this->ajaxReturn($data);
            }
        }catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }

    }

    public function uploadFile(){
        try{
            $files  =   $_FILES;
            $this->loger("execute", "upload()");
            if(empty($files)){
                $this->error = '没有上传的文件！';
            }
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize  = 7097152;
            $upload->exts     = array ('doc', 'docx', 'pdf', 'xls','xlsx','txt','ppt');
            $upload->rootPath = './Uploads/';
            $upload->savePath = 'CompanyLicense/'; // 设置附件上传（子）目录

            // 上传文件
            $info = $upload->upload();
            $this->loger("info", $info);
            if (!$info) {// 上传错误提示错误信息
                $data['code']=2;
                $data['msg']=$upload->getError();
                $this->ajaxReturn($data);
            } else {// 上传成功

                $this->loger("LicenceIMGUpdateinfo", $info);
                // 本地图片
                $localLicence = '/Uploads/' . $info['file']['savepath'] . $info['file']['savename'];
                $this->loger("localLicence", $localLicence);

                // 同步到OSS
                Vendor('OSS.autoload');
                $ossClient = new OssClient(C('OSS_ACCESS_KEY_ID'), C('OSS_ACCESS_KEY_SECRET'), C('OSS_ENDPOINT'));

                //$ossClient->createBucket(C('OSS_BUCKET'));
                $headImgKey = $info['file']['savename'];
                $this->loger("headImgKey", $headImgKey);
                $content = file_get_contents("./".$localLicence);
                $ossClient->putObject(C('OSS_BUCKET'), $headImgKey, $content);

                $license = C('OSS_URL') . $headImgKey;
                $this->loger("license", $license);
                $data['code']=0;
                $data['CDNPath']= $license;
                $data['localPath']= $localLicence;
                $this->ajaxReturn($data);

            }
        }catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }

    }

    public function uploadWithtThumb(){
		
        $this->loger("execute", "uploadUserPhoto()");

        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 6291456;
        $upload->exts     = array ('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Uploads/';
        $upload->savePath = 'CommonImg/Raw/'; // 设置附件上传（子）目录

        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $data['code']=0;
            $data['msg']=$upload->getError();
            $this->ajaxReturn($data);
        } else {// 上传成功

            $this->loger("uploadImage Info", $info);
            // 本地用户头像
            $localHeadImgUrl = '/Uploads/' . $info['file']['savepath'] . $info['file']['savename'];
            $this->loger("localHeadImgUrl", $localHeadImgUrl);

            if (!$nosync) {

                $this->loger('--sync to OSS start');
                // 同步到OSS
                $rawImageUrl = $this->uploadToOss("./".$localHeadImgUrl, $info['file']['savename']);
            }

            $tempPath = str_replace('Raw', 'Thumb', './Uploads/' . $info['file']['savepath']);
            if(!file_exists($tempPath))
            {
                mkdir($tempPath);
            }
            $thumbPath = str_replace('Raw', 'Thumb', '.' . $localHeadImgUrl);
            $this->loger("thumbPath", $thumbPath);
            //产生缩略图
            $image = new Image();
            $image->open('.' . $localHeadImgUrl);
            $image->thumb(300, 200)->save($thumbPath);

            if (!$nosync) {

                $this->loger('--sync to OSS start');
                // 同步到OSS
                $thumbImageUrl = $this->uploadToOss($thumbPath, 'thumb' . $info['file']['savename']);
            }

            $data['code']=1;
            $data['msg']="上传成功" ;
            $data['data']['url'] = $rawImageUrl;
            $data['data']['thumburl'] = $thumbImageUrl;
            $this->ajaxReturn($data);
        }
    }

    private function uploadToOss($path, $filename){

        $this->loger("execute", "uploadToOss()");

        Vendor('OSS.autoload');
        $ossClient = new OssClient(C('OSS_ACCESS_KEY_ID'), C('OSS_ACCESS_KEY_SECRET'), C('OSS_ENDPOINT'));
        $headImgKey = $filename;
        $content = file_get_contents($path);
        $ossClient->putObject(C('OSS_BUCKET'), $headImgKey, $content);

        return C('OSS_URL') . $headImgKey;

    }
}
