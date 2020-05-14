<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/28
 * Time: 15:09
 */

namespace Home\Controller;
use OSS\OssClient;
use OSS\Core\OssException;
use Think\Image;

class FileController extends BaseController
{
    public function _initialize() {
        parent::_initialize();
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
