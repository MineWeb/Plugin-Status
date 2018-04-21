<?php
class StatusAppSchema extends CakeSchema {

	public $file = 'schema.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {}

				public $status__config = array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'isMojang' => array('type' => 'integer', 'null' => false, 'default' => '1')
				);

        public $servers = [
            'status-iconurl' => array('type' => 'string', 'null' => false, 'default' => 'https://pixelads.fr/img/cover/1497104509.png', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
						'status-motd' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
						'status-isShowIp' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => fals),
						'status-isShowCount' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false),
						'status-isShowStatus' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false)
        ];
}
