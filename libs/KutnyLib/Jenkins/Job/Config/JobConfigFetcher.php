<?php

namespace KutnyLib\Jenkins\Job\Config;

use KutnyLib\Jenkins\ActionRunner;
use KutnyLib\Jenkins\JenkinsConfig;

class JobConfigFetcher {

	private $actionRunner;

	public function __construct(ActionRunner $actionRunner) {
		$this->actionRunner = $actionRunner;
	}

	public function fetch(JenkinsConfig $jenkinsConfig, $jobName) {
		return $this->actionRunner->runGetAction($jenkinsConfig, '/job/' . $jobName . '/config.xml');
	}

}
