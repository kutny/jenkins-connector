<?php

namespace KutnyLib\Jenkins\Job;

use KutnyLib\Jenkins\ActionRunner;
use KutnyLib\Jenkins\JenkinsConfig;

class JobDuplicator {

	private $actionRunner;

	public function __construct(ActionRunner $actionRunner) {
		$this->actionRunner = $actionRunner;
	}

	public function duplicateJob(JenkinsConfig $jenkinsConfig, $newJobName) {
		$params = array(
			'name' => $newJobName,
			'mode' => 'copy',
			'from' => $jenkinsConfig->getTemplateJobName()
		);

		return $this->actionRunner->runPostAction($jenkinsConfig, '/createItem', $params);
	}

}
