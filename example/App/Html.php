<?php

namespace App;

class Html
{
	private $type;
	private $charset;

	public function __construct(int $type = ENT_HTML5, string $charset = 'UTF-8')
	{
		$this->type = $type;
		$this->charset = $charset;
	}

	public function decode(string $html): string
	{
		return html_entity_decode($html, ENT_QUOTES | $this->type, $this->charset);
	}

	public function encode(string $value): string
	{
		return htmlspecialchars($value, ENT_QUOTES | $this->type, $this->charset);
	}
}
