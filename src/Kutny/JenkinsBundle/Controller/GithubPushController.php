<?php

namespace Kutny\JenkinsBundle\Controller;

use Kutny\Jenkins\AppBuildRunner;
use Kutny\Jenkins\JobFromBranchCreator;
use Kutny\Jenkins\PusherEmailGetter;
use KutnyLib\Jenkins\JenkinsConfig;
use KutnyLib\Jenkins\Job\JobRemover;
use KutnyLib\Jenkins\ProjectConfigFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service = "controller.github_push_controller")
 */
class GithubPushController {

	private $jobFromBranchCreator;
	private $jobRemover;
	private $pusherEmailGetter;
	private $appBuildRunner;
	private $projectConfigFactory;

	public function __construct(
		JobFromBranchCreator $jobFromBranchCreator,
		JobRemover $jobRemover,
		PusherEmailGetter $pusherEmailGetter,
		AppBuildRunner $appBuildRunner,
		ProjectConfigFactory $projectConfigFactory
	) {
		$this->jobFromBranchCreator = $jobFromBranchCreator;
		$this->jobRemover = $jobRemover;
		$this->pusherEmailGetter = $pusherEmailGetter;
		$this->appBuildRunner = $appBuildRunner;
		$this->projectConfigFactory = $projectConfigFactory;
	}

	/**
	 * @Route("/github-push")
	 */
	public function indexAction(Request $request) {
		$payload = $request->request->get('payload');

		if (!$payload) {
			return new Response('payload POST data missing');
		}

		$projectName = $request->query->get('projectName');

		if (!$projectName) {
			return new Response('projectName GET parameter missing');
		}

		$requestObject = json_decode($payload);
		$projectConfig = $this->projectConfigFactory->createProjectConfig($projectName);
		$jenkinsConfig = $projectConfig->getJenkinsConfig();

		$branchName = $this->getBranchName($requestObject);

		$pusherEmail = $this->pusherEmailGetter->getEmail($projectConfig->getGithubNames2Emails(), $this->getPusherName($requestObject));
		$jobName = $this->getJobName($branchName, $jenkinsConfig);

		if (isset($requestObject->deleted) && $requestObject->deleted === true) {
			$this->jobRemover->removeJob($jenkinsConfig, $jobName);
		}
		else if (isset($requestObject->created) && $requestObject->created === true) {
			$this->jobFromBranchCreator->createJobFromBranch($jenkinsConfig, $jobName, $branchName);

			$this->appBuildRunner->runBuild($jenkinsConfig, $pusherEmail, $jobName);
		}
		else {
			$this->appBuildRunner->runBuild($jenkinsConfig, $pusherEmail, $jobName);
		}

		return new Response('done');
	}

	private function getBranchName(stdClass $requestObject) {
		if (!isset($requestObject->ref)) {
			throw new \Exception('"ref" attribute not defined in input JSON data');
		}
		else if (!preg_match('~/([^/]+)$~', $requestObject->ref, $matches)) {
			throw new \Exception('Invalid refs: ' . $requestObject->ref);
		}

		return $matches[1];
	}

	private function getJobName($branchName, JenkinsConfig $jenkinsConfig) {
		if ($branchName === $jenkinsConfig->getMasterBranchName()) {
			$jobName = $jenkinsConfig->getTemplateJobName();
		}
		else {
			$jobName = $jenkinsConfig->getTemplateJobName() . '_' . $branchName;
		}

		return $jobName;
	}

	private function getPusherName(stdClass $requestObject) {
		if (!isset($requestObject->pusher)) {
			throw new \Exception('"pusher" attribute not defined in input JSON data');
		}

		return $requestObject->pusher->name;
	}
}
