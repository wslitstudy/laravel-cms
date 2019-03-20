<?php

namespace App\Http\Middleware;

use App\Exceptions\AdminException;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $session = new \App\Lib\Model\Rbac\Users\Service();
        if (!$session->getManageId()) {

            return redirect('/admin/login');
        }

        if (!$session->checkAuth()) {
            if ($request->ajax()) {
                throw new AdminException('没有权限',403);
            }else{
                return redirect('/admin/error');
            }
        }

        return $next($request);
    }
}
