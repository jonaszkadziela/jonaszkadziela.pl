<?php

return [

    'rate_limit' => [
        'per_minute' => (int)env('API_RATE_LIMIT_PER_MINUTE', 60),
        'per_second' => (int)env('API_RATE_LIMIT_PER_SECOND', 10),
    ],

];
