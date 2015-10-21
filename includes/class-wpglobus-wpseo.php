<?php
/**
 * Support of WP-SEO by Yoast
 * @package WPGlobus
 * @since   1.1.1
 */

/**  */
class WPGlobus_WPSEO {

	public static function controller() {
		
		if ( is_admin() ) {

			if ( ! WPGlobus_WP::is_doing_ajax() ) {

				/** @see \WPGlobus::__construct */
				WPGlobus::O()->vendors_scripts['WPSEO'] = true;

				if ( WPGlobus_WP::is_pagenow( 'edit.php' ) ) {
					/**
					 * To translate Yoast columns on edit.php page
					 */
					add_filter( 'esc_html', array(
						'WPGlobus_WPSEO',
						'filter__wpseo_columns'
					), 0 );
				}

				add_action( 'admin_print_scripts', array(
					'WPGlobus_WPSEO',
					'action__admin_print_scripts'
				) );

				add_action( 'wpseo_tab_content', array(
					'WPGlobus_WPSEO',
					'action__wpseo_tab_content'
				), 11 );

				/**
				 * Filter for @see wpseo_linkdex_results
				 * @scope admin
				 * @since 1.2.2		 
				 */				
				add_filter( 'wpseo_linkdex_results', array(
					'WPGlobus_WPSEO',
					'filter__wpseo_linkdex_results'
				), 10, 3 );	
			}


		} else {
			/**
			 * Filter SEO title and meta description on front only, when the page header HTML tags are generated.
			 * AJAX is probably not required (waiting for a case).
			 */
			add_filter( 'wpseo_title', array( 'WPGlobus_Filters', 'filter__text' ), 0 );
			//add_filter( 'wpseo_metadesc', array( 'WPGlobus_Filters', 'filter__text' ), 0 );
			
			/**
			 * Filter for @see wpseo_title
			 * @scope front
			 * @since 1.1.1		 
			 */			
//			add_filter( 'wpseo_title', array( 'WPGlobus_WPSEO', 'filter__title' ), 0 );
			
			/**
			 * Filter for @see wpseo_description
			 * @scope front
			 * @since 1.1.1		 
			 */			
			add_filter( 'wpseo_metadesc', array( 'WPGlobus_WPSEO', 'wpseo_metadesc' ), 0 );					
		
		}

	}
	
	/**
	 * Filter results for Page Analysis tab in default language
     *
	 * @see wpseo_linkdex_results filter
	 *
	 * @scope admin
	 * @since 1.2.2
	 *
	 *
	 * @param array $results
	 * @param array $job
	 * @param WP_Post object $post
	 *
	 * @return array
	 */
	public static function filter__wpseo_linkdex_results( $results, $job, $post ) {

		$job['keyword'] 		= WPGlobus_Core::text_filter( $job['keyword'], WPGlobus::Config()->default_language );
		$job['keyword_folded'] 	= WPGlobus_Core::text_filter( $job['keyword_folded'], WPGlobus::Config()->default_language );

		$results = WPGlobus_WPSEO::calculate_results( 
			$results, 
			WPGlobus_Core::text_filter( $post->post_content, WPGlobus::Config()->default_language ), 
			$job, 
			$post 
		);

		return $results;
	}	

	/**
	 * Calculate the page analysis results for post.
	 *
	 * @internal Unfortunately there isn't a filter available to hook into before returning the results
	 * for get_post_meta(), get_post_custom() and the likes. That would have been the preferred solution.
	 *
	 * @see function calculate_results() in wordpress-seo\admin\class-metabox.php
	 * @scope admin
	 * @since 1.2.2
	 *
	 * @param array $results
	 * @param string $post_content
	 * @param array $job, 
	 * @param WP_Post object $post Post to calculate the results for.
	 *
	 * @return  array
	 */
	public static function calculate_results( $results, $post_content, $job, $post ) {
	
		$WPSEO_Metabox = new WPSEO_Metabox;

		$dom                      = new domDocument;
		$dom->strictErrorChecking = false;
		$dom->preserveWhiteSpace  = false;		

		// Check if the post content is not empty.
		if ( ! empty( $post_content ) ) {
			@$dom->loadHTML( $post_content );
		}

		unset( $post_content );

		$xpath = new DOMXPath( $dom );

		// Check if this focus keyword has been used already.
		$WPSEO_Metabox->check_double_focus_keyword( $job, $results );

		// Keyword.
		$WPSEO_Metabox->score_keyword( $job['keyword'], $results );

		// Title.
		$title = WPSEO_Meta::get_value( 'title', $post->ID );
		if ( $title !== '' ) {
			$job['title'] = $title;
		}
		else {
			if ( isset( $options[ 'title-' . $post->post_type ] ) && $options[ 'title-' . $post->post_type ] !== '' ) {
				$title_template = $options[ 'title-' . $post->post_type ];
			}
			else {
				$title_template = '%%title%% - %%sitename%%';
			}
			$job['title'] = wpseo_replace_vars( $title_template, $post );
		}
		unset( $title );
		$WPSEO_Metabox->score_title( $job, $results );
		// Meta description.
		$description = '';
		// $desc_meta   = WPSEO_Meta::get_value( 'metadesc', $post->ID );
		$desc_meta   = WPGlobus_Core::text_filter( WPSEO_Meta::get_value( 'metadesc', $post->ID ), WPGlobus::Config()->default_language );
		if ( $desc_meta !== '' ) {
			$description = $desc_meta;
		}
		elseif ( isset( $options[ 'metadesc-' . $post->post_type ] ) && $options[ 'metadesc-' . $post->post_type ] !== '' ) {
			$description = wpseo_replace_vars( $options[ 'metadesc-' . $post->post_type ], $post );
		}
		unset( $desc_meta );

		WPSEO_Meta::$meta_length = apply_filters( 'wpseo_metadesc_length', WPSEO_Meta::$meta_length, $post );

		$WPSEO_Metabox->score_description( $job, $results, $description, WPSEO_Meta::$meta_length );
		unset( $description );

		// Body.
		// $body   = $WPSEO_Metabox->get_body( $post );
		$body   = WPGlobus_Core::text_filter( $WPSEO_Metabox->get_body( $post ), WPGlobus::Config()->default_language );
		$firstp = $WPSEO_Metabox->get_first_paragraph( $body );
		$WPSEO_Metabox->score_body( $job, $results, $body, $firstp );
		unset( $firstp );

		// URL.
		$WPSEO_Metabox->score_url( $job, $results );

		// Headings.
		$headings = $WPSEO_Metabox->get_headings( $body );
		$WPSEO_Metabox->score_headings( $job, $results, $headings );
		unset( $headings );

		// Images.
		$imgs          = array();
		$imgs['count'] = substr_count( $body, '<img' );
		$imgs          = $WPSEO_Metabox->get_images_alt_text( $post->ID, $body, $imgs );

		// Check featured image.
		if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
			$imgs['count'] += 1;

			if ( empty( $imgs['alts'] ) ) {
				$imgs['alts'] = array();
			}

			$imgs['alts'][] = $WPSEO_Metabox->strtolower_utf8( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) );
		}

		$WPSEO_Metabox->score_images_alt_text( $job, $results, $imgs );
		unset( $imgs );
		unset( $body );

		// Anchors.
		$anchors = $WPSEO_Metabox->get_anchor_texts( $xpath );
		$count   = $WPSEO_Metabox->get_anchor_count( $xpath );

		$WPSEO_Metabox->score_anchor_texts( $job, $results, $anchors, $count );
		unset( $anchors, $count, $dom );	

		return $results;	
		
	}	
	 
	/**
	 * Filter SEO meta description
	 *
	 * @scope front
	 * @since 1.1.1		 
	 *
	 * @param string $text
	 *
	 * @return string
	 */		
	public static function wpseo_metadesc( $text ) {
		
		if ( empty( $text ) ) {
			return $text;
		}	
		
		return WPGlobus_Core::text_filter( $text, WPGlobus::Config()->language );
	
	}
	
	/**
	 * Generate title
	 *
	 * @see get_title_from_options()
	 * @scope front
	 * @since 1.1.1		 
	 *
	 * @param string $text
	 *
	 * @return string
	 */	
	public static function filter__title( $text ) {

		$text = WPGlobus_Core::text_filter( $text, WPGlobus::Config()->language );

		$wpseo_f = WPSEO_Frontend::get_instance();
		
		if ( empty($text) ) {
			global $post;
			$text = $post->post_title . ' ' . $wpseo_f->get_title_from_options( 'wpseo_titles' );
		}
		
		return $text;
		
	}
	
	/**
	 * To translate Yoast columns
	 * @see   WPSEO_Metabox::column_content
	 * @scope admin
	 *
	 * @param string $text
	 *
	 * @return string
	 * @todo  Yoast said things might change in the next version. See the pull request
	 * @link  https://github.com/Yoast/wordpress-seo/pull/1946
	 */
	public static function filter__wpseo_columns( $text ) {

		if ( WPGlobus_WP::is_filter_called_by( 'column_content', 'WPSEO_Metabox' ) ) {

			$text = WPGlobus_Core::text_filter(
				$text,
				WPGlobus::Config()->language,
				null,
				WPGlobus::Config()->default_language
			);
		}

		return $text;
	}

	/**
	 * Enqueue js for WPSEO support
	 * @since 1.0.8
	 */
	public static function action__admin_print_scripts() {

		if ( WPGlobus_WP::is_pagenow( array( 'post.php', 'post-new.php' ) ) ) {

			$handle = 'wpglobus-wpseo';

			/**
			 * WP-SEO Version 2.2 introduces breaking changes.
			 * A new version of our script will be required.
			 */

			/** @noinspection PhpInternalEntityUsedInspection */
			$src_version = version_compare( WPSEO_VERSION, '2.2', '>=' ) ? '22' : '21';

			$src = WPGlobus::$PLUGIN_DIR_URL . 'includes/js/' .
			       $handle . '-' . $src_version .
			       WPGlobus::SCRIPT_SUFFIX() . '.js';

			wp_enqueue_script(
				$handle,
				$src,
				array( 'jquery' ),
				WPGLOBUS_VERSION,
				true
			);

			wp_localize_script(
				$handle,
				'WPGlobusVendor',
				array(
					'version' => WPGLOBUS_VERSION,
					'vendor'  => WPGlobus::O()->vendors_scripts
				)
			);
		}

	}

	/**
	 * Add language tabs to wpseo metabox ( .wpseo-metabox-tabs-div )
	 */
	public static function action__wpseo_tab_content() {

		/** @global WP_Post $post */
		global $post;

		$type = empty( $post ) ? '' : $post->post_type;
		if ( WPGlobus::O()->disabled_entity( $type ) ) {
			return;
		}

		$permalink = array();
		if ( 'publish' == $post->post_status ) {
			$permalink['url']    = get_permalink( $post->ID );
			$permalink['action'] = 'complete';
		} else {
			$permalink['url']    = trailingslashit( home_url() );
			$permalink['action'] = '';
		}
		?>

		<div id="wpglobus-wpseo-tabs">    <?php
			/**
			 * Use span with attributes 'data' for send to js script ids, names elements for which needs to be set new ids, names with language code.
			 */ ?>
			<span id="wpglobus-wpseo-attr"
			      data-ids="wpseosnippet,wpseosnippet_title,yoast_wpseo_focuskw,focuskwresults,yoast_wpseo_title,yoast_wpseo_title-length-warning,yoast_wpseo_metadesc,yoast_wpseo_metadesc-length,yoast_wpseo_metadesc_notice"
			      data-names="yoast_wpseo_focuskw,yoast_wpseo_title,yoast_wpseo_metadesc"
			      data-qtip="snippetpreviewhelp,focuskwhelp,titlehelp,metadeschelp">
			</span>
			<ul class="wpglobus-wpseo-tabs-list">    <?php
				$order = 0;
				foreach ( WPGlobus::Config()->open_languages as $language ) { ?>
					<li id="wpseo-link-tab-<?php echo $language; ?>"
					    data-language="<?php echo $language; ?>"
					    data-order="<?php echo $order; ?>"
					    class="wpglobus-wpseo-tab"><a
							href="#wpseo-tab-<?php echo $language; ?>"><?php echo WPGlobus::Config()->en_language_name[ $language ]; ?></a>
					</li> <?php
					$order ++;
				} ?>
			</ul>    <?php
			$metadesc   = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
			$wpseotitle = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
			$focuskw    = get_post_meta( $post->ID, '_yoast_wpseo_focuskw', true ); 			
			foreach ( WPGlobus::Config()->open_languages as $language ) {
				$permalink['url'] = WPGlobus_Utils::localize_url( $permalink['url'], $language );
				$url = apply_filters( 'wpglobus_wpseo_permalink', $permalink['url'], $language ); 
				if ( $url != $permalink['url'] ) {
					/* We accept that user's filter make complete permalink for draft */
					/* @todo maybe need more investigation */
					$permalink['action'] = 'complete';
				} else {
					if ( 'publish' != $post->post_status ) {
						/**
						 * We cannot get post-name-full to make correct url here ( for draft & auto-draft ). We do it in JS
						 * @see var wpseosnippet_url in wpglobus-wpseo-**.js
						 */
						$permalink['action'] = '';
					}	
				}			?>
				<div id="wpseo-tab-<?php echo $language; ?>" class="wpglobus-wpseo-general"
				     data-language="<?php echo $language; ?>"
				     data-url-<?php echo $language; ?>="<?php echo $url; ?>"
				     data-permalink="<?php echo $permalink['action']; ?>"
				     data-metadesc="<?php echo esc_html( WPGlobus_Core::text_filter( $metadesc, $language, WPGlobus::RETURN_EMPTY ) ); ?>"
				     data-wpseotitle="<?php echo esc_html( WPGlobus_Core::text_filter( $wpseotitle, $language, WPGlobus::RETURN_EMPTY ) ); ?>"
				     data-focuskw="<?php echo WPGlobus_Core::text_filter( $focuskw, $language, WPGlobus::RETURN_EMPTY ); ?>">
				</div> <?php
			} ?>
		</div>
	<?php
	}


} // class

# --- EOF
