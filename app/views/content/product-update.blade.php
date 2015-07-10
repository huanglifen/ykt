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
        $breadTitle = "内容管理";
        $breadcrumb = array(
                array("内容管理"),
                array("卡产品介绍管理", $baseURL . '/product/index'),
                array("编辑卡产品", $baseURL . '/product/update'),
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
                                <label class="control-label">卡片类型</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="type" name="type">
                                        @foreach($cardType as $type)
                                            <option value="{{{$type->id}}}" @if($product->type == $type->id) selected @endif>{{{$type->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">标题</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$product->name}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span7 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">卡样图片</label>
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
                                        <img id="jsPicImg" src="{{{$baseURL}}}/{{{$product->picture}}}"style="max-height: 190px;margin:5px;" data="{{{$product->picture}}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">卡片介绍</label>
                                <div class="controls">
                                    <textarea class="large m-wrap" rows="3" name="describe" id="describe" >{{{$product->describe}}}</textarea>
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
                var data = "type="+$("#type").val();
                data += "&name="+$("#name").val();
                data += "&describe="+document.getElementById("describe").value;
                data += "&picture="+$("#jsPicImg").attr('data');
                data += "&id="+ <?php echo $product->id; ?>;

                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();

                $.ajax({
                    url: baseURL + "product/update",
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
                            alert("添加失败");
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
        });

        var clearForm = function() {
            $("#title").val('');
            $("#describe").val('');
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