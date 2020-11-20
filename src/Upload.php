<?php
/*
* @Author: hzwlxy
* @Email: 120235331@qq.com
* @Github: http：//www.github.com/siaoynli
* @Date: 2019/7/10 9:19
* @Version:
* @Description:
*/

namespace Siaoynli\Upload;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Storage;

class Upload
{

    protected $config;
    protected $info;
    protected $type = "images";
    protected $disk = "";

    public function __construct(Repository $config)
    {
        $this->config = $config->get("upload");
        $this->disk = $this->config['disk'];
    }

    /**
     * @Author: hzwlxy
     * @Email: 120235331@qq.com
     * @Date: 2019/7/16 10:23
     * @Description: 设置类型
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }


    public function disk($name = "public")
    {
        $this->disk = $name;
        return $this;
    }

    /**
     * @Author: hzwlxy
     * @Email: 120235331@qq.com
     * @Date: 2019/7/10 10:10
     * @Description:执行上传操作
     * @return array
     */
    public function do($field = "")
    {
        //上传文件表单字段名称
        $field = $field ?: $this->config["name"];

        $file = request()->file($field);

        if (!$file) {
            return ['state' => '文件上传失败'];
        }

        if ($file->isValid()) {
            //文件后缀小写
            $ext = strtolower($file->getClientOriginalExtension());
            //获取文件大小
            $size = $file->getSize();

            //获取配置文件
            $extension = $this->config['extensions'][$this->type];

            //如果设置了后缀则判断
            if (!in_array('*', $extension)) {
                if (!in_array($ext, $extension)) {
                    return ['state' => '不允许上传的类型'];
                }
            }

            if ($size > $this->config["size"] * 1024) {
                return ['state' => '上传文件大小超过限制'];
            }

            $path = trim($this->config["path"], "/") . '/' . $this->type . '/' . date('Y-m-d');


            $name = $file->getClientOriginalName();

            $realPath = $file->getRealPath();
            $mimetype = $file->getClientMimeType();

            $filename = $path . '/' . sha1(uniqid()) . '.' . $ext;

            $content = file_get_contents($realPath);

            if ($this->disk) {
                if (!Storage::disk($this->disk)->put($filename, $content)) {
                    return ['state' => '文件上传失败，请确保disk:' . $this->disk . '目录可写'];
                }
            } else {
                if (!is_dir(public_path($path))) {
                    try {
                        mkdir(public_path($path), 0777, true);
                    } catch (\Exception $e) {
                        return ['state' => public_path($path) . '目录不可写'];
                    }
                }
                if (!file_put_contents(public_path($filename), $content)) {
                    return ['state' => '文件上传失败，请确保public目录可写'];
                }
            }

            return [
                'state' => 'SUCCESS',
                'original' => $name,
                'disk_name' => $this->disk,
                'ext' => $ext,
                'mime' => $mimetype,
                'size' => $size,
                'url' => '/' . $filename,
            ];
        } else {
            return ['state' => '文件上传失败'];
        }
    }
}
