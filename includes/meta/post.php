<?php
	/**
	 * Registers meta boxes.
	 *
	 * @return void
	 */
	function stag_metabox_post() {
		$meta_box = array(
			'id'          => 'stag-metabox-portfolio',
			'title'       => __( 'Background Settings', 'ink-assistant' ),
			'description' => __( 'Here you can customize post background cover. The cover&rsquo;s image is selected at &ldquo;Featured Image&rdquo; panel on the right.', 'ink-assistant' ),
			'page'        => 'post',
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(
				array(
					'name' => __( 'Background Color', 'ink-assistant' ),
					'desc' => __( 'Choose background color for this post.', 'ink-assistant' ),
					'id'   => 'post-background-color',
					'type' => 'color',
					'std'  => '#000000',
				),
				array(
					'name' => __( 'Featured Image Opacity', 'ink-assistant' ),
					'desc' => __( 'Choose featured image opacity for this post.', 'ink-assistant' ),
					'id'   => 'post-background-opacity',
					'type' => 'number',
					'std'  => '80',
					'step' => '5',
					'min'  => '0',
				),
				array(
					'name'    => __( 'Cover Filter', 'ink-assistant' ),
					'desc'    => __( 'Applies CSS3 filter on cover image.', 'ink-assistant' ),
					'id'      => 'post-background-filter',
					'type'    => 'select',
					'std'     => 'none',
					'options' => array(
						'none'       => __( 'None', 'ink-assistant' ),
						'grayscale'  => __( 'Grayscale', 'ink-assistant' ),
						'sepia'      => __( 'Sepia', 'ink-assistant' ),
						'blur'       => __( 'Blur', 'ink-assistant' ),
						'hue-rotate' => __( 'Hue Rotate', 'ink-assistant' ),
						'contrast'   => __( 'Contrast', 'ink-assistant' ),
						'brightness' => __( 'Brightness', 'ink-assistant' ),
						'invert'     => __( 'Invert', 'ink-assistant' ),
					),
				),
			),
		);

		stag_add_meta_box( $meta_box );

		$meta_box = array(
			'id'          => 'stag-metabox-portfolio',
			'title'       => __( 'Background Settings', 'ink-assistant' ),
			'description' => __( 'Here you can customize page background cover. The cover&rsquo;s image is selected at &ldquo;Featured Image&rdquo; panel on the right.', 'ink-assistant' ),
			'page'        => 'page',
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(
				array(
					'name' => __( 'Background Color', 'ink-assistant' ),
					'desc' => __( 'Choose background color for this page.', 'ink-assistant' ),
					'id'   => 'post-background-color',
					'type' => 'color',
					'std'  => '#000000',
				),
				array(
					'name' => __( 'Featured Image Opacity', 'ink-assistant' ),
					'desc' => __( 'Choose featured image opacity for this page.', 'ink-assistant' ),
					'id'   => 'post-background-opacity',
					'type' => 'number',
					'std'  => '80',
					'step' => '5',
					'min'  => '0',
				),
				array(
					'name'    => __( 'Cover Filter', 'ink-assistant' ),
					'desc'    => __( 'Applies CSS3 filter on cover image.', 'ink-assistant' ),
					'id'      => 'post-background-filter',
					'type'    => 'select',
					'std'     => 'none',
					'options' => array(
						'none'       => __( 'None', 'ink-assistant' ),
						'grayscale'  => __( 'Grayscale', 'ink-assistant' ),
						'sepia'      => __( 'Sepia', 'ink-assistant' ),
						'blur'       => __( 'Blur', 'ink-assistant' ),
						'hue-rotate' => __( 'Hue Rotate', 'ink-assistant' ),
						'contrast'   => __( 'Contrast', 'ink-assistant' ),
						'brightness' => __( 'Brightness', 'ink-assistant' ),
						'invert'     => __( 'Invert', 'ink-assistant' ),
					),
				),
			),
		);

		stag_add_meta_box( $meta_box );

		$meta_box = array(
			'id'          => 'stag-metabox-layout',
			'title'       => __( 'Sidebar Settings', 'ink-assistant' ),
			'description' => __( 'Select a sidebar here to display its widgets after the page content.', 'ink-assistant' ),
			'page'        => 'page',
			'context'     => 'side',
			'priority'    => 'high',
			'fields'      => array(
				array(
					'name'    => __( 'Choose Sidebar', 'ink-assistant' ),
					'desc'    => null,
					'id'      => 'page-sidebar',
					'type'    => 'select',
					'std'     => 'default',
					'options' => stag_registered_sidebars( array( '' => __( 'No Sidebar', 'ink-assistant' ) ) ),
				),
				array(
					'name' => __( 'Hide Page Title?', 'ink-assistant' ),
					'desc' => null,
					'id'   => 'page-hide-title',
					'type' => 'checkbox',
					'std'  => 'off',
				),
			),
		);

		global $post;

		if ( ! empty( $post ) ) {
			if ( 'widgetized.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
				stag_add_meta_box( $meta_box );
			}
		}

		$meta_box = array(
			'id'          => 'stag-metabox-video',
			'title'       => __( 'Video Cover Settings', 'ink-assistant' ),
			'description' => __( 'Select a video to display at the post&lsquo;s single page. If these fields are left blank, the Featured Image will show. The background settings from the panel above (background color and opacity) also apply for the video cover. (Videos are disabled for viewports smaller than 650px of width.)', 'ink-assistant' ),
			'page'        => 'post',
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(
				array(
					'name'    => __( 'MP4 File URL', 'ink-assistant' ),
					'desc'    => __( 'Enter URL to .mp4 video file.', 'ink-assistant' ),
					'id'      => 'post-video-mp4',
					'type'    => 'file',
					'std'     => '',
					'library' => 'video',
				),
				array(
					'name'    => __( 'Webm File URL', 'ink-assistant' ),
					'desc'    => __( 'Enter URL to .webm video file.', 'ink-assistant' ),
					'id'      => 'post-video-webm',
					'type'    => 'file',
					'std'     => '',
					'library' => 'video',
				),
				array(
					'name'    => __( 'OGV File URL', 'ink-assistant' ),
					'desc'    => __( 'Enter URL to .ogv video file.', 'ink-assistant' ),
					'id'      => 'post-video-ogv',
					'type'    => 'file',
					'std'     => '',
					'library' => 'video',
				),
			),
		);

		stag_add_meta_box( $meta_box );
	}

	add_action( 'add_meta_boxes', 'stag_metabox_post' );
