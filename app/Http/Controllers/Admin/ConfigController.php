<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\Entity\SystemConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * @power 系统配置|基本配置
     * @rank 2
     */
    public function index()
    {
        $data = SystemConfig::getConfigByType('base');
        return $this->render('admin.config.index', [
            'list' => $data
        ]);
    }

    /**
     * @power 系统配置|上传配置
     * @method GET
     */
    public function upload()
    {
        $method = SystemConfig::where('config_key', 'upload_method')->value('value');
        $aliyun = SystemConfig::where('config_key', 'upload_aliyun_config')->value('value');
        $qiniu = SystemConfig::where('config_key', 'upload_qiniu_config')->value('value');

        return $this->render('admin.config.upload', [
            'method' => $method,
            'aliyun' => json_decode($aliyun, true),
            'qiniu' => json_decode($qiniu, true)
        ]);
    }

    /**
     * @power 系统配置|上传配置
     * @method POST
     */
    public function doUpload(Request $request)
    {
        $method = $request->input('storage.method');
        $qiuniu = $request->input('storage.qiniu');
        $aliyun = $request->input('storage.aliyun');

        SystemConfig::where('config_key', 'upload_method')->update(['value' => $method]);
        SystemConfig::where('config_key', 'upload_aliyun_config')->update(['value' => json_encode($aliyun)]);
        SystemConfig::where('config_key', 'upload_qiniu_config')->update(['value' => json_encode($qiuniu)]);

        return response(['code' => 0, 'message' => '保存成功']);
    }

    /**
     * @power 系统配置|短信配置
     * @method GET
     */
    public function sms()
    {
        return $this->render('admin.config.sms');
    }

    /**
     * @power 系统配置|奖励配置
     * @method GET
     */
    public function reward()
    {
        $data = SystemConfig::getConfigByType('reward');
        foreach ($data as &$item) {
            $item['value'] = json_decode($item['value'], true);
        }
        return $this->render('admin.config.reward', [
            'list' => $data
        ]);
    }


    /**
     * @power 系统配置|基本配置@配置修改
     * @method POST
     */
    public function revise(Request $request)
    {
        //dd($request->input());
        $type = $request->input('type');
        $data = $request->input('config');

        foreach ($data as $key => $value) {
            $config = SystemConfig::where('config_key', $key)->where('type', $type)->first();
            if (!$config) {
                $config = new SystemConfig();
                $config->config_key = $key;
                $config->type = $type;
            }

            $config->value = is_array($value) ? json_encode($value) : $value;
            $config->save();
        }

        return response(['code' => 0, 'message' => '保存成功']);
    }
}
