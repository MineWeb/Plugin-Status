<?php

class StatusController extends AppController {

    function admin_index(){
        if($this->isConnected AND $this->User->isAdmin()){
          $this->set('title_for_layout', "Status des serveurs");
          $servers = ClassRegistry::init('Server')->find('all');
          $this->set(compact('servers'));
          $this->loadModel('Status.ConfigServerStats');
          $configServerStats = $this->ConfigServerStats->find('first');
          if(empty($configServerStats)){
            $this->ConfigServerStats->set(array(
               'isMojang' => '1'
            ));
            $this->ConfigServerStats->save();
            $this->redirect(Router::reverse($this->request, true));
          }
          $this->set(compact('configServerStats'));
          $this->layout = 'admin';
      }
          else

              throw new ForbiddenException();
    }

    function index(){
        $this->set('title_for_layout', 'Status des serveurs');
        $json = file_get_contents("http://status.mojang.com/check");
        $this->set(compact('json'));
        $servers = ClassRegistry::init('Server')->find('all', array('conditions' => array("Server.type !=" => 2)));
        foreach ($servers as $v){
            $motd_server = $this->Server->call('GET_MOTD', $v["Server"]["id"]);
            $playerMax = $this->Server->call('GET_MAX_PLAYERS', $v['Server']['id']);
            $playerCount = $this->Server->call('GET_PLAYER_COUNT', $v['Server']['id']);
            $playerEco = $this->Server->call('GET_ECONOMY', $v['Server']['id']);
            if(empty($playerMax['GET_MAX_PLAYERS'])){
                $isOnline = "false";
            }else{
                $isOnline = "true";
            }
            $pre_registre_conf = array('status-iconurl' => $v['Server']['status-iconurl'], 'status-motd' => $v['Server']['status-motd'], 'status-isShowIp' => $v['Server']['status-isShowIp'], 'status-isShowCount' => $v['Server']['status-isShowCount'], 'status-isShowStatus' => $v['Server']['status-isShowStatus']);
            $pre_registre_server[] = array('conf' => $pre_registre_conf, 'name' => $v['Server']['name'], 'playerCount' => $playerCount['GET_PLAYER_COUNT'], 'playerMax' => $playerMax['GET_MAX_PLAYERS'], 'motd' => $motd_server['GET_MOTD'], 'ip' => $v['Server']['ip'], 'isOnline' => $isOnline);
        }
        $server_registre = array('server_infos' => $pre_registre_server);
        $this->loadModel('Status.ConfigServerStats');
        $configServerStats = $this->ConfigServerStats->find('first');
        if(empty($configServerStats)){
          $this->ConfigServerStats->set(array(
             'isMojang' => '1'
          ));
          $this->ConfigServerStats->save();
          $this->redirect(Router::reverse($this->request, true));
        }
        $this->set(compact('server_registre', 'configServerStats'));

    }


    function admin_configen_ajax(){
      $this->autoRender = false;
      $this->response->type('json');
      if($this->isConnected){
        if($this->request->is('post')) {
          $this->loadModel('Status.ConfigServerStats');
          $id = $this->request->data['idConfigServerGen'];
          $this->ConfigServerStats->read(null, $id);
          $this->ConfigServerStats->set(array(
             'isMojang' => $this->request->data['show_mojang_server']
          ));
          $this->ConfigServerStats->save();
          $this->response->body(json_encode(array('statut' => true, 'msg' => "La configuration générale a été enregistrée avec succès !")));
          return;
        }
      }
    }

    function admin_configserv_ajax($id){
      $this->autoRender = false;
      $this->response->type('json');
      if($this->isConnected){
        if($this->request->is('post')) {
          $checkIfImageAlreadyUploaded = (isset($this->request->data['img-uploaded']));
          if($checkIfImageAlreadyUploaded) {

						$url_img = Router::url('/').'img'.DS.'uploads'.$this->request->data['img-uploaded'];

					} else {

						$isValidImg = $this->Util->isValidImage($this->request, array('png', 'jpg', 'jpeg'));

						if($isValidImg['status']) {
							$infos = $isValidImg['infos'];
						}

						$url_img = WWW_ROOT.'img'.DS.'uploads'.DS.'icon-server'.DS.$id.'-server.'.$infos['extension'];

						if(!$this->Util->uploadImage($this->request, $url_img)) {
							$this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORM__ERROR_WHEN_UPLOAD'))));
							return;
						}

						$url_img = Router::url('/').'img'.DS.'uploads'.DS.'icon-server'.DS.$id.'-server.'.$infos['extension'];

					}
          $this->loadModel('Server');
          $this->Server->read(null, $id);
          $this->Server->set(array(
             'status-iconurl' => $url_img,
             'status-motd' => $this->request->data['motd_server'],
             'status-isShowIp' => $this->request->data['show_ip_server'],
             'status-isShowCount' => $this->request->data['show_count_server'],
             'status-isShowStatus' => $this->request->data['show_status_server']
          ));
          $this->Server->save();
          $this->response->body(json_encode(array('statut' => true, 'msg' => "La configuration du serveur a été enregistrée avec succès !")));
          return;
        }
      }
    }



}
