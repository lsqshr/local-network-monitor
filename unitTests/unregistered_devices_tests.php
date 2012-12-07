<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');

class unregistered_devices_tests extends WebTestCase {
	#test that the conflicts page exists.
    function testWebpageExists() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Unregistered Devices');
		$this->assertText('Below displays all conflicting IP addresses that connect to the local network.');
    }
	
	#test that the page works correctly
	function testUnregisteredDevicesColumnNamesCorrect() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Unregistered Devices');
		$this->assertText('Mac Address');
		$this->assertText('IP Address');
		$this->assertText('Last Seen');
		#look for a tuple to be sure the table is working.
		$this->assertText('24:b6:57:35:96:70');
		$this->assertText('172.24.9.170');
		$this->assertText('2012-10-02 11:38:20.77794');
	}
	
	#test that navigation from the conflicts page to other pages works correctly
	function testNavigationWorkingProperly() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Unregistered Devices');
		$this->click('Home');
		$this->assertTitle('Administration :: Local Network Monitor');
		$this->click('Unregistered Devices');
		$this->click('Registered Devices');
		$this->assertTitle('Registered Devices :: Local Network Monitor');
		$this->click('Unregistered Devices');
		$this->click('Map');
		$this->assertText('Select a map to view');
		$this->click('Unregistered Devices');
		$this->click('Conflicts');
		$this->assertTitle('Conflicting Devices :: Local Network Monitor');
	}
}
?>