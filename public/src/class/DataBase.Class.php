<?php
define("FETCH_ARRAY", "FETCH_ARRAY");
define("FETCH_ALL", "FETCH_ALL");
define("FETCH_ASSOC", "FETCH_ASSOC");
define("FETCH_OBJECT", "FETCH_OBJECT");
define("FETCH_FIELD", "FETCH_FIELD");
define("FETCH_FIELDS", "FETCH_FIELDS");

define("_STRING_", "STRING");
define("_INT_", "INT");
define("_ARRAY_", "ARRAY");
define("_BOOL_", "BOOL");
define("_DOUBLE_", "DOUBLE");
define("_FLOAT_", "FLOAT");
define("_DATETIME_", "DATETIME");
define("_DATE_", "DATE");

$dataBase;

class cDataBase extends mysqli {

	public function	__construct($hostname = 'localhost', $user = 'root', $password = '' , $database = 'gearvisExample') {
		parent::__construct($hostname, $user, $password, $database);
			if (mysqli_connect_error()) {
				die('Erreur de connexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			}
	}

	public function query($query, $flag = NULL, $constant = NULL)
	{
		$result = parent::query($query);
		if (!$result)
			$this->log($query);
		if (is_bool($result))
			return ($result);
		switch ($flag) {
			case NULL:
				return ($result);
				break;
			case "FETCH_ARRAY":
				if ($constant !== NULL)
					$ret =  $result->fetch_array($constant);
				else
					$ret =  $result->fetch_array();
				break;
			case "FETCH_ALL":
				if ($constant !== NULL)
					$ret =  $result->fetch_all($constant);
				else
					$ret =  $result->fetch_all();
				break;
			case "FETCH_ASSOC":
				$ret =  $result->fetch_assoc();
				break;
			case "FETCH_OBJECT":
				$ret =  $result->fetch_object();
				break;
			case "FETCH_FIELD":
				$ret =  $result->fetch_field();
				break;
			case "FETCH_FIELDS":
				$ret =  $result->fetch_fields();
				break;
			default:
				$ret =  $result;
				break;
		}
		return ($ret);
	}

	// public function query($query, $flag = NULL, $constant = NULL)
	// {
	// 	$result = parent::query($query);
	// 	if (is_bool($result))
	// 		return ($result);
	// 	switch ($flag) {
	// 		case NULL:
	// 			return ($result);
	// 			break;
	// 		case "FETCH_ARRAY":
	// 			if ($constant !== NULL)
	// 				return ($result->fetch_array($constant));
	// 			else
	// 				return ($result->fetch_array());
	// 			break;
	// 		case "FETCH_ALL":
	// 			if ($constant !== NULL)
	// 				return ($result->fetch_all($constant));
	// 			else
	// 				return ($result->fetch_all());
	// 			break;
	// 		case "FETCH_ASSOC":
	// 			return ($result->fetch_assoc());
	// 			break;
	// 		case "FETCH_OBJECT":
	// 			return ($result->fetch_object());
	// 			break;
	// 		case "FETCH_FIELD":
	// 			return ($result->fetch_field());
	// 			break;
	// 		case "FETCH_FIELDS":
	// 			return ($result->fetch_fields());
	// 			break;
	// 		default:
	// 			return ($result);
	// 			break;
	// 	}
	// }

	public function protect($value, $type = _STRING_) {
		if ($value === NULL)
			return ('NULL');
		switch ($type) {
			case 'STRING':
				return '\''.(parent::real_escape_string(htmlentities(htmlspecialchars($value)))).'\'';
			case 'INT':
			case 'BOOL':
				return ((int)$value);
			case 'DOUBLE':
				return ((double)$value);
			case 'FLOAT':
				return ((float)$value);
			case 'DATE':
				return '\''.$value->format('Y-m-d').'\'';
			case 'DATETIME':
				return '\''.$value->format('Y-m-d H:i:s').'\'';
			case 'ARRAY';
				return '\''.(parent::real_escape_string(htmlentities(json_encode($value)))).'\'';
			default:
				throw new Exception ('Unknown second parameter in '.__METHOD__);
				break;
		}

	}

	public function unprotect($value, $type = _STRING_) {
		if ($value === NULL || $value == 'NULL')
			return (NULL);
		switch ($type) {
			case 'STRING':
				return (html_entity_decode($value));
			case 'BOOL':
				return ((bool)$value);
			case 'INT':
				return ((int)$value);
			case 'DOUBLE':
				return ((double)$value);
			case 'FLOAT':
				return ((float)$value);
			case 'DATE':
				return Datetime::createFromFormat('Y-m-d', $value);
			case 'DATETIME':
				return Datetime::createFromFormat('Y-m-d H:i:s', $value);
			case 'ARRAY':
				return (json_decode(html_entity_decode($value), true));
			default:
				throw new Exception ('Unknown second parameter in '.__METHOD__);
				break;
		}
	}

	public function changeUser($user, $password, $database) {
		return (parent::change_user($user, $password, $database));
	}

	public function changeDatabase($database) {
		return (parent::select_db($database));
	}

	private function log($query) {
		$handle = fopen($_SERVER['DOCUMENT_ROOT']."/dojo/interface/log/log.txt", 'a');
		fwrite($handle, date("Y-m-d H:i:s").": \n");
		fwrite($handle, trim($query)."\n".$this->error."\n------------------------------------------------------------------------------------\n");
	}

}

?>
