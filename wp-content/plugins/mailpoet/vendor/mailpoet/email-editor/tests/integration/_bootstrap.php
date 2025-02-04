<?php
declare(strict_types = 1);
if (!defined('ABSPATH')) exit;
use Codeception\Stub;
use MailPoet\EmailEditor\Container;
use MailPoet\EmailEditor\Engine\Dependency_Check;
use MailPoet\EmailEditor\Engine\Email_Api_Controller;
use MailPoet\EmailEditor\Engine\Email_Editor;
use MailPoet\EmailEditor\Engine\Patterns\Patterns;
use MailPoet\EmailEditor\Engine\PersonalizationTags\Personalization_Tags_Registry;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Blocks_Registry;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Content_Renderer;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Postprocessors\Highlighting_Postprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Postprocessors\Variables_Postprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Preprocessors\Blocks_Width_Preprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Preprocessors\Cleanup_Preprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Preprocessors\Spacing_Preprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Preprocessors\Typography_Preprocessor;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Process_Manager;
use MailPoet\EmailEditor\Engine\Renderer\Renderer;
use MailPoet\EmailEditor\Engine\Settings_Controller;
use MailPoet\EmailEditor\Engine\Templates\Templates;
use MailPoet\EmailEditor\Engine\Theme_Controller;
use MailPoet\EmailEditor\Engine\User_Theme;
use MailPoet\EmailEditor\Integrations\Core\Initializer;
use MailPoet\EmailEditor\Integrations\MailPoet\Blocks\BlockTypesController;
use MailPoet\EmailEditor\Engine\Send_Preview_Email;
if ( (bool) getenv( 'MULTISITE' ) === true ) {
 // REQUEST_URI needs to be set for WP to load the proper subsite where MailPoet is activated.
 $_SERVER['REQUEST_URI'] = '/' . getenv( 'WP_TEST_MULTISITE_SLUG' );
 $wp_load_file = getenv( 'WP_ROOT_MULTISITE' ) . '/wp-load.php';
} else {
 $wp_load_file = getenv( 'WP_ROOT' ) . '/wp-load.php';
}
$console = new \Codeception\Lib\Console\Output( array() );
$console->writeln( 'Loading WP core... (' . $wp_load_file . ')' );
require_once $wp_load_file;
abstract class MailPoetTest extends \Codeception\TestCase\Test { // phpcs:ignore
 public Container $di_container;
 public $tester;
 // phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
 protected $backupGlobals = false;
 protected $backupStaticAttributes = false;
 protected $runTestInSeparateProcess = false;
 protected $preserveGlobalState = false;
 // phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
 public function setUp(): void {
 $this->initContainer();
 parent::setUp();
 }
 public function _after() {
 parent::_after();
 $this->tester->cleanup();
 }
 protected function checkValidHTML( string $html ): void {
 $dom = new \DOMDocument();
 libxml_use_internal_errors( true );
 $dom->loadHTML( $html );
 // Check for errors during parsing.
 $errors = libxml_get_errors();
 libxml_clear_errors();
 $this->assertEmpty( $errors, 'HTML is not valid: ' . $html );
 }
 public function getServiceWithOverrides( $id, array $overrides ) {
 $instance = $this->di_container->get( $id );
 return Stub::copy( $instance, $overrides );
 }
 protected function initContainer(): void {
 $container = new Container();
 // Start: MailPoet plugin dependencies.
 $container->set(
 Initializer::class,
 function () {
 return new Initializer();
 }
 );
 $container->set(
 BlockTypesController::class,
 function () {
 return $this->createMock( BlockTypesController::class );
 }
 );
 // End: MailPoet plugin dependencies.
 $container->set(
 Theme_Controller::class,
 function () {
 return new Theme_Controller();
 }
 );
 $container->set(
 User_Theme::class,
 function () {
 return new User_Theme();
 }
 );
 $container->set(
 Settings_Controller::class,
 function ( $container ) {
 return new Settings_Controller( $container->get( Theme_Controller::class ) );
 }
 );
 $container->set(
 Settings_Controller::class,
 function ( $container ) {
 return new Settings_Controller( $container->get( Theme_Controller::class ) );
 }
 );
 $container->set(
 Templates::class,
 function () {
 return new Templates();
 }
 );
 $container->set(
 Patterns::class,
 function () {
 return new Patterns();
 }
 );
 $container->set(
 Cleanup_Preprocessor::class,
 function () {
 return new Cleanup_Preprocessor();
 }
 );
 $container->set(
 Blocks_Width_Preprocessor::class,
 function () {
 return new Blocks_Width_Preprocessor();
 }
 );
 $container->set(
 Typography_Preprocessor::class,
 function ( $container ) {
 return new Typography_Preprocessor( $container->get( Settings_Controller::class ) );
 }
 );
 $container->set(
 Spacing_Preprocessor::class,
 function () {
 return new Spacing_Preprocessor();
 }
 );
 $container->set(
 Highlighting_Postprocessor::class,
 function () {
 return new Highlighting_Postprocessor();
 }
 );
 $container->set(
 Variables_Postprocessor::class,
 function ( $container ) {
 return new Variables_Postprocessor( $container->get( Theme_Controller::class ) );
 }
 );
 $container->set(
 Process_Manager::class,
 function ( $container ) {
 return new Process_Manager(
 $container->get( Cleanup_Preprocessor::class ),
 $container->get( Blocks_Width_Preprocessor::class ),
 $container->get( Typography_Preprocessor::class ),
 $container->get( Spacing_Preprocessor::class ),
 $container->get( Highlighting_Postprocessor::class ),
 $container->get( Variables_Postprocessor::class ),
 );
 }
 );
 $container->set(
 Blocks_Registry::class,
 function () {
 return new Blocks_Registry();
 }
 );
 $container->set(
 Content_Renderer::class,
 function ( $container ) {
 return new Content_Renderer(
 $container->get( Process_Manager::class ),
 $container->get( Blocks_Registry::class ),
 $container->get( Settings_Controller::class ),
 $container->get( Theme_Controller::class ),
 );
 }
 );
 $container->set(
 Renderer::class,
 function ( $container ) {
 return new Renderer(
 $container->get( Content_Renderer::class ),
 $container->get( Templates::class ),
 $container->get( Theme_Controller::class ),
 );
 }
 );
 $container->set(
 Send_Preview_Email::class,
 function ( $container ) {
 return new Send_Preview_Email(
 $container->get( Renderer::class ),
 );
 }
 );
 $container->set(
 Personalization_Tags_Registry::class,
 function () {
 return new Personalization_Tags_Registry();
 }
 );
 $container->set(
 Email_Api_Controller::class,
 function ( $container ) {
 return new Email_Api_Controller(
 $container->get( Personalization_Tags_Registry::class ),
 );
 }
 );
 $container->set(
 Dependency_Check::class,
 function () {
 return new Dependency_Check();
 }
 );
 $container->set(
 Email_Editor::class,
 function ( $container ) {
 return new Email_Editor(
 $container->get( Email_Api_Controller::class ),
 $container->get( Templates::class ),
 $container->get( Patterns::class ),
 $container->get( Settings_Controller::class ),
 $container->get( Send_Preview_Email::class ),
 $container->get( Personalization_Tags_Registry::class ),
 );
 }
 );
 $this->di_container = $container;
 }
}
