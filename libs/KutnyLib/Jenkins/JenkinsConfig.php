<?php

namespace KutnyLib\Jenkins;

class JenkinsConfig {

	private $host;
	private $username;
	private $password;
	private $token;
	private $masterBranchName;
	private $templateJobName;

	/**
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $token
	 * @param string $masterBranchName
	 * @param string $templateJobName
	 */
	public function __construct($host, $username, $password, $token, $masterBranchName, $templateJobName) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->token = $token;
		$this->masterBranchName = $masterBranchName;
		$this->templateJobName = $templateJobName;
	}

	public function getHost() {
		return $this->host;
	}

	public function getMasterBranchName() {
		return $this->masterBranchName;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getTemplateJobName() {
		return $this->templateJobName;
	}

	public function getToken() {
		return $this->token;
	}

	public function getUsername() {
		return $this->username;
	}

}
