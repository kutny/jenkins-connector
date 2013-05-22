<?php

namespace KutnyLib\BuzzBrowser;

use Buzz\Browser;

class BuzzBrowserFactory {

	public function createBuzzBrowser() {
		return new Browser(new \Buzz\Client\Curl());
	}

}
