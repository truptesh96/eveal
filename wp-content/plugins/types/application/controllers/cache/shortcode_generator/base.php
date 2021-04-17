<?php

namespace OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator;

/**
 * Shortcode generator cache controller: base class for post/term/user fields cache managers.
 *
 * @since 3.3.6
 */
abstract class Base {

	/**
	 * @var \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\ManagerBase
	 */
	protected $manager;

	/**
	 * @var \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\InvalidatorBase
	 */
	protected $invalidator;

	/**
	 * Constructor.
	 *
	 * @param \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\ManagerBase $manager
	 * @param \OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\InvalidatorBase $invalidator
	 */
	public function __construct(
		\OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\ManagerBase $manager,
		\OTGS\Toolset\Types\Controller\Cache\ShortcodeGenerator\InvalidatorBase $invalidator
	) {
		$this->manager = $manager;
		$this->invalidator = $invalidator;

	}

	/**
	 * Initialize the controller:
	 * - initialize the cache manager.
	 * - initialize the cache invalidator.
	 *
	 * @since 3.3.6
	 */
	public function initialize() {
		$this->manager->initialize();
		$this->invalidator->initialize();
	}

}
