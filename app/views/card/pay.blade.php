<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>{{{$pageTitle}}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <style>
        body{background: #2baab1}
    </style>
    </head>
<body>
<section style="margin-left:300px;">
<div style="padding-top:5px;text-align: center;">
    <section style="width:50%">

        <header style="background: #fff;border-bottom: 0 none;border-right: 0 none;padding-top:1px;">
            <h5 class="text-center">让收银员扫描下面的条形码或者二维码</h5>
            <img src="<?php echo $barurl;?>" style="max-width: 100%;margin: 0 auto"/>

        </header>
        <div style="border:1px dotted #ddd;width: 90%;margin: 0 auto"></div>
        <div style="background: #fff;border-bottom: 0 none;border-right: 0 none;padding-top:1px;">
            <img src="<?php echo $qrurl;?>" style="max-width: 100%;margin: 0 auto"/>
        </div>
        <div style="width:100%"><button  type="button" onclick="location.href='<?php echo $repeatUrl;?>'" style="width: 100%; display: block; margin: 0 auto">重新生成</button></div>

    </section>
</div>
</section>
</body>
</html>