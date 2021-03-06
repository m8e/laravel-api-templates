<?php

return [
    'commands'                        => env('REGISTER_COMMANDS', false),
    'factories'                       => env('REGISTER_FACTORIES', false),
    'migrations'                      => env('REGISTER_MIGRATIONS', false),
    'translations'                    => env('REGISTER_TRANSLATIONS', false),
    'views'                           => env('REGISTER_VIEWS', false),
    'policies'                        => env('REGISTER_POLICIES', false),
    'api_routes'                      => env('REGISTER_API_ROUTES', false),
    'will_check_device_is_authorized' => env('WILL_CHECK_DEVICE_IS_AUTHORIZED', false)
];
