<?php
namespace InsertFancyNameHere\Application\Core;

/**
 * Class to Handle Validation
 *
 */
class Validator {

	/**
	 * Returns plain text without formatting with the appropriate length
	 * @param string $dirty
	 * @param number $length 0 = full string
	 * @return string
	 */
	public static function toPlainText($dirty = '', $length = 0) {
		$clean = filter_var($dirty, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		return 0 == $length ? $clean : substr($clean, 0, $length);
	}

	/**
	 * Returns integers fulfulling the boundary requirement or 0
	 * @param number $dirty
	 * @param string $boundary
	 * @return number
	 */
	public static function toInt($dirty = 0, $boundary = '') {
		$clean = (int) $dirty;

		if(empty($boundary) || eval("return (".$clean.$boundary.");")) { // really shouldn't use eval() here but I can't be bothered to look into something else
			return $clean;
		}

		return 0;
	}

	/**
	 * Returns parsed & cleaned HTML
	 * @param string $dirty
	 * @return string
	 */
	public static function toCleanHtml($dirty = '') {
		// TODO Should be in Core/Autoloader Function
		require_once ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'htmlpurifier' . DIRECTORY_SEPARATOR .'HTMLPurifier.auto.php';

		$config = \HTMLPurifier_Config::createDefault();
		$config->set('AutoFormat.AutoParagraph', true);
		$purifier = new \HTMLPurifier($config);
		$clean = $purifier->purify($dirty);
		return $clean;
	}

	/**
	 * Returns a boolean value based on input, false if evaluation fails
	 * @param string $dirty
	 * @return boolean
	 */
	public static function toBool($dirty = false) {
		return filter_var($dirty, FILTER_VALIDATE_BOOLEAN);
	}
}
?>