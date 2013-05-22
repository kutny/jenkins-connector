<?php

namespace Kutny\Jenkins;

use KutnyLib\Jenkins\JenkinsConfig;
use KutnyLib\Jenkins\Job\BuildWithParametersRunner;

class AppBuildRunner {

	private $buildWithParametersRunner;

	public function __construct(BuildWithParametersRunner $buildWithParametersRunner) {
		$this->buildWithParametersRunner = $buildWithParametersRunner;
	}

	public function runBuild(JenkinsConfig $jenkinsConfig, $pusherEmail, $jobName) {
		$params = array(
			'PUSHER_EMAIL' => $pusherEmail
		);

		$this->buildWithParametersRunner->runBuildWithParameters($jenkinsConfig, $jobName, $params);
	}

	/**
	 * @param int $number
	 * @param boolean $boolean
	 */
	public function test22($number, $boolean) {
		var_dump($number);
		var_dump($boolean);
	}
	
}
