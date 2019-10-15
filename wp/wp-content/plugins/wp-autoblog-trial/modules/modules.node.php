<?php
if (function_exists('curl_init'))
{
	define('Method', 0);
}
else
{
	define('Method', 1);
}
define('HDOM_TYPE_ELEMENT', 1);
define('HDOM_TYPE_COMMENT', 2);
define('HDOM_TYPE_TEXT', 3);
define('HDOM_TYPE_ENDTAG', 4);
define('HDOM_TYPE_ROOT', 5);
define('HDOM_TYPE_UNKNOWN', 6);
define('HDOM_QUOTE_DOUBLE', 0);
define('HDOM_QUOTE_SINGLE', 1);
define('HDOM_QUOTE_NO', 3);
define('HDOM_INFO_BEGIN', 0);
define('HDOM_INFO_END', 1);
define('HDOM_INFO_QUOTE', 2);
define('HDOM_INFO_SPACE', 3);
define('HDOM_INFO_TEXT', 4);
define('HDOM_INFO_INNER', 5);
define('HDOM_INFO_OUTER', 6);
define('HDOM_INFO_ENDSPACE', 7);
defined('DEFAULT_TARGET_CHARSET') || define('DEFAULT_TARGET_CHARSET', 'UTF-8');
defined('DEFAULT_BR_TEXT') || define('DEFAULT_BR_TEXT', "\r\n");
defined('DEFAULT_SPAN_TEXT') || define('DEFAULT_SPAN_TEXT', ' ');
defined('MAX_FILE_SIZE') || define('MAX_FILE_SIZE', 600000);
define('HDOM_SMARTY_AS_TEXT', 1);
$use_include_path = false;
$context = null;
$offset = -1;
$maxLen = -1;
$lowercase = true;
$forceTagsClosed = true;
$stripRN = false;
$defaultSNode = 1;
$defaultBRText = "\r\n";
$defaultSpanText = " ";
class html_dom_node
{
	public $nodetype = HDOM_TYPE_TEXT;
	public $tag = 'text';
	public $attr = array();
	public $children = array();
	public $nodes = array();
	public $parent = null;
	public $_ = array();
	public $tag_start = 0;
	private $dom = null;
	function __construct($dom)
	{
		$this->dom = $dom;
		$dom->nodes[] = $this;
	}
	function __destruct()
	{
		$this->clear();
	}
	function __toString()
	{
		return $this->outertext();
	}
	function clear()
	{
		$this->dom = null;
		$this->nodes = null;
		$this->parent = null;
		$this->children = null;
	}
	function dump($show_attr = true, $deep = 0)
	{
		$lead = str_repeat('	', $deep);
		echo $lead . $this->tag;
		if ($show_attr && count($this->attr) > 0)
		{
			echo '(';
			foreach ($this->attr as $k => $v)
			{
				echo "[$k]=>\"" . $this->$k . '", ';
			}
			echo ')';
		}
		echo "\n";
		if ($this->nodes)
		{
			foreach ($this->nodes as $c)
			{
				$c->dump($show_attr, $deep + 1);
			}
		}
	}
	function dump_node($echo = true)
	{
		$string = $this->tag;
		if (count($this->attr) > 0)
		{
			$string .= '(';
			foreach ($this->attr as $k => $v)
			{
				$string .= "[$k]=>\"" . $this->$k . '", ';
			}
			$string .= ')';
		}
		if (count($this->_) > 0)
		{
			$string .= ' $_ (';
			foreach ($this->_ as $k => $v)
			{
				if (is_array($v))
				{
					$string .= "[$k]=>(";
					foreach ($v as $k2 => $v2)
					{
						$string .= "[$k2]=>\"" . $v2 . '", ';
					}
					$string .= ')';
				}
				else
				{
					$string .= "[$k]=>\"" . $v . '", ';
				}
			}
			$string .= ')';
		}
		if (isset($this->text))
		{
			$string .= ' text: (' . $this->text . ')';
		}
		$string .= " HDOM_INNER_INFO: '";
		if (isset($node->_[HDOM_INFO_INNER]))
		{
			$string .= $node->_[HDOM_INFO_INNER] . "'";
		}
		else
		{
			$string .= ' NULL ';
		}
		$string .= ' children: ' . count($this->children);
		$string .= ' nodes: ' . count($this->nodes);
		$string .= ' tag_start: ' . $this->tag_start;
		$string .= "\n";
		if ($echo)
		{
			echo $string;
			return;
		}
		else
		{
			return $string;
		}
	}
	function parent($parent = null)
	{
		if ($parent !== null)
		{
			$this->parent = $parent;
			$this->parent->nodes[] = $this;
			$this->parent->children[] = $this;
		}
		return $this->parent;
	}
	function has_child()
	{
		return !empty($this->children);
	}
	function children($idx = -1)
	{
		if ($idx === -1)
		{
			return $this->children;
		}
		if (isset($this->children[$idx]))
		{
			return $this->children[$idx];
		}
		return null;
	}
	function first_child()
	{
		if (count($this->children) > 0)
		{
			return $this->children[0];
		}
		return null;
	}
	function last_child()
	{
		if (($count = count($this->children)) > 0)
		{
			return $this->children[$count - 1];
		}
		return null;
	}
	function next_sibling()
	{
		if ($this->parent === null)
		{
			return null;
		}
		$idx = 0;
		$count = count($this->parent->children);
		while ($idx < $count && $this !== $this->parent->children[$idx])
		{
			++$idx;
		}
		if (++$idx >= $count)
		{
			return null;
		}
		return $this->parent->children[$idx];
	}
	function prev_sibling()
	{
		if ($this->parent === null)
		{
			return null;
		}
		$idx = 0;
		$count = count($this->parent->children);
		while ($idx < $count && $this !== $this->parent->children[$idx])
		{
			++$idx;
		}
		if (--$idx < 0)
		{
			return null;
		}
		return $this->parent->children[$idx];
	}
	function find_ancestor_tag($tag)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		$returnDom = $this;
		while (!is_null($returnDom))
		{
			if (is_object($debug_object))
			{
				$debug_object->debug_log(2, 'Current tag is: ' . $returnDom->tag);
			}
			if ($returnDom->tag == $tag)
			{
				break;
			}
			$returnDom = $returnDom->parent;
		}
		return $returnDom;
	}
	function innertext()
	{
		if (isset($this->_[HDOM_INFO_INNER]))
		{
			return $this->_[HDOM_INFO_INNER];
		}
		if (isset($this->_[HDOM_INFO_TEXT]))
		{
			return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
		}
		$ret = '';
		foreach ($this->nodes as $n)
		{
			$ret .= $n->outertext();
		}
		return $ret;
	}
	function outertext()
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$text = '';
			if ($this->tag === 'text')
			{
				if (!empty($this->text))
				{
					$text = ' with text: ' . $this->text;
				}
			}
			$debug_object->debug_log(1, 'Innertext of tag: ' . $this->tag . $text);
		}
		if ($this->tag === 'root') return $this->innertext();
		if ($this->dom && $this->dom->callback !== null)
		{
			call_user_func_array($this->dom->callback, array($this));
		}
		if (isset($this->_[HDOM_INFO_OUTER]))
		{
			return $this->_[HDOM_INFO_OUTER];
		}
		if (isset($this->_[HDOM_INFO_TEXT]))
		{
			return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
		}
		if ($this->dom && $this->dom->nodes[$this->_[HDOM_INFO_BEGIN]])
		{
			$ret = $this->dom->nodes[$this->_[HDOM_INFO_BEGIN]]->makeup();
		}
		else
		{
			$ret = '';
		}
		if (isset($this->_[HDOM_INFO_INNER]))
		{
			if ($this->tag !== 'br')
			{
				$ret .= $this->_[HDOM_INFO_INNER];
			}
		}
		else
		{
			if ($this->nodes)
			{
				foreach ($this->nodes as $n)
				{
					$ret .= $this->convert_text($n->outertext());
				}
			}
		}
		if (isset($this->_[HDOM_INFO_END]) && $this->_[HDOM_INFO_END] != 0)
		{
			$ret .= '</' . $this->tag . '>';
		}
		return $ret;
	}
	function text()
	{
		if (isset($this->_[HDOM_INFO_INNER]))
		{
			return $this->_[HDOM_INFO_INNER];
		}
		switch ($this->nodetype)
		{
			case HDOM_TYPE_TEXT: return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
			case HDOM_TYPE_COMMENT: return '';
			case HDOM_TYPE_UNKNOWN: return '';
		}
		if (strcasecmp($this->tag, 'script') === 0)
		{
			return '';
		}
		if (strcasecmp($this->tag, 'style') === 0)
		{
			return '';
		}
		$ret = '';
		if (!is_null($this->nodes))
		{
			foreach ($this->nodes as $n)
			{
				if ($n->tag === 'p')
				{
					$ret .= "\n\n";
				}
				$ret .= $this->convert_text($n->text());
				if ($n->tag === 'span')
				{
					$ret .= $this->dom->default_span_text;
				}
			}
		}
		return trim($ret);
	}
	function xmltext()
	{
		$ret = $this->innertext();
		$ret = str_ireplace('<![CDATA[', '', $ret);
		$ret = str_replace(']]>', '', $ret);
		return $ret;
	}
	function makeup()
	{
		if (isset($this->_[HDOM_INFO_TEXT]))
		{
			return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
		}
		$ret = '<' . $this->tag;
		$i = -1;
		foreach ($this->attr as $key => $val)
		{
			++$i;
			if ($val === null || $val === false)
			{
				continue;
			}
			$ret .= $this->_[HDOM_INFO_SPACE][$i][0];
			if ($val === true)
			{
				$ret .= $key;
			}
			else
			{
				switch ($this->_[HDOM_INFO_QUOTE][$i])
				{
					case HDOM_QUOTE_DOUBLE: $quote = '"';
						break;
					case HDOM_QUOTE_SINGLE: $quote = '\'';
						break;
					default: $quote = '';
				}
				$ret .= $key . $this->_[HDOM_INFO_SPACE][$i][1] . '=' . $this->_[HDOM_INFO_SPACE][$i][2] . $quote . $val . $quote;
			}
		}
		$ret = $this->dom->restore_noise($ret);
		return $ret . $this->_[HDOM_INFO_ENDSPACE] . '>';
	}
	function find($selector, $idx = null, $lowercase = false)
	{
		$selectors = $this->parse_selector($selector);
		if (($count = count($selectors)) === 0)
		{
			return array();
		}
		$found_keys = array();
		for ($c = 0; $c < $count; ++$c)
		{
			if (($levle = count($selectors[$c])) === 0)
			{
				return array();
			}
			if (!isset($this->_[HDOM_INFO_BEGIN]))
			{
				return array();
			}
			$head = array($this->_[HDOM_INFO_BEGIN] => 1);
			$cmd = ' ';
			for ($l = 0; $l < $levle; ++$l)
			{
				$ret = array();
				foreach ($head as $k => $v)
				{
					$n = ($k === -1) ? $this->dom->root : $this->dom->nodes[$k];
					$n->seek($selectors[$c][$l], $ret, $cmd, $lowercase);
				}
				$head = $ret;
				$cmd = $selectors[$c][$l][4];
			}
			foreach ($head as $k => $v)
			{
				if (!isset($found_keys[$k]))
				{
					$found_keys[$k] = 1;
				}
			}
		}
		ksort($found_keys);
		$found = array();
		foreach ($found_keys as $k => $v)
		{
			$found[] = $this->dom->nodes[$k];
		}
		if (is_null($idx))
		{
			return $found;
		}elseif ($idx < 0)
		{
			$idx = count($found) + $idx;
		}
		return (isset($found[$idx])) ? $found[$idx] : null;
	}
	protected function seek($selector, &$ret, $parent_cmd, $lowercase = false)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		list($tag, $id, $class, $attributes, $cmb) = $selector;
		$nodes = array();
		if ($parent_cmd === ' ')
		{
			$end = (!empty($this->_[HDOM_INFO_END])) ? $this->_[HDOM_INFO_END] : 0;
			if ($end == 0)
			{
				$parent = $this->parent;
				while (!isset($parent->_[HDOM_INFO_END]) && $parent !== null)
				{
					$end -= 1;
					$parent = $parent->parent;
				}
				$end += $parent->_[HDOM_INFO_END];
			}
			$nodes_start = $this->_[HDOM_INFO_BEGIN] + 1;
			$nodes_count = $end - $nodes_start;
			$nodes = array_slice($this->dom->nodes, $nodes_start, $nodes_count, true);
		}elseif ($parent_cmd === '>')
		{
			$nodes = $this->children;
		}elseif ($parent_cmd === '+' && $this->parent && in_array($this, $this->parent->children))
		{
			$index = array_search($this, $this->parent->children, true) + 1;
			$nodes[] = $this->parent->children[$index];
		}elseif ($parent_cmd === '~' && $this->parent && in_array($this, $this->parent->children))
		{
			$index = array_search($this, $this->parent->children, true);
			$nodes = array_slice($this->parent->children, $index);
		}
		foreach($nodes as $node)
		{
			$pass = true;
			if (!$node->parent)
			{
				$pass = false;
			}
			if ($pass && !in_array($node, $node->parent->children, true))
			{
				$pass = false;
			}
			if ($pass && $tag !== '' && $tag !== $node->tag && $tag !== '*')
			{
				$pass = false;
			}
			if ($pass && $id !== '' && !isset($node->attr['id']))
			{
				$pass = false;
			}
			if ($pass && $id !== '' && isset($node->attr['id']))
			{
				$node_id = explode(' ', trim($node->attr['id']))[0];
				if ($id !== $node_id)
				{
					$pass = false;
				}
			}
			if ($pass && $class !== '' && is_array($class) && !empty($class))
			{
				if (isset($node->attr['class']))
				{
					$node_classes = explode(' ', $node->attr['class']);
					if ($lowercase)
					{
						$node_classes = array_map('strtolower', $node_classes);
					}
					foreach($class as $c)
					{
						if (!in_array($c, $node_classes))
						{
							$pass = false;
							break;
						}
					}
				}
				else
				{
					$pass = false;
				}
			}
			if ($pass && $attributes !== '' && is_array($attributes) && !empty($attributes))
			{
				foreach($attributes as $a)
				{
					list ($att_name, $att_expr, $att_val, $att_inv, $att_case_sensitivity) = $a;
					if (is_numeric($att_name) && $att_expr === '' && $att_val === '')
					{
						$count = 0;
						foreach ($node->parent->children as $c)
						{
							if ($c->tag === $node->tag) ++$count;
							if ($c === $node) break;
						}
						if ($count === (int)$att_name) continue;
					}
					if ($att_inv)
					{
						if (isset($node->attr[$att_name]))
						{
							$pass = false;
							break;
						}
					}
					else
					{
						if ($att_name !== 'plaintext' && !isset($node->attr[$att_name]))
						{
							$pass = false;
							break;
						}
					}
					if ($att_expr === '') continue;
					if ($att_name === 'plaintext')
					{
						$nodeKeyValue = $node->text();
					}
					else
					{
						$nodeKeyValue = $node->attr[$att_name];
					}
					if (is_object($debug_object))
					{
						$debug_object->debug_log(2, 'testing node: ' . $node->tag . ' for attribute: ' . $att_name . $att_expr . $att_val . ' where nodes value is: ' . $nodeKeyValue);
					}
					if ($lowercase)
					{
						$check = $this->match($att_expr, strtolower($att_val), strtolower($nodeKeyValue), $att_case_sensitivity);
					}
					else
					{
						$check = $this->match($att_expr, $att_val, $nodeKeyValue, $att_case_sensitivity);
					}
					if (is_object($debug_object))
					{
						$debug_object->debug_log(2, 'after match: ' . ($check ? 'true' : 'false'));
					}
					if (!$check)
					{
						$pass = false;
						break;
					}
				}
			}
			if ($pass) $ret[$node->_[HDOM_INFO_BEGIN]] = 1;
			unset($node);
		}
		if (is_object($debug_object))
		{
			$debug_object->debug_log(1, 'EXIT - ret: ', $ret);
		}
	}
	protected function match($exp, $pattern, $value, $case_sensitivity)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		if ($case_sensitivity === 'i')
		{
			$pattern = strtolower($pattern);
			$value = strtolower($value);
		}
		switch ($exp)
		{
			case '=': return ($value === $pattern);
			case '!=': return ($value !== $pattern);
			case '^=': return preg_match('/^' . preg_quote($pattern, '/') . '/', $value);
			case '$=': return preg_match('/' . preg_quote($pattern, '/') . '$/', $value);
			case '*=': return preg_match('/' . preg_quote($pattern, '/') . '/', $value);
			case '|=': return strpos($value, $pattern) === 0;
			case '~=': return in_array($pattern, explode(' ', trim($value)), true);
		}
		return false;
	}
	protected function parse_selector($selector_string)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		$pattern = "/([\w:\*-]*)(?:\#([\w-]+))?(?:|\.([\w\.-]+))?((?:\[@?(?:!?[\w:-]+)(?:(?:[!*^$|~]?=)[\"']?(?:.*?)[\"']?)?(?:\s*?(?:[iIsS])?)?\])+)?([\/, >+~]+)/is";
		preg_match_all($pattern, trim($selector_string) . ' ', $matches, PREG_SET_ORDER);
		if (is_object($debug_object))
		{
			$debug_object->debug_log(2, 'Matches Array: ', $matches);
		}
		$selectors = array();
		$result = array();
		foreach ($matches as $m)
		{
			$m[0] = trim($m[0]);
			if ($m[0] === '' || $m[0] === '/' || $m[0] === '//')
			{
				continue;
			}
			if ($this->dom->lowercase)
			{
				$m[1] = strtolower($m[1]);
			}
			if ($m[3] !== '')
			{
				$m[3] = explode('.', $m[3]);
			}
			if ($m[4] !== '')
			{
				preg_match_all("/\[@?(!?[\w:-]+)(?:([!*^$|~]?=)[\"']?(.*?)[\"']?)?(?:\s*?([iIsS])?)?\]/is", trim($m[4]), $attributes, PREG_SET_ORDER);
				$m[4] = array();
				foreach($attributes as $att)
				{
					if (trim($att[0]) === '')
					{
						continue;
					}
					$inverted = (isset($att[1][0]) && $att[1][0] === '!');
					$m[4][] = array($inverted ? substr($att[1], 1) : $att[1], (isset($att[2])) ? $att[2] : '', (isset($att[3])) ? $att[3] : '', $inverted, (isset($att[4])) ? strtolower($att[4]) : '',);
				}
			}
			if ($m[5] !== '' && trim($m[5]) === '')
			{
				$m[5] = ' ';
			}
			else
			{
				$m[5] = trim($m[5]);
			}
			if ($is_list = ($m[5] === ','))
			{
				$m[5] = '';
			}
			array_shift($m);
			$result[] = $m;
			if ($is_list)
			{
				$selectors[] = $result;
				$result = array();
			}
		}
		if (count($result) > 0)
		{
			$selectors[] = $result;
		}
		return $selectors;
	}
	function __get($name)
	{
		if (isset($this->attr[$name]))
		{
			return $this->convert_text($this->attr[$name]);
		}
		switch ($name)
		{
			case 'outertext': return $this->outertext();
			case 'innertext': return $this->innertext();
			case 'plaintext': return $this->text();
			case 'xmltext': return $this->xmltext();
			default: return array_key_exists($name, $this->attr);
		}
	}
	function __set($name, $value)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		switch ($name)
		{
			case 'outertext': return $this->_[HDOM_INFO_OUTER] = $value;
			case 'innertext': if (isset($this->_[HDOM_INFO_TEXT]))
				{
					return $this->_[HDOM_INFO_TEXT] = $value;
				}
				return $this->_[HDOM_INFO_INNER] = $value;
		}
		if (!isset($this->attr[$name]))
		{
			$this->_[HDOM_INFO_SPACE][] = array(' ', '', '');
			$this->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_DOUBLE;
		}
		$this->attr[$name] = $value;
	}
	function __isset($name)
	{
		switch ($name)
		{
			case 'outertext': return true;
			case 'innertext': return true;
			case 'plaintext': return true;
		}
		return (array_key_exists($name, $this->attr)) ? true : isset($this->attr[$name]);
	}
	function __unset($name)
	{
		if (isset($this->attr[$name]))
		{
			unset($this->attr[$name]);
		}
	}
	function convert_text($text)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		$converted_text = $text;
		$sourceCharset = '';
		$targetCharset = '';
		if ($this->dom)
		{
			$sourceCharset = strtoupper($this->dom->_charset);
			$targetCharset = strtoupper($this->dom->_target_charset);
		}
		if (is_object($debug_object))
		{
			$debug_object->debug_log(3, 'source charset: ' . $sourceCharset . ' target charaset: ' . $targetCharset);
		}
		if (!empty($sourceCharset) && !empty($targetCharset) && (strcasecmp($sourceCharset, $targetCharset) != 0))
		{
			if ((strcasecmp($targetCharset, 'UTF-8') == 0) && ($this->is_utf8($text)))
			{
				$converted_text = $text;
			}
			else
			{
				$converted_text = iconv($sourceCharset, $targetCharset, $text);
			}
		}
		if ($targetCharset === 'UTF-8')
		{
			if (substr($converted_text, 0, 3) === "\xef\xbb\xbf")
			{
				$converted_text = substr($converted_text, 3);
			}
			if (substr($converted_text, -3) === "\xef\xbb\xbf")
			{
				$converted_text = substr($converted_text, 0, -3);
			}
		}
		return $converted_text;
	}
	static function is_utf8($str)
	{
		$c = 0;
		$b = 0;
		$bits = 0;
		$len = strlen($str);
		for($i = 0; $i < $len; $i++)
		{
			$c = ord($str[$i]);
			if ($c > 128)
			{
				if (($c >= 254))
				{
					return false;
				}elseif ($c >= 252)
				{
					$bits = 6;
				}elseif ($c >= 248)
				{
					$bits = 5;
				}elseif ($c >= 240)
				{
					$bits = 4;
				}elseif ($c >= 224)
				{
					$bits = 3;
				}elseif ($c >= 192)
				{
					$bits = 2;
				}
				else
				{
					return false;
				}
				if (($i + $bits) > $len)
				{
					return false;
				}
				while ($bits > 1)
				{
					$i++;
					$b = ord($str[$i]);
					if ($b < 128 || $b > 191)
					{
						return false;
					}
					$bits--;
				}
			}
		}
		return true;
	}
	function get_display_size()
	{
		global $debug_object;
		$width = -1;
		$height = -1;
		if ($this->tag !== 'img')
		{
			return false;
		}
		if (isset($this->attr['width']))
		{
			$width = $this->attr['width'];
		}
		if (isset($this->attr['height']))
		{
			$height = $this->attr['height'];
		}
		if (isset($this->attr['style']))
		{
			$attributes = array();
			preg_match_all('/([\w-]+)\s*:\s*([^;]+)\s*;?/', $this->attr['style'], $matches, PREG_SET_ORDER);
			foreach ($matches as $match)
			{
				$attributes[$match[1]] = $match[2];
			}
			if (isset($attributes['width']) && $width == -1)
			{
				if (strtolower(substr($attributes['width'], -2)) === 'px')
				{
					$proposed_width = substr($attributes['width'], 0, -2);
					if (filter_var($proposed_width, FILTER_VALIDATE_INT))
					{
						$width = $proposed_width;
					}
				}
			}
			if (isset($attributes['height']) && $height == -1)
			{
				if (strtolower(substr($attributes['height'], -2)) == 'px')
				{
					$proposed_height = substr($attributes['height'], 0, -2);
					if (filter_var($proposed_height, FILTER_VALIDATE_INT))
					{
						$height = $proposed_height;
					}
				}
			}
		}
		$result = array('height' => $height, 'width' => $width);
		return $result;
	}
	function getAllAttributes()
	{
		return $this->attr;
	}
	function getAttribute($name)
	{
		return $this->__get($name);
	}
	function setAttribute($name, $value)
	{
		$this->__set($name, $value);
	}
	function hasAttribute($name)
	{
		return $this->__isset($name);
	}
	function removeAttribute($name)
	{
		$this->__set($name, null);
	}
	function getElementById($id)
	{
		return $this->find("#$id", 0);
	}
	function getElementsById($id, $idx = null)
	{
		return $this->find("#$id", $idx);
	}
	function getElementByTagName($name)
	{
		return $this->find($name, 0);
	}
	function getElementsByTagName($name, $idx = null)
	{
		return $this->find($name, $idx);
	}
	function parentNode()
	{
		return $this->parent();
	}
	function childNodes($idx = -1)
	{
		return $this->children($idx);
	}
	function firstChild()
	{
		return $this->first_child();
	}
	function lastChild()
	{
		return $this->last_child();
	}
	function nextSibling()
	{
		return $this->next_sibling();
	}
	function previousSibling()
	{
		return $this->prev_sibling();
	}
	function hasChildNodes()
	{
		return $this->has_child();
	}
	function nodeName()
	{
		return $this->tag;
	}
	function appendChild($node)
	{
		$node->parent($this);
		return $node;
	}
}
class the_html_dom
{
	public $root = null;
	public $nodes = array();
	public $callback = null;
	public $lowercase = false;
	public $original_size;
	public $size;
	protected $pos;
	protected $doc;
	protected $char;
	protected $cursor;
	protected $parent;
	protected $noise = array();
	protected $token_blank = " \t\r\n";
	protected $token_equal = ' =/>';
	protected $token_slash = " />\r\n\t";
	protected $token_attr = ' >';
	public $_charset = '';
	public $_target_charset = '';
	protected $default_br_text = '';
	public $default_span_text = '';
	protected $self_closing_tags = array('area' => 1, 'base' => 1, 'br' => 1, 'col' => 1, 'embed' => 1, 'hr' => 1, 'img' => 1, 'input' => 1, 'link' => 1, 'meta' => 1, 'param' => 1, 'source' => 1, 'track' => 1, 'wbr' => 1);
	protected $block_tags = array('body' => 1, 'div' => 1, 'form' => 1, 'root' => 1, 'span' => 1, 'table' => 1);
	protected $optional_closing_tags = array('b' => array('b' => 1), 'dd' => array('dd' => 1, 'dt' => 1), 'dl' => array('dd' => 1, 'dt' => 1), 'dt' => array('dd' => 1, 'dt' => 1), 'li' => array('li' => 1), 'optgroup' => array('optgroup' => 1, 'option' => 1), 'option' => array('optgroup' => 1, 'option' => 1), 'p' => array('p' => 1), 'rp' => array('rp' => 1, 'rt' => 1), 'rt' => array('rp' => 1, 'rt' => 1), 'td' => array('td' => 1, 'th' => 1), 'th' => array('td' => 1, 'th' => 1), 'tr' => array('td' => 1, 'th' => 1, 'tr' => 1),);
	function __construct($str = null, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT, $options = 0)
	{
		if ($str)
		{
			if (preg_match('/^http:\/\//i', $str) || is_file($str))
			{
				$this->load_file($str);
			}
			else
			{
				$this->load($str, $lowercase, $stripRN, $defaultBRText, $defaultSpanText, $options);
			}
		}
		if (!$forceTagsClosed)
		{
			$this->optional_closing_array = array();
		}
		$this->_target_charset = $target_charset;
	}
	function __destruct()
	{
		$this->clear();
	}
	function load($str, $lowercase = true, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT, $options = 0)
	{
		global $debug_object;
		$this->prepare($str, $lowercase, $defaultBRText, $defaultSpanText);
		$this->remove_noise("'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is");
		$this->remove_noise("'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is");
		if ($stripRN)
		{
			$this->doc = str_replace("\r", ' ', $this->doc);
			$this->doc = str_replace("\n", ' ', $this->doc);
			$this->size = strlen($this->doc);
		}
		$this->remove_noise("'<!\[CDATA\[(.*?)\]\]>'is", true);
		$this->remove_noise("'<!--(.*?)-->'is");
		$this->remove_noise("'<\s*style[^>]*[^/]>(.*?)<\s*/\s*style\s*>'is");
		$this->remove_noise("'<\s*style\s*>(.*?)<\s*/\s*style\s*>'is");
		$this->remove_noise("'<\s*(?:code)[^>]*>(.*?)<\s*/\s*(?:code)\s*>'is");
		$this->remove_noise("'(<\?)(.*?)(\?>)'s", true);
		if ($options &HDOM_SMARTY_AS_TEXT)
		{
			$this->remove_noise("'(\{\w)(.*?)(\})'s", true);
		}
		$this->parse();
		$this->root->_[HDOM_INFO_END] = $this->cursor;
		$this->parse_charset();
		return $this;
	}
	function load_file()
	{
		$args = func_get_args();
		if (($doc = call_user_func_array('file_get_contents', $args)) !== false)
		{
			$this->load($doc, true);
		}
		else
		{
			return false;
		}
	}
	function set_callback($function_name)
	{
		$this->callback = $function_name;
	}
	function remove_callback()
	{
		$this->callback = null;
	}
	function save($filepath = '')
	{
		$ret = $this->root->innertext();
		if ($filepath !== '')
		{
			file_put_contents($filepath, $ret, LOCK_EX);
		}
		return $ret;
	}
	function find($selector, $idx = null, $lowercase = false)
	{
		return $this->root->find($selector, $idx, $lowercase);
	}
	function clear()
	{
		foreach ($this->nodes as $n)
		{
			$n->clear();
			$n = null;
		}
		if (isset($this->children))
		{
			foreach ($this->children as $n)
			{
				$n->clear();
				$n = null;
			}
		}
		if (isset($this->parent))
		{
			$this->parent->clear();
			unset($this->parent);
		}
		if (isset($this->root))
		{
			$this->root->clear();
			unset($this->root);
		}
		unset($this->doc);
		unset($this->noise);
	}
	function dump($show_attr = true)
	{
		$this->root->dump($show_attr);
	}
	protected function prepare($str, $lowercase = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT)
	{
		$this->clear();
		$this->doc = trim($str);
		$this->size = strlen($this->doc);
		$this->original_size = $this->size;
		$this->pos = 0;
		$this->cursor = 1;
		$this->noise = array();
		$this->nodes = array();
		$this->lowercase = $lowercase;
		$this->default_br_text = $defaultBRText;
		$this->default_span_text = $defaultSpanText;
		$this->root = new html_dom_node($this);
		$this->root->tag = 'root';
		$this->root->_[HDOM_INFO_BEGIN] = -1;
		$this->root->nodetype = HDOM_TYPE_ROOT;
		$this->parent = $this->root;
		if ($this->size > 0)
		{
			$this->char = $this->doc[0];
		}
	}
	protected function parse()
	{
		while (true)
		{
			if (($s = $this->copy_until_char('<')) === '')
			{
				if ($this->read_tag())
				{
					continue;
				}
				else
				{
					return true;
				}
			}
			$node = new html_dom_node($this);
			++$this->cursor;
			$node->_[HDOM_INFO_TEXT] = $s;
			$this->link_nodes($node, false);
		}
	}
	protected function parse_charset()
	{
		global $debug_object;
		$charset = null;
		if (function_exists('get_last_retrieve_url_contents_content_type'))
		{
			$contentTypeHeader = get_last_retrieve_url_contents_content_type();
			$success = preg_match('/charset=(.+)/', $contentTypeHeader, $matches);
			if ($success)
			{
				$charset = $matches[1];
				if (is_object($debug_object))
				{
					$debug_object->debug_log(2, 'header content-type found charset of: ' . $charset);
				}
			}
		}
		if (empty($charset))
		{
			$el = $this->root->find('meta[http-equiv=Content-Type]', 0, true);
			if (!empty($el))
			{
				$fullvalue = $el->content;
				if (is_object($debug_object))
				{
					$debug_object->debug_log(2, 'meta content-type tag found' . $fullvalue);
				}
				if (!empty($fullvalue))
				{
					$success = preg_match('/charset=(.+)/i', $fullvalue, $matches);
					if ($success)
					{
						$charset = $matches[1];
					}
					else
					{
						if (is_object($debug_object))
						{
							$debug_object->debug_log(2, 'meta content-type tag couldn\'t be parsed. using iso-8859 default.');
						}
						$charset = 'ISO-8859-1';
					}
				}
			}
		}
		if (empty($charset))
		{
			$charset = false;
			if (function_exists('mb_detect_encoding'))
			{
				$charset = mb_detect_encoding($this->doc . 'ascii', $encoding_list = array('UTF-8', 'CP1252'));
				if (is_object($debug_object))
				{
					$debug_object->debug_log(2, 'mb_detect found: ' . $charset);
				}
			}
			if ($charset === false)
			{
				if (is_object($debug_object))
				{
					$debug_object->debug_log(2, 'since mb_detect failed - using default of utf-8');
				}
				$charset = 'UTF-8';
			}
		}
		if ((strtolower($charset) == strtolower('ISO-8859-1')) || (strtolower($charset) == strtolower('Latin1')) || (strtolower($charset) == strtolower('Latin-1')))
		{
			if (is_object($debug_object))
			{
				$debug_object->debug_log(2, 'replacing ' . $charset . ' with CP1252 as its a superset');
			}
			$charset = 'CP1252';
		}
		if (is_object($debug_object))
		{
			$debug_object->debug_log(1, 'EXIT - ' . $charset);
		}
		return $this->_charset = $charset;
	}
	protected function read_tag()
	{
		if ($this->char !== '<')
		{
			$this->root->_[HDOM_INFO_END] = $this->cursor;
			return false;
		}
		$begin_tag_pos = $this->pos;
		$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
		if ($this->char === '/')
		{
			$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
			$this->skip($this->token_blank);
			$tag = $this->copy_until_char('>');
			if (($pos = strpos($tag, ' ')) !== false)
			{
				$tag = substr($tag, 0, $pos);
			}
			$parent_lower = strtolower($this->parent->tag);
			$tag_lower = strtolower($tag);
			if ($parent_lower !== $tag_lower)
			{
				if (isset($this->optional_closing_tags[$parent_lower]) && isset($this->block_tags[$tag_lower]))
				{
					$this->parent->_[HDOM_INFO_END] = 0;
					$org_parent = $this->parent;
					while (($this->parent->parent) && strtolower($this->parent->tag) !== $tag_lower)
					{
						$this->parent = $this->parent->parent;
					}
					if (strtolower($this->parent->tag) !== $tag_lower)
					{
						$this->parent = $org_parent;
						if ($this->parent->parent)
						{
							$this->parent = $this->parent->parent;
						}
						$this->parent->_[HDOM_INFO_END] = $this->cursor;
						return $this->as_text_node($tag);
					}
				}elseif (($this->parent->parent) && isset($this->block_tags[$tag_lower]))
				{
					$this->parent->_[HDOM_INFO_END] = 0;
					$org_parent = $this->parent;
					while (($this->parent->parent) && strtolower($this->parent->tag) !== $tag_lower)
					{
						$this->parent = $this->parent->parent;
					}
					if (strtolower($this->parent->tag) !== $tag_lower)
					{
						$this->parent = $org_parent;
						$this->parent->_[HDOM_INFO_END] = $this->cursor;
						return $this->as_text_node($tag);
					}
				}elseif (($this->parent->parent) && strtolower($this->parent->parent->tag) === $tag_lower)
				{
					$this->parent->_[HDOM_INFO_END] = 0;
					$this->parent = $this->parent->parent;
				}
				else
				{
					return $this->as_text_node($tag);
				}
			}
			$this->parent->_[HDOM_INFO_END] = $this->cursor;
			if ($this->parent->parent)
			{
				$this->parent = $this->parent->parent;
			}
			$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
			return true;
		}
		$node = new html_dom_node($this);
		$node->_[HDOM_INFO_BEGIN] = $this->cursor;
		++$this->cursor;
		$tag = $this->copy_until($this->token_slash);
		$node->tag_start = $begin_tag_pos;
		if (isset($tag[0]) && $tag[0] === '!')
		{
			$node->_[HDOM_INFO_TEXT] = '<' . $tag . $this->copy_until_char('>');
			if (isset($tag[2]) && $tag[1] === '-' && $tag[2] === '-')
			{
				$node->nodetype = HDOM_TYPE_COMMENT;
				$node->tag = 'comment';
			}
			else
			{
				$node->nodetype = HDOM_TYPE_UNKNOWN;
				$node->tag = 'unknown';
			}
			if ($this->char === '>')
			{
				$node->_[HDOM_INFO_TEXT] .= '>';
			}
			$this->link_nodes($node, true);
			$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
			return true;
		}
		if ($pos = strpos($tag, '<') !== false)
		{
			$tag = '<' . substr($tag, 0, -1);
			$node->_[HDOM_INFO_TEXT] = $tag;
			$this->link_nodes($node, false);
			$this->char = $this->doc[--$this->pos];
			return true;
		}
		if (!preg_match('/^\w[\w:-]*$/', $tag))
		{
			$node->_[HDOM_INFO_TEXT] = '<' . $tag . $this->copy_until('<>');
			if ($this->char === '<')
			{
				$this->link_nodes($node, false);
				return true;
			}
			if ($this->char === '>')
			{
				$node->_[HDOM_INFO_TEXT] .= '>';
			}
			$this->link_nodes($node, false);
			$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
			return true;
		}
		$node->nodetype = HDOM_TYPE_ELEMENT;
		$tag_lower = strtolower($tag);
		$node->tag = ($this->lowercase) ? $tag_lower : $tag;
		if (isset($this->optional_closing_tags[$tag_lower]))
		{
			while (isset($this->optional_closing_tags[$tag_lower][strtolower($this->parent->tag)]))
			{
				$this->parent->_[HDOM_INFO_END] = 0;
				$this->parent = $this->parent->parent;
			}
			$node->parent = $this->parent;
		}
		$guard = 0;
		$space = array($this->copy_skip($this->token_blank), '', '');
		do
		{
			$name = $this->copy_until($this->token_equal);
			if ($name === '' && $this->char !== null && $space[0] === '')
			{
				break;
			}
			if ($guard === $this->pos)
			{
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				continue;
			}
			$guard = $this->pos;
			if ($this->pos >= $this->size - 1 && $this->char !== '>')
			{
				$node->nodetype = HDOM_TYPE_TEXT;
				$node->_[HDOM_INFO_END] = 0;
				$node->_[HDOM_INFO_TEXT] = '<' . $tag . $space[0] . $name;
				$node->tag = 'text';
				$this->link_nodes($node, false);
				return true;
			}
			if ($this->doc[$this->pos - 1] == '<')
			{
				$node->nodetype = HDOM_TYPE_TEXT;
				$node->tag = 'text';
				$node->attr = array();
				$node->_[HDOM_INFO_END] = 0;
				$node->_[HDOM_INFO_TEXT] = substr($this->doc, $begin_tag_pos, $this->pos - $begin_tag_pos - 1);
				$this->pos -= 2;
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				$this->link_nodes($node, false);
				return true;
			}
			if ($name !== '/' && $name !== '')
			{
				$space[1] = $this->copy_skip($this->token_blank);
				$name = $this->restore_noise($name);
				if ($this->lowercase)
				{
					$name = strtolower($name);
				}
				if ($this->char === '=')
				{
					$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
					$this->parse_attr($node, $name, $space);
				}
				else
				{
					$node->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_NO;
					$node->attr[$name] = true;
					if ($this->char != '>')
					{
						$this->char = $this->doc[--$this->pos];
					}
				}
				$node->_[HDOM_INFO_SPACE][] = $space;
				$space = array($this->copy_skip($this->token_blank), '', '');
			}
			else
			{
				break;
			}
		}
		while ($this->char !== '>' && $this->char !== '/');
		$this->link_nodes($node, true);
		$node->_[HDOM_INFO_ENDSPACE] = $space[0];
		if ($this->copy_until_char('>') === '/')
		{
			$node->_[HDOM_INFO_ENDSPACE] .= '/';
			$node->_[HDOM_INFO_END] = 0;
		}
		else
		{
			if (!isset($this->self_closing_tags[strtolower($node->tag)]))
			{
				$this->parent = $node;
			}
		}
		$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
		if ($node->tag === 'br')
		{
			$node->_[HDOM_INFO_INNER] = $this->default_br_text;
		}
		return true;
	}
	protected function parse_attr($node, $name, &$space)
	{
		if (isset($node->attr[$name]))
		{
			return;
		}
		$space[2] = $this->copy_skip($this->token_blank);
		switch ($this->char)
		{
			case '"': $node->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_DOUBLE;
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				$node->attr[$name] = $this->restore_noise($this->copy_until_char('"'));
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				break;
			case '\'': $node->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_SINGLE;
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				$node->attr[$name] = $this->restore_noise($this->copy_until_char('\''));
				$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
				break;
			default: $node->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_NO;
				$node->attr[$name] = $this->restore_noise($this->copy_until($this->token_attr));
		}
		$node->attr[$name] = str_replace("\r", '', $node->attr[$name]);
		$node->attr[$name] = str_replace("\n", '', $node->attr[$name]);
		if ($name === 'class')
		{
			$node->attr[$name] = trim($node->attr[$name]);
		}
	}
	protected function link_nodes(&$node, $is_child)
	{
		$node->parent = $this->parent;
		$this->parent->nodes[] = $node;
		if ($is_child)
		{
			$this->parent->children[] = $node;
		}
	}
	protected function as_text_node($tag)
	{
		$node = new html_dom_node($this);
		++$this->cursor;
		$node->_[HDOM_INFO_TEXT] = '</' . $tag . '>';
		$this->link_nodes($node, false);
		$this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null;
		return true;
	}
	protected function skip($chars)
	{
		$this->pos += strspn($this->doc, $chars, $this->pos);
		$this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null;
	}
	protected function copy_skip($chars)
	{
		$pos = $this->pos;
		$len = strspn($this->doc, $chars, $pos);
		$this->pos += $len;
		$this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null;
		if ($len === 0)
		{
			return '';
		}
		return substr($this->doc, $pos, $len);
	}
	protected function copy_until($chars)
	{
		$pos = $this->pos;
		$len = strcspn($this->doc, $chars, $pos);
		$this->pos += $len;
		$this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null;
		return substr($this->doc, $pos, $len);
	}
	protected function copy_until_char($char)
	{
		if ($this->char === null)
		{
			return '';
		}
		if (($pos = strpos($this->doc, $char, $this->pos)) === false)
		{
			$ret = substr($this->doc, $this->pos, $this->size - $this->pos);
			$this->char = null;
			$this->pos = $this->size;
			return $ret;
		}
		if ($pos === $this->pos)
		{
			return '';
		}
		$pos_old = $this->pos;
		$this->char = $this->doc[$pos];
		$this->pos = $pos;
		return substr($this->doc, $pos_old, $pos - $pos_old);
	}
	protected function remove_noise($pattern, $remove_tag = false)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		$count = preg_match_all($pattern, $this->doc, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
		for ($i = $count - 1; $i > -1; --$i)
		{
			$key = '___noise___' . sprintf('% 5d', count($this->noise) + 1000);
			if (is_object($debug_object))
			{
				$debug_object->debug_log(2, 'key is: ' . $key);
			}
			$idx = ($remove_tag) ? 0 : 1;
			$this->noise[$key] = $matches[$i][$idx][0];
			$this->doc = substr_replace($this->doc, $key, $matches[$i][$idx][1], strlen($matches[$i][$idx][0]));
		}
		$this->size = strlen($this->doc);
		if ($this->size > 0)
		{
			$this->char = $this->doc[0];
		}
	}
	function restore_noise($text)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		while (($pos = strpos($text, '___noise___')) !== false)
		{
			if (strlen($text) > $pos + 15)
			{
				$key = '___noise___' . $text[$pos + 11] . $text[$pos + 12] . $text[$pos + 13] . $text[$pos + 14] . $text[$pos + 15];
				if (is_object($debug_object))
				{
					$debug_object->debug_log(2, 'located key of: ' . $key);
				}
				if (isset($this->noise[$key]))
				{
					$text = substr($text, 0, $pos) . $this->noise[$key] . substr($text, $pos + 16);
				}
				else
				{
					$text = substr($text, 0, $pos) . 'UNDEFINED NOISE FOR KEY: ' . $key . substr($text, $pos + 16);
				}
			}
			else
			{
				$text = substr($text, 0, $pos) . 'NO NUMERIC NOISE KEY' . substr($text, $pos + 11);
			}
		}
		return $text;
	}
	function search_noise($text)
	{
		global $debug_object;
		if (is_object($debug_object))
		{
			$debug_object->debug_log_entry(1);
		}
		foreach($this->noise as $noiseElement)
		{
			if (strpos($noiseElement, $text) !== false)
			{
				return $noiseElement;
			}
		}
	}
	function __toString()
	{
		return $this->root->innertext();
	}
	function __get($name)
	{
		switch ($name)
		{
			case 'outertext': return $this->root->innertext();
			case 'innertext': return $this->root->innertext();
			case 'plaintext': return $this->root->text();
			case 'charset': return $this->_charset;
			case 'target_charset': return $this->_target_charset;
		}
	}
	function childNodes($idx = -1)
	{
		return $this->root->childNodes($idx);
	}
	function firstChild()
	{
		return $this->root->first_child();
	}
	function lastChild()
	{
		return $this->root->last_child();
	}
	function createElement($name, $value = null)
	{
		return @str_get_html("<$name>$value</$name>")->first_child();
	}
	function createTextNode($value)
	{
		return @end(str_get_html($value)->nodes);
	}
	function getElementById($id)
	{
		return $this->find("#$id", 0);
	}
	function getElementsById($id, $idx = null)
	{
		return $this->find("#$id", $idx);
	}
	function getElementByTagName($name)
	{
		return $this->find($name, 0);
	}
	function getElementsByTagName($name, $idx = -1)
	{
		return $this->find($name, $idx);
	}
	function loadFile()
	{
		$args = func_get_args();
		$this->load_file($args);
	}
}
