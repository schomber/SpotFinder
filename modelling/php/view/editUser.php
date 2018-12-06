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
        <div class="form-group blocked"><input class="form-control" type="text" name="id" readonly value="<?php echo !empty($customer->getId()) ? $customer->getId() : ''; ?>"></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="username" readonly value="<?php echo !empty($customer->getUsername()) ? $customer->getUsername() : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="firstname" placeholder="name" value="<?php echo !empty($customer->getFirstname()) ? $customer->getFirstname() : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="surname" placeholder="" value="<?php echo !empty($customer->getSurname()) ? $customer->getSurname() : ''; ?>"></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="email" value="<?php echo !empty($customer->getEmail()) ? $customer->getEmail() : ''; ?>"></div>
        <div class="form-group"><button class="btn btn-primary btn-block save" type="submit">Save&nbsp;<i class="la la-save"></i></button></div>
    </form>
</div>
