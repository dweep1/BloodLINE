<?php

	/* === BASE CLASS TO ADD, UPDATE AND SELECT DATA FROM A DATABASE === */

	abstract class Table
	{

		public $table = null;   // Table Name


		/**
		*	Assign variables in array to matching variables in this class
		*   
		*   @param  an associative array (key-value pair)
		*	@return none
		*/
		function bind ($data)
		{
			foreach( $data as $key=>$value)
			{
				$this->$key = $value; //Dynamic key name
			}
		}


		/**
		*	Executes Select query on Database
		*   
		*   @param  id - primary key of table
		*	@return none
		*/
		abstract protected function select($id);


		/**
		*	Save data to Database
		*   
		*   @param  none
		*	@return none
		*/	
		function insert(){
			$dbo = database::getInstance();
			$sql = $this->buildQuery('insert');
			$dbo->doQuery($sql);

		}


		/**
		*	Creates sql query statements
		*   
		*   @param  task - what we want to do whether we want to store info (insert) or load it(select)
		*	@return none
		*/
		abstract protected function buildQuery($task);
		

	} 



?>