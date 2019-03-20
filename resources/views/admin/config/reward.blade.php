@extends('admin.layout.layout')

@section('header')

@endsection

@section('main')
    <div class="tpl-content-wrapper ">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" method="post" action="/admin/config/revise" novalidate="novalidate">
                            <input type="hidden" name="type" value="reward">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">分享奖励配置</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">一级奖励</label>
                                        <div class="am-u-sm-5" style="float: left">
                                            <input type="text" class="tpl-form-input" name="config[share_reward][one]"
                                                   value="{{ !empty($data['list']['share_reward']) ? $data['list']['share_reward']['value']['one'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">二级奖励</label>
                                        <div class="am-u-sm-5" style="float: left">
                                            <input type="text" class="tpl-form-input" name="config[share_reward][two]"
                                                   value="{{ !empty($data['list']['share_reward']) ? $data['list']['share_reward']['value']['two'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">三级奖励</label>
                                        <div class="am-u-sm-5" style="float: left">
                                            <input type="text" class="tpl-form-input" name="config[share_reward][three]"
                                                   value="{{ !empty($data['list']['share_reward']) ? $data['list']['share_reward']['value']['three'] : ''}}">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">晋级奖励配置</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">升级v1</label>
                                        <div class="am-u-sm-9" style="display: flex;justify-content: flex-start;float: left">
                                            <div class="am-form-group" style="display: flex;align-items: center;">
                                                <input type="text"
                                                       name="config[upgrade_reward_one][child]"
                                                       value="{{ !empty($data['list']['upgrade_reward_one']) ? $data['list']['upgrade_reward_one']['value']['child'] : ''}}"
                                                       class="am-form-field" placeholder="直推人数">
                                                <span>人</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_one][reward]"
                                                       value="{{ !empty($data['list']['upgrade_reward_one']) ? $data['list']['upgrade_reward_one']['value']['reward'] : ''}}"
                                                       class="am-form-field" placeholder="奖励金额">
                                                <span>元</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">升级v2</label>
                                        <div class="am-u-sm-9" style="display: flex;justify-content: flex-start;float: left">
                                            <div class="am-form-group" style="display: flex;align-items: center;">
                                                <input type="text"
                                                       name="config[upgrade_reward_two][child]"
                                                       value="{{ !empty($data['list']['upgrade_reward_two']) ? $data['list']['upgrade_reward_two']['value']['child'] : ''}}"
                                                       class="am-form-field"
                                                       placeholder="直推人数">
                                                <span>人</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_two][team]"
                                                       value="{{ !empty($data['list']['upgrade_reward_two']) ? $data['list']['upgrade_reward_two']['value']['team'] : ''}}"
                                                       class="am-form-field"
                                                       placeholder="V1人数">
                                                <span>人</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_two][reward]"
                                                       value="{{ !empty($data['list']['upgrade_reward_two']) ? $data['list']['upgrade_reward_two']['value']['reward'] : ''}}"
                                                       class="am-form-field"
                                                       placeholder="奖励金额">
                                                <span>元</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">升级v3</label>
                                        <div class="am-u-sm-9" style="display: flex;justify-content: flex-start;float: left">
                                            <div class="am-form-group" style="display: flex;align-items: center;">
                                                <input type="text"
                                                       name="config[upgrade_reward_three][child]"
                                                       value="{{ !empty($data['list']['upgrade_reward_three']) ? $data['list']['upgrade_reward_three']['value']['child'] : ''}}"
                                                       class="am-form-field"
                                                       placeholder="直推人数">
                                                <span>人</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_three][total_reward]"
                                                       value="{{ !empty($data['list']['upgrade_reward_three']) ? $data['list']['upgrade_reward_three']['value']['total_reward'] : ''}}"
                                                       class="am-form-field" placeholder="累计奖励">
                                                <span>元</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_three][reward]"
                                                       value="{{ !empty($data['list']['upgrade_reward_three']) ? $data['list']['upgrade_reward_three']['value']['reward'] : ''}}"
                                                       class="am-form-field"
                                                       placeholder="奖励金额">
                                                <span>元</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-1 am-form-label">升级v4</label>
                                        <div class="am-u-sm-9" style="display: flex;justify-content: flex-start;float: left">
                                            <div class="am-form-group" style="display: flex;align-items: center;">
                                                <input type="text"
                                                       class="am-form-field"
                                                       name="config[upgrade_reward_four][child]"
                                                       value="{{ !empty($data['list']['upgrade_reward_four']) ? $data['list']['upgrade_reward_four']['value']['child'] : ''}}"
                                                       placeholder="直推人数">
                                                <span>人</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_four][total_reward]"
                                                       class="am-form-field"
                                                       value="{{ !empty($data['list']['upgrade_reward_four']) ? $data['list']['upgrade_reward_four']['value']['total_reward'] : ''}}" placeholder="累计奖励">
                                                <span>元</span>
                                            </div>
                                            <div class="am-form-group" style="display: flex;align-items: center;margin-left: 15px">
                                                <input type="text"
                                                       name="config[upgrade_reward_four][reward]"
                                                       class="am-form-field"
                                                       value="{{ !empty($data['list']['upgrade_reward_four']) ? $data['list']['upgrade_reward_four']['value']['reward'] : ''}}" placeholder="奖励金额">
                                                <span>元</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-1 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                            </button>
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
    </script>
@endsection
