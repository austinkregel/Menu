<?php
return [
    'items'=> [
        'Some thing...' => [
            'link' => [
                'named::route', 
                [
                    'parameter'
                ]
            ], 
            'icon' => 'glyphicon glyphicon-user text-success'
        ],
        'Custom Icon' => [
            'link' =>[
                'other::namedroute', 
                function(){
                    return md5(Auth::user()->email);
                }
            ], 
            'icon' => 'glyphicon glyphicon-lock text-success'
        ]
    ],
    'custom-css-framework' => function($menu, $menuObject)
    {
        class d{public $thing = 'af';}
        return dd(new d);
        // If you want to use your own css-framework...
    }
];

