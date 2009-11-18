###Info

This is a simple CAPTCHA Class, written in PHP4. 

###Parameters

`s: user defined captcha text`

`c: captcha type`

More settings can be changed in the class ...

###How to use it

Just call the captcha.php file and pass the desired type and/or a predefined captcha text.

`captcha.php?s=123456`

Output: `123456`

`captcha.php?c=1&s=foobar`

Output: `FOOBAR`

`captcha.php?c=2&s=foobar`

Output: `A 6 digits random number (letters are discarded)`

`captcha.php?c=6`

Output: `A 6 digits random string (Lower/upper letters + numbers)`

CAPTCHA Types:

`0 : Lowercase Letters (a-z)`

`1 : Uppercase Letters (A-Z)`

`2 : Numbers Only (0-9)`

`3 : Letters Only (upper and lower case)`

`4 : Lowercase Letters and Numbers`

`5 : Uppercase Letters and Numbers`

`6 : All together`

###Example

The image:
`<img name="user_captcha" src="captcha.php?c=5" alt="" />`

Verification code (sample): See captcha.php file ...

###Requirements

This is a PHP4-like class, however it should work unchanged under PHP5.
You can find more details in the code...

###License

See gpl.txt and lgpl.txt for licensing terms.

