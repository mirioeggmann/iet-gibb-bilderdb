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
                <a class="btn waves-effect blue" href="../user/doDelete" type="button">Delete Account
                </a>
            </div>
        </div>
    </form>
</div>

