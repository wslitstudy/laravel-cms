<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Lib\Entity\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @power 内容管理|文章管理
     * @rank 2
     */
    public function index(Request $request)
    {
        $query = Article::select(['*']);
        if ($request->input('is_show')) {
            $query->where('is_show', $request->input('is_show'));
        }
        if ($request->input('cate_id')) {
            $query->where('cate_id', $request->input('cate_id'));
        }
        if ($request->input('keyword')) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%');
        }

        return $this->render('admin.article.index', [
            'list' => $query->paginate(25),
            'category' => Article::getAllCate()
        ]);
    }

    /**
     * @power 内容管理|文章管理@添加
     */
    public function create()
    {
        return $this->render('admin.article.create', [
            'status_label' => Article::getAllStatus(),
            'category' => Article::getAllCate(),
            'app_url' => env('APP_URL')
        ]);
    }

    /**
     * @power 内容管理|文章管理@添加
     */
    public function store(ArticleRequest $request)
    {
        $result = Article::addArticle($request->input('Article'));
        if (!$result) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/article')]);
    }


    /**
     * @power 内容管理|文章管理@编辑
     */
    public function edit($id)
    {
        $info = Article::find($id);
        if (!$info) {
            throw new AdminException('文章不存在');
        }

        return $this->render('admin.article.edit', [
            'status_label' => Article::getAllStatus(),
            'app_url' => env('APP_URL'),
            'category' => Article::getAllCate(),
            'info' => $info
        ]);
    }

    /**
     * @power 内容管理|文章管理@编辑
     */
    public function update(ArticleRequest $request, $id)
    {
        $info = Article::find($id);
        if (!$info) {
            throw new AdminException('文章不存在');
        }

        $info->title = $request->input('Article.title');
        $info->is_show = $request->input('Article.is_show');
        $info->content = $request->input('Article.content');
        $info->sort = $request->input('Article.sort');
        $info->cate_id = $request->input('Article.cate_id');

        if (!$info->save()) {
            throw new AdminException('编辑失败');
        }

        return response(['code' => 0, 'message' => '编辑成功', 'url' => url('/admin/article')]);
    }

    /**
     * @power 内容管理|文章管理@删除
     */
    public function destroy($id)
    {
        $info = Article::find($id);
        if (!$info) {
            throw new AdminException('文章不存在');
        }

        if (!$info->delete()) {
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
