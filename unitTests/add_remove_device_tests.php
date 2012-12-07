<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');

class add_remove_device_tests extends WebTestCase {
    function testNavigateToAddDevicePageWorks() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Add Device');
		$this->assertText('This is where new hospital devices should be added.');
    }
	
	 function testNavigateToRegisteredDevicePageWorks() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Registered Devices');
		$this->assertText('Below displays all registered devices that are being monitored.');
    }
	
	function testAddDevice() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Add Device');
		$this->setField('name', 'dummyTestDevice');
		$this->setField('macAddress', 'doesntEvenMatter');
		$this->setField('location', 'blankTest');
		$this->setField('mobile', 'No');
		$this->clickSubmit('Add Device');
		$this->assertText('Device added successfully');
		#NOTE: Because simpletest does not support our delete button we have to manually delete the device, otherwise
		#this test will fail on the second attempt each time.
	}
	
	function testSearchFunction() {
		$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Registered Devices');
		$this->setField('search', 'dummyTestDevice');
		$this->click('SEARCH');
		$this->assertText('dummyTestDevice');
		$this->assertNoText('DavidMacD');
		$this->click('delete');
		$this->back();
	}
	
	#function testDeleteFunction() {
		#unfortuantly this is impossible to test because simpletest does not support one of our features.
	#}
	
	function testEditDevice() {
			$this->get('http://www.ug.it.usyd.edu.au/~dbro8182/lnm/');
        $this->assertTitle('Administration :: Local Network Monitor');
		$this->setField('username', 'admin');
		$this->setField('passwd', 'admin');
		$this->click('Submit');
		$this->click('Registered Devices');
		$this->click('dummyTestDevice');
		$this->assertText('Edit Device');
		$this->setField('name','seconddummy');
		$this->setField('macAddress','stillDummy');
		$this->click('Edit Device');
		$this->click('Registered Devices');
		$this->assertText('seconddummy');
	}
}
?>