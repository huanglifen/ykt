@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "网点设置";
        $breadcrumb = array(
                array("网点管理"),
                array("网点设置", $baseURL . '/site/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="btn-group span2">
                                <a href="{{{$baseURL}}}/site/add" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>
                            <div class="row-fluid span10 pull-right" >
                                <div class="control-group span3">
                                        <div class="control-label" style="float: left;width:63px;padding-top:5px;">网点类型</div>
                                        <div class="controls">
                                            <select class="span7 chosen" tabindex="1" id="type" name="type">
                                                <option value="0">全部</option>
                                                @foreach($typeArr as $key => $type)
                                                    <option value="{{{$key}}}">{{{$type}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <div class="control-group span2">
                                    <div class="controls">
                                        <input class="span12 m-wrap" type="text" id="contact" name="contact" placeholder="联系人">
                                    </div>
                                </div>
                                <div class="control-group span3">
                                    <div class="controls">
                                        <input class="span12 m-wrap" type="text" id="tel" name="tel" placeholder="联系电话">
                                    </div>
                                </div>
                                <div class="control-group span3">
                                    <div class="input-append">
                                        <input class="span12 m-wrap" type="text" id="name" name="name" placeholder="网点名称">
                                        <button class="btn green btnSearch" type="button" id="btnSearch">搜索</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_sites">
                            <thead>
                            <tr>
                                <th style="width:10%">网点编号</th>
                                <th style="width:15%">网点名称</th>
                                <th style="width:15%">地址</th>
                                <th style="width:10%">联系人</th>
                                <th style="width:15%">联系电话</th>
                                <th style="width:10%">网点类型</th>
                                <th style="width:15%">时间</th>
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
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}common.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var typeArr = <?php echo json_encode($typeArr); ?>;

            App.init();
            var tbl = $('#datatable_sites').dataTable({
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
                "sAjaxDataProp": 'site',
                "sAjaxSource": baseURL + 'site/site',
                "aoColumns": [{
                    "mData": "number",
                    "aTargets": [0]
                }, {
                    "mData": "name",
                    "aTargets": [1]
                },{
                    "mData": "address",
                    "aTargets": [2]
                },{
                    "mData": "contactor",
                    "aTargets": [3]
                },{
                    "mData": "tel",
                    "aTargets": [4]
                },{
                    "mData": null,
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return typeArr[obj.aData.type];
                    }
                }, {
                    "mData": null,
                    "aTargets": [6],
                    "fnRender" : function(obj) {
                        return Common.formatDate(obj.aData.start_time) + "-" + Common.formatDate(obj.aData.end_time);
                    }
                }, {
                    "mData": null,
                    "aTargets": [7],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'site/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var name = $("#name").val();
                var type = $("#type").val();
                var contact = $("#contact").val();
                var tel = $("#tel").val();
                oSettings.sAjaxSource = baseURL + "site/site?name=" + name + "&type=" + type + "&contact=" + contact + "&tel=" + tel;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });


            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该网点？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'site/delete',
                    'success' : function(json) {
                        Common.checkLogin(json);
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