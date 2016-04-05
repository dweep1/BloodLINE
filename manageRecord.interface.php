<?php

	/* === BloodLINE INTERFACE === */

	interface manageRecord{

		public function addNew($rec);

		public function searchRecord($id);

		public function editRecord($rec);

		public function viewRecord($id);

	}

?>