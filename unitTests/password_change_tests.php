<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');

class password_change_tests extends WebTestCase {
    function testWebpageExists() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
    }
	
	function testLoginWorksWithCorrectPassword() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->assertText('Welcome back John Doe!');
	}
	
	function testLoginFailsWithInCorrectPassword() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'total');
		$this->setField('passwd', 'failure');
		$this->click('Submit');
		$this->assertText('Please login to proceed to administration');
	}
	
	function testLogoutPageWorksCorrectly() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Log Out');
		$this->assertText('Welcome back John Doe!');
	}
	
	function testSideBarLinksWorkCorrectly() {
		
	}
}
?>