<?php

namespace KutnyLib\Jenkins;

use KutnyLib\BuzzBrowser\BuzzBrowserFactory;
use Buzz\Message\Response;
use Symfony\Component\HttpFoundation\Request;

class ActionRunner {

	private $buzzBrowserFactory;
	
	public function __construct(BuzzBrowserFactory $buzzBrowserFactory) {
		$this->buzzBrowserFactory = $buzzBrowserFactory;
	}

	public function runGetAction(JenkinsConfig $jenkinsConfig, $actionPath, array $getParams = array()) {
		$buzzBrowser = $this->buzzBrowserFactory->createBuzzBrowser();
		$apiPath = $this->buildApiPath($actionPath, $getParams, $jenkinsConfig->getToken());

		$request = $this->createRequest('GET', $apiPath, $jenkinsConfig);
		$response = new Response();

		$buzzBrowser->send($request, $response);

		return $response->getContent();
	}

	public function runPostAction(JenkinsConfig $jenkinsConfig, $actionPath, array $getParams = array(), $postData = null) {
		$buzzBrowser = $this->buzzBrowserFactory->createBuzzBrowser();
		$apiPath = $this->buildApiPath($actionPath, $getParams, $jenkinsConfig->getToken());

		$request = $this->createRequest('POST', $apiPath, $jenkinsConfig);

		if ($postData) {
			$request->setContent($postData);
		}

		$response = new Response();

		$buzzBrowser->send($request, $response);

		return $response->getContent();
	}

	private function createRequest($method, $apiPath, JenkinsConfig $jenkinsConfig) {
		$request = new \Buzz\Message\Request($method, $apiPath, $jenkinsConfig->getHost());
		$request->addHeader('Authorization: Basic ' . base64_encode($jenkinsConfig->getUsername() . ':' . $jenkinsConfig->getPassword()));

		return $request;
	}

	private function buildApiPath($actionPath, array $getParams, $jenkinsToken) {
		$getParams['token'] = $jenkinsToken;

		return $actionPath . '?' .  http_build_query($getParams);
	}

}
