<?php
class SysVar extends AppModel {
	var $name = "SysVar";
	var $useTable = "sys_vars";
	public function getParam( $key ) {
		return $this->findByMeta_key($key);
	}
}
?>