<?php

namespace UFCOE\UnitControl;

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {
	spl_autoload_register(function ($class) {
		if (0 === strpos($class, __NAMESPACE__ . '\\')) {
			$file = __DIR__ . '/lib/' . strtr($class, '_\\', '//') . '.php';
			is_file($file) && (require $file);
		}
	});

	if (false !== strpos($_SERVER['REQUEST_URI'], '/engine/tests/suite.php')) {
		elgg_register_plugin_hook_handler('unit_test', 'system',
			__NAMESPACE__ . '\\unit_test_handler', 999);
	}
}

/**
 * Get the shortname of this plugin
 * @return string
 */
function shortname() {
	return basename(__DIR__);
}

function unit_test_handler($hook, $type, array $return_value, $params) {
	if (($dir = (string) get_input('dir')) && preg_match('~^\\w+(/\\w+)*$~', $dir)) {
		if (preg_match('~^my_tests\\b~', $dir)) {
			$path = __DIR__ . "/$dir";
		} else {
			$path = dirname(dirname(__DIR__)) . "/engine/tests/$dir";
			if (preg_match('~^test_files\\b~', $dir)) {
				exit ("The given directory cannot be run as a test suite.");
			}
		}
		$test_files = array();
		if (is_dir($path)) {
			$iter = new \RecursiveDirectoryIterator($path);
			foreach ($iter as $fileInfo) {
				/* @var \SplFileInfo $fileInfo */
				$basename = $fileInfo->getBasename();
				if ($fileInfo->isFile() && preg_match('/^\\w+\\.php$/', $basename)) {
					$test_files[] = $fileInfo->getPathname();
				}
			}
		} else {
			exit ("Test directory not found: $dir");
		}
		if ($test_files) {
			$return_value = $test_files;
		} else  {
			exit ("No test files found in: $dir");
		}
	}
	return $return_value;
}
