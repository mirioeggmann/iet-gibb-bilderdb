<?php

/**
 * Lychez : Image database (https://lychez.luvirx.io)
 * Copyright (c) luvirx (https://luvirx.io)
 *
 * Licensed under The MIT License
 * For the full copyright and license information, please see the LICENSE.md
 * Redistributions of the files must retain the above copyright notice.
 *
 * @link 		https://lychez.luvirx.io Lychez Project
 * @copyright 	Copyright (c) 2016 luvirx (https://luvirx.io)
 * @license		https://opensource.org/licenses/mit-license.php MIT License
 */
?>

<div class="row">
    <form action="#" method="post" autocomplete="off" class="col s12 m12 l8">
        <div class="row">
            <div class="input-field col s6">
                <input disabled value="<?php echo $user->firstName; ?>" id="firstName" name="firstName" type="text" class="validate">
                <label for="firstName">First Name</label>
            </div>
            <div class="input-field col s6">
                <input disabled value="<?php echo $user->lastName; ?>" id="lastName" name="lastName" type="text" class="validate">
                <label for="lastName">Last Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input disabled value="<?php echo $user->userName; ?>" id="userName" name="userName" type="text" class="validate">
                <label for="userName">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input disabled value="<?php echo $user->email; ?>" id="email" name="email" type="email" class="validate">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <a class="btn waves-effect blue" href="../user/edit" type="button">Edit Profile
                </a>
                <a class="btn waves-effect blue" href="../user/changepw" type="button">Change Password
                </a>
                <a class="btn waves-effect blue" href="../user/delete" type="button">Delete Account
                </a>
            </div>
        </div>
    </form>
</div>

