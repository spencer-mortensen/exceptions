<?php

namespace App\Exceptions;

use ErrorException;
use ReflectionClass;
use ReflectionProperty;

class ResultException extends ErrorException
{
	/** @var string */
	private $function;

	/** @var array */
	private $arguments;

	/** @var mixed */
	private $result;

	public function __construct($function, array $arguments, $result)
	{
		$message = $this->makeMessage($function, $arguments, $result);

		parent::__construct($message);

		$this->function = $function;
		$this->arguments = $arguments;
		$this->result = $result;
	}

	private function makeMessage($function, array $arguments, $result)
	{
		$argumentsText = $this->getListText($arguments);
		$resultText = $this->getValueText($result);

		return "Unexpected result: {$function}({$argumentsText}) returned {$resultText}";
	}

	private function getValueText($argument)
	{
		$type = gettype($argument);

		switch ($type) {
			case 'NULL':
				return 'null';

			case 'double':
				return json_encode($argument);

			case 'array':
				return $this->getArrayText($argument);

			case 'object':
				return $this->getObjectText($argument);

			case 'resource':
				return $this->getResourceText($argument);

			default:
				return var_export($argument, true);
		}
	}

	private function getArrayText(array $array)
	{
		if ($this->isList($array)) {
			$valuesText = $this->getListText($array);
		} else {
			$valuesText = $this->getMapText($array);
		}

		return "[{$valuesText}]";
	}

	private function isList(array $array)
	{
		$i = 0;

		foreach ($array as $key => $value) {
			if ($key !== $i) {
				return false;
			}

			++$i;
		}

		return true;
	}

	private function getListText(array $array)
	{
		$elements = [];

		foreach ($array as $value) {
			$elements[] = $this->getValueText($value);
		}

		return implode(', ', $elements);
	}

	private function getMapText(array $array)
	{
		$elements = [];

		foreach ($array as $key => $value) {
			$keyText = $this->getValueText($key);
			$valueText = $this->getValueText($value);

			$elements[] = "{$keyText} => {$valueText}";
		}

		return implode(', ', $elements);
	}

	private function getObjectText($object)
	{
		$class = get_class($object);
		$properties = $this->getProperties($object);
		$propertiesText = $this->getMapText($properties);

		return "new \\{$class}({$propertiesText})";
	}

	private function getProperties($object)
	{
		$output = [];

		$class = new ReflectionClass($object);

		do {
			$className = $class->getName();
			$properties = $class->getProperties();

			/** @var ReflectionProperty $property */
			foreach ($properties as $property) {
				$declaringClass = $property->getDeclaringClass();

				if ($declaringClass->getName() !== $className) {
					continue;
				}

				$property->setAccessible(true);
				$propertyName = $property->getName();
				$propertyValue = $property->getValue($object);

				$output[$className][$propertyName] = $propertyValue;
			}

			$class = $class->getParentClass();
		} while ($class !== false);

		return $output;
	}

	private function getResourceText($resource)
	{
		$id = (integer)$resource;
		$type = get_resource_type($resource);
		return "{$type}({$id})";
	}

	public function getFunction()
	{
		return $this->function;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function getResult()
	{
		return $this->result;
	}
}
