@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "商户管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商户管理", $baseURL . '/business/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{{$baseURL}}}/business/add" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>

                            <div class="row-fluid span7 pull-right" style="margin-bottom: 20px;">
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="controls">
                                            <select class="span11 chosen" tabindex="1" id="cityId" name="cityId">
                                                @foreach($cities as $city)
                                                    <option value="{{{$city->id}}}">{{{$city->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="controls">
                                            <select class="span11 chosen" tabindex="1" id="districtId" name="districtId">
                                                <option value="0">全部</option>
                                                @foreach($districts as $district)
                                                    <option value="{{{$district->id}}}">{{{$district->name}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <form action="#" class="form-search">
                                            <div class="input-append">
                                                <input class="m-wrap" type="text" id="keyword" placeholder="商户编号/账户/名称"><button class="btn green btnSearch" type="button" id="btnSearch" >搜索</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_business">
                            <thead>
                            <tr>
                                <th style="width:10%">商户编号</th>
                                <th style="width:10%">商户账号</th>
                                <th style="width:10%">商户名称</th>
                                <th style="width:9%">手机号</th>
                                <th style="width:8%">联系人</th>
                                <th >行业</th>
                                <th style="width:8%">城市</th>
                                <th style="width:10%">查询</th>
                                <th style="width:10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            Common.bindCitySelect(true, false);
            var tbl = $('#datatable_business').dataTable({
                "sScrollXInner": "100%",
                "bServerSide": true,
                "bDestroy": false,
                'bPaginate': true,
                "bProcessing": true,
                "bDestroy": true,
                "bLengthChange": true,
                "bSort": false,
                "bFilter": false,
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                "iDisplayLength": 10,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sProcessing": "正在加载中......",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "没有数据！",
                    "sEmptyTable": "表中无数据存在！",
                    "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                    "sInfoEmpty": "显示0到0条记录",
                    "sInfoFiltered": "",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "末页"
                    }
                },
                "fnDrawCallback": function () {
                    App.initUniform();
                },
                "sAjaxDataProp": 'business',
                "sAjaxSource": baseURL + 'business/business',
                "aoColumns": [{
                    "mData": "number",
                    "aTargets": [0]
                },{
                    "mData": "account",
                    "aTargets": [1]
                },{
                    "mData": "name",
                    "aTargets": [2]
                }, {
                    "mData": "tel",
                    "aTargets": [3]
                },{
                    "mData": "contacter",
                    "aTargets": [4]
                },{
                    "mData": "industryStr",
                    "aTargets": [5]
                },{
                    "mData": "cityName",
                    "aTargets": [6]
                },{
                    "mData": null,
                    "aTargets": [7],
                    "fnRender" : function(obj) {
                        return "<a href='"+ baseURL + "activity/index/"+ obj.aData.id + "'>活动</a> <a href='"+ baseURL + "coupon/index/"+obj.aData.id + "'>优惠券</a>";
                    }
                }, {
                    "mData": null,
                    "aTargets": [8],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'business/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var keyword = $("#keyword").val();
                var cityId = $("#cityId").val();
                var districtId = $("#districtId").val();
                oSettings.sAjaxSource = baseURL + "business/business?keyword=" + keyword + "&cityId="+cityId+"&districtId="+districtId;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该商户？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'business/delete',
                    'success' : function(json) {
                        if(json.status == 0) {
                            alert('删除成功！');
                            window.location.reload();
                        }else{
                            alert(json.result);
                        }
                    }
                });
            });
        });
    </script>
@stop