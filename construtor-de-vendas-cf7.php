<?php
/**
 * Plugin Name: Construtor de Vendas CF7
 * Author: ER Soluções Web LTDA
 * Author URI: https://ersolucoesweb.com.br
 * Version: 0.0.1
 * Description: Integração da API do Construtor de Vendas como o Contact Form 7
 */

add_action('admin_enqueue_scripts', function(){
  wp_enqueue_style( 'cv_cf7', plugin_dir_url(__FILE__) . 'admin.css', [], time(), 'all' );
});

add_action('init', function(){
  register_setting( 'cv_cf7', 'cv_cf7_token', [] );
  register_setting( 'cv_cf7', 'cv_cf7_email', [] );
  register_setting( 'cv_cf7', 'cv_cf7_empreendimento', [] );
  register_setting( 'cv_cf7', 'cv_cf7_endpoint', [] );
});

add_action( 'admin_menu', function(){
  add_menu_page( 'Construtor de Vendas', 'Construtor de Vendas', 'manage_options', 'cv_cf7', function(){
    include __DIR__ . '/settings.php';
  }, null, 0);
}); 

add_action('wpcf7_before_send_mail', function($form){
  $submission = WPCF7_Submission::get_instance();
  $data = $submission->get_posted_data();
    
  $lead = json_encode([   
    "acao" =>  'salvar_editar',
    "nome" =>  $data['your-name'],
    "email" =>  $data['your-email'],
    "telefone" =>  $data['telefone'],
    "modulo" =>  'gestor',
    "permitir_alteracao" => "true",
    "origem" =>  'SI',
    "idempreendimento" => (string) get_option('cv_cf7_empreendimento')
  ]);

  $req = wp_remote_post(get_option('cv_cf7_endpoint') . '/api/cvio/lead', [
    "headers" => [
      'token' => get_option('cv_cf7_token'),
      'email' => get_option('cv_cf7_email'),
      'painel' => 'gestor',
		'sslverify' => false,
      'Content-Type' => 'application/json'
    ],
    "body" => $lead
  ]);

});
function get_empreendimentos(){
  $req = wp_remote_get(get_option('cv_cf7_endpoint') . '/api/cvio/empreendimento', [
    "headers" => [
      'token' => get_option('cv_cf7_token'),
      'email' => get_option('cv_cf7_email'),
      'painel' => 'gestor',
	  'sslverify' => false,
      'Content-Type' => 'application/json'
    ],
    "body" => $lead
  ]);

  return json_decode(wp_remote_retrieve_body( $req ));

}

add_filter( 'https_ssl_verify', '__return_false' );
