<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2019072565935643",
		//编码格式
		'charset' => "UTF-8",
		//签名方式
		'sign_type'=>"RSA2",
		//scope auth_user获取用户信息; auth_base静默授权
		'scope' => 'auth_user',
		//跳转地址
		'redirect_url' => 'http://'.$_SERVER['HTTP_HOST'].'/home/login/alicallback',
        //支付宝授权地址 沙箱环境
//        'oauth_url' => 'https://openauth.alipaydev.com/oauth2/publicAppAuthorize.htm',
        //支付宝授权地址 正式环境
         'oauth_url' => 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm',
        //支付宝网关 沙箱环境
//        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",
        //支付宝网关 正式环境
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEApaXarHkOgEBb2PmnepHAl/gbThrXYzAG+cg4gjgpwXWLd+QZyt3toD5YyzS/pIdQEcB0dBkmEJa2HRrvktEigB5FYdWVLZSQ0y4HGAYyCaBYNBvwG6X3ggEzD4YGnaPaGeuCvTRGnDwQmc3iYvFpRIuEiLIwWNdcTn3jQ2XOteh5PmiOAT20zvw7dqaUv4iewjCJLa5UX+awAWQB0JUfTcNydK/eAENkVGQYMZYNCIuW6vkVrV74rawgxdB0laQQ6q4JMW4/7BKJoV+NmqDYVP8q1IFQKDlD/NELE8txaQ7fy3+UGs7oDz/OwOmGul9uN0wUGMCv65BXXfhUf4Y50wIDAQABAoIBAEP/pJe+jhRZ1xpnybeIE46O2+6hGB/wfDyXU5MpKQLwlNMfgPMFTWHFlj+8pJsOrPDMl0F9fWG77IBgKU6UqVv8kTDLM5Tlctot/9191ZacCvlBKry+0a69fU93DkoyE/sl8aJnzkCea5YnrTI+tZ7cwwg2VaByr8LM7LkjFssXPXAvg2/qBYQgpTxICRfEY7K9y6oFwaxAzOFvjowk+UPPA5sNPmedD+/0lWswx4KgrgH0mfYenYZgHYgeu+GHhWA5N2rGNVC9VuaFR8N5Ir6NRG3pV2DQCsetO1iWrNTbKR4YdWuxqQybjdJJ8+GuFYHv0iJdcpR+6hwoW5RWofkCgYEA0OT5FLdK3C66hOa1Qc8zSZSlEPAFvZMFcrkfZLuKpnqbWnmbCyGQA4B2paKS1nVM54tMQoxXdBfC+g9kjZP5f1ErTbUAfRFEMqi5zVedCRkCZUVz319x6qv7iCy0fnMXHEx/wF1pjIo9K0k4Q/u/XoylGCre9qOCYrlpRMt9Fo8CgYEAywBZqG9XQF1IrNaEjmxRYRmMNUMFeXHDSGT0HuhDxXwwtf9RNx5sNI+P4FpBfI8c/lkEkcmfWnDXVEpXC0Spir3E7UDJwf1BijII5F3XK2CkQdTrMOAnmo7POKTmAYikdEkFXq038RC0PpCduTL7r47kVyd3C0wriykz6cu1an0CgYEAnu9H0AoxK9tl0E5UZHDIfdhZysxEIduljobpKtRCBq5MWwcg/tQXZYKtQxKxk/gFfjoO2Kc8triJgYaKo+mNL+BLCUGI0J99eunDDEf30/8yQmkYY0CURM97fj09SuQ4FjDiFjM8ZlCbf76iz57QGJj716pun8sCHikhvdTxJGMCgYEAlm/JAaiZWUqIDAXhMAaXfETJgcMMMIac+G5P9wObDaPOGWF/F0DFYWIudk2MkDkifF8Nothu7kAHYyDARsp4difR4xyLJ+Z9hmMz8cCVL0EsGNkn/g1va/t/F3QkO2i+rqpaf2IQveXqHR9gsxlUKTLUhr3pW4b0EenT3eOnqqUCgYAeNGIsz5Wd5/5Y2ardRSF8BF+uudXKe7zc3jVT2i4mbWFfS2X9nrKQyuGXC3t9Ktoza/l/h94+ohAWf+vipsd0ycw/TAKU+XJN0GTXjsYLeRlwcMGYZXZNkbqmCpQT1xj8roNZ1dE6XE3AsEGXSctqBt94rEfbQWhJgHSouaAtwQ==",

);