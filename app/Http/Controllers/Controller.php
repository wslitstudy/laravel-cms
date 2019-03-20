<?php

namespace App\Http\Controllers;

use App\Lib\Model\Rbac\Power\Service;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function render($path, $data = [])
    {
        $service = new Service();

        $userService = new \App\Lib\Model\Rbac\Users\Service();

        return view($path, [
            'left' => $service->getLeft(),
            'data' => $data,
            'manage_info' => $userService->getManageInfo(),
            'app_url' => env('APP_URL')
        ]);
    }
}
