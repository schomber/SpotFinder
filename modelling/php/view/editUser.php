<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:09
 */
use view\TemplateView;
use domain\Customer;
use services\AuthServiceImpl;

isset($this->customer) ? $customer = $this->customer : $customer = new Customer();
//$this->customer;
?>
<div style="text-align: center; width: 100%;">
    <?php if (AuthServiceImpl::getInstance()->verifyAdminExists() || (AuthServiceImpl::getInstance()->verfiyAdmin() && $this->customer->getRoleid()!==1) ) {?>
    <a class="adminButton btn" type="button" href="role/createAdmin?id=<?php echo $customer->getID() ?>" >Elevate to Admin</a>
    <?php } ?>
</div>
<div class="login-clean">
    <form method="post" action="update">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="icon ion-edit"></i></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="id" readonly value="<?php echo TemplateView::noHTML(!empty($customer->getId()) ? $customer->getId() : ''); ?>"></div>
        <div class="form-group blocked"><input class="form-control" type="text" name="username" readonly value="<?php echo TemplateView::noHTML(!empty($customer->getUsername()) ? $customer->getUsername() : ''); ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="firstname" placeholder="name" value="<?php echo TemplateView::noHTML(!empty($customer->getFirstname()) ? $customer->getFirstname() : ''); ?>"></div>
        <div class="form-group"><input class="form-control" type="text" name="surname" placeholder="" value="<?php echo TemplateView::noHTML( !empty($customer->getSurname()) ? $customer->getSurname() : ''); ?>"></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="email" value="<?php echo TemplateView::noHTML(!empty($customer->getEmail()) ? $customer->getEmail() : ''); ?>"></div>
        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="password" value=""></div>
        <div class="form-group"><button class="btn btn-primary btn-block save" type="submit">Save&nbsp;<i class="la la-save"></i></button></div>
    </form>
</div>
