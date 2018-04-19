<?php

/* Collection of walker class */

    /*

        wp_nav_menu()

        <div class="menu-container">
            <ul> // start_lvl()
                <li><a><span> // start_el()

                </a></span></li> // end_el()

                <li><a>link</a></li>
                <li><a>link</a></li>
                <li><a>link</a></li>
            </ul> // end_lvl()

        </div>

     */

/**
 * Walker_Nav_Primary
 */
class Walker_Nav_Primary extends Walker_Nav_Menu
{

    function start_lvl() // ul
    {
        # code...
    }

    function start_el() // li a span
    {
        # code...
    }

    // function end_el() // closing li a span
    // {
    //     # code...
    // }
    //
    // function end_lvl() // closing ul
    // {
    //     # code...
    // }

}

 ?>
