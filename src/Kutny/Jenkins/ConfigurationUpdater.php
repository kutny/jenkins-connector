<?php

namespace Kutny\Jenkins;

use KutnyLib\Jenkins\JenkinsConfig;
use KutnyLib\Jenkins\Job\Config\JobConfigFetcher;
use KutnyLib\Jenkins\Job\Config\JobConfigUpdater;

class ConfigurationUpdater {

	private $jobConfigFetcher;
	private $jobConfigUpdater;

	public function __construct(JobConfigFetcher $jobConfigFetcher, JobConfigUpdater $jobConfigUpdater) {
		$this->jobConfigFetcher = $jobConfigFetcher;
		$this->jobConfigUpdater = $jobConfigUpdater;
	}

	public function process(JenkinsConfig $jenkinsConfig, $jobName, $branchName) {
		$data = $this->jobConfigFetcher->fetch($jenkinsConfig, $jobName);

		$data = preg_replace('~<name>origin/[^<]+</name>~', '<name>origin/' . $branchName . '</name>', $data);

		$data = preg_replace('~<recipients>[^<]+</recipients>~', '<recipients>${PUSHER_EMAIL}</recipients>', $data);

		$this->jobConfigUpdater->update($jenkinsConfig, $jobName, $data);
	}
	
}
