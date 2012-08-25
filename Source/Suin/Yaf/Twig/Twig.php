<?php

namespace Suin\Yaf\Twig;

use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Twig implements \Yaf_View_Interface
{
	protected $templateDir;
	protected $options = array();
	protected $variables = array();

	/**
	 * @param string $templateDir
	 * @param array  $options
	 */
	public function __construct($templateDir, array $options = array())
	{
		$this->templateDir = $templateDir;
		$this->options = $options;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->variables[$name]);
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set($name, $value)
	{
		$this->variables[$name] = $value;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->variables[$name];
	}

	/**
	 * @param string $name
	 */
	public function __unset($name)
	{
		unset($this->variables[$name]);
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return bool
	 */
	public function assign($name, $value = null)
	{
		$this->variables[$name] = $value;
	}

	/**
	 * @param string $template
	 * @param array  $variables
	 * @return bool
	 */
	public function display($template, $variables = null)
	{
		echo $this->render($template, $variables);
	}

	/**
	 * @return string
	 */
	public function getScriptPath()
	{
		return $this->templateDir;
	}

	/**
	 * @param string $template
	 * @param array  $variables
	 * @return string
	 */
	public function render($template, $variables = null)
	{
		if ( is_array($variables) )
		{
			$this->variables = array_merge($this->variables, $variables);
		}

		$twig = new Twig_Environment(new Twig_Loader_Filesystem($this->templateDir), $this->options);
		return $twig->loadTemplate($template)->render($this->variables);
	}

	/**
	 * @param string $templateDir
	 * @return void
	 */
	public function setScriptPath($templateDir)
	{
		$this->templateDir = $templateDir;
	}
}
