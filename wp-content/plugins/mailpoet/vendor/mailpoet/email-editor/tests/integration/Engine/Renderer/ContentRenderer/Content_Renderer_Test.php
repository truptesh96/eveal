<?php
declare(strict_types = 1);
namespace MailPoet\EmailEditor\Engine\Renderer\ContentRenderer;
if (!defined('ABSPATH')) exit;
use MailPoet\EmailEditor\Engine\Email_Editor;
use MailPoet\EmailEditor\Integrations\MailPoet\Blocks\BlockTypesController;
require_once __DIR__ . '/Dummy_Block_Renderer.php';
class Content_Renderer_Test extends \MailPoetTest {
 private Content_Renderer $renderer;
 private \WP_Post $email_post;
 public function _before(): void {
 parent::_before();
 $this->di_container->get( Email_Editor::class )->initialize();
 $this->di_container->get( BlockTypesController::class )->initialize();
 $this->renderer = $this->di_container->get( Content_Renderer::class );
 $this->email_post = $this->tester->create_post(
 array(
 'post_content' => '<!-- wp:paragraph --><p>Hello!</p><!-- /wp:paragraph -->',
 )
 );
 }
 public function testItRendersContent(): void {
 $template = new \WP_Block_Template();
 $template->id = 'template-id';
 $template->content = '<!-- wp:core/post-content /-->';
 $content = $this->renderer->render(
 $this->email_post,
 $template
 );
 verify( $content )->stringContainsString( 'Hello!' );
 }
 public function testItInlinesContentStyles(): void {
 $template = new \WP_Block_Template();
 $template->id = 'template-id';
 $template->content = '<!-- wp:core/post-content /-->';
 $rendered = $this->renderer->render( $this->email_post, $template );
 $paragraph_styles = $this->getStylesValueForTag( $rendered, 'p' );
 verify( $paragraph_styles )->stringContainsString( 'margin: 0' );
 verify( $paragraph_styles )->stringContainsString( 'display: block' );
 }
 public function testItRendersBlockWithFallbackRenderer(): void {
 $fallback_renderer = $this->createMock( Block_Renderer::class );
 $fallback_renderer->expects( $this->once() )->method( 'render' );
 $blocks_registry = $this->createMock( Blocks_Registry::class );
 $blocks_registry->expects( $this->once() )->method( 'get_block_renderer' )->willReturn( null );
 $blocks_registry->expects( $this->once() )->method( 'get_fallback_renderer' )->willReturn( $fallback_renderer );
 $renderer = $this->getServiceWithOverrides(
 Content_Renderer::class,
 array(
 'blocks_registry' => $blocks_registry,
 )
 );
 $renderer->render_block( 'content', array( 'blockName' => 'block' ) );
 }
 public function testItRendersBlockWithBlockRenderer(): void {
 $renderer = $this->createMock( Block_Renderer::class );
 $blocks_registry = $this->createMock( Blocks_Registry::class );
 $blocks_registry->expects( $this->once() )->method( 'get_block_renderer' )->willReturn( $renderer );
 $blocks_registry->expects( $this->never() )->method( 'get_fallback_renderer' )->willReturn( null );
 $renderer = $this->getServiceWithOverrides(
 Content_Renderer::class,
 array(
 'blocks_registry' => $blocks_registry,
 )
 );
 $renderer->render_block( 'content', array( 'blockName' => 'block' ) );
 }
 public function testItReturnsContentIfNoRendererAvailable(): void {
 $blocks_registry = $this->createMock( Blocks_Registry::class );
 $blocks_registry->expects( $this->once() )->method( 'get_block_renderer' )->willReturn( null );
 $blocks_registry->expects( $this->once() )->method( 'get_fallback_renderer' )->willReturn( null );
 $renderer = $this->getServiceWithOverrides(
 Content_Renderer::class,
 array(
 'blocks_registry' => $blocks_registry,
 )
 );
 verify( $renderer->render_block( 'content', array( 'blockName' => 'block' ) ) )->equals( 'content' );
 }
 private function getStylesValueForTag( $html, $tag ): ?string {
 $html = new \WP_HTML_Tag_Processor( $html );
 if ( $html->next_tag( $tag ) ) {
 return $html->get_attribute( 'style' );
 }
 return null;
 }
}
