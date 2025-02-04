<?php
declare(strict_types = 1);
namespace MailPoet\EmailEditor\Integrations\Core\Renderer\Blocks;
if (!defined('ABSPATH')) exit;
use MailPoet\EmailEditor\Engine\Email_Editor;
use MailPoet\EmailEditor\Engine\Settings_Controller;
class Columns_Test extends \MailPoetTest {
 private $columns_renderer;
 private $parsed_columns = array(
 'blockName' => 'core/columns',
 'attrs' => array(),
 'email_attrs' => array(
 'width' => '784px',
 ),
 'innerHTML' => '<div class="wp-block-columns"></div>',
 'innerBlocks' => array(
 0 => array(
 'blockName' => 'core/column',
 'attrs' => array(),
 'innerBlocks' => array(
 0 => array(
 'blockName' => 'core/paragraph',
 'attrs' => array(),
 'innerBlocks' => array(),
 'innerHTML' => '<p>Column 1</p>',
 'innerContent' => array(
 0 => '<p>Column 1</p>',
 ),
 ),
 ),
 'innerHTML' => '<div class="wp-block-column"></div>',
 'innerContent' => array(
 0 => '<div class="wp-block-column">',
 1 => null,
 2 => '</div>',
 ),
 ),
 ),
 );
 private $settings_controller;
 public function _before() {
 $this->di_container->get( Email_Editor::class )->initialize();
 $this->columns_renderer = new Columns();
 $this->settings_controller = $this->di_container->get( Settings_Controller::class );
 }
 public function testItRendersInnerColumn() {
 $rendered = $this->columns_renderer->render( '', $this->parsed_columns, $this->settings_controller );
 verify( $rendered )->stringContainsString( 'Column 1' );
 }
 public function testItContainsColumnsStyles(): void {
 $parsed_columns = $this->parsed_columns;
 $parsed_columns['attrs'] = array(
 'style' => array(
 'border' => array(
 'color' => '#123456',
 'radius' => '10px',
 'width' => '2px',
 ),
 'color' => array(
 'background' => '#abcdef',
 ),
 'spacing' => array(
 'padding' => array(
 'bottom' => '5px',
 'left' => '15px',
 'right' => '20px',
 'top' => '10px',
 ),
 ),
 ),
 );
 $rendered = $this->columns_renderer->render( '', $parsed_columns, $this->settings_controller );
 verify( $rendered )->stringContainsString( 'background-color:#abcdef;' );
 verify( $rendered )->stringContainsString( 'border-color:#123456;' );
 verify( $rendered )->stringContainsString( 'border-radius:10px;' );
 verify( $rendered )->stringContainsString( 'border-width:2px;' );
 verify( $rendered )->stringContainsString( 'border-style:solid;' );
 verify( $rendered )->stringContainsString( 'padding-bottom:5px;' );
 verify( $rendered )->stringContainsString( 'padding-left:15px;' );
 verify( $rendered )->stringContainsString( 'padding-right:20px;' );
 verify( $rendered )->stringContainsString( 'padding-top:10px;' );
 }
 public function testItSetsCustomColorAndBackground(): void {
 $parsed_columns = $this->parsed_columns;
 $parsed_columns['attrs']['style']['color']['text'] = '#123456';
 $parsed_columns['attrs']['style']['color']['background'] = '#654321';
 $rendered = $this->columns_renderer->render( '', $parsed_columns, $this->settings_controller );
 $this->checkValidHTML( $rendered );
 $this->assertStringContainsString( 'color:#123456;', $rendered );
 $this->assertStringContainsString( 'background-color:#654321;', $rendered );
 }
 public function testItPreservesClassesSetByEditor(): void {
 $parsed_columns = $this->parsed_columns;
 $content = '<div class="wp-block-columns editor-class-1 another-class"></div>';
 $parsed_columns['attrs']['style']['color']['background'] = '#654321';
 $rendered = $this->columns_renderer->render( $content, $parsed_columns, $this->settings_controller );
 $this->checkValidHTML( $rendered );
 $this->assertStringContainsString( 'wp-block-columns editor-class-1 another-class', $rendered );
 }
}
