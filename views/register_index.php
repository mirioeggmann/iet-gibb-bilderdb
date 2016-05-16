<div class="row">
  <form action="register/doRegister" method="post" autocomplete="off" class="col s12">
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
        <label for="userName">Username</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input value="<?php echo $email; ?>" id="email" name="email" type="email" class="validate">
        <label for="email">Email</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password" name="password" type="password" class="validate">
        <label for="password">Password</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password2" name="password2" type="password" class="validate">
        <label for="password2">Confirm password</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <button id="register" name="register" class="btn waves-effect blue" type="submit">Register
        </button>
      </div>
    </div>
  </form>
</div>
