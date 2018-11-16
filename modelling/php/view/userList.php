<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:13
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
            <tr>
                <td>1</td>
                <td>schomber</td>
                <td>Martin Peraic</td>
                <td>martin.peraic@students.fhnw.ch</td>
                <td>
                    <div class="btn-group" role="group"><button class="btn btn-secondary" type="button"><i class="fa fa-edit"></i></button><button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>menogu</td>
                <td>Philipp Labhart</td>
                <td>boba@partyheld.de</td>
                <td>
                    <div class="btn-group" role="group"><button class="btn btn-secondary" type="button"><i class="fa fa-edit"></i></button><button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
