<div class="row">
	<form action="login/doLogin" method="post" autocomplete="off"
		class="col s12 m12 l8">
		<div class="row">
			<div class="input-field col s12">
				<input value="<?php echo $email; ?>" id="email" name="email"
					type="text" class="validate"> <label for="email">Email</label>
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
			</div>
		</div>
	</form>
</div>
