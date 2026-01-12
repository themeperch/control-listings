<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'id'         => 'recaptcha_key',
        'name'      => 'Google reCaptcha site key',
        'type'       => 'text',
        'desc'  => 'Google reCaptcha site key (version 3). Optional.',
       
    ],
    [
        'id'         => 'recaptcha_secret',
        'name'      => 'Google reCaptcha secret key',
        'type'       => 'text',
        'desc'  => 'Google reCaptcha secret key (version 3). Optional.',
       
    ],
];