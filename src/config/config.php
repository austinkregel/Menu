<?php
return [
    'brand' => [
        'name' => '<i class="fa fa-btn fa-sun-o"></i>Spark',
        'link' => '/'
    ],
    'theme' => 'navbar-default',
    'items'=> [
        // This menu will be shown regardless of whether or not
        // the login system is enabled!
        
        'Pricing' => [
            'link' => '#',
            'icon' => 'fa fa-money'
        ],
        'Like Things?' => [
            'link' => '#',
            'icon' => 'fa fa-line-chart'
        ]
    
    ],
    // If enabled this will add a login/logout button to your nav menu
    'login' => [
        'enabled' => true,
        'sign-in' => [
            // This menu will only be shown if the login system is enabled!
            // And is  only shown when the user is not logged in!
            'Login' =>[
                'link' => 'login',
                'icon' => 'fa fa-login'
            ],
            'Register' => [
                'link' => 'register',
                'icon' => 'fa fa-user-plus'
            ]
        ],
        'sign-out' => [
            // This is the main menu item, the rest is in a drop down.
            'My Account' => [
                // Drop down menu item that uses named route and a closure.
                'Logout' => [
                    'link' => 'logout',
                    'icon' => 'fa fa-btn fa-fw fa-sign-out'
                ]
            ]
        ]
    ],
    'custom-css-framework' => function($menu) {
        /**
         * Please note that this is NOT the recommended way to implement,
         * this is just meant to be a boiler plate for you to copy and
         * paste to make your own framework based menu handler. 
         */
        
        return new Namespacing\To\MyFramework;
    }
];

