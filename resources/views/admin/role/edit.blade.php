@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" action="/admin/role/{{ $data['info']->id }}"
                              method="post" novalidate="novalidate">
                            <input type="hidden" name="id" value="{{ $data['info']->id }}">
                            {{ method_field('PUT') }}
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">编辑角色</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">角色名称 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Role[name]" value="{{ $data['info']->group_name }}"
                                                   placeholder="请输入角色名称" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">选择权限 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <div class="order-list am-scrollable-horizontal am-u-sm-12">
                                                <div class="am-checkbox">
                                                    <label>
                                                        <input onclick="selectAll(this)" id="select-all"
                                                               type="checkbox"> 全选
                                                    </label>
                                                </div>
                                                <table id="auths" width="100%"
                                                       class="am-table am-table-centered am-text-nowrap">
                                                    @foreach($data['menus'] as $menu)
                                                        @if($menu->level == 1)
                                                            <tbody class="am-margin-bottom-sm">
                                                            <tr>
                                                                <td class="am-text-left" colspan="2">
                                                                    <div class="am-checkbox">
                                                                        <label>
                                                                            <input name="power_id[]"
                                                                                   onclick="selectChilds(this)"
                                                                                   value="{{ $menu->id }}"
                                                                                   type="checkbox"
                                                                                   {{ in_array($menu->id,$data['auth_ids']) ? 'checked' : '' }}
                                                                            > {{ $menu->getShrotName() }}
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @foreach($data['menus'] as $two)
                                                                @if($two->level == 2 && $two->parent_id == $menu->id)
                                                                    <tr>
                                                                        <td class="am-text-left">
                                                                            <div class="am-checkbox-inline am-margin-left-lg">
                                                                                <label>
                                                                                    <input name="power_id[]"
                                                                                           onclick="selectActions(this)"
                                                                                           value="{{ $two->id }}"
                                                                                           type="checkbox"
                                                                                            {{ in_array($two->id,$data['auth_ids']) ? 'checked' : '' }}
                                                                                    > {{ $two->getShrotName() }}
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="am-text-left">
                                                                            @foreach($data['menus'] as $three)
                                                                                @if($three->level == 3 && $three->parent_id == $two->id)
                                                                                    <div class="am-checkbox-inline">
                                                                                        <label>
                                                                                            <input name="power_id[]"
                                                                                                   onclick="selectAction(this)"
                                                                                                   value="{{ $three->id }}"
                                                                                                   type="checkbox"
                                                                                                    {{ in_array($three->id,$data['auth_ids']) ? 'checked' : '' }}
                                                                                            > {{ $three->getShrotName() }}
                                                                                        </label>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-2 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">提交</button>
                                            <a class="am-btn am-btn-sm am-btn-danger am-radius" href="javascript:history.go(-1)">返回</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {
            /**
             * 表单验证提交
             * @type {*}
             */
            $('#my-form').superForm();

        });

        function selectAll(event) {
            if ($(event).is(':checked')) {
                $("#auths").find('input').prop('checked', true);
            } else {
                $("#auths").find('input').prop('checked', false);
            }
        }

        function selectChilds(event) {
            if ($(event).is(':checked')) {
                $(event).parents('tr').siblings('tr').find('input').prop('checked', true);
            } else {
                if ($("#select-all").is(':checked')) {
                    $("#select-all").prop('checked', false);
                }
                $(event).parents('tr').siblings('tr').find('input').prop('checked', false);
            }
        }

        function selectActions(event) {
            var parentsNode = $(event).parents('tbody').find('tr:first input');
            if ($(event).is(':checked')) {
                $(event).parents('td').siblings('td').find('input').prop('checked', true);
                if (!parentsNode.is(':checked')) {
                    parentsNode.prop('checked', true);
                }
            } else {
                $(event).parents('td').siblings('td').find('input').prop('checked', false);
                var total = 0;
                $(event).parents('tbody').find('tr').each(function () {
                    if ($(this).find('input').is(':checked')) {
                        total++;
                    }
                })
                if (total <= 1) {
                    parentsNode.prop('checked', false);
                }
            }
        }

        function selectAction(event) {
            var parent = $(event).parents('td').prev('td').find('input');
            var parentsNode = $(event).parents('tbody').find('tr:first input');
            var siblings = $(event).parents('label').siblings('label');
            if ($(event).is(':checked')) {
                if (!parent.is(':checked')) {
                    parent.prop('checked', true);
                }
                if (!parentsNode.is(':checked')) {
                    parentsNode.prop('checked', true);
                }
            } else {
                var total = 0;
                siblings.each(function () {
                    if ($(this).find('input').is(':checked')) {
                        total++;
                    }
                })
                if (total < 1) {
                    parent.prop('checked', false);
                }

                var totals = 0;
                $(event).parents('tbody').find('tr').each(function () {
                    if ($(this).find('input').is(':checked')) {
                        totals++;
                    }
                })
                if (totals <= 1) {
                    parentsNode.prop('checked', false);
                }
            }

        }
    </script>

@endsection