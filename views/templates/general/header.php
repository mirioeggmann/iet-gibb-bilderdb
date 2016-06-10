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

<?php session_start(); ?>
<header>
    <div class="navbar-fixed">
        <ul id="dropdown1" class="dropdown-content">
            <li class="light-blue darken-4"><p class="center white-text"><?php echo $_SESSION['userName']; ?></p></li>
            <li class="divider"></li>
            <li><a href="/user">Profile</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
        <nav class="light-blue darken-4" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="/home" class="brand-logo">LycheZ</a>
                <ul class="right hide-on-med-and-down">
                    <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
                        <li><a href="/album/create" title="Create album"><i class="material-icons">add</i></a></li>
                        <li><a href="/upload" title="Upload photos"><i class="material-icons">cloud_upload</i></a></li>
                    <?php endif; ?>
                    <li><a href="/home" title="Home"><i class="material-icons">home</i></a></li>
                    <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
                        <li><a href="/photos" title="Photos"><i class="material-icons">photo</i></a></li>
                        <li><a href="/albums" title="Albums"><i class="material-icons">collections</i></a></li>
                        <li><a href="/user" title="View profile and more"
                               class="dropdown-button" data-activates="dropdown1"><i
                                    class="material-icons right">arrow_drop_down</i><i
                                    class="material-icons">perm_identity</i></a></li>
                    <?php endif; ?>
                    <!-- just show when logged in-->
                    <?php if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']): ?>
                        <li><a href="/login" class="waves-effect center">Sign In</a></li>
                        <li><a href="/register" class="waves-effect blue btn">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <ul id="nav-mobile" class="side-nav"
                    style="transform: translateX(-100%);">
                    <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
                        <li><a href="/album/create"><i class="material-icons left">add</i>Create album</a></li>
                        <li><a href="/upload"><i class="material-icons left">cloud_upload</i>Upload photos</a></li>
                    <?php endif; ?>
                    <li><a href="/home"><i class="material-icons left">home</i>Home</a></li>
                    <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
                        <li><a href="/photos"><i class="material-icons left">photo</i>Photos</a></li>
                        <li><a href="/albums"><i class="material-icons left">collections</i>Albums</a></li>
                        <li><a href="/user"><i class="material-icons left">perm_identity</i>
                            Profile</a></li>
                        <li><a href="/logout" class="waves-effect blue btn">Logout</a></li>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']): ?>
                        <li><a href="/login" class="waves-effect center">Sign In</a></li>
                        <li><a href="/register" class="waves-effect blue btn">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i
                        class="material-icons">menu</i></a>
            </div>
        </nav>
    </div>
</header>
