<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016101300676934",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCC44ob1141Bhrj5DaGQmrEyCIjQWzUB4/dyyT3LGc+9qMyv7iC56BvjKhyBiWpM5q/35/nqk+zva4QyjEDzQXozr+4aFmvuY9vMEliLejjoh9BXYWYAkwBaSEKkTBSdqDV8TXVhJEinKlIoJrcAuPxCjOpXVTNuT6VCxBtirnO3uC0Fr4JqhZEYyMCSVcmB6+KPX9MR+Xj+tVrhgAlcU+map8pgChgQsahuaRWDxs2z6Fx48V7ElscMf5LEbfWORfo1wgNv63v+20lLjzDB8UV0lo+wSuupx224VnGaHKSI2EhXiMyqBXfCeqbLNeGe2sHg0o/j6wJrr2IEMjg/EGLAgMBAAECggEAMoO4kIgs/o/Nnvg7ptNJO4r1yd99LdOBTZsSOCa17hHn6DUf872LKKIDfIYs0MFuzvByWUlcm0TwQeCWzB27Ux8/1N7JBk26MrJTEAYh5IB0SZjbb1ArnzvAmcBxAtJvvkHqge44yT/nAXWibpja+fLy/0Fa8k60/XaYr34judet7un79yyp+hmBuMY3FJKGlTTHDZJapMkzSHAIbi3UaZuh41cv1wwfvimrVl3frXKjb51V48/43FW6tY7sI6GGd8BqqryHOm/x96yFhsbOjnHN/9yMhUqBWlECyzG7gGLTIT9b9nSMJ4m1Mn1FbDbHEOOO00ypPH5wOPYGUMh5iQKBgQDxTFiv6pJS82017Pq+mkztVbNYI5IBc5CkJkBfCZdMJL+/2IssIEd6ItQ+Ka3FyS8/syAlH+ZCkOH7MdWq6vHP8azDCKGhufu6am7IYmjnYN6Ag+7/4r9XKBC0XIN30Bo+CG1FtbKKbqOHcaqEQfwufdVZB5JnNUM6SoueAWnuxwKBgQCK3RSS7CVDajA3iIJZE6nifCo9e7Y5YuyyYe66gE28TFZk8F4vZBCQ4gfjQMM0/GfTIeUvC7sf1q4zgZb2t59Q3AAhTNNKo9L6UmQ6hUbeDv0Y0ddwwUxDplfylkqm3us2jMubNIFTKdCakIejzv70jtXF1G43z+YlaT319fEjHQKBgC1wF/9AZ79xEW6nKmx79+J1UelWAWd+kI0omtSKpM/015rTtxlfFracGmV+SbfF87zGCVaUVDLSv4sizj56MYDb3JF5bZ5bvFhVNHlNdr2jUyLWNUpAM5HA/KxKA4OrT1XBFnqbBXzl6qtVrytqlYdXsLYsI9iFghxW70WYtI7/AoGADMoX3wBI3lClaDf2aWXaO7Xb3hXKzrZBvpwudJbkkfcl7d4Fjq/UpsNqno+UawjkNxnkFdUqwt/u42eIE+kNj1Dz4h1FSJaWE+AKwykLQeB3hxWslgH3mDN13i3hakUVvMxy5DSNxK8RO2scUwX5jWSqY7IRBKrtM3zh7Ale0DECgYEA6zIG1PwxLIQ66KdowysipHHTeM3J7larKcCQs9DwdlSFX9PU9mvCApWQuvOIav/4MnbqzF9c0KNMqp3AMG6VFSUlJIerrIQtz3kw9DBZYN+NV6tc/KKa8CIc8Faj5//LWJoyqy5PTcCod3po5oZ2RD+FyKrL66m0VqSTfO5ntgQ=",
		
		//异步通知地址
		'notify_url' => "http://localhost/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://localhost/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzrh4YWRN9gQqsS4JNNuJMSPxZW9MA658jW0LDNSU61+WAOAStntmrx6wXpCycNAjGK4YGHs8WgBWW0b5keRBYPO/u/v501kg6Q84NVLzi4ge12ycUHnR1DCxFHA2kuopuZS+f4BQ/rP3hEHKvfRLNbkBM4YT/4C5veJd4/P2EZIj4yd5kiBZjgX3QgiPsNLneFWKi7ES1uxvpxUoTJNjKaJIRQVR0JULzUkM6apnCcLKhzLvPpPFnDoWBE9VjKvaE6MpOekuOA0q3ShAaPIGLqA6celmNCv5ax9iltS+fzUV3JMwozvwvGYp2J83zvT3uzAH6F+9aEE+YO3RBZ3HjwIDAQAB",
		
	
);