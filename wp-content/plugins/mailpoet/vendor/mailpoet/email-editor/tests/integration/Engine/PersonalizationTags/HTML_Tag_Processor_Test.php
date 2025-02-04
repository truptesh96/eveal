<?php
declare(strict_types = 1);
namespace MailPoet\EmailEditor\Engine\PersonalizationTags;
if (!defined('ABSPATH')) exit;
use WP_HTML_Text_Replacement;
class HTML_Tag_Processor_Test extends \MailPoetTest {
 public function testReplaceToken(): void {
 // Example HTML content to process.
 $html_content = '<div><!--greetings--></div>';
 // Instantiate the HTML_Tag_Processor with the HTML content.
 $processor = new HTML_Tag_Processor( $html_content );
 while ( $processor->next_token() ) {
 if ( $processor->get_token_type() === '#comment' && $processor->get_modifiable_text() === 'greetings' ) {
 $processor->replace_token( 'Hello there!' );
 }
 }
 $processor->flush_updates();
 $updated_html = $processor->get_updated_html();
 $this->assertSame( '<div>Hello there!</div>', $updated_html );
 }
 public function testReplaceMultipleTokens(): void {
 // Example HTML content to process.
 $html_content = '
 <div>
 <h1><!--replace_heading--></h1>
 <p><!--replace_paragraph--></p>
 </div>
 ';
 $processor = new HTML_Tag_Processor( $html_content );
 while ( $processor->next_token() ) {
 if ( $processor->get_token_type() === '#comment' && $processor->get_modifiable_text() === 'replace_heading' ) {
 $processor->replace_token( 'Hello John!' );
 }
 if ( $processor->get_token_type() === '#comment' && $processor->get_modifiable_text() === 'replace_paragraph' ) {
 $processor->replace_token( 'This is a paragraph.' );
 }
 }
 $processor->flush_updates();
 $updated_html = $processor->get_updated_html();
 $this->assertEquals(
 '
 <div>
 <h1>Hello John!</h1>
 <p>This is a paragraph.</p>
 </div>
 ',
 $updated_html
 );
 }
}
