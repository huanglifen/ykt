@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
    <style>
        .chzn-container-single {
            margin-right: 30px !important;
        }
    </style>
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "修改网点";
        $breadcrumb = array(
                array("网点管理"),
                array("网点设置", $baseURL . '/site/index'),
                array("修改网点", $baseURL . '/site/update/'.$id),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addProductForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">网点类型</label>
                                <div class="controls">
                                    <select class="span3 chosen" tabindex="1" id="type" name="type">
                                        @foreach($typeArr as $key => $type)
                                            <option value="{{{$key}}}" @if($site->type == $key) selected @endif>{{{$type}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">所在区域</label>
                                <div class="controls">
                                    <select class="chosen span3" tabindex="1" id="cityId" name="cityId">
                                        @foreach($cities as $city)
                                            <option value="{{{$city->id}}}" @if($parentId == $city->id) selected @endif>{{{$city->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="controls">
                                    <select class="chosen span3" tabindex="1" id="districtId" name="districtId">
                                        @foreach($districts as $district)
                                            <option value="{{{$district->id}}}" @if($site->area_id == $district->id) selected @endif>{{{$district->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="control-group">
                                <label class="control-label">网点编号</label>
                                <div class="controls">
                                    <input type="text" id="number" name="number" value="{{{$site->number}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">网点名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$site->name}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">联系人</label>
                                <div class="controls">
                                    <input type="text" id="contact" name="contact" value="{{{$site->contactor}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">联系电话</label>
                                <div class="controls">
                                    <input type="text" id="tel" name="tel" value="{{{$site->tel}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">地址</label>
                                <div class="controls">
                                    <input type="text" id="address" name="address" value="{{{$site->address}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">开始时间</label>
                                <div class="controls input-prepend" style="margin-left:20px;">
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input class="span12 m-wrap m-ctrl-medium date-picker" @if($site->start_time)value="{{{date("m/d/Y", $site->start_time)}}}" @endif name="startTime" id="startTime" readonly
                                           type="text" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">结束时间</label>
                                <div class="controls input-prepend" style="margin-left:20px;">
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input class="m-wrap m-ctrl-medium date-picker" style="width:167px;" @if($site->end_time) value="{{{date("m/d/Y", $site->end_time)}}}" @endif name="endTime" id="endTime" readonly
                                           type="text" value=""/>
                                    <span for="endTime" class="error JsErrorTip" style="font-size:14px"></span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">图片上传</label>
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
													<input type="file"  class="default" name="file" />

													</span>
                                                        <a href="#" class="btn fileupload-exists" id="jsReset" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsPic" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>上传
                                                        </a>
                                                    </div>
                                                    <input type="hidden" id="picture"/>
                                                </div>

                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group" style="height:200px;border:1px solid #ccc;margin-left:180px;text-align:center;vertical-align: middle">
                                        <img id="jsPicImg" style="max-height: 190px;margin:5px;" data="{{{$site->picture}}}" @if($site->picture)src="{{{$baseURL}}}/{{{$site->picture}}}" @endif/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">备注</label>
                                <div class="controls">
                                    <input type="text" id="remark" name="remark" value="{{{$site->remark}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
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
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            Common.bindCitySelect(false, false);
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            $("#JsSaveBtn").on('click', function() {
                var data = "type=" + $("#type").val();
                data += "&name=" + $("#name").val();
                data += "&number=" + $("#number").val();
                data += "&contact="+ $("#contact").val();
                data += "&districtId=" + $("#districtId").val();
                data += "&tel=" + $("#tel").val();
                data += "&address=" + $("#address").val();
                data += "&startTime=" + $("#startTime").val();
                data += "&endTime=" + $("#endTime").val();
                data += "&remark=" + $("#remark").val();
                data += "&picture=" + $("#jsPicImg").attr('data');
                data += "&id=" + <?php echo $id; ?>;

                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();

                $.ajax({
                    url: baseURL + "site/update",
                    dataType: 'json',
                    type: "POST",
                    data: data,
                    success: function (d) {
                        Common.checkLogin(d);
                        if (d.status == 0) {
                            alert("修改成功");
                        } else if(d.status == 1001) {
                            Common.checkError(d);
                        }else if(d.status == 1000) {
                            alert(d.result);
                        } else {
                            alert("修改失败");
                        }
                    }
                });
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
            $("#clearForm").on('click', function() {
                clearForm();
            });
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });
        });

        var clearForm = function() {
            $("#name").val('');
            $("#number").val('');
            $("#contact").val('');
            $("#tel").val('');
            $("#address").val('');
            $("#remark").val('');
            $("#startTime").val('');
            $("#endTime").val('');
            $("#jsRest").click();
            $("#jsPicImg").removeAttr('data').removeAttr('src', '');
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