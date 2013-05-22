<?php

namespace KutnyLib\Jenkins;

class ProjectConfigFactory {

	private $allProjectsConfig;

	public function __construct($allProjectsConfig) {
		$this->allProjectsConfig = $allProjectsConfig;
	}

	public function createProjectConfig($projectName) {
		$this->performChecks($projectName);

		$projectConfigArray = $this->allProjectsConfig[$projectName]['jenkins'];

		$jenkinsConfig = new JenkinsConfig(
			$projectConfigArray['host'],
			$projectConfigArray['username'],
			$projectConfigArray['password'],
			$projectConfigArray['token'],
			$projectConfigArray['master_branch_name'],
			$projectConfigArray['template_job_names']
		);

		return new ProjectConfig($jenkinsConfig, $this->allProjectsConfig[$projectName]['githubNames2Emails']);
	}

	private function performChecks($projectName) {
		if (!array_key_exists($projectName, $this->allProjectsConfig)) {
			throw new \Exception('Configuration for project "' . $projectName . '" not defined in config');
		}

		if (!array_key_exists('jenkins', $this->allProjectsConfig[$projectName])) {
			throw new \Exception('Jenkins configuration for project "' . $projectName . '" not defined in config');
		}

		if (!array_key_exists('githubNames2Emails', $this->allProjectsConfig[$projectName])) {
			throw new \Exception('GithubNames2Emails configuration for project "' . $projectName . '" not defined in config');
		}
	}

}
