<?php

/* Prevent unauthorized access */
if (! defined ( "INSITE" ))die ( "No direct access allowed!" );

/**
 * Class Captcha
 *
 * Defines the Captcha class - generate CAPTCHAs
 * to create a safe Captcha image
 *
 * @package PHP Captcha Class
 * @author  Gonçalo Fontoura gesf
 * @copyright 2005 Gonçalo "gesf" Fontoura.
 * @license Licensed under the GNU L-GPL
 * @link https://github.com/gesf/captcha.class.php
 * @version 1.1 
 */

/* Class Start */
class Captcha {
	
	/**
	 * Set Captcha Mode
	 *
	 * @var number
	 * @name $_capMode
	 * 2 : normal
	 * 4 : medium
	 * 6 : strong
	 */
	var $_capMode = 4;
	
	/**
	 * Set Captcha Lenght
	 *
	 * @var number
	 * @name $_capLength
	 */
	var $_capLength = 6;
	
	/**
	 * Store Captcha String
	 *
	 * @var string
	 * @name $_capString
	 */
	var $_capString;
	
	/**
	 * Captcha Image Type
	 *
	 * @var string
	 * @name $_capImageType
	 */
	var $_capImageType = 'png';
	
	/**
	 * Captcha Image Fonts
	 *
	 * @var string
	 * @name $_capFont
	 */
	var $_capFont = 'fonts/captcha.ttf';
	
	/**
	 * Captcha Default Character Width
	 *
	 * @var number
	 * @name $_capCharWidth
	 */
	var $_capCharWidth = 25;
	
	/**
	 * Captcha Default Text Color
	 *
	 * @var string
	 * @name $_capTextColor
	 */
	var $_capTextColor = 'FFFFFF';
	
	/**
	 * Captcha Default Background Color
	 *
	 * @var string
	 * @name $_capBgColor
	 */
	var $_capBgColor = '0070C2';
	
	/**
	 * To Store the Captcha String Type
	 *
	 * @var number
	 * @name $_capCase
	 */
	var $_capCase = 5;
	
	/**
	 * Stores the Captcha Image Height
	 *
	 * @var number
	 * @name $_capimage_height
	 */
	var $_capimage_height = 40;
	
	/**
	 * The Captcha Text Padding
	 *
	 * @var number
	 * @name $_capimage_padding
	 */
	var $_capimage_padding = 0;
	
	/**
	 * Class Constructor
	 *
	 * Call needed methods and gerenate CAPTCHA right away .
	 *
	 * @param string $letter        	
	 * @param number $case        	
	 */
	public function Captcha($letter = '', $case = 5) {
		$this->_capCase = $case;
		if (empty ( $letter )) {
			$this->StringGen ();
		} else {
			$this->_capLength = strlen ( $letter );
			$this->_capString = substr ( $letter, 0, $this->_capLength );
		}
		@session_start ();
		$_SESSION ["CAPTCHA_HASH"] = sha1 ( $this->_capString );
		$this->SendHeader ();
		$this->MakeCaptcha ();
	}
	
	/**
	 * Generate CAPTCHA string
	 *
	 * String Type:
	 * 0 : Lowercase Letters (a-z).
	 * 1 : Uppercase Letters (A-Z).
	 * 2 : Numbers Only (0-9).
	 * 3 : Letters Only (upper and lower case).
	 * 4 : Lowercase Letters and Numbers.
	 * 5 : Uppercase Letters and Numbers.
	 * 6 : All together
	 */
	public function StringGen() {
		$uppercase = range ( 'A', 'Z' );
		$lowercase = range ( 'a', 'z' );
		$numeric = range ( 0, 9 );
		$char_pool = array ();
		switch ($this->_capCase) {
			case 0 :
				$char_pool = $lowercase;
				break;
			case 1 :
				$char_pool = $uppercase;
				break;
			case 2 :
				$char_pool = $numeric;
				break;
			case 3 :
				$char_pool = array_merge ( $uppercase, $lowercase );
				break;
			case 4 :
				$char_pool = array_merge ( $lowercase, $numeric );
				break;
			case 5 :
				$char_pool = array_merge ( $uppercase, $numeric );
				break;
			case 6 :
				$char_pool = array_merge ( $uppercase, $lowercase, $numeric );
				break;
			default :
				$char_pool = array_merge ( $uppercase, $numeric );
		}
		$pool_length = count ( $char_pool ) - 1;
		for($i = 0; $i < $this->_capLength; $i ++) {
			$this->_capString .= $char_pool [mt_rand ( 0, $pool_length )];
		}
	}
	
	/**
	 * Captcha Header Setting
	 * 
	 * Sends the proper Content-type
	 */
	public function SendHeader() {
		switch ($this->_capImageType) {
			case 'jpeg' :
				header ( 'Content-type: image/jpeg' );
				break;
			case 'png' :
				header ( 'Content-type: image/png' );
				break;
			case 'gif' :
				header ( 'Content-type: image/gif' );
				break;
			default :
				header ( 'Content-type: image/png' );
				break;
		}
	}
	
	/**
	 * Create Captcha
	 * 
	 * Generate the image based on all the settings
	 * @version 1.1 
	 */
	public function MakeCaptcha() {
		$imagelength = $this->_capLength * $this->_capCharWidth + $this->_capimage_padding;
		$image = imagecreate ( $imagelength, $this->_capimage_height );
		$bgcolor = imagecolorallocate ( $image, hexdec ( substr ( $this->_capBgColor, 0, 2 ) ), hexdec ( substr ( $this->_capBgColor, 2, 2 ) ), hexdec ( substr ( $this->_capBgColor, 4, 2 ) ) );
		$stringcolor = imagecolorallocate ( $image, hexdec ( substr ( $this->_capTextColor, 0, 2 ) ), hexdec ( substr ( $this->_capTextColor, 2, 2 ) ), hexdec ( substr ( $this->_capTextColor, 4, 2 ) ) );
		$linecolor = imagecolorallocate ( $image, 0, 0, 0 );		
		for ($i = 0; $i <= 2; $i++) {
			$captcha_image_lcolor[] = imagecolorallocate($image, hexdec ( substr ( $this->_capTextColor, 0, 2 ) ), hexdec ( substr ( $this->_capTextColor, 2, 2 ) ), hexdec ( substr ( $this->_capTextColor, 4, 2 ) ));
		}       
		for($j = 0; $j <= $this->_capMode; $j ++) {
			if ($this->_capMode % ($j+1) === 0) {
				for($i = 0; $i <= 10; $i ++) {
					imageline ( $image, $i * 20 + mt_rand ( 4, 26 ), 0, $i * 20 - mt_rand ( 4, 26 ), 39, $captcha_image_lcolor [mt_rand ( 0, 2 )] );
				}
			} else {
				for($i = 0; $i <= 10; $i ++) {
					imageline ( $image, $i * 20 + mt_rand ( 4, 26 ), 39, $i * 20 - mt_rand ( 4, 26 ), 0, $captcha_image_lcolor [mt_rand ( 0, 2 )] );
				}
				
			}
		}		
		imagettftext ( $image, $this->_capCharWidth, 4, 18, 34, $stringcolor, $this->_capFont, $this->_capString );
		switch ($this->_capImageType) {
			case 'jpeg' :
				imagejpeg ( $image );
				break;
			case 'png' :
				imagepng ( $image );
				break;
			case 'gif' :
				imagegif ( $image );
				break;
			default :
				imagepng ( $image );
				break;
		}
		imagedestroy ( $image );
	}
	
	/**
	 * Some additional methods you might want to use
	 *
	 * Returns the CAPTCHA string as it is
	 *
	 * @return string
	 */
	public function GetCaptchaString() {
		return $this->_capString;
	}
	
	/**
	 * Returns the CAPTCHA hash
	 *
	 * @return string
	 */
	public function GetCaptchaHash() {
		return $_SESSION ["CAPTCHA_HASH"];
	}
}/* End Class Captcha */
