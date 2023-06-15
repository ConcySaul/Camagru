<?php

function    returnHeader() {
    echo (
        "
        <header>
            <nav class='neon-border'>
                <ul id='nav-list'>
                    <!-- <li class='nav-li'id='logo'><span>LOGO</span></li> -->
                    <li class='nav-li' id='profile'><a href='/Profile' data-title='profile'>Profile</a></li>
                    <li class='nav-li'><a href='/Home' data-title='home'>Home</a></li>
                    <li class='nav-li' id='logout'><a href='/Logout' data-title='About'>Logout</a></li>
                </ul>
            </nav>
        </header>
    "
    );
}
