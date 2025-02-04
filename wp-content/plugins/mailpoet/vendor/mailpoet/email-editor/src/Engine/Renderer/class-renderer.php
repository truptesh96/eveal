<?php
declare(strict_types = 1);
namespace MailPoet\EmailEditor\Engine\Renderer;
if (!defined('ABSPATH')) exit;
use MailPoet\EmailEditor\Engine\Renderer\ContentRenderer\Content_Renderer;
use MailPoet\EmailEditor\Engine\Templates\Templates;
use MailPoet\EmailEditor\Engine\Theme_Controller;
use MailPoetVendor\Html2Text\Html2Text;
use MailPoetVendor\Pelago\Emogrifier\CssInliner;
use WP_Style_Engine;
use WP_Theme_JSON;
class Renderer {
 private Theme_Controller $theme_controller;
 private Content_Renderer $content_renderer;
 private Templates $templates;
 const TEMPLATE_FILE = 'template-canvas.php';
 const TEMPLATE_STYLES_FILE = 'template-canvas.css';
 public function __construct(
 Content_Renderer $content_renderer,
 Templates $templates,
 Theme_Controller $theme_controller
 ) {
 $this->content_renderer = $content_renderer;
 $this->templates = $templates;
 $this->theme_controller = $theme_controller;
 }
 public function render( \WP_Post $post, string $subject, string $pre_header, string $language, $meta_robots = '' ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
 $template_slug = get_page_template_slug( $post ) ? get_page_template_slug( $post ) : 'email-general';
 // phpcs:ignore Generic.Commenting.DocComment.MissingShort -- used for phpstan
 $template = $this->templates->get_block_template( $template_slug );
 $email_styles = $this->theme_controller->get_styles();
 $template_html = $this->content_renderer->render( $post, $template );
 $layout = $this->theme_controller->get_layout_settings();
 ob_start();
 include self::TEMPLATE_FILE;
 $rendered_template = (string) ob_get_clean();
 $template_styles =
 WP_Style_Engine::compile_css(
 array(
 'background-color' => $email_styles['color']['background'] ?? 'inherit',
 'color' => $email_styles['color']['text'] ?? 'inherit',
 'padding-top' => $email_styles['spacing']['padding']['top'] ?? '0px',
 'padding-bottom' => $email_styles['spacing']['padding']['bottom'] ?? '0px',
 'padding-left' => $email_styles['spacing']['padding']['left'] ?? '0px',
 'padding-right' => $email_styles['spacing']['padding']['right'] ?? '0px',
 'font-family' => $email_styles['typography']['fontFamily'] ?? 'inherit',
 'line-height' => $email_styles['typography']['lineHeight'] ?? '1.5',
 'font-size' => $email_styles['typography']['fontSize'] ?? 'inherit',
 ),
 'body, .email_layout_wrapper'
 );
 $template_styles .= '.email_layout_wrapper { box-sizing: border-box;}';
 $template_styles .= file_get_contents( __DIR__ . '/' . self::TEMPLATE_STYLES_FILE );
 $template_styles = '<style>' . wp_strip_all_tags( (string) apply_filters( 'mailpoet_email_renderer_styles', $template_styles, $post ) ) . '</style>';
 $rendered_template = $this->inline_css_styles( $template_styles . $rendered_template );
 // This is a workaround to support link :hover in some clients. Ideally we would remove the ability to set :hover
 // however this is not possible using the color panel from Gutenberg.
 if ( isset( $email_styles['elements']['link'][':hover']['color']['text'] ) ) {
 $rendered_template = str_replace( '<!-- Forced Styles -->', '<style>a:hover { color: ' . esc_attr( $email_styles['elements']['link'][':hover']['color']['text'] ) . ' !important; }</style>', $rendered_template );
 }
 return array(
 'html' => $rendered_template,
 'text' => $this->render_text_version( $rendered_template ),
 );
 }
 private function inline_css_styles( $template ) {
 return CssInliner::fromHtml( $template )->inlineCss()->render(); // TODO: Install CssInliner.
 }
 private function render_text_version( $template ) {
 $template = ( mb_detect_encoding( $template, 'UTF-8', true ) ) ? $template : mb_convert_encoding( $template, 'UTF-8', mb_list_encodings() );
 $result = Html2Text::convert( $template ); // TODO: Install Html2Text.
 if ( false === $result ) {
 return '';
 }
 return $result;
 }
}
