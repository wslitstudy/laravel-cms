<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Lib\Entity\Banner;

class BannerController extends Controller
{
    /**
     * @power 内容管理|轮播图管理
     * @rank 2
     */
    public function index()
    {
        return $this->render('admin.banner.index', [
            'list' => Banner::all()
        ]);
    }

    /**
     * @power 内容管理|轮播图管理@添加
     */
    public function create()
    {
        return $this->render('admin.banner.create', [
            'status_label' => Banner::getAllStatus()
        ]);
    }

    /**
     * @power 内容管理|轮播图管理@添加
     */
    public function store(BannerRequest $request)
    {
        $result = Banner::addBanner($request->input('Banner'));
        if (!$result) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/banner')]);
    }


    /**
     * @power 内容管理|轮播图管理@编辑
     */
    public function edit($id)
    {
        $info = Banner::find($id);
        if (!$info) {
            throw new AdminException('对象不存在');
        }

        return $this->render('admin.banner.edit', [
            'status_label' => Banner::getAllStatus(),
            'info' => $info
        ]);
    }

    /**
     * @power 内容管理|轮播图管理@编辑
     */
    public function update(BannerRequest $request, $id)
    {
        $info = Banner::find($id);
        if (!$info) {
            throw new AdminException('对象不存在');
        }

        $info->img = $request->input('Banner.img');
        $info->is_show = $request->input('Banner.is_show');
        $info->url = $request->input('Banner.url');
        $info->sort = $request->input('Banner.sort');

        if (!$info->save()) {
            throw new AdminException('编辑失败');
        }

        return response(['code' => 0, 'message' => '编辑成功', 'url' => url('/admin/banner')]);
    }

    /**
     * @power 内容管理|轮播图管理@删除
     */
    public function destroy($id)
    {
        $info = Banner::find($id);
        if (!$info) {
            throw new AdminException('对象不存在');
        }

        if (!$info->delete()) {
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
