<?php


namespace Tribe\Project\Theme;


use Tribe\Project\Templates\Components\Video;

class Oembed_Filter {

	const CACHE_PREFIX     = '_oembed_filtered_';
	const PROVIDER_VIMEO   = 'Vimeo';
	const PROVIDER_YOUTUBE = 'YouTube';

	private $supported_providers = [];

	public function __construct( array $supported_providers = [ self::PROVIDER_VIMEO, self::PROVIDER_YOUTUBE ] ) {
		$this->supported_providers = $supported_providers;
	}

	public function get_video_component( $html, $data, $url ) {
		/**
		 * @var $cache Cache
		 */
		$cache = tribe_project()->container()['cache'];

		$figure_classes = [ 'video__embed', 'wp-embed-lazy' ];

		if ( $data->provider_name === 'YouTube' ) {
			$embed_id    = $this->get_youtube_embed_id( $url );
			$video_thumb = $this->get_youtube_max_resolution_thumbnail( $url );

			if ( strpos( $video_thumb, 'maxresdefault' ) === false ) {
				$figure_classes[] = 'wp-embed-lazy--low-res';
			}

		} else {
			$embed_id    = $this->get_vimeo_embed_id( $url );
			$video_thumb = $data->thumbnail_url;
		}

		$options = [
			Video::THUMBNAIL_URL   => $video_thumb,
			Video::CONTAINER_ATTRS => $this->get_layout_container_attrs( $data->provider_name, $embed_id ),
			Video::FIGURE_CLASSES  => $figure_classes,
			Video::TITLE           => $data->title,
			Video::VIDEO_URL       => $url,
		];

		$video_obj = Video::factory( $options );
		$html      = $video_obj->render();

		$cache->set( $url, $html, 'video_data_objects' );

		return $html;
	}

	private function get_layout_container_attrs( $provider_name, $embed_id ): array {
		return [
			'data-js'             => 'video',
			'data-embed-id'       => $embed_id,
			'data-embed-provider' => $provider_name,
		];
	}

	/**
	 * If we've cached replacement HTML for a URL, override
	 * the default with the cached value.
	 *
	 * @filter embed_oembed_html 1
	 */
	public function filter_frontend_html_from_cache( $html, $url, $attr, $post_id ) {
		if ( is_admin() ) {
			return $html;
		}

		$cache = tribe_project()->container()['cache'];

		$cached = $cache->get( $url, 'video_data_objects' );

		return empty( $cached ) ? $html : $cached;
	}

	/**
	 * Get the highest resolution thumbnail we can get for
	 * a YouTube video
	 *
	 * @todo Use \Tribe\Libs\Oembed\YouTube when it's working
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	private function get_youtube_max_resolution_thumbnail( $url ) {

		$video_id = $this->get_youtube_embed_id( $url );

		if ( $video_id === null ) {
			return '';
		}

		$maxthumburl = sprintf( 'https://i.ytimg.com/vi/%s/maxresdefault.jpg', $video_id );

		$cache_key = 'yt_thumb_' . md5( $maxthumburl );

		$url = wp_cache_get( $cache_key );

		if ( $url === false ) {
			$url = $maxthumburl;

			$response = wp_remote_head( $maxthumburl );
			if ( wp_remote_retrieve_response_code( $response ) == 404 ) {
				$url = 'https://i.ytimg.com/vi/' . $video_id . '/0.jpg';
			}

			wp_cache_set( $cache_key, $url );
		}

		return $url;
	}

	/**
	 * Extract the video ID from a YouTube URL
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	private function get_youtube_embed_id( $url ) {
		preg_match( '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $url, $video_id );

		return ! empty( $video_id[0] ) ? $video_id[0] : '';
	}

	/**
	 * Extract the video ID from a vimeo URL
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	private function get_vimeo_embed_id( $url ) {
		preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $url, $video_id );

		return ! empty( $video_id[5] ) ? $video_id[5] : '';
	}

	/**
	 * Store the front-end HTML for a URL
	 * in the options table
	 *
	 * WordPress will regenerate the oembed cache
	 * whenever its cache expires. When it does so,
	 * this filter will run again and update at the
	 * same time.
	 *
	 * @param string $frontend_html
	 * @param string $url
	 */
	private function cache_frontend_html( $frontend_html, $url ) {
		update_option( $this->get_cache_key( $url ), $frontend_html );
	}

	/**
	 * @param string $url
	 *
	 * @return string The option name to use to store the cache for a URL
	 */
	private function get_cache_key( $url ) {
		$hash = md5( $url );

		return static::CACHE_PREFIX . $hash;
	}
}
