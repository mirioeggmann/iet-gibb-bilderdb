<div class="row">
    <form action="../../user/doEdit" method="post" autocomplete="off" class="col s12 m12 l8">
        <div class="row">
            <div class="input-field col s6">
                <input value="<?php echo $user->firstName; ?>" id="firstName" name="firstName" type="text" class="validate">
                <label for="firstName">First Name</label>
            </div>
            <div class="input-field col s6">
                <input value="<?php echo $user->lastName; ?>" id="lastName" name="lastName" type="text" class="validate">
                <label for="lastName">Last Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $user->userName; ?>" id="userName" name="userName" type="text" class="validate">
                <label for="userName">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input value="<?php echo $user->email; ?>" id="email" name="email" type="email" class="validate">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button id="userEdit" name="userEdit" class="btn waves-effect blue" type="submit">Bearbeiten
                </button>
            </div>
        </div>
    </form>
</div>
