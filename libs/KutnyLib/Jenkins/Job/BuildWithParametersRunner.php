<?php

namespace KutnyLib\Jenkins\Job;

use KutnyLib\Jenkins\ActionRunner;
use KutnyLib\Jenkins\JenkinsConfig;

class BuildWithParametersRunner {

	private $actionRunner;

	public function __construct(ActionRunner $actionRunner) {
		$this->actionRunner = $actionRunner;
	}

	public function runBuildWithParameters(JenkinsConfig $jenkinsConfig, $jobName, $params) {
		// @see http://amokti.me/2011/10/11/automatic-opt-in-branch-building-with-jenkins-and-git-2/
		return $this->actionRunner->runGetAction($jenkinsConfig, '/job/' . $jobName . '/buildWithParameters', $params);
	}

}
