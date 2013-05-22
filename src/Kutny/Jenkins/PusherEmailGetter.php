<?php

namespace Kutny\Jenkins;

class PusherEmailGetter {

	public function getEmail($githubNames2Emails, $githubUsername) {
		if (!array_key_exists($githubUsername, $githubNames2Emails)) {
			throw new \Exception('Unkwnown GitHub username: ' . $githubUsername);
		}

		return $githubNames2Emails[$githubUsername];
	}

}