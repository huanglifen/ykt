@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "站点信息";
        $breadcrumb = array(
                array("站点管理"),
                array("站点信息", $baseURL . '/web/index')
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
                                <label class="control-label">网站名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$info->name or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">网站域名</label>
                                <div class="controls">
                                    <input type="text" id="site" name="site" value="{{{$info->site or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">网站简称</label>
                                <div class="controls">
                                    <input type="text" id="abbr" name="abbr" value="{{{$info->abbr or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">SEO标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title" value="{{{$info->title or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">SEO关键字</label>
                                <div class="controls">
                                    <input type="text" id="keyword" name="keyword" value="{{{$info->keyword or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">SEO描述</label>
                                <div class="controls">
                                    <input type="text" id="describe" name="describe" value="{{{$info->describe or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form class="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">头部LOGO</label>
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
                                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsPicHead" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>上传
                                                        </a>
                                                    </div>
                                                    <input type="hidden" id="headLogo" data="{{{$info->head_logo or ''}}}"/>
                                                </div>
                                                @if($info->head_logo)
                                                <div id="JsHeadUrl" class="alert alert-success">当前LOGO路径：{{{$info->head_logo or ''}}}</div>
                                                    @else
                                                    <div  id="JsHeadUrl"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form class="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">底部LOGO</label>
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
                                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsPicBottom" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>上传
                                                        </a>
                                                    </div>
                                                    <input type="hidden" id="bottomLogo" data="{{{$info->bottom_logo or ''}}}"/>
                                                </div>
                                                @if($info->bottom_logo)
                                                <div class="alert alert-success" id="JsBottomUrl">当前LOGO路径： {{{$info->bottom_logo or ''}}}</div>
                                                @else
                                                    <div  id="JsBottomUrl"></div>
                                                @endif
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">系统备案号</label>
                                <div class="controls">
                                    <input type="text" id="fillNumber" name="fillNumber" value="{{{$info->filling_number or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">统计代码</label>
                                <div class="controls">
                                    <textarea class="large m-wrap" rows="3" name="code" id="code">{{{$info->code or ''}}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">新浪微博</label>
                                <div class="controls">
                                    <input type="text" id="weibo" name="weibo" value="{{{$info->weibo or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">腾讯微博</label>
                                <div class="controls">
                                    <input type="text" id="qq" name="qq" value="{{{$info->qq or ''}}}"
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            $("#JsSaveBtn").on('click', function() {
                var data = "name=" + $("#name").val();
                data += "&site=" + $("#site").val();
                data += "&abbr=" + $("#abbr").val();
                data += "&title=" + $("#title").val();
                data += "&keyword=" + $("#keyword").val();
                data += "&describe=" + $("#describe").val();
                data += "&headLogo="  +$("#headLogo").attr('data');
                data += "&bottomLogo="  +$("#bottomLogo").attr('data');
                data += "&fillNumber=" + $("#fillNumber").val();
                data += "&weibo="+$("#weibo").val();
                data += "&qq=" + $("#qq").val();
                data += "&code=" + $("#code").val();

                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();

                $.ajax({
                    url: baseURL + "web/web",
                    dataType: 'json',
                    type: "POST",
                    data: data,
                    success: function (d) {
                        Common.checkLogin(d);
                        if (d.status == 0) {
                            alert("操作成功");
                        } else if(d.status == 1001) {
                            Common.checkError(d);
                        }else if(d.status == 1000) {
                            alert(d.result);
                        } else {
                            alert("操作失败");
                        }
                    }
                });
            });

            //上传图片
            $("#jsPicHead").on('click', function() {
                var $parent = $(this).parents(".jsPicUpload");
                if($parent.find("input[name=file]").val()) {
                    uploadPic($parent, '#headLogo', '#JsHeadUrl');
                }

            });
            $("#jsPicBottom").on('click', function() {
                var $parent = $(this).parents(".jsPicUpload");
                if($parent.find("input[name=file]").val()) {
                    uploadPic($parent, '#bottomLogo', '#JsBottomUrl');
                }
            });
        });

        //上传图片
        function uploadPic(form, target, tipTarget) {
            var options  = {
                url : '/import/picture',
                type : 'post',
                dataType : 'json',
                success:function(json) {
                    if(json.status != 0) {
                        alert(json.result);
                    }else{
                        $(tipTarget).addClass("alert").addClass("alert-success").text('当前LOGO路径：'+ json.result);
                        $(target).attr('data', json.result);
                    }
                }
            };
            form.ajaxSubmit(options);
        }
    </script>
@stop