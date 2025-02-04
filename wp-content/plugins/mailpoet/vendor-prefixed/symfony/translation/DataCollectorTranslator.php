<?php
namespace MailPoetVendor\Symfony\Component\Translation;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use MailPoetVendor\Symfony\Component\Translation\Exception\InvalidArgumentException;
use MailPoetVendor\Symfony\Contracts\Translation\LocaleAwareInterface;
use MailPoetVendor\Symfony\Contracts\Translation\TranslatorInterface;
class DataCollectorTranslator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface, WarmableInterface
{
 public const MESSAGE_DEFINED = 0;
 public const MESSAGE_MISSING = 1;
 public const MESSAGE_EQUALS_FALLBACK = 2;
 private $translator;
 private $messages = [];
 public function __construct(TranslatorInterface $translator)
 {
 if (!$translator instanceof TranslatorBagInterface || !$translator instanceof LocaleAwareInterface) {
 throw new InvalidArgumentException(\sprintf('The Translator "%s" must implement TranslatorInterface, TranslatorBagInterface and LocaleAwareInterface.', \get_debug_type($translator)));
 }
 $this->translator = $translator;
 }
 public function trans(?string $id, array $parameters = [], ?string $domain = null, ?string $locale = null)
 {
 $trans = $this->translator->trans($id = (string) $id, $parameters, $domain, $locale);
 $this->collectMessage($locale, $domain, $id, $trans, $parameters);
 return $trans;
 }
 public function setLocale(string $locale)
 {
 $this->translator->setLocale($locale);
 }
 public function getLocale()
 {
 return $this->translator->getLocale();
 }
 public function getCatalogue(?string $locale = null)
 {
 return $this->translator->getCatalogue($locale);
 }
 public function getCatalogues() : array
 {
 return $this->translator->getCatalogues();
 }
 public function warmUp(string $cacheDir)
 {
 if ($this->translator instanceof WarmableInterface) {
 return (array) $this->translator->warmUp($cacheDir);
 }
 return [];
 }
 public function getFallbackLocales()
 {
 if ($this->translator instanceof Translator || \method_exists($this->translator, 'getFallbackLocales')) {
 return $this->translator->getFallbackLocales();
 }
 return [];
 }
 public function __call(string $method, array $args)
 {
 return $this->translator->{$method}(...$args);
 }
 public function getCollectedMessages()
 {
 return $this->messages;
 }
 private function collectMessage(?string $locale, ?string $domain, string $id, string $translation, ?array $parameters = [])
 {
 if (null === $domain) {
 $domain = 'messages';
 }
 $catalogue = $this->translator->getCatalogue($locale);
 $locale = $catalogue->getLocale();
 $fallbackLocale = null;
 if ($catalogue->defines($id, $domain)) {
 $state = self::MESSAGE_DEFINED;
 } elseif ($catalogue->has($id, $domain)) {
 $state = self::MESSAGE_EQUALS_FALLBACK;
 $fallbackCatalogue = $catalogue->getFallbackCatalogue();
 while ($fallbackCatalogue) {
 if ($fallbackCatalogue->defines($id, $domain)) {
 $fallbackLocale = $fallbackCatalogue->getLocale();
 break;
 }
 $fallbackCatalogue = $fallbackCatalogue->getFallbackCatalogue();
 }
 } else {
 $state = self::MESSAGE_MISSING;
 }
 $this->messages[] = ['locale' => $locale, 'fallbackLocale' => $fallbackLocale, 'domain' => $domain, 'id' => $id, 'translation' => $translation, 'parameters' => $parameters, 'state' => $state, 'transChoiceNumber' => isset($parameters['%count%']) && \is_numeric($parameters['%count%']) ? $parameters['%count%'] : null];
 }
}
