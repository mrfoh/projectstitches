<?php

return [

    'appNameIOS'     => [
        'environment' =>'development',
        'certificate' =>'/path/to/certificate.pem',
        'passPhrase'  =>'password',
        'service'     =>'apns'
    ],
    'stitches' => [
        'environment' =>'production',
        'apiKey'      => env('GCM_APIKEY'),
        'service'     =>'gcm'
    ],
];