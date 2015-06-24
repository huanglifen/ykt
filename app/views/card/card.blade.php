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
        $breadTitle = "卡池管理";
        $breadcrumb = array(
                array("卡片管理"),
                array("卡池管理", $baseURL . '/card/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <form id="jsFileUpload" enctype="multipart/form-data">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="icon-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择文件</span>
													<span class="fileupload-exists">修改选择</span>
													<input type="file" class="default" name="file" />
													</span>
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                <a href="javascript:;" id="jsImport" class="btn green margin-right-10">
                                                    <i class="icon-upload"></i>开始导入
                                                </a>
                                                <a href="javascript:;" class="btn green pull-right">
                                                    <i class="icon-download"></i>下载模板
                                                </a>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </form>
                            <form action="#" class="form-search ">
                                <div class="row-fluid span8" style="margin-bottom: 20px;">
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span11 chosen" tabindex="1" id="cardType" name="cardType">
                                                    <option value="0">选择卡类型</option>
                                                    @foreach($cardType as $ctype)
                                                        <option value="{{{$ctype->id}}}">{{{$ctype->name}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span11 chosen" tabindex="1" id="type" name="type">
                                                    <option value="-1">选择卡分类</option>
                                                    @foreach($type as $key => $t)
                                                        <option value="{{{$key}}}">{{{$t}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span11 chosen" tabindex="1" id="status" name="status">
                                                    <option value="0">选择卡状态</option>
                                                    @foreach($status as $k => $s)
                                                        <option value="{{{$k}}}">{{{$s}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button class="btn green"  type="button" id="btnSearch">搜索</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_cards">
                            <thead>
                            <tr>
                                <th style="width:9%">ID</th>
                                <th style="width:9%">卡类型</th>
                                <th style="width:15%">卡号</th>
                                <th style="width:8%">校验码</th>
                                <th style="width:8%">分类</th>
                                <th style="width:9%">状态</th>
                                <th style="width:14%">导入时间</th>
                                <th style="width:14%">卖出时间</th>
                                <th style="width:13%">操作</th>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var state = <?php echo json_encode($status); ?>;
            var types = <?php echo json_encode($type); ?>;
            App.init();
            var tbl = $('#datatable_cards').dataTable({
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
                "sAjaxDataProp": 'cards',
                "sAjaxSource": baseURL + 'card/cards',
                "aoColumns": [{
                    "mData": "id",
                    "aTargets": [0]
                },{
                    "mData": "cardtypename",
                    "aTargets": [1]
                }, {
                    "mData": "cardno",
                    "aTargets": [2]
                }, {
                    "mData": "checkcode",
                    "aTargets": [3]
                }, {
                    "mData": "type",
                    "aTargets": [4],
                    "fnRender" : function(obj) {
                        return types[obj.aData.type];
                    }
                }, {
                    "mData": "status",
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return state[obj.aData.status];
                    }
                }, {
                    "mData": "created_at",
                    "aTargets": [6]
                },  {
                    "mData": "sale_time",
                    "aTargets": [7]
                }, {
                    "mData": null,
                    "aTargets": [8],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'card/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="查看更多" href="javascript:;" class="JsMore btn mini green green margin-right-10"><i class="icon-file"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var cardType = $("#cardType").val();
                var type = $("#type").val();
                var status = $("#status").val();
                oSettings.sAjaxSource = baseURL + "card/cards?cardType="+cardType+"&type="+type+"&status="+status;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该卡？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'card/delete',
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

            $("#jsImport").on('click', function() {
                var data = $("#jsFileUpload").serialize();
                alert('hi');
                console.log(data);
                $.ajax({
                    'type' : 'post',
                    'data' : data,
                    'dataType' : 'json',
                    'url' : baseURL + 'import/cards',
                    'success' : function() {

                    }
                });
            });
        });
    </script>
@stop