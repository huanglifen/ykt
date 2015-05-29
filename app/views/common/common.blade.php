
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    @section('title')
    <title>一卡通后台管理系统</title>
    @show

    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{{$mediaURL}}}css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/style-metro.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/style.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$cssURL}}}global.css" rel="stylesheet" type="text/css"/>
    <link href="{{{$mediaURL}}}css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    @section("otherCss")

        @show
</head>
@yield("content")
@section("footer")
    <div class="copyright">
        河北一卡通互联网后台管理系统      v1.0

        河北一卡通电子支付有限公司      版权所有 2015-2016      意见反馈：master@966009.com
    </div>
@show
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{{$mediaURL}}}js/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{{$mediaURL}}}js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/bootstrap.min.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="{{{$mediaURL}}}js/excanvas.min.js"></script>
<script src="{{{$mediaURL}}}js/respond.min.js"></script>
<![endif]-->
<script src="{{{$mediaURL}}}js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/jquery.cookie.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/jquery.uniform.min.js" type="text/javascript" ></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{{$mediaURL}}}js/jquery.backstretch.min.js" type="text/javascript"></script>
<script>
    var baseURL = "<?php echo $baseURL .'/' ?>";
    var jsURL = baseURL + "asset/js/";
    var cssURL = baseURL + "asset/css/";
    var media = baseURL + "media/"
</script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section("otherJs")
    @show
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>