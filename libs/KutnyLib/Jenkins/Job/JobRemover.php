<?php

namespace KutnyLib\Jenkins\Job;

use KutnyLib\Jenkins\ActionRunner;
use KutnyLib\Jenkins\JenkinsConfig;

class JobRemover {

	private $actionRunner;

	public function __construct(ActionRunner $actionRunner) {
		$this->actionRunner = $actionRunner;
	}

	public function removeJob(JenkinsConfig $jenkinsConfig, $jobName) {
		return $this->actionRunner->runPostAction($jenkinsConfig, '/job/' . $jobName . '/doDelete');
	}

}
