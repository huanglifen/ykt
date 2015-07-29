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
        $breadTitle = "添加素材";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("微信素材", $baseURL . '/wsource/index');
        $breadcrumb[] = array("添加素材", $baseURL ."/wsource/add/".$type);
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="row-fluid">
                    <div class="portlet-body form">
                        <div id="addContentForm" action="#" class="form-horizontal">
                            <div class="row-fluid">
                            <div class="span8">
                            <div class="control-group">
                                <label class="control-label">标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title"
                                           class="span10 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">封面</label>
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
                            <div class="control-group">
                                <label class="control-label">url</label>
                                <div class="controls">
                                    <input type="text" id="url" name="url"
                                           class="span10 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">摘要</label>
                                <div class="controls">
                                    <textarea class="large m-wrap" rows="3" name="brief" id="brief"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">详细内容</label>
                                <div class="controls">
                                    <script id="editor" name="editor" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                    <input type="hidden" id="content" class="span10 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                          </div>
                                <div class="span4">
                                    <div class="control-group" style="height:260px;width:250px;color:#c0c0c0;margin:0 20px 0 20px;border:1px solid #c0c0c0;">
                                        <div style="margin:5px 0 5px 11px" id="minTitle">标题</div>
                                        <div style="text-align:center;background-color: #f5f2f2; height:200px;margin:5px 15px 5px 15px;">
                                            <img id="jsPicImg" style="display:none;" data=""/>
                                            <div style="padding-top:90px;">封面图片<BR/>(大图片建议尺寸：900像素 * 500像素)</div>
                                        </div>
                                        <div style="margin-left:11px" id="minBrief">简介</div>
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
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>

        jQuery(document).ready(function() {
            App.init();
            var ue = UE.getEditor('editor');
            //上传图片
            $("#jsPic").on('click', function () {
                var form = $("form[name=picUpload]");
                if (!$("form[name=picUpload] input[name=file]").val()) {
                    alert('请选择要上传的图片');
                    return false;
                }

                uploadPic(form, '#jsPicImg');
            });
            $("#title").on('keyup', function () {
                var text = $(this).val();
                if (text == '') {
                    text = "标题";
                }
                $("#minTitle").text(text);
            });
            $("#brief").on('keyup', function () {
                var text = $(this).val();
                if (text == '') {
                    text = "简介";
                }
                $("#minBrief").text(text);
            });
            $("#clearForm").on('click', function () {
                clearForm();
            });

            var clearForm = function () {
                if (!confirm('确认要清空当前内容？')) {
                    return false;
                }
                $("#url").val('');
                $("#brief").val('');
                $("#title").val('');
                $("#minTitle").text("标题");
                $("#minBrief").text("简介");
                var jsPic = $("#jsPicImg");
                jsPic.attr('src', "").attr('data', '').hide().next().show();
                $("#jsReset").click();
                ue.setContent('', false);
            }

            $("#JsSaveBtn").on('click', function () {
                var data = "title=" + $("#title").val();
                data += "&type=" + <?php echo $type; ?>;
                data += "&cover=" + $("#jsPicImg").attr('data');
                data += "&brief=" + $("#brief").val();
                data += "&url=" + $("#url").val();
                data += "&editor=" + ue.getContent();
                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();
                $.ajax({
                    'data': data,
                    'type': 'post',
                    'dataType': 'json',
                    'url': baseURL + "wsource/add",
                    'success': function (d) {
                        if (d.status == 0) {
                            alert("添加成功");
                            window.location.reload();
                        }
                        else {
                            Common.checkLogin(d);
                            if(d.status == 1001) {
                                Common.checkError(d);
                            }else{
                                alert("添加失败");
                            }
                        }
                    }
                })
            });//save
        });

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
                        $(target).show();
                        $(target).next().hide();
                    }
                }
            };
            form.ajaxSubmit(options);
        }
    </script>
@stop