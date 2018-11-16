<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:08
 */
?>
<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean">
        <div class="container"><a class="navbar-brand" href="../index.html"><i class="fa fa-map-o"></i>&nbsp;SpotFinder</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="register.html"><i class="fa fa-plus"></i>&nbsp;Spot</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="register.html">Find Spot</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="editUser.html">Edit Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container spot-container">
    <form method="post">
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <fieldset disabled=""><input class="form-control" type="text" name="s_ID" required="" placeholder="ID"></fieldset>
            </div>
        </div>
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><input class="form-control" type="text" name="s_title" required="" placeholder="spot name"></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col"><iframe allowfullscreen="" frameborder="0" width="100%" height="400" src="https://www.google.com/maps/embed/v1/search?key=AIzaSyCuXnCcm1Sq61688xAtHoCGRA5GcNYVxTA&amp;q=Big+Ben&amp;zoom=11" class="gmaps" style="max-height: 300px;padding-right: 0;"></iframe></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><input class="form-control" type="text" name="s_address" required="" placeholder="Langackerstrasse 11, 4142 Münchenstein"></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><select class="form-control" name="s_category" required=""><optgroup label="Category"><option value="0" selected="">Freestyle</option><option value="1">Racing</option><option value="2">Both</option></optgroup></select></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><textarea class="form-control" rows="6" name="s_comment" placeholder="additional comments?"></textarea></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4"><button class="btn btn-primary btn-block save" type="submit" style="margin-top: 0;">Save&nbsp;<i class="la la-save"></i></button></div>
        </div>
    </form>
</div>
