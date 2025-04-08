<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Here you can configure values for headers related to security.
    |
    | @see https://owasp.org/www-project-secure-headers/
    |
    */

    'headers' => [
        'cross_origin_opener_policy' => env('SECURITY_HEADERS_CROSS_ORIGIN_OPENER_POLICY', 'same-origin'),
        'cross_origin_resource_policy' => env('SECURITY_HEADERS_CROSS_ORIGIN_RESOURCE_POLICY', 'same-origin'),
        'referrer_policy' => env('SECURITY_HEADERS_REFERRER_POLICY', 'no-referrer'),
        'strict_transport_security' => env('SECURITY_HEADERS_STRICT_TRANSPORT_SECURITY', 'max-age=31536000; includeSubDomains'),
        'x_content_type_options' => env('SECURITY_HEADERS_X_CONTENT_TYPE_OPTIONS', 'nosniff'),
        'x_frame_options' => env('SECURITY_HEADERS_X_FRAME_OPTIONS', 'deny'),

        'permissions_policy_append_string' => env('SECURITY_HEADERS_PERMISSIONS_POLICY_APPEND_STRING', ''),
        'permissions_policy' => [
            'accelerometer' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_ACCELEROMETER', '')),
            'autoplay' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_AUTOPLAY', '')),
            'camera' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_CAMERA', '')),
            'clipboard-read' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_CLIPBOARD_READ', '')),
            'clipboard-write' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_CLIPBOARD_WRITE', '')),
            'cross-origin-isolated' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_CROSS_ORIGIN_ISOLATED', '')),
            'display-capture' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_DISPLAY_CAPTURE', '')),
            'encrypted-media' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_ENCRYPTED_MEDIA', '')),
            'fullscreen' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_FULLSCREEN', '')),
            'gamepad' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_GAMEPAD', '')),
            'geolocation' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_GEOLOCATION', '')),
            'gyroscope' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_GYROSCOPE', '')),
            'hid' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_HID', '')),
            'idle-detection' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_IDLE_DETECTION', '')),
            'interest-cohort' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_INTEREST_COHORT', '')),
            'keyboard-map' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_KEYBOARD_MAP', '')),
            'magnetometer' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_MAGNETOMETER', '')),
            'microphone' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_MICROPHONE', '')),
            'midi' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_MIDI', '')),
            'payment' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_PAYMENT', '')),
            'picture-in-picture' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_PICTURE_IN_PICTURE', '')),
            'publickey-credentials-get' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_PUBLICKEY_CREDENTIALS_GET', '')),
            'screen-wake-lock' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_SCREEN_WAKE_LOCK', '')),
            'serial' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_SERIAL', '')),
            'sync-xhr' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_SYNC_XHR', '')),
            'unload' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_UNLOAD', '')),
            'usb' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_USB', '')),
            'web-share' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_WEB_SHARE', '')),
            'xr-spatial-tracking' => explode(',', env('SECURITY_HEADERS_PERMISSIONS_POLICY_XR_SPATIAL_TRACKING', '')),
        ],
    ],

];
