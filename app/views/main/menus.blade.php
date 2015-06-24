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
                $breadTitle = "菜单管理";
                $breadcrumb = array(
                        array("权限管理"),
                        array("菜单管理", $baseURL . '/menu/index'));
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
                                        <a href="{{{$baseURL}}}/menu/add" class="btn margin-right-10 green">
                                            新增<i class="icon-plus"></i>
                                        </a>
                                        <a href="javascript:;" class="btn red" id="JsDeleteBatch">
                                            删除<i class="icon-remove"></i>
                                            </a>
                                    </div>
                                    <div class="control-group pull-right">
                                        <form action="#" class="form-search">
                                            <div class="input-append">
                                                <input class="m-wrap" type="text" id="keyword" placeholder="输入菜单编号/菜单名称"><button class="btn green" type="button" id="btnSearch" >搜索</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <table class="table table-striped table-bordered table-hover" id="datatable_menus">
                                    <thead>
                                    <tr>
                                        <th style="width:15px;">
                                            <input type="checkbox" class="group-checkable" id="JsSelectAll" />
                                        </th>
                                        <th style="width:100px">编号</th>
                                        <th style="width:130px">名称</th>
                                        <th style="width:130px">上级菜单</th>
                                        <th style="width:130px">分组</th>
                                        <th>URL</th>
                                        <th style="width:60px">排序</th>
                                        <th style="width:70px">是否显示</th>
                                        <th style="width:80px">操作</th>
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
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var displayArr = {"1":"是", "2" : "否"};
            App.init();
            var tbl = $('#datatable_menus').dataTable({
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
                "sAjaxDataProp": 'menus',
                "sAjaxSource": baseURL + 'menu/menus',
                "aoColumns": [{
                    "mData": null,
                    "aTargets": [0],
                    "fnRender": function (obj) {
                        return '<input type="checkbox" class="group-checkable" data-level="' + obj.aData.level + '" data-id="' + obj.aData.id + '"/>';
                    }
                }, {
                    "mData": "number",
                    "aTargets": [1]
                }, {
                    "mData": "name",
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        if(obj.aData.level == 3) {
                            return  "&nbsp;&nbsp;" + obj.aData.name;
                        }else if(obj.aData.level == 2) {
                            return "&nbsp;"+obj.aData.name;
                        }else {
                            return  obj.aData.name;
                        }
                    }
                }, {
                    "mData": "parent",
                    "aTargets": [3]
                }, {
                    "mData": "groupName",
                    "aTargets": [4]
                }, {
                    "mData": "url",
                    "aTargets": [5]
                }, {
                    "mData": "sort",
                    "aTargets": [6]
                }, {
                    "mData": "display",
                    "aTargets": [7],
                    "fnRender" : function(obj) {
                        return displayArr[obj.aData.display];
                    }
                }, {
                    "mData": null,
                    "aTargets": [8],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'menu/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var keyword = $("#keyword").val();
                oSettings.sAjaxSource = baseURL + "menu/menus?keyword=" + keyword;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该菜单？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                   'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'menu/delete',
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

            $("#JsDeleteBatch").on('click', function() {
                if(! confirm('确定要删除选中的菜单吗?')){
                    return false;
                }
                var checkBoxes = $("td span.checked input");
                if(checkBoxes.length <= 0 ) {
                    alert('至少选中一个菜单进行删除');
                    return false;
                }
                var deleteArr = {};
                $.each(checkBoxes, function(i, item) {
                    var box = $(item);
                    var level = box.attr('data-level');
                    var id = box.attr('data-id');
                    var target = {"id":id,"level":level};
                    deleteArr[i] = target;
                });

                deleteArr = JSON.stringify(deleteArr);
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'deleteArr='+deleteArr,
                    'url' : baseURL + 'menu/delete-batch',
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
            Common.dataTableSelectAll();
        });
    </script>
@stop