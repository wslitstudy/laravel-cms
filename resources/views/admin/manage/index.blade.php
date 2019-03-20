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
                            <div class="widget-title am-cf">管理员列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-form-group">
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-success am-radius" href="{{ url('/admin/manage/create')  }}">
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
                                        <th>姓名</th>
                                        <th>角色</th>
                                        <th>状态</th>
                                        <th>注册时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['list'] as $manage)
                                        <tr>
                                            <td class="am-text-middle">{{ $manage->id }}</td>
                                            <td class="am-text-middle">{{ $manage->name }}</td>
                                            <td class="am-text-middle">
                                                @foreach($manage->roles as $role)
                                                    <span>{{ $role->group_name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="am-text-middle">
                                                @if($manage->isForbiddened())
                                                    <span class="am-badge am-badge-warning">已禁用</span>
                                                    <span>禁用时间：{{ $manage->getForbiddenTime() }}</span>
                                                @else
                                                    <span class="am-badge am-badge-success">正常</span>
                                                @endif
                                            </td>
                                            <td class="am-text-middle">{{ $manage->getCreateTime() }}</td>
                                            <td class="am-text-middle">
                                                @if($manage->isDefault())
                                                    <span class="am-badge am-badge-warning">系统默认用户，不能修改</span>
                                                @else
                                                    <div class="tpl-table-black-operation">
                                                        <a href="/admin/manage/{{ $manage->id }}/edit">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        @if($manage->isForbiddened())
                                                            <a href="javascript:void(0);"
                                                               class="unForbidden-delete tpl-table-black-operation-del"
                                                               data-url="/admin/manage/disabled/{{ $manage->id }}"
                                                            >
                                                                解禁
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);"
                                                               class="forbidden-delete tpl-table-black-operation-del"
                                                               data-url="/admin/manage/{{ $manage->id }}"
                                                            >
                                                               禁用
                                                            </a>
                                                        @endif

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
            $('.unForbidden-delete').delete('确定要解禁此管理员吗');
            $('.forbidden-delete').delete('确定要禁用此管理员吗');
        });
    </script>
@endsection