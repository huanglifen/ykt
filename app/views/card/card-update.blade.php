@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "卡池管理";
        $breadcrumb = array(
                array("卡片管理"),
                array("卡池管理", $baseURL . '/card/index'),
                array("编辑卡片", $baseURL . '/card/update/'.$card->id),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updateCardForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">卡类型</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="cardType" name="cardType">
                                        @foreach($cardType as $ctype)
                                            <option value="{{{$ctype->id}}}" @if($card->card_type == $ctype->id)selected @endif>{{{$ctype->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">卡号</label>
                                <div class="controls">
                                    <input type="text" id="cardNo" name="cardNo" value="<?php echo App\Module\CardModule::encrypt($card->cardno, "D"); ?>"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">校验码</label>
                                <div class="controls">
                                    <input type="text" id="checkCode" name="checkCode" value="<?php echo App\Module\CardModule::encrypt($card->checkcode, "D"); ?>"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">卡类别</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="type" name="type">
                                        @foreach($type as $key=>$t)
                                            <option value="{{{$key}}}" @if($card->type == $key)selected @endif>{{{$t}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">状态</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="status" name="status">
                                        @foreach($status as $k=>$s)
                                            <option value="{{{$k}}}" @if($card->status == $k)selected @endif>{{{$s}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
    <!-- END PAGE -->
@stop
@section('otherJs')
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            var target = $("#updateCardForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&id="+<?php echo $card->id ?>;
                    $.ajax({
                        url: baseURL + "card/update",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功");
                            }
                            else {
                                alert("修改失败");
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    cardNo: {
                        required : true
                    },
                    checkCode : {
                        required : true
                    }

                },
                messages: {
                    cardNo:  {
                        required : "请输入卡号"
                    },
                    checkCode : {
                        required : '请输入校验码'
                    }
                }
            });
        });
    </script>
@stop