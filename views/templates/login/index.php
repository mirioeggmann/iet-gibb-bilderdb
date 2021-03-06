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
	<form action="login/doLogin" method="post" autocomplete="off"
		class="col s12 m12 l8">
		<div class="row">
			<div class="input-field col s12">
				<input value="<?php echo $email; ?>" id="email" name="email"
					type="text" class="validate"> <label for="email">Email or Username</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<input id="password" name="password" type="password"
					class="validate"> <label for="password">Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<button class="btn waves-effect blue" type="submit" id="login"
					name="login">Login</button>
				 or <a class="" href="../register"">Register
				</a>
			</div>
		</div>
	</form>
</div>
