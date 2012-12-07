<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');

class conflicts_tests extends WebTestCase {
	#test that the conflicts page exists.
    function testWebpageExists() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Conflicts');
		$this->assertText('Below displays all conflicting devices that are connected to the network. Conflicting Devices share IP addresses.');
    }
	
	#test that the page works correctly
	function testConflictsPageWorksCorrectly() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		#ensure a registered device conflicting is already added.
		$this->click('Registered Devices');
		$this->setField('search', 'Test Device 48');
		$this->click('SEARCH');
		$this->assertText('Test Device 48');
		$this->assertText('172.24.9.4');
		#ensure an unregistered device conflicting is already added.
		$this->click('Unregistered Devices');
		$this->assertText('172.24.9.4');
		#Check both those devices appear on the conflicts page.
		$this->click('Conflicts');
		$this->assertText('172.24.9.4');
	}
	
	#test that navigation from the conflicts page to other pages works correctly
	function testNavigationWorkingProperly() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Conflicts');
		$this->click('Home');
		$this->assertTitle('Administration :: Local Network Monitor');
		$this->click('Conflicts');
		$this->click('Registered Devices');
		$this->assertTitle('Registered Devices :: Local Network Monitor');
		$this->click('Conflicts');
		$this->click('Map');
		$this->assertText('Select a map to view');
		$this->click('Conflicts');
		$this->click('Unregistered Devices');
		$this->assertTitle('Unregistered Devices :: Local Network Monitor');
	}
}
?>