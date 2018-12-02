<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:09
 */
global $customer;
?>
<div class="login-clean">
    <form method="post" action="update">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="icon ion-edit"></i></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="id" disabled="" value="<?php echo !empty($customer["uid"]) ? $customer["uid"] : ''; ?>"></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="username" disabled="" value="<?php echo !empty($customer["uusername"]) ? $customer["uusername"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="firstname" placeholder="name" value="<?php //echo !empty($customer["ufname"]) ? $customer["ufname"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="surname" placeholder="" value="<?php //echo !empty($customer["usname"]) ? $customer["usname"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="email" value="<?php // echo !empty($customer["semail"]) ? $customer["semail"] : ''; ?>"></div>
        <div class="form-group"><button class="btn btn-primary btn-block save" type="submit">Save&nbsp;<i class="la la-save"></i></button></div>
    </form>
</div>
