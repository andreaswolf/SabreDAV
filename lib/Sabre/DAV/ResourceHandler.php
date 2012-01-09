<?php

/**
 * SabreDAV Resource Handler.
 *
 * This encapsulates a stream
 *
 * @package Sabre
 * @subpackage DAVClient
 * @copyright Copyright (C) 2007-2011 Rooftop Solutions. All rights reserved.
 * @author Andreas Wolf <andreas.wolf@ikt-werk.de>
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class Sabre_DAV_ResourceHandler {

	protected $readPointer = 0;

	protected $writePointer = 0;

	protected $writeHandle;

	/**
	 * @param resource $writeHandle Optional file pointer to write response contents to. If not set, writing the response is not possible!
	 */
	public function __construct($writeHandle = NULL) {
		$this->writeHandle = $writeHandle;
	}

	public function readCallback($curlHandle, $fileHandle, $length) {
		if (!feof($fileHandle)) {
			$contents = fread($fileHandle, $length);
			return $contents;
		} else {
			return 0;
		}
	}

	public function writeCallback($curlHandle, $data) {
		if (!$this->writeHandle) {
			// TODO fail
		}

		$length = fwrite($this->writeHandle, $data);

		return $length;
	}
}