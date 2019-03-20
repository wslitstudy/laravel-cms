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
                            <div class="widget-title am-cf">轮播图列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="page_toolbar am-margin-bottom-xs am-cf">
                                <div class="am-u-sm-12 am-u-md-3 am-padding-left-0">
                                    <div class="am-form-group">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success" href="/admin/banner/create">
                                                <span class="am-icon-plus"></span> 新增
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-scrollable-horizontal am-u-sm-12 am-padding-0">
                                <table width="100%"
                                       class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>图片</th>
                                        <th>跳转地址</th>
                                        <th>状态</th>
                                        <th>创建时间</th>
                                        <th>更新时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['list'] as $banner)
                                        <tr>
                                            <td class="am-text-middle">{{ $banner->id }}</td>
                                            <td class="am-text-middle">
                                                <img src="{{ $banner->img }}" height="60px">
                                            </td>
                                            <td class="am-text-middle">
                                                <a href="{{ $banner->url }}" class="am-btn am-btn-xs am-btn-link">{{ $banner->url }}</a>
                                            </td>
                                            <td class="am-text-middle">
                                                @if($banner->is_show == 1)
                                                    <span class="am-badge am-badge-success">{{ $banner->getStatusText() }}</span>
                                                @endif
                                                @if($banner->is_show == -1)
                                                    <span class="am-badge am-badge-warning">{{ $banner->getStatusText() }}</span>
                                                @endif
                                            </td>
                                            <td class="am-text-middle">{{ $banner->create_time }}</td>
                                            <td class="am-text-middle">{{ $banner->update_time }}</td>
                                            <td class="am-text-middle">
                                                <div class="tpl-table-black-operation">
                                                    <a href="/admin/banner/{{ $banner->id }}/edit">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                    <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                       data-url="/admin/banner/{{ $banner->id }}">
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
@endsection

@section('footer')
    <script>
        $(function () {
            $('.item-delete').delete('删除后不可恢复，确定要删除吗？');
        })
    </script>
@endsection