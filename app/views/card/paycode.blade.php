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
        $breadTitle = "虚拟卡发码";
        $breadcrumb = array(
                array("卡片管理"),
                array("虚拟卡发码", $baseURL . '/paycode/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="control-group pull-right">
                                <form action="#" class="form-search">
                                    <div class="input-append">
                                        <input class="m-wrap" type="text" id="keyword" placeholder="输入用户名/用户ID/卡号"><button class="btn green" type="button" id="btnSearch" >搜索</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_codes">
                            <thead>
                            <tr>
                                <th style="width:15%">ID</th>
                                <th style="width:30%">姓名/uid</th>
                                <th style="width:20%">卡号</th>
                                <th style="width:20%">TOKEN码</th>
                                <th style="width:15%">发码时间</th>
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
    <div class="portlet box">
        <div class="portlet-body">
            <!-- Modal -->
            <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h3 id="myModalLabel1">个人信息</h3>
                </div>
                <div class="modal-body">
                    <div class=" row-fluid">
                        <div class = "span12">
                    <div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">姓名：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalUsername"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">openid：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalOpenId"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">绑定卡：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalCardno"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">身份证号：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalIdcard"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">联系方式：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalMobile"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">地址：</label>

                            <div class="controls">
                                <span class="help-inline" id="JsModalAddress"></span>
                            </div>
                        </div>
                        </form>
                    </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true" id="JsCloseModal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <a  href="#myModal1" data-toggle="modal" role="button" class="btn mini green margin-right-10 hide" id="JsModal"></a>
@stop
@section('otherJs')
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            var tbl = $('#datatable_codes').dataTable({
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
                "sAjaxDataProp": 'codes',
                "sAjaxSource": baseURL + 'paycode/codes',
                "aoColumns": [{
                    "mData": "id",
                    "aTargets": [0]
                },{
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return "<a class='JsMore' data-id='" + obj.aData.id + "' data-name='" + obj.aData.username + "'>"+obj.aData.username + " / " + obj.aData.uid + "</a>";
                    }
                }, {
                    "mData": "cardno",
                    "aTargets": [2]
                }, {
                    "mData": "token",
                    "aTargets": [3]
                }, {
                    "mData": "created_at",
                    "aTargets": [4]
                }]
            });
            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var keyword = $("#keyword").val();
                oSettings.sAjaxSource = baseURL + "paycode/codes?keyword="+keyword;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

            $("body").on("click", '.JsMore', function() {
                $("#JsModalTbody").html("");
                $("#myModalLabel1").text("个人信息");
                var id = $(this).attr('data-id');
                var name = $(this).attr("data-name");
                $.ajax({
                    'data' : "id="+id,
                    'dataType' : 'json',
                    'type' : 'get',
                    'url' : baseURL + 'customer/customer',
                    'success' : function(json) {
                        Common.checkLogin(json);
                        var info = json.result;
                        $("#JsModalUsername").text(info.username);
                        $("#JsModalOpenId").text(info.openid);
                        $("#JsModalCardno").text(info.cardno);
                        $("#JsModalIdcard").text(info.idcard);
                        $("#JsModalMobile").text(info.mobile);
                        $("#JsModalAddress").text(info.address);
                        $("#myModalLabel1").text(name+"的信息");
                        $("#JsModal").click();
                    }
                });

            });
        });
    </script>
@stop