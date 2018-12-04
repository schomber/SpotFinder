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
        <div class="form-group blocked"><input class="form-control" type="text" name="id" readonly value="<?php echo !empty($customer["id"]) ? $customer["id"] : ''; ?>"></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="username" readonly value="<?php echo !empty($customer["username"]) ? $customer["username"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="firstname" placeholder="name" value="<?php echo !empty($customer["firstname"]) ? $customer["firstname"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="surname" placeholder="" value="<?php echo !empty($customer["surname"]) ? $customer["surname"] : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="email" value="<?php echo !empty($customer["email"]) ? $customer["email"] : ''; ?>"></div>
        <div class="form-group"><button class="btn btn-primary btn-block save" type="submit">Save&nbsp;<i class="la la-save"></i></button></div>
    </form>
</div>
