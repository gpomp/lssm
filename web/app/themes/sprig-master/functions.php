<?php

	if (!class_exists('Timber')){
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . admin_url('plugins.php#timber') . '">' . admin_url('plugins.php') . '</a></p></div>';
		});
		return;
	}

	/**
	* 	Add custom timber routes
	*/

	Routes::map('blog/page/:paged', function($params){
    	Routes::load('blog.php', $params);
	});

	Routes::map('gallerie/page/:paged', function($params){
    	Routes::load('page-gallerie.php', $params);
	});

	Timber::add_route('objet-cat/:name', function($params){
		$params['paged'] = 0;
    Timber::load_template('single-objet-cat.php', false, 200, $params);
	});

	Timber::add_route('objet-cat/:name/page/:paged', function($params){
    	Timber::load_template('single-objet-cat.php', false, 200, $params);
	});

	Timber::add_route('service-cat/:name', function($params){
		$params['paged'] = 0;
    Timber::load_template('single-service-cat.php', false, 200, $params);
	});

	Timber::add_route('service-cat/:name/page/:paged', function($params){
    	Timber::load_template('single-service-cat.php', false, 200, $params);
	});

	

	// Allow group write permissions on new files
	umask(0002);

	function getYTIDFromURL($url) {
		$values = '';
		if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		}
		else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		    $values = $id[1];
		}

		echo $values;
	}

	add_action('getYTIDFromURL', 'getYTIDFromURL');

	function getObjectListExist() {
		return isset($_SESSION['objectList']) && count($_SESSION['objectList']) > 0;
	}

	add_action('getObjectListExist', 'getObjectListExist');

	function pif_disable_redirect_canonical($redirect_url) {
		if (is_singular('objet-cat')) $redirect_url = false;
		return $redirect_url;
	}
	add_filter('redirect_canonical','pif_disable_redirect_canonical');

	class LSSM extends TimberSite {

		function __construct(){
			add_theme_support('post-formats');
			add_theme_support('post-thumbnails');
			add_theme_support('menus');
			add_theme_support('soil-clean-up');

			add_filter('timber_context', array($this, 'add_to_context'));
			add_filter('get_twig', array($this, 'add_to_twig'));
			add_filter('wp_handle_upload', array($this, 'handle_upload'));


			update_option('large_size_w', 1920);
			update_option('large_size_h', 1920);

			if ( function_exists( 'add_image_size' ) ) { 
			    add_image_size( 'mobile-size', 760, 520, true);
			}

			add_filter('pre_site_transient_update_core', array($this, 'disable_updates'));
			add_filter('pre_site_transient_update_plugins', array($this, 'disable_updates'));
			add_filter('pre_site_transient_update_themes', array($this, 'disable_updates'));

			add_action('init', array($this, 'register_post_types'));			

			add_action('admin_menu', array($this, 'remove_menu'));	

			/*if (@$_SERVER['HTTP_X_PJAX']) {
				ob_start(function($output) {
					// Code from VTalbot/Pjax (Laravel Pjax plugin)
					$crawler = new Symfony\Component\DomCrawler\Crawler($output);
					$html = $crawler->filter(@$_SERVER['HTTP_X_PJAX_CONTAINER'])->html();
					$title = $crawler->filter('head title')->html();
					header('X-PJAX-URL: ' . $_SERVER['REQUEST_URI']);
					return '<title>' . $title . '</title>' . $html;
				});
			}*/

			// This function call may trigger some actions to fire, which may
			// add scripts and such to the header queue
			get_header();

			parent::__construct();
		}

		function register_post_types(){
			//this is where you can register custom post types
			register_post_type( 'actu',
				array(
					'labels' => array(
						'name' => __( 'Actu' ),
						'singular_name' => __( 'Actu' )
					),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'actu',
					)
				)
			);

			register_post_type( 'projet',
				array(
					'labels' => array(
						'name' => __( 'Project' ),
						'singular_name' => __( 'Project' )
					),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'projet',
					)
				)
			);

			register_post_type( 'service-cat',
				array(
					'labels' => array(
						'name' => __( 'Categorie Service' ),
						'singular_name' => __( 'Categorie Service' )
					),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'service-cat',
					)
				)
			);

			register_post_type( 'service',
				array(
					'labels' => array(
						'name' => __( 'Service' ),
						'singular_name' => __( 'Service' )
					),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'service',
					)
				)
			);

			register_post_type( 'objet-cat',
				array(
					'labels' => array(
						'name' => __( 'Categorie Objet' ),
						'singular_name' => __( 'Categorie Objet' )
					),
					'rewrite' => array( 'slug' => 'objet-cat' ),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'objet-cat',
					)
				)
			);

			register_post_type( 'objet',
				array(
					'labels' => array(
						'name' => __( 'Objet' ),
						'singular_name' => __( 'Objet' )
					),
					'public' => true,
					'has_archive' => false,
					'capability_type' => 'post',
					'supports' => array(
						'title',
						'editor'
					),
					'rewrite' => array(
						'slug' => 'objet',
					)
				)
			);
		}

		function register_taxonomies(){
			//this is where you can register custom taxonomies
		}

		function add_to_context($context){
			$context['menu'] = new TimberMenu();
			$context['site'] = $this;

			return $context;
		}

		function add_to_twig($twig){
			$twig->addExtension(new Twig_Extension_StringLoader());
			$twig->addFilter('trailing_slash', new Twig_Filter_Function(array($this, 'add_trailing_slash')));
			return $twig;
		}

		function add_trailing_slash($text) {
			return rtrim($text, '/') . '/';
		}

		function remove_menu() {
			remove_menu_page('edit.php');
			remove_menu_page('edit-comments.php');
			remove_submenu_page( 'index.php', 'update-core.php' );
			remove_submenu_page('plugins.php', 'plugin-install.php');
		}

		/**
		 * Due to the fact we manage WordPress and related plugins via Composer
		 * we do not want the WordPress admin panel to report updates. All updates
		 * should be made in composer.json and then deployed to each environment.
		 *
		 * @return object
		 */
		function disable_updates() {
			global $wp_version;
			return (object) array(
				'last_checked' => time(),
				'version_checked' => $wp_version,
			);
		}

		/**
		 * Reduce all upload images to maximum size and quality
		 *
		 * @param $params
		 *
		 * @internal param $init
		 * @return mixed
		 */
		function handle_upload($params) {
			$filePath = $params['file'];
			if ((!is_wp_error($params)) && file_exists($filePath) && in_array($params['type'], array('image/png','image/gif','image/jpeg'))) {
				$quality                        = 85;
				list($largeWidth, $largeHeight) = array( get_option('large_size_w'), get_option('large_size_h'));
				list($oldWidth, $oldHeight)     = getimagesize($filePath);
				list($newWidth, $newHeight)     = wp_constrain_dimensions($oldWidth, $oldHeight, $largeWidth, $largeHeight);
				$resizeImageResult = wp_get_image_editor( $filePath );//image_resize($filePath, $newWidth, $newHeight, false, null, null, $quality);
				unlink($filePath);
				if (!is_wp_error($resizeImageResult)) {
					$resizeImageResult->resize( $newWidth, $newHeight, false );
					$resizeImageResult->set_quality( $quality );
					$newFilePath = $resizeImageResult;
					$resizeImageResult->save($filePath);
				} else {
					$params = wp_handle_upload_error(
						$filePath,
						$resizeImageResult->get_error_message()
					);
				}
			}
			return $params;
		}

	}

	new LSSM();
