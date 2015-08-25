@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <style>
        .little_source ul {
            list-style: none;
            margin: 20px 0 0 0;
            padding: 0;
        }
        .little_source ul li {
            border-top: 1px solid #ddd;
            margin:0 13px;
        }
        .plus_box {
            border: 2px dotted #d9dadc;
            display: block;
            font-size: 16px;
            line-height: 60px;
            margin-bottom: 20px;
            margin-top:20px;
            text-align: center;
            text-decoration: none;
        }
        .little_box_li {
            height: 80px;
        }
        .little_pic {
            background-color: #F5F2F2;
            height : 60px;
            margin-top:10px;
        }
        .little_title {
            word-wrap: break-word;
            margin-top:20px;
        }
        .little_mask {
            display:none;
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(229,229,229,0.85)!important;
            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#d9e5e5e5',endcolorstr = '#d9e5e5e5');
            text-align: center;
            line-height: 160px;
        }
        .hover-mask.current {
            border-left : 2px solid #ff0000;
        }
    </style>
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "编辑素材";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("微信素材", $baseURL . '/wsource/index');
        $breadcrumb[] = array("编辑素材", $baseURL ."/wsource/update/".$id);
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="row-fluid">
                        <div class="portlet-body form">
                            <div  action="#" class="form-horizontal">
                                <div class="row-fluid" >
                                    <div class="span8" id="jsMultiForm">
                                        <div  style="display: none;" id="multi_source_mx">
                                            <div class="control-group">
                                                <label class="control-label">标题</label>
                                                <div class="controls">
                                                    <input type="text" name="title"
                                                           class="span10 m-wrap popovers title" data-trigger="hover"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    (大图片建议尺寸：900像素 * 500像素)
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span10 ">
                                                    <form class="jsPicUpload" name="picUpload" enctype="multipart/form-data">
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
                                                                        <a href="#" class="btn fileupload-exists jsReset" data-dismiss="fileupload">重置</a>
                                                                        <a href="javascript:;"class="btn green margin-right-10 jsPic">
                                                                            <i class="icon-upload"></i>上传
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">url</label>
                                                <div class="controls">
                                                    <input type="text" name="url"
                                                           class="span10 m-wrap popovers url" data-trigger="hover"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">详细内容</label>
                                                <div class="controls">
                                                    <script class="editor" name="editor" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                                    <input type="hidden" class="span10 m-wrap popovers content" data-trigger="hover"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="multi_source_m0" data-key="0" class="multi_source" data-id="{{{$source->id}}}">
                                            <div class="control-group">
                                                <label class="control-label">标题</label>
                                                <div class="controls">
                                                    <input type="text" name="title" value="{{{$source->title}}}"
                                                           class="span10 m-wrap popovers title" data-trigger="hover"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    (大图片建议尺寸：900像素 * 500像素)
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span10 ">
                                                    <form class="jsPicUpload" name="picUpload" enctype="multipart/form-data">
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
                                                                        <a href="#" class="btn fileupload-exists jsReset" data-dismiss="fileupload">重置</a>
                                                                        <a href="javascript:;" class="btn green margin-right-10 jsPic">
                                                                            <i class="icon-upload"></i>上传
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">url</label>
                                                <div class="controls">
                                                    <input type="text" name="url" value="{{{$source->url}}}"
                                                           class="span10 m-wrap popovers url" data-trigger="hover"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">详细内容</label>
                                                <div class="controls">
                                                    <script id="editorm0" name="editorm0" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                                    <input type="hidden" class="span10 m-wrap popovers content" data-trigger="hover"/>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $children = $source->child; ?>
                                           @foreach($children as $key=>$child)
                                            <div id="multi_source_m{{{$key+1}}}" style="display:none;" data-key="{{{$key+1}}}" data-id="{{{$child->id}}}" class="multi_source">
                                                <div class="control-group">
                                                    <label class="control-label">标题</label>
                                                    <div class="controls">
                                                        <input type="text" name="title" value="{{{$child->title}}}"
                                                               class="span10 m-wrap popovers title" data-trigger="hover"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        (大图片建议尺寸：900像素 * 500像素)
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span10 ">
                                                        <form class="jsPicUpload" name="picUpload" enctype="multipart/form-data">
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
                                                                            <a href="#" class="btn fileupload-exists jsReset" data-dismiss="fileupload">重置</a>
                                                                            <a href="javascript:;" class="btn green margin-right-10 jsPic">
                                                                                <i class="icon-upload"></i>上传
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">url</label>
                                                    <div class="controls">
                                                        <input type="text" name="url" value="{{{$child->url}}}"
                                                               class="span10 m-wrap popovers url" data-trigger="hover"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">详细内容</label>
                                                    <div class="controls">
                                                        <script id="editorm{{{$key+1}}}" name="editorm{{{$key+1}}}" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                                        <input type="hidden" class="span10 m-wrap popovers content" data-trigger="hover"/>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                    </div>
                                    <div class="span4 little_source">
                                        <div class="control-group" style="width:250px;color:#c0c0c0;margin:0 20px;border:1px solid #c0c0c0;">
                                            <div class="hover-mask current" id="little_box_li_m0" data-key="0" style="background-color: #f5f2f2; height:190px;margin:15px;">
                                                <div style="height:160px;">
                                                    @if($source->cover)
                                                    <img class="jsPicImg" src="{{{$baseURL}}}/{{{$source->cover}}}" data="{{{$source->cover}}}"/>
                                                    <div style="padding-top:90px;text-align:center; display:none;">封面图片</div>
                                                        @else
                                                        <img class="jsPicImg"  style="display:none;" src="" data=""/>
                                                        <div style="padding-top:90px;text-align:center;">封面图片</div>
                                                    @endif
                                                </div>
                                                <div style="background-color: rgba(0,0,0,0.6);line-height:30px;padding-left:5px;" class="minTitle">{{{$source->title or '标题'}}}</div>
                                                <div class="little_mask"><i class="icon-pencil jsIconEdit"></i></div>
                                            </div>
                                            <ul id="little_box_ul">
                                                <li class="little_box_li" data-key = "0" id="little_box_li_mx" style="display: none;">
                                                    <div class="span9 little_title minTitle">标题</div>
                                                    <div class="span3 little_pic">
                                                        <img  class ="jsPicImg" style="display:none;" data=""/>
                                                        <div style="padding-top:20px;text-align:center;">缩略图</div>
                                                    </div>
                                                    <div class="little_mask">
                                                        <div style="margin-top:-40px">
                                                            <i class="icon-pencil jsIconEdit"></i>
                                                            <i class="icon-trash jsIconDelete"></i>
                                                        </div>
                                                    </div>
                                                </li>
                                                @foreach($children as $key=>$child )
                                                    <li class="little_box_li hover-mask" data-key = "{{{$key+1}}}" id="little_box_li_m{{{$key+1}}}">
                                                        <div class="span9 little_title minTitle">{{{$child->title or '标题'}}}</div>
                                                        <div class="span3 little_pic">
                                                            @if($child->cover)
                                                            <img  class ="jsPicImg" src="{{{$baseURL}}}/{{{$child->cover}}}" data="{{{$child->cover}}}"/>
                                                            <div style="padding-top:20px;text-align:center;display:none;">缩略图</div>
                                                                @else
                                                                <img  class ="jsPicImg" style="display:none;" src="" data=""/>
                                                                <div style="padding-top:20px;text-align:center;">缩略图</div>
                                                            @endif
                                                        </div>
                                                        <div class="little_mask">
                                                            <div style="margin-top:-40px">
                                                                <i class="icon-pencil jsIconEdit"></i>
                                                                <i class="icon-trash jsIconDelete"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                            </ul>
                                            <ul >
                                                <li>
                                                    <a class="plus_box" href="javascript:;" id="jsPlusBox">
                                                        <i class="icon-plus"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
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
        var sourceNum = <?php echo count($children); ?>;
        jQuery(document).ready(function() {
            App.init();
            var ue = new Array();
            var content = '';
            var children = <?php echo json_encode($children); ?>;

            for(var i=0; i<=sourceNum; i++) {
                ue[i] = UE.getEditor('editorm'+i);
                if(i == 0) {
                    content = '<?php echo $source->content ; ?>';
                }else{
                    content = children[i-1].content;
                }
                target = "editorm"+i;
                setContent(content, target);
            }

            //上传图片
            $("body").on('click', '.jsPic', function () {
                var $this = this;
                var parents = $(this).parents(".multi_source");
                var form = $(parents).find("form[name=picUpload]");
                var input = $(form).find("input[name=file]");
                if (!input.val()) {
                    alert('请选择要上传的图片');
                    return false;
                }
                var key = $(parents).attr('data-key');
                var target = $("#little_box_li_m"+key).find(".jsPicImg");
                uploadPic(form, target);
            });

            var littleBox = sourceNum + 1;
            var prototype = $("#little_box_li_mx");
            var editKey = 0;
            //增加图文
            $("#jsPlusBox").on('click', function() {
                var html = '<li class="little_box_li hover-mask"  data-key="' + littleBox + '"id="little_box_li_m' + littleBox + '">';
                html += prototype.html();
                html +="</li>";
                $("#little_box_ul").append(html);
                var formHtml = '<div style="display:none;" data-id="0" data-key="' + littleBox + '" id="multi_source_m' + littleBox + '" class="multi_source">';
                formHtml += $("#multi_source_mx").html();
                formHtml += "</div>";
                $("#jsMultiForm").append(formHtml);

                $("#multi_source_m" + littleBox).find(".editor").attr('id', 'editorm'+littleBox);
                ue[littleBox] = UE.getEditor('editorm'+littleBox);

                littleBox++;
            });

            //删除一条图文
            $("body").on('click', '.jsIconDelete', function() {
                var parentLi = $(this).parents(".little_box_li");
                var key = $(parentLi).attr('data-key');
                $("#multi_source_m" + key).remove();
                $(parentLi).remove();
                if(editKey == key) {
                    $("#multi_source_m0").show();
                    $("#little_box_li_m0").addClass("current");
                }
            });

            //编辑图文
            $("body").on('click', ".jsIconEdit", function() {
                var parentTarget = $(this).parents(".hover-mask");
                var key = $(parentTarget).attr('data-key');

                $(".multi_source").hide();
                $("#multi_source_m"+key).show();

                $(".hover-mask").removeClass("current");
                $("#little_box_li_m"+key).addClass("current");
                editKey = key;
            });

            //鼠标经过右侧缩略图遮罩事件
            $("body").on('mouseenter',".hover-mask", function() {
                var offset= $(this).offset();
                var width = $(this).width();
                var height = $(this).height();
                $(this).find(".little_mask").css({top:offset.top, left:offset.left}).width(width).height(height).show();

            });
            //鼠标离开右侧缩略图遮罩消失事件
            $("body").on('mouseleave', ".hover-mask", function() {
                $(this).find(".little_mask").hide();
            });

            //输入标题显示小标题事件
            $("body").on("blur", '.title', function() {
                var parent = $(this).parents('.multi_source');
                var key = $(parent).attr('data-key');
                var target = $("#little_box_li_m"+key).find(".minTitle");
                var text = $(this).val();
                $(target).text(text);
            });

            //保存
            $("#JsSaveBtn").on('click', function() {
                var $source = $(".multi_source");
                if($source.length < 2) {
                    alert('至少要两条图文！');
                    return false;
                }
                var source = {};
                var num = 0;
                $.each($source, function(i, item) {
                    var target = $(item);
                    var title = target.find(".title").val();
                    var url = target.find('.url').val();
                    var key = target.attr('data-key');
                    var id = target.attr('data-id');
                    var box = $("#little_box_li_m"+key);
                    var pic = box.find(".jsPicImg").attr('data');
                    var content = ue[key].getContent();
                    if(title != '') {
                        num++;
                    }
                    var data = {"id": id, "title" : title, "url" : url, "pic" : pic, "content" : content};
                    source[key] = data;
                });
                if(num < 2) {
                    alert('至少要两条图文！');
                    return false;
                }
                source = JSON.stringify(source);
                var data = {"source" : source};
                $.ajax({
                    'data' : data,
                    'dataType' : 'json',
                    'type' : 'post',
                    'url' : baseURL + 'wsource/multi-update',
                    'success' : function(d) {
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

        function setContent(content, target) {
            UE.getEditor(target).ready(function () {
                UE.getEditor(target).setContent(content, false);
            });
        }
    </script>
@stop