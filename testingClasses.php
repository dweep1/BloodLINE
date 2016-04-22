<?php

	/* === CONNECTION === */
	include('dbaccess.php');

	/* === CLASSES === */
	//include('Person.class.php');
	include('Recipient.class.php');
	//include('Donor.control.php');
	//include('MedicalRecord.class.php');
	//include('DonationRecord.class.php');
	//include('BloodSpecimen.class.php');
	include('Recipient_DonationRec_BloodSpec.control.php');
	//include('UserLogin.control.php');
	//include('SystemNotification.class.php');

	/*=== DATA FOR TESTING FUNCTIONS ===*/
	//$data = array('123456789', 'fnameupdate', 'lname', 'address1', 'address2', 'cellNo', 'workNo', 'homeNo', 'email', '1995-09-04', 'F', 'idPicture', 'maritalStatus', 'mname', "MR001", "DR001");
	//$data = array('123456789', 'fname', 'lname', 'address1', 'address2', 'cellNo', 'workNo', 'homeNo', 'email', '1995-09-04', 'F', 'idPicture', 'maritalStatus', 'mname');
	$data = array('12348910', 'fname', 'lname', 'address1', 'address2', 'cellNo', 'workNo', 'homeNo', 'email', '1956-12-19', 'F', 'idPicture', 'maritalStatus', 'middlename', 'AB', '2.2', 'reason', '1.0', 'location', '+', 'compatibleWith');
	//$data = array('12345678910', 'fname', 'lname', 'address1', 'address2', 'cellNo', 'workNo', 'homeNo', 'email', '1956-12-19', 'F', 'idPicture', 'maritalStatus', 'middlename');
	//$data = array('12345678910', 'AB', '2.2', 'reason', '1', 'location', '+', 'compatibleWith');
	//$data = array("DR001", "12345678910", "BS001");
	//$data = array('MR001', '175.5', '5.5', '170/80', '98.6', '15.5', '00:00:00', '2016-04-04','medicalHistory','rejectionReason');
	//$data2 = array('DR001', '2016-04-04', 'location', '1.0', 'donorType', 'collectedBy', '2016-06-09');
	//$data = array('BS001', 'componentsinfo', 'storageLocation', 'testResults', 'O', '-', 'testedBy','2016-04-06','status');
	//$data = array(1,'username','N','password');
	//$data = array(2,'userName','L','passWord');
	//$data = array("123456789","MR001", "DR001");

	//$primaryKey = 123456789;


	/* === CREATING OBJECTS === */
	 //$donor = new Donor();
	 //$recipient = new Recipient();
	 //$person = new Person();
	 //$mr = new MedicalRecord();
	 //$dr = new DonationRecord();
	 //$bs = new BloodSpecimen();
	 $rdb = new Recipient_DonationRec_BloodSpec();
	 //$user = new UserLogin();

	/* === UNIT TESTS == */
	//$donor->add_MedicalRecord($data);
	//$donor->add_DonationRecord($data2);
	//$rdb->add_BloodSpecimen($data);
	$rdb->add_Recipient($data);
	//$rdb->construct($data);
	//$donor->addNew($data);
	//$donor->editRecord($data);
	//$donor->searchRecord($primaryKey);
	//$donor->viewRecord($primaryKey);

	
//==========================================================================================================================================================================================
	


	// How to set up database connection
	//$dbo = database :: getInstance();
	//$dbo->connect('localhost','root','','pa_database');

	// How to store data in database
	//$data = array("4","updatedilocation","08:22","2015-11-29","Witness Statement","describing the scene");
	//$data = array("icname10","updatedupdatedaddress1","address2","email","phone","fax");
	//$data = array("vin","updata","update","make","model","yeer","damages",5);
	//$data = array("trn","updatedlname","fname","mname","addresw","addres3","email","home","cell","work","dob","occupation","mortaLSatus",6);
	//$data = array("policyNo","updatedlname","fname","mname","dlicense","Key Insurance","vin");



	//$ic->updateExisting($data);
	//$accident->load('3');
	
	//$accident->bind($data);
	//$accident->insert();

	    /*// Create new Vehicle Owner object
        $owner = new VehicleOwner();
        // Get values to be stored in database
        $data = array($policyNo,$lname_ic,$fname_ic,$mname_ic,$dlicense,$icname,$vin);
        // Add record to database
        $owner->addNew($data);*/

	// How to access data in database
	//$accident->load('1'); //accident no (make auto-increment)

	//How to update
	//$data =  array("trn"=>"new data","location"=>"");
	//$accident->bind($data);
	//$accident->store();
        /*$rec= array();

      $trn = "Advantage General";
      $rec[] = $ic->search($trn);

for ( $i = 0; $i < count($rec); $i++){
	foreach ($rec[$i] as $key=>$value)
			{
				
				echo "{$key}-->{$value}<br>";
			}
}
	//echo $rec;*/


	




?>