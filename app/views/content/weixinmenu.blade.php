@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/jquery.nestable.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/multi-select-metro.css" />
@stop
@section("context")
    <style>
        .dd-handle i {
            cursor: pointer;
        }
    </style>
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "内容管理";
        $breadcrumb = array(
                array("内容管理"),
                array("微信自定义菜单", $baseURL . '/wmenu/index'));
        ?>
        @include('common.bread')
            <div class="row-fluid">
                    <div class="portlet box">
                        <div class="portlet-body ">
                            <div class="clearfix">
                                <div class="row-fluid span12" style="margin-bottom: 20px;">
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span12" tabindex="1" id="parentId" name="parentId">
                                                    <option value="0">选择父级</option>
                                                    @foreach($tree as $parent)
                                                        <option value="{{{$parent->id}}}">{{{$parent->name}}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span12" tabindex="1" id="type" name="type">
                                                    <option value="{{{\App\Module\WeixinMenuModule::TYPE_CLICK}}}">点击事件</option>
                                                    <option value="{{{\App\Module\WeixinMenuModule::TYPE_VIEW}}}">跳转URL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select data-placeholder="选择关联内容数据" class="chosen span12" tabindex="-1" id="category">
                                                    <option value="0"></option>
                                                    <optgroup label="单个图文">
                                                        @foreach($sources['single'] as $single)
                                                            <option value="{{{$single->id}}}">{{{$single->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="多条图文">
                                                        @foreach($sources['multi'] as $multi)
                                                            <option value="{{{$multi->id}}}">{{{$multi->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="自定义图文">
                                                        @foreach($sources['custom'] as $custom)
                                                            <option value="{{{$custom->id}}}">{{{$custom->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="text" id="name" name="name"
                                                       class="span12 m-wrap popovers" data-trigger="hover" placeholder="名称"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="text" id="key" name="key"
                                                       class="span12 m-wrap popovers" data-trigger="hover" placeholder="URL OR KEY"/>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="menuId"  value="0"/>
                                    <div class="span1">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button class="btn green"  type="button" id="btnOpt">操作</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                            <div class="span6">
                            <div class="dd" id="nestable_list_1">
                                @foreach($tree as $t)
                                <ol class="dd-list">
                                    <li class="dd-item" >
                                        <div class="dd-handle" style="cursor:default;" data-url="{{{$t->url}}}" data-key="{{{$t->key}}}" data-parent="{{{$t->parent_id}}}" data-type="{{{$t->type}}}" data-category="{{{$t->category}}}" data-name="{{{$t->name}}}"  data-id="{{{$t->id}}}">
                                            @if(count($t->children))
                                            <i class="jsCollapse" data-action="collapsed">-</i>
                                            @endif
                                            <span style="padding-right:20px;">{{{$t->name}}}</span>
                                            <a class="JsPlus"><i class="icon-plus"></i></a>
                                            <a class="JsPencil"><i class="icon-pencil"></i></a>
                                            <a class="JsTrash"><i class="icon-trash"></i></a>
                                        </div>
                                        @if(count($t->children))
                                        <ol class="dd-list">
                                            @foreach($t->children as $child)
                                            <li class="dd-item">
                                                <div class="dd-handle" style="cursor:default;" data-url="{{{$child->url}}}" data-key="{{{$child->key}}}"  data-parent="{{{$child->parent_id}}}" data-type="{{{$child->type}}}" data-category="{{{$child->category}}}"  data-name="{{{$child->name}}}" data-id="{{{$child->id}}}">
                                                    <span style="padding-right:20px;">{{{$child->name}}}</span>
                                                    <a class="JsPencil"><i class="icon-pencil"></i></a>
                                                    <a class="JsTrash"><i class="icon-trash"></i></a>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                </ol>
                                    @endforeach
                            </div>
                        </div>
                            <div class="span6">

                                <textarea style="height:200px;"class="m-wrap span10">{{{$json}}}</textarea>
                                <div class="control-group">
                                    <div class="controls">
                                        <button class="btn green"  type="button" id="btnSysc">创建更新菜单</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>
@stop
@section('otherJs')
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/jquery.nestable.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/jquery.multi-select.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function() {
            App.init();
            //新增一个二级菜单
            $(".JsPlus").on('click', function() {
                var $parent = $(this).parent();
                var id = $parent.attr('data-id');
                $("#parentId option[value="+id+"]").attr("selected","selected");
            });
            //编辑一个菜单
            $(".JsPencil").on('click', function() {
                var $parent = $(this).parent();
                var id = $parent.attr('data-id');
                var name = $parent.attr('data-name');
                var category = $parent.attr('data-category');
                var type = $parent.attr('data-type');
                var parentId = $parent.attr('data-parent');
                $("#menuId").val(id);
                $("#name").val(name);
                $("#parentId option[value="+parentId+"]").attr("selected","selected");
                $("#type option[value="+type+"]").attr("selected","selected");
                $("#category option[value="+category+"]").attr("selected","selected");
                $("#category").trigger("liszt:updated");
                if(type == '<?php echo \App\Module\WeixinMenuModule::TYPE_VIEW ?>') {
                    var key = $parent.attr('data-url');
                }else{
                    var key = $parent.attr('data-key');
                }
                $("#key").val(key);
            });

            //删除一个菜单
            $(".JsTrash").on('click', function(e) {
                var sibling = $(this).siblings(".jsCollapse");
                if(sibling.length > 0) {
                    if(! confirm("删除该菜单，则该菜单下的子菜单也会删除，确定要删除？")){
                        return false;
                    }
                }else{
                    if(! confirm("确定要删除该菜单")) {
                        return false;
                    }
                }
                var $parent = $(this).parent();
                var id = $parent.attr('data-id');
                var data = "id="+id;
                $.ajax({
                    'data' : data,
                    'dataType' : 'json',
                    'type' : 'post',
                    'url' : baseURL + 'wmenu/delete',
                    'success' : function(json) {
                        Common.checkLogin(json);
                        if(json.status == 0) {
                            alert('删除成功');
                            window.location.reload();
                        }else{
                            alert('删除失败');
                        }
                    }
                })
            });
            //列表展开和收缩
            $(".jsCollapse").on('click', function() {
                var $this= $(this);
                var ol = $this.parent().next();
                if($this.attr('data-action') == 'collapsed') {
                    $this.attr('data-action', 'expand');
                    $this.text("+");
                    ol.hide();
                }else{
                    $this.attr('data-action', 'collapsed');
                    $this.text("-");
                    ol.show();
                }
            })
            //新增/更新菜单
            $("#btnOpt").on('click', function() {
                var id = $("#menuId").val();
                var parentId = $("#parentId").val();
                if(id == parentId) {
                    alert('不能选择自己为父级菜单');
                    return false;
                }
                var type = $("#type").val();
                var data = "id="+id;
                data += "&parentId="+parentId;
                data +="&name="+$("#name").val();
                data +="&type="+type;
                var key = $("#key").val();
                if(type == '<?php echo \App\Module\WeixinMenuModule::TYPE_VIEW ?>') {
                    data +="&url="+key;
                }else{
                    data+="&key="+key;
                }
                data +="&category="+$("#category").val();

                editMenu(data, 'wmenu/menu');
            });
        });

        var editMenu = function(data, url) {
            $.ajax({
                'data' : data,
                'dataType' : 'json',
                'type' : 'post',
                'url' : baseURL + url,
                'success' : function(json) {
                    Common.checkLogin(json);
                    if(json.status == 0) {
                        alert('操作成功');
                        window.location.reload();
                    }else{
                        if(json.status == 1001) {
                            alert('请填写名称');
                        }else{
                            alert(json.result);
                        }
                    }
                }

            })};
    </script>
@stop