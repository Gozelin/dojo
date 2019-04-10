<?php

class cOrderManager {

//string
protected $_path = PATH_INTER."pages/utility/order/";

//string
protected $_action = NULL;

//string
protected $_file = NULL;

//array
protected $_order = NULL;

//will be passed into action function
protected $_arg = NULL;

public function getOrder() { return ($this->_order); }

public function __construct($details) {
	foreach ($details as $key => $d) {
		$key = "_".$key;
		if (property_exists("cOrderManager", $key)) {
			$this->$key = $d;
		}
	}
	if (!$this->_action || !$this->_file)
		throw new Exception( "cOrderManager: missing parameters" );
	$this->_path .= $this->_file.".order.json";
	if (!$this->_order)
		$this->_order = json_decode(file_get_contents($this->_path), true);
}

public function execQuery() {
	if (method_exists($this, $this->_action)) {
		$func = $this->_action;
		return ($this->$func());
	}
}

private function changeOrder() {
	if (!$this->_order)
		throw new Exception( "cOrderManager: missing update order" );
	$arr_f = json_decode(file_get_contents($this->_path), true);
	if (isset($this->_arg)) {
		$i = $this->_arg;
		if (!isset($arr_f[$i]))
			$arr_f[$i] = array();
		$arr_f[$i] = $this->_order;
	} else {
		$arr_f = $this->_order;
	}
	file_put_contents($this->_path, json_encode($arr_f));
}

private function addOrder() {
	if (!$this->_arg || !isset($this->_arg["id"]))
		throw new Exception( "cOrderManager: missing add order" );
	$arr_f = json_decode(file_get_contents($this->_path), true);
	$id = $this->_arg["id"];
	$index = NULL;
	if (isset($this->_arg["index"]))
		$index = $this->_arg["index"];
	$arr_f = $this->pushVal($arr_f, $id, $index);
	file_put_contents($this->_path, json_encode($arr_f));
}

private function supprOrder() {
	if (!isset($this->_arg) || !isset($this->_arg["id"]))
		throw new Exception( "cOrderManager: missing id to supprOrder()" );
	$arr_f = json_decode(file_get_contents($this->_path), true);
	$arr_f = $this->unsetVal($arr_f, $this->_arg["id"]);
	file_put_contents($this->_path, json_encode($arr_f));
}

private function swapIndex() {
	if (!$this->_arg || !isset($this->_arg["index"]) || !isset($this->_arg["id"]))
		throw new Exception( "cOrderManager: missing data to swapIndex()" );
	$id = $this->_arg["id"];
	$index = $this->_arg["index"];
	$arr_f = json_decode(file_get_contents($this->_path), true);
	if (is_array($arr_f)) {
		$arr_f = $this->unsetVal($arr_f, $id);
		$arr_f = $this->pushVal($arr_f, $id, $index);
		file_put_contents($this->_path, json_encode($arr_f));
	} else
		throw new Exception("file is empty or is not json");
}

private function unsetVal($arr_f, $id) {
	foreach ($arr_f as $index => $subIds) {
		if (is_array($subIds)) {
			foreach ($subIds as $key => $sid) {
				if ($sid == intval($id)) {
					unset($arr_f[$index][$key]);
					$arr_f[$index] = array_values($arr_f[$index]);
					break;
				}
			}
		} else if ($subIds == intval($id)) {
			unset($arr_f[$index]);
		}
	}
	return ($arr_f);
}

private function pushVal($arr_f, $val, $index = NULL) {
	if ($index) {
		if (!isset($arr_f[$index]))
			$arr_f[$index] = array();
		array_push($arr_f[$index], intval($val));
	} else {
		array_push($arr_f, intval($val));
	}
	return ($arr_f);
}

}
?>