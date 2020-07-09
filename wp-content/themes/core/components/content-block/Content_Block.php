<?php

namespace Tribe\Project\Templates\Components;

use Tribe\Project\Components\Component;

/**
 * Class Content_Block
 *
 * @property string   $tag
 * @property string[] $classes
 * @property string[] $attrs
 * @property string[] $container_classes
 * @property array    $leadin
 * @property array    $title
 * @property array    $text
 * @property array    $action
 * @property string   $action_component
 */
class Content_Block extends Component {

	public const TAG              = 'tag';
	public const CLASSES          = 'classes';
	public const ATTRS            = 'attrs';
	public const LEADIN           = 'leadin';
	public const TITLE            = 'title';
	public const TEXT             = 'text';
	public const ACTION           = 'action';
	public const ACTION_COMPONENT = 'action_component';

	protected function defaults(): array {
		return [
			self::TAG              => 'div',
			self::CLASSES          => [ 'c-content-block' ],
			self::ATTRS            => [],
			self::LEADIN           => [],
			self::TITLE            => [],
			self::TEXT             => [],
			self::ACTION           => [],
			self::ACTION_COMPONENT => 'link/Link.php',
		];
	}
}
