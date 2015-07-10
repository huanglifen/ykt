@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/multi-select-metro.css" />
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
        $breadTitle = "商户管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商户管理", $baseURL . '/business/index'),
                array("新增商户", $baseURL . '/business/add'),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addBusinessForm"  class="form-horizontal">
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">选择区域</label>
                                        <div class="controls">
                                            <select class=" chosen span5" tabindex="1" id="cityId" name="cityId">
                                                @foreach($cities as $city)
                                                    <option value="{{{$city->id}}}" @if($business->city_id == $city->id)selected @endif>{{{$city->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="controls">
                                            <select class=" chosen span5" tabindex="1" id="districtId" name="districtId">
                                                @foreach($districts as $district)
                                                    <option value="{{{$district->id}}}" @if($business->district_id == $district->id)selected @endif>{{{$district->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="name">商户名称</label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" value="{{{$business->name}}}" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="account">商户账号</label>
                                        <div class="controls">
                                            <input type="text" id="account"  value="{{{$business->account}}}" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="password">登录密码</label>
                                        <div class="controls">
                                            <input type="password" id="password" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="number">商户编码</label>
                                        <div class="controls">
                                            <input type="text" id="number"  value="{{{$business->number}}}" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="integralNumber">积分系统商户编号</label>
                                        <div class="controls">
                                            <input type="text" id="integralNumber" value="{{{$business->integral_number}}}" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="address">商户地址</label>
                                        <div class="controls">
                                            <input type="text" id="address" value="{{{$business->address}}}" class="m-wrap span12">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="circle">商圈</label>
                                        <div class="controls">
                                            <select class="span12 chosen" tabindex="1" id="circle" name="circle">
                                                <option value="0" @if(!$business->business_district_id)selected @endif>无商圈</option>
                                                @foreach($circles as $circle)
                                                    <option value="{{{$circle->id}}}" @if($business->business_district_id == $circle->id)selected @endif>{{{$circle->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="bankType">开户银行</label>
                                        <div class="controls">
                                            <input type="text" id="bankType" class="m-wrap span12" value="{{{$business->bank_type}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="bankAccount">银行账号</label>
                                        <div class="controls">
                                            <input type="text" id="bankAccount" class="m-wrap span12" value="{{{$business->bank_account}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="tariff">商户税号</label>
                                        <div class="controls">
                                            <input type="text" id="tariff" class="m-wrap span12" value="{{{$business->tariff}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="license">执照号码</label>
                                        <div class="controls">
                                            <input type="text" id="license" class="m-wrap span12" value="{{{$business->license}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="contacter">联系人</label>
                                        <div class="controls">
                                            <input type="text" id="contacter" class="m-wrap span12" value="{{{$business->contacter}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="email">电子邮件</label>
                                        <div class="controls">
                                            <input type="text" id="email" class="m-wrap span12" value="{{{$business->email}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" for="phone">电话</label>
                                        <div class="controls">
                                            <input type="text" id="phone" class="m-wrap span12" value="{{{$business->phone}}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" for="tel">手机</label>
                                        <div class="controls">
                                            <input type="text" id="tel" class="m-wrap span12" value="{{{$business->tel}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" for="qq">QQ</label>
                                        <div class="controls">
                                            <input type="text" id="qq" class="m-wrap span12" value="{{{$business->qq}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="uniqueNumber">一卡通分配的唯一编码</label>
                                        <div class="controls">
                                            <input type="text" id="uniqueNumber" class="m-wrap span12" value="{{{$business->unique_number}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="level">商户级别</label>
                                        <div class="controls">
                                            <select class="span12 chosen" tabindex="1" id="level" name="level">
                                                <option value="0" @if($business->level == 0)selected @endif>半级</option>
                                                <option value="1" @if($business->level == 1)selected @endif>一级</option>
                                                <option value="2" @if($business->level == 2)selected @endif>二级</option>
                                                <option value="3" @if($business->level == 3)selected @endif>三级</option>
                                                <option value="4" @if($business->level == 4)selected @endif>四级</option>
                                                <option value="5" @if($business->level == 5)selected @endif>五级</option>
                                                <option value="6" @if($business->level == 6)selected @endif>六级</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="industry">行业类型</label>
                                        <div class="controls">
                                            <select  data-placeholder="选择行业" class="chosen span12" multiple="multiple" tabindex="6" id="industry" name="industry">
                                                <option value="0" @if(in_array(0,$business->industry))selected @endif>全部行业</option>\
                                                @foreach($industry as $in)
                                                    <option value="{{{$in->id}}}" @if(in_array($in->id,$business->industry))selected @endif>@if($in->parent_id != 0)&nbsp;@endif{{{$in->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="discount">折扣协议</label>
                                        <div class="controls">
                                            <input type="text" id="discount" class="m-wrap span12" name="discount" value="{{{$business->discount}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="level">用户星级</label>
                                        <div class="controls">
                                            <select class="span12 chosen" tabindex="1" id="star" name="star">
                                                <option value="0" @if($business->star == 0)selected @endif>零星级</option>
                                                <option value="1" @if($business->star == 1)selected @endif>一星级</option>
                                                <option value="2" @if($business->star == 2)selected @endif>二星级</option>
                                                <option value="3" @if($business->star == 3)selected @endif>三星级</option>
                                                <option value="4" @if($business->star == 4)selected @endif>四星级</option>
                                                <option value="5" @if($business->star == 5)selected @endif>五星级</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="cardType">支持的卡类型</label>
                                        <div class="controls">
                                            @foreach($cardType as $cType)
                                                <label class="checkbox">
                                                    <input type="checkbox" name="cardType" @if(in_array($cType->id, $business->card_type))checked @endif value="{{{$cType->id}}}" /> {{{$cType->name}}}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <label class="control-label">商户状态</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="status" value="1" @if($business->status != 2)checked @endif />
                                            可用
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="status" value="2" @if($business->status == 2)checked @endif/>
                                            禁用
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">图片</label>
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
                                <div class="span6 ">
                                    <form  id="jsPromotion" name="promotionUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">促销图片</label>
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
                                                        <a href="javascript:;" id="jsPromotionPic" class="btn green margin-right-10">
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
                                        <img id="jsPicImg" src="@if($business->picture)<?php  echo $baseURL.'/'.$business->picture ?> @endif"style="max-height: 190px;margin:5px;" data="{{{$business->picture}}}"/>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group" style="height:200px;border:1px solid #ccc;margin-left:180px;text-align:center;vertical-align: middle">
                                        <img id="jsPromotionPicImg" src="@if($business->promotion_pic)<?php echo $baseURL.'/'.$business->promotion_pic ?> @endif"  style="max-height: 190px;margin:5px;" data="{{{$business->promotion_pic}}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">商户简介</label>
                                        <div class="controls">
                                            <script id="editor" type="text/plain" style="width:445px;height:150px;"></script>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">商户简介手机版</label>
                                        <div class="controls">
                                            <textarea class="span7 large m-wrap" rows="12" id="appDescription" name="appDescription">{{{$business->app_description}}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="lng">经度</label>
                                        <div class="controls">
                                            <input type="text" id="lng" class="m-wrap span12" value="{{{$business->lng}}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="lat">纬度</label>
                                        <div class="controls">
                                            <input type="text" id="lat" class="m-wrap span12" value="{{{$business->lat}}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">地图标注</label>
                                <div class="controls">
                                    <input type="text" id="keyword" name="keyword" placeholder="您可以输入关键词来定位，地图加载完成后，请点击目标位置" class="span5 m-wrap popovers" />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <div id="allmap" class="span10" style="height: 300px;"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn blue" id="saveBusinessBtn">保存</button>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/jquery.multi-select.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.all.min.js"> </script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/form-components.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo Config::get('param.baidu.map_ak')?>"></script>
    <script>
        var ue = UE.getEditor('editor');
        var content = '<?php echo $business->description; ?> ';
        ue.ready(function() {
            ue.setContent(content, false);
        });
        jQuery(document).ready(function() {
            App.init();
            Common.bindCitySelect(false);
            Common.bindMap(false, false);
            changeCircle();
            //上传促销图片
            $("#jsPromotionPic").on('click', function() {
                if(! $("form[name=promotionUpload] input[name=file]").val()) {
                    alert('请选择要上传的图片');
                    return false;
                }
                var form = $("form[name=promotionUpload]");
                uploadPic(form, '#jsPromotionPicImg');
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

            $('#keyword').on('blur', function() {
                var that = this;
                Common.search(that);
            });

            $("#saveBusinessBtn").on('click', function() {
                addBusiness();
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
                    }
                }
            };
            form.ajaxSubmit(options);
        }

        //根据选择的城市动态显示商圈
        function changeCircle() {
            $("#cityId").chosen().change(function() {
                var $this = $(this);
                var cityId = $this.val();
                var data = "cityId="+cityId+"&districtId=0&iDisplayStart=0&iDisplayLength=500";
                $.ajax({
                    'url' : baseURL + "circle/circles",
                    'type' : 'get',
                    'dataType' : 'json',
                    'data' : data,
                    'success' : function(data) {
                        var option = [];
                        var circles = data.circles;
                        option.push('<option value="0">','无商圈','</option>');
                        $.each(circles,function(index,item){
                            option.push('<option value="'+item.id+'">',item.name,'</option>');
                        });
                        $('#circle').html(option.join(''));
                        $("#circle").trigger("liszt:updated");
                    }
                })
            });
        }

        //写入内容
        function setContent(html) {
           // UE.getEditor('editor').setContent(html);
        }

        //保存
        function addBusiness() {
            var data = '';
            var $cardType = $("input[name=cardType]");
            var cardType = '';
            $.each($cardType, function(i, item){
                var check = $(item).attr('checked');
                if(check == 'checked' || check == true) {
                    if(cardType == '') {
                        cardType = $(item).val();
                    }else{
                        cardType +=","+$(item).val();
                    }
                }
            });
            data +="cityId="+$("#cityId").val();
            data +="&districtId="+$("#districtId").val();
            data +="&name="+$("#name").val();
            data +="&account="+$("#account").val();
            data +="&password="+$("#password").val();
            data +="&number="+$("#number").val();
            data +="&integralNumber="+$("#integralNumber").val();
            data +="&address="+$("#address").val();
            data +="&circle="+$("#circle").val();
            data +="&bankType="+$("#bankType").val();
            data +="&bankAccount="+$("#bankAccount").val();
            data +="&tariff="+$("#tariff").val();
            data +="&license="+$("#license").val();
            data +="&contacter="+$("#contacter").val();
            data +="&email="+$("#email").val();
            data +="&phone="+$("#phone").val();
            data +="&tel="+$("#tel").val();
            data +="&qq="+$("#qq").val();
            data +="&cardType="+cardType;
            data +="&industry="+$("#industry").val();
            data +="&discount="+$("#discount").val();
            data +="&star="+$("#star").val();
            data +="&status="+$("input[name=status]").val();
            data +="&level="+$("#level").val();
            data +="&picture="+$("#jsPicImg").attr('data');
            data +="&promotion="+$("#jsPromotionPicImg").attr('data');
            data +="&description="+getAllHtml();
            data +="&appDescription="+document.getElementById("appDescription").value;
            data +="&lng="+$("#lng").val();
            data +="&lat="+$("#lat").val();
            data +="&uniqueNumber="+$("#uniqueNumber").val();
            data +="&id="+<?php echo $business->id ?>;
            $.ajax({
                'data' : data,
                'dataType' : 'json',
                'type' : 'post',
                'url' : baseURL + 'business/update',
                'success' : function(data) {
                    $(".JsErrorTarget").removeClass('error');
                    $(".JsErrorTip").hide();
                    if(data.status != 0) {
                        Common.checkLogin(data);
                        Common.checkError(data);
                    }else{
                        alert('修改成功！');
                    }
                }
            });
        }
    </script>
@stop