<?php use view\TemplateView; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SpotFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean-1.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean">
        <div class="container"><a class="navbar-brand" href="<?php echo $GLOBALS["ROOT_URL"]; ?>/"><i class="fa fa-map-o"></i>&nbsp;SpotFinder</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button></div>
    </nav>
</div>

<div class="login-clean">
    <form name="form" action="<?php echo $GLOBALS["ROOT_URL"]; ?>/password/reset" method="post">
        <div class="illustration"><i class="icon ion-ios-rewind"></i></div>
        <input type="hidden" name="token" value="<?php echo TemplateView::noHTML($this->token);?>"/>
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <p class="help-block"></p>
        </div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Reset</button></div>
    </form>
</div>

<script src="assets/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>