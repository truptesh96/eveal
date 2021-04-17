<?php

namespace OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator;

/**
 * Postmeta cache controller.
 *
 * @since 3.3.6
 */
class Postmeta extends Base {

	const TRANSIENT_KEY = 'toolset_types_cache_sg_postmeta';

	/**
	 * Constructor.
	 *
	 * @param \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\Postmeta\Manager $manager
	 * @param \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\Postmeta\Invalidator
	 */
	public function __construct(
		\OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\Postmeta\Manager $manager,
		\OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\Postmeta\Invalidator $invalidator
	) {
		$this->manager = $manager;
		$this->invalidator = $invalidator;
	}

}
