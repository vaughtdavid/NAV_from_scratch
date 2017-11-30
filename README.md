# WORKING WITH GIT/GITHUB
**Notes from [this video](https://www.youtube.com/watch?time_continue=1859&v=ZDR433b0HJY) by Scott Chacon of GitHub**

## INTRODUCTION

[IEXCHANGE](https://iextrading.com) provides free access to very current [stock quotes](https://iextrading.com/apps/stocks/#/AAPL) and other data. 

## API
[The API is pretty great](https://iextrading.com/developer/docs/#quote) (it's RESTful, for one). So, I can use cURL to request a stock quote. The following code (from get_quote.php)...

```
### https://iextrading.com/developer/docs/#quote
function _1_GET_quote($symbol) {
    $symbol = strtolower($symbol);
    $response = CallAPI("GET", "https://api.iextrading.com/1.0/stock/".$symbol."/quote");
    $response = json_decode($response);
    return $response;
}
```
Gets the following result...
```
{
  "symbol": "AAPL",
  "companyName": "Apple Inc.",
  "primaryExchange": "Nasdaq Global Select",
  "sector": "Technology",
  "calculationPrice": "tops",
  "open": 154,
  "openTime": 1506605400394,
  "close": 153.28,
  "closeTime": 1506605400394,
  "latestPrice": 158.73,
  "latestSource": "Previous close",
  "latestTime": "September 19, 2017",
  "latestUpdate": 1505779200000,
  "latestVolume": 20567140,
  "iexRealtimePrice": 158.71,
  "iexRealtimeSize": 100,
  "iexLastUpdated": 1505851198059,
  "delayedPrice": 158.71,
  "delayedPriceTime": 1505854782437,
  "previousClose": 158.73,
  "change": -1.67,
  "changePercent": -0.01158,
  "iexMarketPercent": 0.00948,
  "iexVolume": 82451,
  "avgTotalVolume": 29623234,
  "iexBidPrice": 153.01,
  "iexBidSize": 100,
  "iexAskPrice": 158.66,
  "iexAskSize": 100,
  "marketCap": 751627174400,
  "peRatio": 16.86,
  "week52High": 159.65,
  "week52Low": 93.63,
  "ytdChange": 0.3665,
}
```
Man, that's nice.



## CONCLUSION
Sadly, IEXCHANGE does not provide historical stock prices, which is exactly what is needed to calculate Net Asset Value over the life of a (pre-existing) stock portfolio. 

### Looks like it's time to find a new data source...

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
Which returns the following information about Apple stocks (AAPL)...

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

## GET HISTORICAL PRICES WORKING
the function **get_historical_prices()** works, but only for US stocks, other stocks, like BZUN, ANET, to name a few, are not available in the free quandl WIKI. They throw the following error:

```
{"quandl_error":{"code":"QEPx04","message":"You do not have permission to view this dataset. Please subscribe to this database to get access."}}
```
I emailed support about the problem and there's no (free) way around that. I'll probably end up searching on google or yahoo..
