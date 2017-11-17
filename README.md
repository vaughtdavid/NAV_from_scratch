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