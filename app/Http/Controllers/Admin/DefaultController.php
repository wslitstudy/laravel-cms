<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login;

class DefaultController extends Controller
{
    public function index()
    {
        return $this->render('admin.default.index');
    }

    public function login()
    {
        return view('admin.default.login');
    }

    /**
     * 登录处理
     */
    public function store(Login $request)
    {

        $service = new \App\Lib\Model\Rbac\Users\Service();

        try {
            $service->doLogin($request->input('username'), $request->input('password'));

            return response()->json([
                'code' => 0,
                'message' => '登录成功',
                'url' => '/admins'
            ]);
        } catch (\Exception $exception) {

            throw new AdminException($exception->getMessage());
        }

    }

    public function logout()
    {
        $service = new \App\Lib\Model\Rbac\Users\Service();

        $service->logout();

        return redirect('/admin/login');
    }

}
