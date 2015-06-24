@extends("common.right")
@section("otherCss")
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-tree.css" />
@stop
@section("context")
  <div class="container-fluid">
        <?php
        $breadTitle = "角色管理";
        $breadcrumb = array(
                array("权限管理"),
                array("角色管理", $baseURL . '/role/index'),
                array("角色授权", $baseURL . '/role/authority/'.$role->id));
        ?>
        @include('common.bread')
            <div class="row-fluid">
                <div class="span6">
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-comments"></i>请给角色{{{$role->name}}}选择权限</div>
                        </div>
                        <div class="portlet-body fuelux">
                            <ul class="tree" id="tree_1">
                                <li>
                                    <a href="#" data-role="branch" class="tree-toggle" data-toggle="branch" >
                                        <input type="checkbox"  data-id="0" name="permission" @if(in_array(0, $permissions))checked="checked"@endif/>  全部
                                    </a>
                                    <ul class="branch in">
                                        <?php $length = count($menus); $len = $length - 2;?>
                                        @foreach($menus as $key=>$menu)
                                            @if($menu->level == 1)
                                                <li>
                                                @if(($key <= $len && $menus[$key+1]->level == 1)||$key > $len)
                                                        <a href="#" data-role="leaf" >
                                                            <input type="checkbox" data-id="{{{$menu->id}}}" name="permission" @if(in_array($menu->id, $permissions))checked="checked"@endif/>  {{{$menu->name}}}
                                                        </a>
                                                </li>
                                                @else
                                                    <a href="#" class="tree-toggle" data-toggle="branch">
                                                        <input type="checkbox"  data-id="{{{$menu->id}}}" name="permission" @if(in_array($menu->id, $permissions))checked="checked"@endif/> {{{$menu->name}}}
                                                    </a>
                                                <ul class="branch in">
                                                @endif
                                            @endif
                                            @if($menu->level == 2)
                                                  <li>
                                                      @if($key <= $len && $menus[$key+1]->level == 3)
                                                          <a href="#" class="tree-toggle" data-toggle="branch">
                                                              <input type="checkbox"  data-id="{{{$menu->id}}}" name="permission" @if(in_array($menu->id, $permissions))checked="checked"@endif/>  {{{$menu->name}}}
                                                          </a>
                                                          @else
                                                          <a href="#" data-role="leaf">
                                                              <input type="checkbox"  data-id="{{{$menu->id}}}" name="permission" @if(in_array($menu->id, $permissions))checked="checked"@endif/> {{{$menu->name}}}
                                                          </a>
                                                          @endif
                                                   @if($key <= $len && $menus[$key+1]->level == 2)
                                                   </li>
                                                   @elseif($key <= $len && $menus[$key+1]->level == 3)

                                                    <ul class="branch in">
                                                   @elseif(($key <= $len && $menus[$key+1]->level == 1) || $key > $len )
                                                     </li>
                                                     </ul>
                                                     </li>
                                                   @endif
                                            @endif
                                            @if($menu->level == 3)
                                                <li><a href="#" data-role="leaf"><input type="checkbox"  data-id="{{{$menu->id}}}" name="permission" @if(in_array($menu->id, $permissions))checked="checked"@endif/>  {{{$menu->name}}}</a></li>
                                                  @if($key <= $len && $menus[$key+1]->level == 1 || $key > $len)
                                                    </ul>
                                                    </li>
                                                    </ul>
                                                    </li>
                                                  @elseif($key <= $len && $menus[$key+1]->level == 2)
                                                      </ul>
                                                    </li>
                                                  @endif
                                            @endif
                                        @endforeach

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="form-actions" style="margin-bottom: 0px;">
                            <button type="submit" class="btn blue" id="JsSave">保存</button>
                        </div>
                    </div>
                </div>
            </div>
  </div>
@stop
@section('otherJs')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{{$jsURL}}}app.js"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            App.init();
            $("body").on("click", ".tree-toggle", function() {
                var $this = $(this);
                var $next = $this.next("ul.branch");
                if($this.hasClass("closed")) {
                    $this.removeClass("closed");
                    $next.addClass("in");
                }else{
                    $this.addClass("closed");
                    $next.removeClass("in");
                }
            });
            $("div.checker").on("click", function(e) {
                e.stopPropagation();
                var $this = $(this);
                var $span = $this.find("span");
                var $parent = $this.parent();
                var $grandParent = $parent.parent();

                if($span.hasClass("checked")) {
                    var $children = $grandParent.find("ul.branch .checker span");
                    var $childBox = $grandParent.find("ul.branch .checker input");
                    $children.addClass("checked");
                    $childBox.attr("checked", "checked");
                }else{
                    var $parents = $grandParent.parent().parents("li");
                    $.each($parents, function(i, item) {
                        var $checker = $(item).children(":first").find(".checker");
                        var $parentsChecker = $checker.find("span");
                        var $parentsInput = $checker.find("input");
                        $parentsChecker.removeClass("checked");
                        $parentsInput.attr("checked", false);
                    });

                }
            });

            $("#JsSave").on('click', function() {
                saveRolePermission();
            });
        });
        var saveRolePermission = function() {
            var checked = $("span.checked");
            var ids = "";
            $.each(checked, function(i, item) {
                var checkbox = $(item).children(":first");
                var id = checkbox.attr('data-id');
                ids += id + ",";
            });
            var length = ids.length;
            ids = ids.substring(0, length-1);
            var id = "<?php echo $role->id?>";
            var data = "id=" + id + "&ids="+ids;
            $.ajax({
                'type' : 'post',
                'data' : data,
                'dataType' : 'json',
                'success' : function(result) {
                    Common.checkLogin(result);
                    if(result.status == 0) {
                        alert('操作成功！');
                    }else {
                        alert(result.msg);
                    }
                }
            })
        }
    </script>
@stop