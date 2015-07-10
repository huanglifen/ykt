@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
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
        $breadTitle = "商圈管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商圈管理", $baseURL . '/circle/index'),
                array("编辑商圈", $baseURL . '/circle/update/'.$circle->id),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updateCircleForm"  class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">选择区域</label>
                                <div class="controls">
                                    <select class=" chosen span3" tabindex="1" id="cityId" name="cityId">
                                        @foreach($cities as $city)
                                            <option value="{{{$city->id}}}" @if($circle->city_id == $city->id)selected @endif>{{{$city->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="controls">
                                    <select class=" chosen span3" tabindex="1" id="districtId" name="districtId">
                                        @foreach($districts as $district)
                                            <option value="{{{$district->id}}}" @if($circle->district_id == $district->id)selected @endif>{{{$district->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="control-group">
                                <label class="control-label">商圈名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$circle->name}}}" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">中心地址</label>
                                <div class="controls">
                                    <input type="text" id="address" name="address" value="{{{$circle->address}}}" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">经度</label>
                                <div class="controls">
                                    <input type="text" id="lng" name="lng"   value="{{{$circle->lng}}}" class="span6 m-wrap popovers" data-trigger="hover"
                                           data-content="地图加载成功后，您可以点击地图上的位置来获取商圈的经度"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">纬度</label>
                                <div class="controls">
                                    <input type="text" id="lat" name="lat"  value="{{{$circle->lat}}}" class="span6 m-wrap popovers" data-trigger="hover"
                                           data-content="地图加载成功后，您可以点击地图上的位置来获取商圈的纬度"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">地图标注</label>
                                <div class="controls">
                                    <input type="text" id="keyword" name="keyword" value="{{{$circle->keyword}}}"  placeholder="您可以输入关键词来定位，地图加载完成后，请点击目标位置"  onblur="Common.search(this);" class="span6 m-wrap popovers" />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <div id="allmap" class="span6" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">保存</button>
                                <button type="button" class="btn" id="clearForm">清空</button>
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
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo Config::get('param.baidu.map_ak')?>"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            var x = $("#lng").val() ;
            var y = $("#lat").val();
            var pointX = x ? x : false;
            var pointY = y ? y : false;
            Common.bindMap(pointX, pointY);
            Common.bindCitySelect(false);
            var target = $("#updateCircleForm");
            var id = <?php echo $circle->id ?>;
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize()+"&id="+id;
                    $.ajax({
                        url: baseURL + "circle/update",
                        dataType: 'json',
                        type: "post",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功");
                            }
                            else {
                                alert(d.result);
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    name: {
                        required : true,
                        maxlength : 20
                    },
                    address : {
                        required : true,
                        maxlength : 100
                    }
                },
                messages: {
                    name:  {
                        required : "请输入商圈名称",
                        maxlength : "名称长度不能超过20个字"
                    },
                    address : {
                        required : "请输入商圈地址",
                        maxlength : "地址长度不能超过50个字"
                    }
                }
            });
            $('#keyword').on('blur', function() {
                var that = this;
                Common.search(that);
            });
            $("#clearForm").on('click', function() {
                clearForm();
            });
            var clearForm = function() {
                $("#name").val('');
                $("#address").val('');
                $("#lat").val('');
                $("#lng").val('');
            }
        });
    </script>
@stop