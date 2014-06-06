--TEST--
Bug #67118 crashes in DateTime when this used after failed __construct
--INI--
date.timezone=Europe/Berlin
--FILE--
<?php
class mydt extends datetime
{
	public function __construct($time = 'now', $tz = NULL, $format = NULL)
	{
		if (!empty($tz) && !is_object($tz)) {
			$tz = new DateTimeZone($tz);
		}
		try {
			@parent::__construct($time, $tz);
		} catch (Exception $e) {
			echo "Bad date" . $this->format("Y") . "\n";
		}
	}

};

new mydt("Funktionsansvarig rådgivning och juridik", "UTC");
?>
--EXPECTF--
Fatal error: Call to a member function format() on a non-object in %sbug67118.php on line %d
