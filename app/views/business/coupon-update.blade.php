@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "商户管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商户管理", $baseURL . '/business/index'),
                array("优惠券列表", $baseURL . '/coupon/index/'.$businessId),
                array("编辑优惠券", $baseURL . '/coupon/update/'.$businessId."/".$id),
        );
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addCouponForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">商户编号</label>
                                <div class="controls" >
                                    <span class="help-inline">{{{$business->number}}}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">商户名称</label>
                                <div class="controls">
                                    <span class="help-inline">{{{$business->name}}}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">优惠券标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title" value="{{{$coupon->title}}}" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">优惠券内容</label>
                                <div class="controls">

                                    <textarea class="large m-wrap" rows="3" name="content" id="content">{{{$coupon->content}}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">优惠券数量</label>
                                <div class="controls">
                                    <input type="text" id="amount" name="amount" value="{{{$coupon->amount}}}" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">剩余数量</label>
                                <div class="controls">
                                    <input type="text" id="remainAmount" name="remainAmount"  value="{{{$coupon->remain_amount}}}"class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">开始时间</label>
                                <div class="controls">
                                    <input class="m-wrap m-ctrl-medium date-picker" id="startTime" name="startTime" readonly size="16" type="text" value="<?php echo date("m/d/Y", $coupon->start_time);?>"  placeholder="请输入开始时间"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">结束时间</label>
                                <div class="controls">
                                    <input class="m-wrap m-ctrl-medium date-picker"id="endTime"  name="endTime" readonly size="16" type="text" value="<?php echo date("m/d/Y", $coupon->end_time);?>"  placeholder="请输入结束时间"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">优惠券状态</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="1" @if($coupon->status != 2) checked @endif />
                                        启用
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="2" @if($coupon->status == 2) checked @endif/>
                                        禁用
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">所属城市</label>
                                <div class="controls">
                                    <select class="span3 chosen" tabindex="1" id="cityId" name="cityId">
                                        @foreach($cities as $city)
                                            <option value="{{{$city->id}}}" @if($coupon->city_id == $city->id) selected @endif>{{{$city->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">优惠券图片</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input">
                                                            <i class="icon-file fileupload-exists"></i>
                                                            <span class="fileupload-preview"></span>
                                                        </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择图片</span>
													<span class="fileupload-exists">修改选择</span>
													<input type="file" class="default" name="file" />

													</span>
                                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsPic" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>上传
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group" style="height:200px;border:1px solid #ccc;margin-left:180px;text-align:center;vertical-align: middle">
                                        <img id="jsPicImg" src="{{{$baseURL}}}/{{{$coupon->picture}}}" style="max-height: 190px;margin:5px;" data="{{{$coupon->picture}}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
                                <button type="button" class="btn" id="clearForm">清空</button>
                            </div>
                        </div>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/daterangepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            var target = $("#addCouponForm");
            var businessId = <?php echo $businessId; ?>;

            $("#JsSaveBtn").on('click', function() {
                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();

                var data = "title="+$("#title").val();
                data += "&content="+document.getElementById("content").value;
                data += "&amount="+$("#amount").val();
                data += "&remainAmount="+$("#remainAmount").val();
                data += "&startTime="+$("#startTime").val();
                data += "&endTime="+$("#endTime").val();
                data += "&status="+$("#status").val();
                data += "&cityId="+$("#cityId").val();
                data += "&picture="+$("#jsPicImg").attr('data');
                data += "&businessId="+businessId;
                $.ajax({
                    url: baseURL + "coupon/add",
                    dataType: 'json',
                    type: "POST",
                    data: data,
                    success: function (d) {
                        Common.checkLogin(d);
                        if (d.status == 0) {
                            alert("修改成功");
                        }
                        else {
                            if(d.status == 1001) {
                                Common.checkError(d);
                            }else{
                                alert("修改失败");
                            }
                        }
                    }
                });
            });

            $("#clearForm").on('click', function() {
                clearForm();
            });

            //上传图片
            $("#jsPic").on('click', function() {
                var form = $("form[name=picUpload]");
                if(! $("form[name=picUpload] input[name=file]").val()) {
                    alert('请选择要上传的图片');
                    return false;
                }

                uploadPic(form, '#jsPicImg');
            });
        });

        var clearForm = function() {
            $("#title").val('');
            $("#content").val('');
            $("#startTime").val('');
            $("#endTime").val('');
            $("#amount").val('');
            $("#remainAmount").val('');
        }

        //上传图片
        function uploadPic(form, target) {
            var options  = {
                url : '/import/picture',
                type : 'post',
                dataType : 'json',
                success:function(json) {
                    if(json.status != 0) {
                        alert(json.result);
                    }else{
                        $(target).attr('src', baseURL+json.result);
                        $(target).attr('data', json.result);
                    }
                }
            };
            form.ajaxSubmit(options);
        }
    </script>
@stop