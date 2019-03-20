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
                            <div class="widget-title am-cf">角色列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-form-group">
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-success am-radius" href="{{ url('/admin/role/create')  }}">
                                            <span class="am-icon-plus"></span> 新增
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="am-scrollable-horizontal am-u-sm-12 am-padding-0">
                                <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>角色名称</th>
                                        <th>默认角色</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['list'] as $role)
                                        <tr>
                                            <td class="am-text-middle">{{ $role->id }}</td>
                                            <td class="am-text-middle">{{ $role->group_name }}</td>
                                            <td class="am-text-middle">
                                                @if($role->is_default == 1)
                                                    <span class="am-badge am-badge-warning">默认角色</span>
                                                @endif
                                                @if($role->is_default == 0)
                                                    <span class="am-badge am-badge-primary">新增角色</span>
                                                @endif
                                            </td>
                                            <td class="am-text-middle">
                                                @if($role->is_default == 1)
                                                    <span class="am-badge am-badge-warning">默认角色，不可修改</span>
                                                @endif
                                                @if($role->is_default == 0)
                                                    <div class="tpl-table-black-operation">
                                                        <a href="/admin/role/{{ $role->id }}/edit">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        <a href="javascript:void(0);" class="item-delete tpl-table-black-operation-del" data-url="/admin/role/{{ $role->id }}">
                                                            <i class="am-icon-trash"></i> 删除
                                                        </a>
                                                    </div>
                                                @endif
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
            // 删除元素
            $('.item-delete').delete('删除后不可恢复，确定要删除吗？');

        });
    </script>
@endsection