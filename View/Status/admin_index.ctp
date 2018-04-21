<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Configuration général</h3>
            </div>
            <div class="box-body">
                <form action="<?= $this->Html->url(array('controller' => 'status', 'action' => 'configen_ajax')) ?>" method="POST" data-ajax="true" data-redirect-url="<?= $this->Html->url(array('controller' => 'status', 'action' => 'index', 'admin' => 'true')) ?>">
                  <input type="hidden" name="idConfigServerGen" value="<?= $configServerStats['ConfigServerStats']['id']; ?>">
                  <div class="form-group">
                    <label>Afficher le status de Mojang</label>
                    <br>
                    <small>Si actif, le status des serveurs de Mojang sera affiché</small>
                    <div class="radio">
                      <input type="radio" name="show_mojang_server" value="1" <?= ($configServerStats['ConfigServerStats']['isMojang'] == '1') ? 'checked=""' : '' ?>>
                      <label>Afficher</label>
                    </div>
                    <div class="radio">
                      <input type="radio" name="show_mojang_server" value="0" <?= ($configServerStats['ConfigServerStats']['isMojang'] == '0') ? 'checked=""': '' ?>>
                      <label>Ne pas afficher</label>
                    </div>
                  </div>
                  <button class="btn btn-primary" type="submit">Envoyer</button>
               </form>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Gestion des serveurs | Status des serveurs</h3>
            </div>
            <div class="box-body">
                <?php foreach($servers as $server): ?>
                <div class="box">
                    <div data-toggle="collapse" data-target="#server-<?= $server['Server']['id']; ?>" style="cursor: pointer;" class="box-header with-border">
                        <h3 class="box-title">Gestion de <?= $server['Server']['name']; ?></h3>
                    </div>
                    <div id="server-<?= $server['Server']['id']; ?>" class="collapse box-body">
                        <form action="<?= $this->Html->url(array('controller' => 'status', 'action' => 'configserv_ajax', $server['Server']['id'])) ?>" method="post" data-ajax="true" data-upload-image="true" data-redirect-url="<?= $this->Html->url(array('controller' => 'status', 'action' => 'index', 'admin' => 'true')) ?>">
                          <div class="col-sm-4">
                            <?php if(!empty($server['Server']['status-iconurl'])){ ?>
                                <input type="hidden" name="icon-server-already" value="<?= $server['Server']['status-iconurl']; ?>">
                            <?php }?>
                            <?php $form_input_server = str_replace("Envoyer une image", "Changer l'icône", $this->element('form.input.upload.img', $form_input)); ?>
                            <?= str_replace('id="img-form"', 'id="img-form-server-'.$server['Server']['id'].'"', $form_input_server); ?>
                            <?php echo "<script>$('#img-form-server-".$server['Server']['id']."').attr('src','".$server['Server']['status-iconurl']."');</script>"; ?>
                          </div>
                          <div class="col-sm-8">
                            <label>Votre description du serveur (Si vide, le MOTD du serveur sera affiché)</label>
                            <textarea class="form-control" rows="5"  name="motd_server"><?= $server['Server']['status-motd']; ?></textarea>
                            <br />
                            <div class="form-group">
                              <label>Afficher l'adresse ip</label>
                              <br>
                              <small>Si actif, l'adresse ip du serveur sera affiché dans le status de celui-ci</small>
                              <div class="radio">
                                <input type="radio" name="show_ip_server" value="1" <?= ($server['Server']['status-isShowIp'] == '1') ? 'checked=""' : '' ?>>
                                <label>Afficher</label>
                              </div>
                              <div class="radio">
                                <input type="radio" name="show_ip_server" value="0" <?= ($server['Server']['status-isShowIp'] == '0') ? 'checked=""': '' ?>>
                                <label>Ne pas afficher</label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Afficher le nombre de connectés</label>
                              <br>
                              <small>Si actif, le nombre de joueurs connectés sera affiché dans le status de celui-ci</small>
                              <div class="radio">
                                <input type="radio" name="show_count_server" value="1" <?= ($server['Server']['status-isShowCount'] == '1') ? 'checked=""' : '' ?>>
                                <label>Afficher</label>
                              </div>
                              <div class="radio">
                                <input type="radio" name="show_count_server" value="0" <?= ($server['Server']['status-isShowCount'] == '0') ? 'checked=""': '' ?>>
                                <label>Ne pas afficher</label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Afficher le status de connexion</label>
                              <br>
                              <small>Si actif, l'état de connexion sera affiché dans le status de celui-ci</small>
                              <div class="radio">
                                <input type="radio" name="show_status_server" value="1" <?= ($server['Server']['status-isShowStatus'] == '1') ? 'checked=""' : '' ?>>
                                <label>Afficher</label>
                              </div>
                              <div class="radio">
                                <input type="radio" name="show_status_server" value="0" <?= ($server['Server']['status-isShowStatus'] == '0') ? 'checked=""': '' ?>>
                                <label>Ne pas afficher</label>
                              </div>
                            </div>
                            <br />
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                          </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
