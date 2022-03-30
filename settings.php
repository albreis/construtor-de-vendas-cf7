<div class="albreis">
  <h1>Configurações</h1>
  <hr/>
  <form action="options.php" method="post">
    <?php settings_fields( 'cv_cf7' ); ?>
    <?php do_settings_sections( 'cv_cf7' ); ?>
    <div class="field">
      <label>Toke API</label>
      <input type="text" class="input form-control" name="cv_cf7_token" value="<?php echo get_option('cv_cf7_token'); ?>" />
    </div>
    <div class="field">
      <label>E-mail</label>
      <input type="text" class="input form-control" name="cv_cf7_email" value="<?php echo get_option('cv_cf7_email'); ?>" />
    </div>
    <div class="field">
      <label>ID do Empreendimento</label>
      <select class="input form-control" name="cv_cf7_empreendimento">
      <option value="0">Selecione o empreendimento</option>
      <?php foreach(get_empreendimentos() as $emp): ?>
		  <option <?php if(get_option('cv_cf7_empreendimento') == $emp->idempreendimento): ?>selected<?php endif; ?> value="<?php echo $emp->idempreendimento; ?>"><?php echo $emp->idempreendimento; ?> - <?php echo $emp->nome; ?></option>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="field">
      <label>Subdomínio da API</label>
      <input type="text" class="input form-control" name="cv_cf7_endpoint" value="<?php echo get_option('cv_cf7_endpoint'); ?>" />
    </div>
    <?php submit_button(); ?>
  </form>
</div>