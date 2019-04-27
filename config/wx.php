<?php

return [
    'app_id' => env('WX_APP_ID', ''),
    'app_secret' => env('WX_APP_SECRET', ''),
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code"
];