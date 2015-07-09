@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "客户管理";
        $breadcrumb = array(
                array("卡片管理"),
                array("客户管理", $baseURL . '/customer/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                                <div class="row-fluid span8" style="margin-bottom: 20px;">
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span11 chosen" tabindex="1" id="bind" name="bind">
                                                    <option value="0">是否绑定</option>
                                                    <option value="1">未绑定</option>
                                                    <option value="2">已绑定</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span11 chosen" tabindex="1" id="type" name="type">
                                                    <option value="-1">绑定类型</option>
                                                    @foreach($type as $key => $t)
                                                        <option value="{{{$key}}}">{{{$t}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <form action="#" class="form-search">
                                                <div class="input-append">
                                                    <input class="m-wrap" type="text" id="keyword" placeholder="姓名/openid/手机号/身份证号"><button class="btn green btnSearch" type="button" >搜索</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_customers">
                            <thead>
                            <tr>
                                <th style="width:6%">ID</th>
                                <th style="width:22%">姓名/openid</th>
                                <th style="width:10%">电话</th>
                                <th style="width:18%">身份证号</th>
                                <th style="width:10%">地址</th>
                                <th style="width:10%">备注</th>
                                <th style="width:10%">类型</th>
                                <th style="width:14%">绑定卡号</th>
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
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/bootstrap-fileupload.js" type="text/javascript" ></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            var tbl = $('#datatable_customers').dataTable({
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
                "sAjaxDataProp": 'customers',
                "sAjaxSource": baseURL + 'customer/customers',
                "aoColumns": [{
                    "mData": "id",
                    "aTargets": [0]
                },{
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return obj.aData.username + "<br/>" + obj.aData.openid;
                    }
                }, {
                    "mData": "mobile",
                    "aTargets": [2]
                }, {
                    "mData": "idcard",
                    "aTargets": [3]
                }, {
                    "mData": "address",
                    "aTargets": [4]
                }, {
                    "mData": "note",
                    "aTargets": [5]
                },{
                    "mData": null,
                    "aTargets": [6],
                    "fnRender" : function(obj) {
                        if(obj.aData.typec == 1) {
                            return "实体卡";
                        }else if(obj.aData.typec == 0){
                            return "虚拟卡";
                        }else {
                            return "无";
                        }
                    }
                }, {
                    "mData": "cardid",
                    "aTargets": [7],
                    "fnRender" : function(obj) {
                        if(obj.aData.cardid > 0) {
                            return obj.aData.cardno;
                        }else{
                            return "未绑定";
                        }
                    }
                }]
            });
            $(".btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var bind = $("#bind").val();
                var type = $("#type").val();
                var keyword = $("#keyword").val();
                oSettings.sAjaxSource = baseURL + "customer/customers?bind="+bind+"&type="+type+"&keyword="+keyword;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

        });
    </script>
@stop