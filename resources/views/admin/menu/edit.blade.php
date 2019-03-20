@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" action="/admin/menu/{{ $data['info']->id }}"  method="post" novalidate="novalidate">
                            {{ csrf_field() }}
                            {{ method_field('PUT')  }}
                            <input type="hidden" name="id" value="{{ $data['info']->id }}">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">编辑菜单</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">菜单名称 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Menu[name]" value="{{ $data['info']->path }}" placeholder="请输入菜单名称" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">上级菜单 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <select name="Menu[parent_id]" data-am-selected="{btnSize: 'sm',
                                             placeholder:'请选择上级菜单', maxHeight: 400}">
                                                <option value="" {{ $data['info']->parent_id == 0 ? 'selected' : ''}}></option>
                                                @foreach($data['parents'] as $parent)
                                                    <option value="{{ $parent['self']->id }}" {{$data['info']->parent_id == $parent['self']->id ? 'selected' : ''}}  >{{ $parent['self']->getShrotName() }}</option>
                                                    @if(isset($parent['child']))
                                                        @foreach($parent['child'] as $child)
                                                            <option value="{{ $child['self']->id }}" {{$data['info']->parent_id == $child['self']->id ? 'selected' : ''}} >&nbsp;&nbsp;--{{ $child['self']->getShrotName() }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">等级 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <select name="Menu[level]" data-am-selected="{btnSize: 'sm', maxHeight: 400}" required>
                                                <option value="1" {{ $data['info']->level == 1 ? 'selected' : ''}}>1</option>
                                                <option value="2" {{ $data['info']->level == 2 ? 'selected' : ''}}>2</option>
                                                <option value="3" {{ $data['info']->level == 3 ? 'selected' : ''}}>3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">图标 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="Menu[icon]" value="{{ $data['info']->icon }}" placeholder="请输入图标">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label">排序 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="number" class="tpl-form-input" name="Menu[sort]" value="{{ $data['info']->sort }}" placeholder="请输入管理员名称" required="">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-2 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">提交</button>
                                            <a class="am-btn am-btn-danger am-btn-sm am-radius" href="javascript:history.go(-1)">返回</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function () {
                /**
                 * 表单验证提交
                 * @type {*}
                 */
                $('#my-form').superForm();

            });
        </script>

    </div>
@endsection

@section('footer')

@endsection