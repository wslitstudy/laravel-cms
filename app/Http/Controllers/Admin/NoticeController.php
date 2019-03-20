<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoticeRequest;
use App\Lib\Entity\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * @power 内容管理|公告管理
     * @rank 2
     */
    public function index(Request $request)
    {
        $query = Notice::select(['*']);
        if ($request->input('is_show')) {
            $query->where('is_show', $request->input('is_show'));
        }
        if ($request->input('keyword')) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%');
        }

        return $this->render('admin.notice.index', [
            'list' => $query->paginate(25)
        ]);
    }

    /**
     * @power 内容管理|公告管理@添加
     */
    public function create()
    {
        return $this->render('admin.notice.create', [
            'status_label' => Notice::getAllStatus(),
            'app_url' => env('APP_URL')
        ]);
    }

    /**
     * @power 内容管理|公告管理@添加
     */
    public function store(NoticeRequest $request)
    {
        $result = Notice::addNotice($request->input('Notice'));
        if (!$result) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/notice')]);
    }


    /**
     * @power 内容管理|公告管理@编辑
     */
    public function edit($id)
    {
        $info = Notice::find($id);
        if (!$info) {
            throw new AdminException('公告不存在');
        }

        return $this->render('admin.notice.edit', [
            'status_label' => Notice::getAllStatus(),
            'app_url' => env('APP_URL'),
            'info' => $info
        ]);
    }

    /**
     * @power 内容管理|公告管理@编辑
     */
    public function update(NoticeRequest $request, $id)
    {
        $info = Notice::find($id);
        if (!$info) {
            throw new AdminException('公告不存在');
        }

        $info->title = $request->input('Notice.title');
        $info->is_show = $request->input('Notice.is_show');
        $info->content = $request->input('Notice.content');
        $info->sort = $request->input('Notice.sort');

        if (!$info->save()) {
            throw new AdminException('编辑失败');
        }

        return response(['code' => 0, 'message' => '编辑成功', 'url' => url('/admin/notice')]);
    }

    /**
     * @power 内容管理|公告管理@删除
     */
    public function destroy($id)
    {
        $info = Notice::find($id);
        if (!$info) {
            throw new AdminException('公告不存在');
        }

        if (!$info->delete()) {
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
