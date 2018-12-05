<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:13
 */
?>
<div class="container spot-container"></div>
<div class="container list-header"><h1 class="text-center">User Management</h1>
    <div class="table-responsive">
        <table class="table">
            <thead class="text-left">
            <tr>
                <th>ID</th>
                <th>USER</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ACTION</th>
            </tr>
            </thead>
            <tbody class="text-left">
            <?php
            global $customers;
            foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo $customer->getID(); ?></td>
                <td><?php echo $customer->getUsername(); ?></td>
                <td><?php echo $customer->getFirstname() ." ". $customer->getSurname(); ?></td>
                <td><?php echo $customer->getEmail() ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="user/edit?id=<?php echo $customer->getID() ?>" class="btn btn-secondary" type="button">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="user/delete?id=<?php echo $customer->getID() ?>"class="btn btn-danger" type="button">
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>
                </td>

            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
