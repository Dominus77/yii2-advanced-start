<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 26.10.16
 * Time: 14:05
 */
?>
<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?= $data['avatar']; ?>"
             alt="User profile picture">

        <h3 class="profile-username text-center"><?= $data['username']; ?></h3>

        <p class="text-muted text-center"><?= $data['role']; ?></p>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Followers</b> <a class="pull-right">1,322</a>
            </li>
            <li class="list-group-item">
                <b>Following</b> <a class="pull-right">543</a>
            </li>
            <li class="list-group-item">
                <b>Friends</b> <a class="pull-right">13,287</a>
            </li>
        </ul>

        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->