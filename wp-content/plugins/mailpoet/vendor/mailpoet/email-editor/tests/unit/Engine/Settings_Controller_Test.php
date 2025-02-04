<?php
declare(strict_types = 1);
namespace MailPoet\EmailEditor\Engine;
if (!defined('ABSPATH')) exit;
class Settings_Controller_Test extends \MailPoetUnitTest {
 public function testItGetsCorrectLayoutWidthWithoutPadding(): void {
 $theme_json_mock = $this->createMock( \WP_Theme_JSON::class );
 $theme_json_mock->method( 'get_data' )->willReturn(
 array(
 'styles' => array(
 'spacing' => array(
 'padding' => array(
 'left' => '10px',
 'right' => '10px',
 ),
 ),
 ),
 )
 );
 $theme_controller = $this->createMock( Theme_Controller::class );
 $theme_controller->method( 'get_theme' )->willReturn( $theme_json_mock );
 $theme_controller->method( 'get_layout_settings' )->willReturn(
 array(
 'contentSize' => '660px',
 'wideSize' => null,
 )
 );
 $settings_controller = new Settings_Controller( $theme_controller );
 $layout_width = $settings_controller->get_layout_width_without_padding();
 // default width is 660px and if we subtract padding from left and right we must get the correct value.
 $expected_width = 660 - 10 * 2;
 $this->assertEquals( $expected_width . 'px', $layout_width );
 }
}
