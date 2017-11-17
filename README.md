# WORKING WITH GIT/GITHUB
**Notes from [this video](https://www.youtube.com/watch?time_continue=1859&v=ZDR433b0HJY) by Scott Chacon of GitHub**

## INTRODUCTION
[Quandl's](https://www.quandl.com) mission, among other points I'm unaware of, is to make **[historical stock prices](https://www.quandl.com/product/WIKIP/WIKI/PRICES-Quandl-End-Of-Day-Stocks-Info)** publicly available. 

## API
Quandl has a Python API, but this app uses PHP / MySQL, sooo...

## DannyBen to the rescue.
[DannyBen has a git repo](https://github.com/DannyBen/php-quandl) that **translates the python into PHP.** I have cloned it into the resources directory of this repo.

```
<?php
### SETUP
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/Quandl.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/examples.php");

### GET QUANDL API KEY FROM STDIN
if (defined('STDIN')) {
  $api_key = $argv[1];
} else { 
  throw new Exception("No user input received. Need API Key as argument.", 1);
}
```
And I need the example 2 function defined in Example.php ...

```
// Example 2: API Key + JSON
function example2($api_key, $symbol) {
	$quandl = new Quandl($api_key);
	$quandl->format = "json";
	return $quandl->getSymbol($symbol);
}
```

So my main is..

```
function main() {
	global $api_key;
	$json_data = example2($api_key, "WIKI/AAPL");
	$data = json_decode($json_data);
	
	print_r($data);
}

main();
?>
```

## CONCLUSION
