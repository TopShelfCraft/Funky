<?php
namespace TopShelfCraft\Funky;

use Craft;
use craft\console\Application as CraftConsoleApp;
use craft\web\Application as CraftWebApp;
use yii\base\BootstrapInterface;
use yii\base\Module;

class Funky extends Module implements BootstrapInterface
{

	private array $_fns = [];

	/**
	 * @param \yii\base\Application $app
	 */
	public function bootstrap($app)
	{
		if (!($app instanceof CraftWebApp || $app instanceof CraftConsoleApp)) {
			return;
		}
		static::setInstance($this);
		Craft::setAlias('@TopShelfCraft/Funky', __DIR__);
	}

	function init()
	{
		Craft::$app->view->registerTwigExtension(new TwigExtension());
	}

	public function __call($name, $params)
	{
		if (isset($this->_fns[$name]))
		{
			return call_user_func_array($this->_fns[$name], $params);
		}
		return parent::__call($name, $params);
	}

	public function __get($name)
	{
		if (isset($this->_fns[$name]))
		{
			return $this->_fns[$name];
		}
		return parent::__get($name);
	}

	public function __set($name, $value)
	{
		if (is_callable($value))
		{
			$this->_fns[$name] = $value;
			return;
		}
		parent::__set($name, $value);
	}

}
