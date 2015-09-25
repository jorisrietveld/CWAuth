<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 13:42
 * Licence: GPLv3
 */

namespace CWAuth\Helper;

class Message
{
	// \m/ (^-^) \m/
	const ERROR_MESSAGE_XML_PARSER    = "ErrorMessage error: Can't parse the error messages xml file.";
	const ERROR_MESSAGE_UNDEFINED_KEY = "ErrorMessage error: The given key is not found in the error messages xml file.";

	const XML_FILE_PATH = PROJECT_ROOT . DIRECTORY_SEPARATOR . "Config" . DIRECTORY_SEPARATOR . "messages.xml";

	/**
	 * This method will return an message based on the key. the messages are defined in
	 * {project_root}/Config/messages.xml. The key consist out of segments separated by dots that represent an array.
	 *
	 * @param $key
	 *
	 * @return array
	 */
	public static function getMessage( $key )
	{
		$messages = self::parseXmlFile();

		$message = Arr::get( $messages, $key );

		if( $message )
		{
			return $message;
		}
		trigger_error( self::ERROR_MESSAGE_UNDEFINED_KEY, E_USER_ERROR );
	}

	/**
	 * This will return an array with all the error messages.
	 * @return array
	 */
	private static function parseXmlFile()
	{
		$errorMessagesFile = simplexml_load_file( self::XML_FILE_PATH );

		if( $errorMessagesFile )
		{
			$errorMessages = Arr::objectToArray( $errorMessagesFile );

			return $errorMessages;
		}
		else
		{
			trigger_error( self::ERROR_MESSAGE_XML_PARSER, E_USER_ERROR );
		}
	}


}