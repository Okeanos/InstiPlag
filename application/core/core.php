<?php
namespace InsertFancyNameHere\Application\Core;

/**
 * Main Handler Class for the Application
 *
 */
class Core {
	// assorted internal variables
	protected static $instance		= null;
	private			 $config 		= null;
	private			 $db			= null;
	private			 $translations	= null;

	// Request Array & other return output things
	public			 $request		= null;
	private			 $title			= '';   // Output Title for Browser Header
	private			 $content		= '';   // Output Content
	private			 $result		= null; // Action Result
	private			 $flash			= array('type' => '', 'text' => '');	// Flash message for results

	/**
	 * Creates an instance of this class and stores the config
	 * Also creates a PDO Database Access Object and loads translation files based on config settings
	 * @param array $config Config File data
	 */
	private function __construct($config) {
		// Set config
		$this->config = $config;
		// Create PDO Database Access Object
		$this->db = new \PDO(
						'mysql:host='.$this->config['db']['hostname'].';dbname='.$this->config['db']['database'],
						$this->config['db']['username'],
						$this->config['db']['password'],
						array(	\PDO::ATTR_PERSISTENT => true,
								\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
								\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
						)
					);
		// Load Translations
		$translationPath = ROOT . DIRECTORY_SEPARATOR . 'application'. DIRECTORY_SEPARATOR .'translations'. DIRECTORY_SEPARATOR .$this->config['language'].'.php';
		$this->setTranslations(require_once($translationPath));
		$this->title = $this->config['name'];

		spl_autoload_register(array($this,'loadController'));
        spl_autoload_register(array($this,'loadModel'));
        spl_autoload_register(array($this,'loadVendor'));

        // globally (re)start session
        session_start();
	}

	/**
	 * Prevents to clone the instance.
	 *
	 * @param  void
	 * @return void
	 */
    final private function __clone() {}

    /**
     * Create and/or return an instance of this class as singleton
     * @param object $instance
     */
    final static public function getInstance($config = array()) {
    	if (!isset(self::$instance) && !empty($config)) {
    		$c = __CLASS__;
    		self::$instance = new $c($config);
    	} elseif(!isset(self::$instance) && empty($array)) {
    		throw new \Exception('Internal Server Error',500);
    	}

    	return self::$instance;
    }

    /**
     * Parse requests, delegate requests, return answers
     */
    public function run() {
		// grab model and action from request or set to valid defaults
		$this->request['model'] = isset($_REQUEST['m']) ? ucfirst(strtolower($_REQUEST['m'])) : '';
    	$this->request['action'] = isset($_REQUEST['a']) ? ucfirst(strtolower($_REQUEST['a'])) : '';
    	// grab ID from request
    	$this->request['id'] = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

    	// start output buffering
    	ob_start();

    	// Only continue if neither controller/model nor action are empty
    	if(!empty($this->request['model']) && !empty($this->request['action'])) {
			// Regular Processing
    		try {
    			$controllerName = 'InsertFancyNameHere\\Application\\Controllers\\' . $this->request['model'];
    			if(class_exists($controllerName, true)) {
		    		// invoke Controller for the request
	    			$controller = new $controllerName($this);

		    		// only invoke action if exists
		    		if(method_exists($controller,$this->request['action'])) {
		    			$this->result = $controller->{$this->request['action']}();
		    			$this->content = $this->loadView($this->request['model'] . DIRECTORY_SEPARATOR . $this->request['action'] . '.php');
		    		} else {
		    			throw new \Exception('Bad Request (Method)', 400);
		    		}
    			} else {
    				throw new \Exception('Bad Request (Model)', 400);
    			}
	    	// Do Error Page
	    	} catch(\Exception $e) {
	    		$this->result = $e->getCode().'<br />'.$e->getMessage();
	    		$this->content = $this->loadView('main' . DIRECTORY_SEPARATOR . 'error.php');
	    	}
	    // Index page
    	} else {
    		$this->content = $this->loadView('main' . DIRECTORY_SEPARATOR . 'index.php');
    	}

    	// Load Layout
    	$main = $this->loadView('main' . DIRECTORY_SEPARATOR . 'layout.php');

    	// Set headers
    	header("Content-Type: text/html; charset=UTF-8");
		// Flush buffered output and display generated result
		echo $main;
    	ob_end_flush();
    	// We are done here, close the connection to the DB
    	$this->db = null;
    }

    /**
     * Retrieves translated text from language file if it exists, otherwise returns the lookup value
     * @param string $key lookup value for translations
     * @return string translated lookup value
     */
    public function t($key) {
		return !isset($this->translations[$key]) ? $key : $this->translations[$key];
    }

    /**
     * Returns the Application Name set in the config file
     * @return string
     */
    public function getName() {
    	return $this->config['name'];
    }

    /**
     * Returns the PDO Database Object
     * @return \InsertFancyNameHere\Application\PDO
     */
    public function getDb() {
    	return $this->db;
    }

    /**
     * Returns the language code as defined in the config
     * @return String the language code
     */
    public function getLanguage() {
    	return $this->config['language'];
    }

    /**
     * Returns the current title for the website (including all additions based on page/article view)
     * @return string the current title
     */
    public function getTitle() {
    	return $this->title;
    }

    /**
     * Returns the thrown Exception as Code: Message string or the action result as object
     * @return string|object the action result or any error that appeared
     */
    public function getResult() {
    	return $this->result;
    }

    /**
     * Returns the main content
     * @return string
     */
    public function getContent() {
    	return $this->content;
    }

    /**
     * Sets the translations to be used
     * @param array $translations
     */
    protected function setTranslations($translations) {
    	$this->translations = $translations;
    }

    /**
     * Set the Flash message for action results
     * @param string $type
     * @param string $message
     */
    public function setFlash($type, $message) {
    	$this->flash['type'] = $type;
    	$this->flash['text'] = $message;
    }

    /**
     * Returns the flash message
     * @return multitype:string
     */
    public function getFlash() {
    	return $this->flash;
    }

    /**
     * Returns the menu as html/string
     * @return string
     */
    public function getMenu() {
    	return $this->loadView('main' . DIRECTORY_SEPARATOR . '_menu.php');
    }

    /**
     * Autoloader for Controller Files
     * @param string $controller Controller Name to be loaded
     */
    public function loadController($controller) {
    	if ($controller) {
    		set_include_path(ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'controllers');
    		spl_autoload_extensions('.php');
    		spl_autoload(substr($controller,strripos($controller,'\\')+1,strlen($controller)-1));
    	}
    }

    /**
     * Autoloader for Model Files
     * @param string $model Controller Name to be loaded
     */
    public function loadModel($model) {
    	if ($model) {
    		set_include_path(ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models');
    		spl_autoload_extensions('.php');
    		spl_autoload(substr($model,strripos($model,'\\')+1,strlen($model)-1));
    	}
    }

    /**
     * Autoloader for Third Party Files
     * @param string $controller Third Party Class File to be loaded
     */
    public function loadVendor($vendor) {
    	if ($vendor) {
    		if ($handle = opendir(ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'vendor')) {
    			while (false !== ($entry = readdir($handle))) {
    				if ($entry != "." && $entry != ".." && is_dir($entry)) {
    					set_include_path(ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $entry);
    					spl_autoload_extensions('.php');
    					spl_autoload($vendor);
    				}
    			}
    			closedir($handle);
    		}
    	}
    }

    /**
     * Loads View files and returns them as string
     * @param string $path
     * @return string
     */
    protected function loadView($path) {
    	$temp = '';
    	ob_start(); // start buffer
    	include ROOT. DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . strtolower($path);
    	$temp .= ob_get_contents(); // assign buffer contents to variable
    	ob_end_clean();
    	return $temp;
    }
}

?>