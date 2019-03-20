@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">文章列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="page_toolbar am-margin-bottom-xs am-cf">
                                <form class="toolbar-form" action="{{ url('/admin/article') }}">
                                    <div class="am-u-sm-12 am-u-md-3 am-padding-left-0">
                                        <div class="am-form-group">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a class="am-btn am-btn-default am-btn-success" href="/admin/article/create">
                                                    <span class="am-icon-plus"></span> 新增
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-u-sm-12 am-u-md-9">
                                        <div class="am fr">
                                            <div class="am-form-group am-fl">
                                                <select name="cate_id"
                                                        data-am-selected="{btnSize: 'sm', placeholder: '文章分类'}"
                                                        >
                                                    <option value=""></option>
                                                    <option value="0">全部文章</option>
                                                    @foreach($data['category'] as $cateId=>$name)
                                                        <option value="{{ $cateId }}" {{ request()->input('cate_id') == $cateId ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="am-form-group am-fl">
                                                <select name="is_show"
                                                        data-am-selected="{btnSize: 'sm', placeholder: '发布状态'}"
                                                        >
                                                    <option value=""></option>
                                                    <option value="0">全部状态</option>
                                                    <option value="1" {{ request()->input('is_show') == 1 ? 'selected' : '' }}>已发布</option>
                                                    <option value="-1" {{ request()->input('is_show') == -1 ? 'selected' : '' }}>未发布</option>
                                                </select>
                                            </div>
                                            <div class="am-form-group am-fl">
                                                <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                                    <input type="text" class="am-form-field" name="keyword"
                                                           placeholder="请输入文章标题" value="{{ request()->input('keyword') }}">
                                                    <div class="am-input-group-btn">
                                                        <button class="am-btn am-btn-default am-icon-search" type="submit"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="am-scrollable-horizontal am-u-sm-12 am-padding-0">
                                <table width="100%"
                                       class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>文章标题</th>
                                        <th>文章类别</th>
                                        <th>文章内容</th>
                                        <th>状态</th>
                                        <th>创建时间</th>
                                        <th>更新时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['list'] as $article)
                                        <tr>
                                            <td class="am-text-middle">{{ $article->id }}</td>
                                            <td class="am-text-middle">{{ $article->title }}</td>
                                            <td class="am-text-middle">{{ $article->getCateText() }}</td>
                                            <td class="am-text-middle">
                                                <button type="button" data-content="{{ $article->content }}"
                                                        class="am-btn am-btn-xs am-btn-link show-content"
                                                >查看内容</button>
                                            </td>
                                            <td class="am-text-middle">
                                                @if($article->is_show == 1)
                                                    <span class="am-badge am-badge-success">{{ $article->getStatusText() }}</span>
                                                @endif
                                                @if($article->is_show == -1)
                                                    <span class="am-badge am-badge-warning">{{ $article->getStatusText() }}</span>
                                                @endif
                                            </td>
                                            <td class="am-text-middle">{{ $article->create_time }}</td>
                                            <td class="am-text-middle">{{ $article->update_time }}</td>
                                            <td class="am-text-middle">
                                                <div class="tpl-table-black-operation">
                                                    <a href="/admin/article/{{ $article->id }}/edit">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                    <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                       data-url="/admin/article/{{ $article->id }}">
                                                        <i class="am-icon-trash"></i> 删除
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="am-modal am-modal-no-btn" tabindex="-1" id="content-modal">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">文章内容
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd" id="notice-content">

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {
            $(".show-content").click(function () {
                var content = $(this).data('content');

                $("#content-modal").find('#notice-content').html(content);

                $("#content-modal").modal({
                    width: '414px'
                })
            })

            $('.item-delete').delete('删除后不可恢复，确定要删除吗？');
        })
    </script>
@endsection