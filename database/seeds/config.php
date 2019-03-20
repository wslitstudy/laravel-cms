<?php

use Illuminate\Database\Seeder;

class config extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<SQL
INSERT INTO `config` (`id`, `config_key`, `value`, `config_desc`, `type`)
VALUES
	(1, 'app_switch', '1', '关闭后用户无法进行访问', 'base'),
	(2, 'app_close_reason', '网站关闭原因', '网站关闭后提示的信息', 'base'),
	(3, 'app_auto_close', '1', '到设置的时间段网站自动开启或者关闭', 'base'),
	(4, 'app_close_time', '23:00', '网站自动关闭时间', 'base'),
	(5, 'app_open_time', '07:00', '到达此时间，网站会自动开启', 'base'),
	(6, 'register_open', '1', '开关后会员无法进行注册', 'base'),
	(7, 'register_ip_limit', '20', '同一个ip最多可以注册多少次', 'base'),
	(8, 'upload_method', 'local', '上传图片方式(本地服务器，阿里云OSS，七牛云)', 'upload'),
	(9, 'upload_aliyun_config', '{\"bucket\":null,\"region\":null,\"ecs\":null,\"access_key_id\":null,\"access_key_secret\":null,\"domain\":null}', '阿里云存储配置（key,secret,城市,网络模式,domain）', 'upload'),
	(10, 'upload_qiniu_config', '{\"bucket\":null,\"access_key\":null,\"secret_key\":null,\"domain\":null}', '七牛云存储配置(key,secret,bucket,domain)', 'upload');
SQL;
        \Illuminate\Support\Facades\DB::insert($sql);

    }
}
