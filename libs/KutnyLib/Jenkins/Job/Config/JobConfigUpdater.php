<?php

namespace KutnyLib\Jenkins\Job\Config;

use KutnyLib\Jenkins\ActionRunner;
use KutnyLib\Jenkins\JenkinsConfig;

class JobConfigUpdater {

	private $actionRunner;

	public function __construct(ActionRunner $actionRunner) {
		$this->actionRunner = $actionRunner;
	}

	public function update(JenkinsConfig $jenkinsConfig, $jobName, $configXmlData) {
		$this->actionRunner->runPostAction($jenkinsConfig, '/job/' . $jobName . '/config.xml', array(), $configXmlData);
	}

}
