<?php

namespace Tribe\Project\Templates\Components;

class Video extends Component {

	const TEMPLATE_NAME = 'components/video.twig';

	const TITLE           = 'title';
	const VIDEO_URL       = 'video_url';
	const THUMBNAIL_URL   = 'thumbnail_url';
	const PLAY_TEXT       = 'play_text';
	const SHIM            = 'shim';
	const FIGURE_CLASSES  = 'figure_classes';
	const CONTAINER_ATTRS = 'container_attrs';

	protected function parse_options( array $options ): array {
		$defaults = [
			static::TITLE           => '',
			static::VIDEO_URL       => '',
			static::THUMBNAIL_URL   => '',
			static::PLAY_TEXT       => __( 'Play Video', 'tribe' ),
			static::SHIM            => '/wp-content/plugins/core/assets/theme/img/shims/16x9.png',
			static::FIGURE_CLASSES  => [],
			static::CONTAINER_ATTRS => [],
		];

		return wp_parse_args( $options, $defaults );
	}

	public function get_data(): array {
		$data = [
			static::TITLE           => $this->options[ static::TITLE ],
			static::VIDEO_URL       => $this->options[ static::VIDEO_URL ],
			static::THUMBNAIL_URL   => $this->options[ static::THUMBNAIL_URL ],
			static::PLAY_TEXT       => $this->options[ static::PLAY_TEXT ],
			static::SHIM            => $this->options[ static::SHIM ],
			static::FIGURE_CLASSES  => $this->merge_classes( [], $this->options[ static::FIGURE_CLASSES ], true ),
			static::CONTAINER_ATTRS => $this->merge_attrs( [], $this->options[ static::CONTAINER_ATTRS ], true ),
		];

		return $data;
	}

}