<?php

namespace Kutny\Jenkins;

use KutnyLib\Jenkins\JenkinsConfig;
use KutnyLib\Jenkins\Job\JobDuplicator;

class JobFromBranchCreator {

	private $jobDuplicator;
	private $configurationUpdater;

	public function __construct(JobDuplicator $jobDuplicator, ConfigurationUpdater $configurationUpdater) {
		$this->jobDuplicator = $jobDuplicator;
		$this->configurationUpdater = $configurationUpdater;
	}

	public function createJobFromBranch(JenkinsConfig $jenkinsConfig, $newJobName, $branchName) {
		$this->jobDuplicator->duplicateJob($jenkinsConfig, $newJobName);

		$this->configurationUpdater->process($jenkinsConfig, $newJobName, $branchName);
	}
	
}
