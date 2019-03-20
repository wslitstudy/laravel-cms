@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">菜单列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                                <div class="am-form-group">
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success am-radius" href="{{ url('/admin/menu/create') }}">
                                                <span class="am-icon-plus"></span> 新增
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12">
                                <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black ">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>菜单名称</th>
                                        <th>排序</th>
                                        <th>路由</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['menus'] as $menu)
                                        <tr>
                                            <td class="am-text-middle">{{ $menu->id }}</td>
                                            <td class="am-text-middle">{{ $menu->path }}</td>
                                            <td class="am-text-middle">
                                                {{ $menu->sort }}
                                            </td>
                                            <td class="am-text-middle">
                                                @foreach($menu->getPower as $power)
                                                    <p>
                                                        {{ $power['method'] }} &nbsp;&nbsp; {{ $power['path'] }}
                                                        <a href="javascript:void(0)" data-method="{{ $power['method'] }}"
                                                           data-path="{{ $power['path'] }}"
                                                           data-id="{{ $power['id'] }}"
                                                           data-title="{{ $menu->path }}"
                                                           class="item-power"
                                                        >
                                                            <i class="am-icon-pencil"></i>
                                                        </a>
                                                        <a href="javascript:;" class="am-text-danger delete-power"
                                                           data-url="/admin/power/{{ $power['id'] }}">
                                                            <i class="am-icon-trash"></i>
                                                        </a>
                                                    </p>
                                                @endforeach
                                            </td>
                                            <td class="am-text-middle">
                                                <div class="tpl-table-black-operation">
                                                    <a href="/admin/menu/{{ $menu->id }}/edit">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                    <a href="javascript:void(0)" class="item-route" data-id="{{ $menu->id }}" data-name="{{ $menu->path }}">
                                                        <i class="am-icon-pencil"></i> 新增路由
                                                    </a>
                                                    <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                       data-url="/admin/menu/{{ $menu->id }}">
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
                        <div class="am-text-right" style="padding-right: 20px">
                            {{ $data['menus']->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-modal" tabindex="-1" id="route-model">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd"><span class="am-modal-title"></span>
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd am-margin-top-lg">
                        <form id="add-power-form" class="am-form tpl-form-line-form" action="{{ url('/admin/power') }}"  method="post" novalidate="novalidate">
                            <input type="hidden" name="menu_id" value="0">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-4 am-u-lg-3 am-form-label form-require">路由地址 </label>
                                        <div class="am-u-sm-8 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Power[path]" value="" placeholder="请输入路由地址" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-4 am-u-lg-3 am-form-label form-require">路由方式 </label>
                                        <div class="am-u-sm-8 am-u-end">
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" value="GET" name="Power[method]" checked>GET
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" value="POST" name="Power[method]">POST
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" value="PUT" name="Power[method]">PUT
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" value="DELETE" name="Power[method]">DELETE
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                    <div class="am-modal-footer">
                        <span class="am-modal-btn" data-am-modal-close >取消</span>
                        <span class="am-modal-btn" id="add-power">确定</span>
                    </div>
                </div>
            </div>

            <div class="am-modal" tabindex="-1" id="route-edit-model">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd"><span class="am-modal-title"></span>
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd am-margin-top-lg">
                        <form id="edit-power-form" class="am-form tpl-form-line-form" action="{{ url('/admin/power') }}"  method="post" novalidate="novalidate">
                            <input type="hidden" name="id" value="0">
                            {{ method_field('PUT')  }}
                            <div class="widget-body">
                                <fieldset>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-4 am-u-lg-3 am-form-label form-require">路由地址 </label>
                                        <div class="am-u-sm-8 am-u-end">
                                            <input type="text" class="tpl-form-input" name="path" value="" placeholder="请输入路由地址" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-4 am-u-lg-3 am-form-label form-require">路由方式 </label>
                                        <div class="am-u-sm-8 am-u-end">
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" class="edit-power-method" value="GET" name="method">GET
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" class="edit-power-method" value="POST" name="method">POST
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" class="edit-power-method" value="PUT" name="method">PUT
                                                </label>
                                            </div>
                                            <div class="am-radio-inline">
                                                <label>
                                                    <input type="radio" class="edit-power-method" value="DELETE" name="method">DELETE
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                    <div class="am-modal-footer">
                        <span class="am-modal-btn" data-am-modal-close >取消</span>
                        <span class="am-modal-btn" id="edit-power">确定</span>
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

            $(".delete-power").delete('删除后不可恢复，确定要删除吗？');

            $('.item-route').click(function () {
                var menuId = $(this).data('id');
                var name = $(this).data('name');

                $("#route-model").find('.am-modal-title').html(name)
                $("#route-model").find('input[name=menu_id]').val(menuId)

                $('#route-model').modal()
            })

            $(".item-power").click(function () {
                var id = $(this).data('id');
                var name = $(this).data('title');
                var path = $(this).data('path');
                var method = $(this).data('method');

                $("#route-edit-model").find('.am-modal-title').html(name)
                $("#route-edit-model").find('input[name=id]').val(id)
                $("#route-edit-model").find('input[name=path]').val(path)

                $(".edit-power-method").each(function () {
                    if($(this).val() == method){
                        $(this).attr('checked',true)
                    }
                })

                $('#route-edit-model').modal()
            })

            $("#edit-power").click(function () {
                var $form = $("#edit-power-form")
                var index = layer.load(0, {shade: [0.2,'#000']});
                var id = $("#route-edit-model").find('input[name=id]').val();
                $form.ajaxSubmit({
                    type: "post",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $form.attr('action') + '/' + id,
                    success: function (result) {
                        layer.close(index)
                        result.code === 0
                            ? $.show_success(result.message, result.url)
                            : $.show_error(result.message);
                    }
                });

                return false;
            })

            $("#add-power").click(function () {
                var $form = $("#add-power-form")
                var index = layer.load(0, {shade: [0.2,'#000']});
                $form.ajaxSubmit({
                    type: "post",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $form.attr('action'),
                    success: function (result) {
                        layer.close(index)
                        result.code === 0
                            ? $.show_success(result.message, result.url)
                            : $.show_error(result.message);
                    }
                });

                return false;
            })

        });
    </script>
@endsection