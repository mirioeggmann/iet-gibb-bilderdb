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
  <form action="register/doRegister" method="post" autocomplete="off" class="col s12 m12 l8">
    <div class="row">
      <div class="input-field col s6">
        <input value="<?php echo $firstName; ?>" id="firstName" name="firstName" type="text" class="validate">
        <label for="firstName">First Name</label>
      </div>
      <div class="input-field col s6">
        <input value="<?php echo $lastName; ?>" id="lastName" name="lastName" type="text" class="validate">
        <label for="lastName">Last Name</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input value="<?php echo $userName; ?>" id="userName" name="userName" type="text" class="validate">
        <label for="userName">Username*</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input value="<?php echo $email; ?>" id="email" name="email" type="email" class="validate">
        <label for="email">Email*</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password" name="password" type="password" class="validate">
        <label for="password">Password*</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password2" name="password2" type="password" class="validate">
        <label for="password2">Confirm password*</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <button id="register" name="register" class="btn waves-effect blue" type="submit">Register
        </button>
        or <a class="" href="../login"">Login
        </a>
      </div>
    </div>
  </form>
</div>
