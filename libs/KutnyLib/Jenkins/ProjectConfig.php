<?php

namespace KutnyLib\Jenkins;

class ProjectConfig {

	private $jenkinsConfig;
	private $githubNames2Emails;

	public function __construct(JenkinsConfig $jenkinsConfig, array $githubNames2Emails) {
		$this->jenkinsConfig = $jenkinsConfig;
		$this->githubNames2Emails = $githubNames2Emails;
	}

	public function getJenkinsConfig() {
		return $this->jenkinsConfig;
	}

	public function getGithubNames2Emails() {
		return $this->githubNames2Emails;
	}

}
