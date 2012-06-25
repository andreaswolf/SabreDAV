<?php

interface Sabre_DAV_ClientObserverInterface {

	/**
	 * This method is executed after a request has been completed by SabreDAV, regardless of the result (successful or
	 * not).
	 *
	 * @param array $curlSettings
	 * @param $response
	 * @return mixed
	 */
	public function notifyAfterRequest(array $curlSettings, $response);
}