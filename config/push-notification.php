<?php

return [

    'appNameIOS'     => [
        'environment' =>'development',
        'certificate' =>'/path/to/certificate.pem',
        'passPhrase'  =>'password',
        'service'     =>'apns'
    ],
    'co.reftek.stitchesvendor' => [
        'environment' =>'production',
        'apiKey'      =>env('GCM_KEY'),
        'service'     =>'gcm'
    ],
    'co.reftek.stitchesmarket' => [
        'environment' =>'production',
        'apiKey'      =>env('GCM_KEY'),
        'service'     =>'gcm'
    ]
];