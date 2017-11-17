# WORKING WITH GIT/GITHUB
**Notes from [this video](https://www.youtube.com/watch?time_continue=1859&v=ZDR433b0HJY) by Scott Chacon of GitHub**

## INTRODUCTION
[Quandl's](https://www.quandl.com) mission, among other points I'm unaware of, is to make **[historical stock prices](https://www.quandl.com/product/WIKIP/WIKI/PRICES-Quandl-End-Of-Day-Stocks-Info)** publicly available. 

## API
Quandl has a [Python API](https://www.quandl.com/tools/python), but I want to use PHP / MySQL, sooo... 

*(There's no real reason for this other than preference. I cut my teeth on Python, but have spent more time with PHP and SQL in the last few years, and that's how I started this project. I mostly don't want to switch languages mid-stream.)*
## DannyBen to the rescue.
**DannyBen** has a git repo called **[php-quandl](https://github.com/DannyBen/php-quandl)** that translates the python into PHP. I have cloned it into the **resources/php-quandl-master/** directory of this repo.

It is required in **get_quotes.php**

```
<?php
### SETUP
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/Quandl.php");
require("/Users/vaughtdavid/Sites/VCM/13_NAV_from_scratch/resources/php-quandl-master/examples.php");
```

Note that Quandl assigns a user-specific API key, and rather than post mine publically by saving it in my code, **I'm reading it from STDIN** every time I run the program.

```
### GET QUANDL API KEY FROM STDIN
if (defined('STDIN')) {
  $api_key = $argv[1];
} else { 
  throw new Exception("No user input received. Need API Key as argument.", 1);
}
```
I'm using the example 2 function defined in **/resources/php-quandl-master/Example.php** ...

```
// Example 2: API Key + JSON
function example2($api_key, $symbol) {
	$quandl = new Quandl($api_key);
	$quandl->format = "json";
	return $quandl->getSymbol($symbol);
}
```

So my main is simply...

```
function main() {
	global $api_key;
	$json_data = example2($api_key, "WIKI/AAPL");
	$php_std_obj = json_decode($json_data);
	
	
	### THE HEADERS...
	print_r("\n\nThe headers are...\n");
	print_r(($php_std_obj->dataset)->column_names);

	### THE RECORDS...
	print_r("\n\nThe data is...\n");
	print_r(_2d_array_print(($php_std_obj->dataset)->data));
}

main();
?>
```
Which returns [the following information about Apple stocks (AAPL)](https://www.quandl.com/api/v3/datatables/WIKI/PRICES?ticker=A&api_key=PCGMFqJjTVBN99R-ysBq)...

```
The headers are...
Array
(
    [0] => Date
    [1] => Open
    [2] => High
    [3] => Low
    [4] => Close
    [5] => Volume
    [6] => Ex-Dividend
    [7] => Split Ratio
    [8] => Adj. Open
    [9] => Adj. High
    [10] => Adj. Low
    [11] => Adj. Close
    [12] => Adj. Volume
)


The data is...

2017-11-16        171.18            171.87            170.3             171.1             23497326          0                 1                 171.18            171.87            170.3             171.1             23497326          
2017-11-15        169.97            170.3197          168.38            169.08            28702351          0                 1                 169.97            170.3197          168.38            169.08            28702351          
2017-11-14        173.04            173.48            171.18            171.34            23588451          0                 1                 173.04            173.48            171.18            171.34            23588451          
2017-11-13        173.5             174.5             173.4             173.97            16828025          0                 1                 173.5             174.5             173.4             173.97            16828025 
...
...
1980-12-17        25.87             26                25.87             25.87             385900            0                 1                 0.38036181021984  0.38227317610034  0.38036181021984  0.38036181021984  21610400          
1980-12-16        25.37             25.37             25.25             25.25             472000            0                 1                 0.37301040298714  0.37301040298714  0.37124606525129  0.37124606525129  26432000          
1980-12-15        27.38             27.38             27.25             27.25             785200            0                 1                 0.40256306006259  0.40256306006259  0.40065169418209  0.40065169418209  43971200          
1980-12-12        28.75             28.87             28.75             28.75             2093900           0                 1                 0.42270591588018  0.42447025361603  0.42270591588018  0.42270591588018  117258400   
```	
**That's staggering. All this data, since 12/12/1980, available through a public API, for free. Awesome.**

## CONCLUSION
