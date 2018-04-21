<?php
Router::connect('/status', array('controller' => 'status', 'action' => 'index', 'plugin' => 'Status'));
Router::connect('/status/configserv_ajax/*', array('controller' => 'status', 'action' => 'configserv_ajax', 'plugin' => 'Status', 'admin' => true));
Router::connect('/status/configen_ajax', array('controller' => 'status', 'action' => 'configen_ajax', 'plugin' => 'Status', 'admin' => true));
