@extends("common.common")
<!-- BEGIN BODY -->
@section("content")
    <body class="page-header-fixed">
    @include("common.header")
    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid" >
        @include("common.left")
        <div class="page-content">
         <iframe frameborder="0" scrolling="auto" id="rightMain" name="rightMain" src="{{{$baseURL}}}/main/welcome" style="Z-INDEX: 1; VISIBILITY: inherit; OVERFLOW: auto; WIDTH: 100%; min-height: 756px;">
         </iframe>
        </div>
    </div>
    <!-- END CONTAINER -->
    @stop
    @section("footer")
        <div class="footer">

            <div class="copyright">
                河北一卡通互联网后台管理系统      v1.0

                河北一卡通电子支付有限公司      版权所有 2015-2016      意见反馈：master@966009.com
            </div>

            <div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

            </div>

        </div>
    @stop
    @section("otherJs")
        <script src="{{{$jsURL}}}/app.js"></script>
        <script>
            jQuery(document).ready(function() {
                App.init();
            });
            $("ul.sub-menu li").on('click', function() {
                var that = $(this);
                var child = that.find('ul');
                if(child.length <= 0) {
                    $("li.menu").removeClass('active');
                    var parent = that.parents('li.menu');
                    parent.addClass("active");
                    $("ul.sub-menu li").removeClass("active");
                    that.addClass("active");
                }
            })
        </script>
@stop

