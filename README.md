# Crypto 2 BGN

Show specific cryptocurrency price in bulgarian Lev (BGN)

Plugin works coinmarketcap.com API.

Gets the price of specific cryptocurrency from coinmarketcap.com in EUR and convert it to BGN (Bulgarian Lev).

Has options for custom output.

## Installation

Download and activate the plugin. The plugin works with shortcode:

[crypto_to_bgn]

The deafult currency is Bitcoin (BTC) and the default FIAT is BGN.

With all parameters it will look like this:

[crypto_to_bgn currency="BTC" fiat="BGN" decimals="5" simple="0"]

## Frequently Asked Questions

### Can I choose another currency?

Yes, you can just add parameter "currency" in the shortcode. So it will look like this [crypto_to_bgn currency="LTC"]

### Can I use just the rate?

Yes, you can! Set parameter "equal" to false. So it will look like this [crypto_to_bgn currency="LTC" simple="1"]

### Can I use multiple shortcodes in my page?

Yes, you can! Place as many shortodes as you want!

[crypto_to_bgn currency=BTC]

[crypto_to_bgn currency=ETH]

[crypto_to_bgn currency=RRP]

### Can I use the plugin in a Widget?

Yes, you can!

Go to "Widgets" section choose "Text", add it to the desired location Sidebar for example.

Then place the shortcode in the content box and it's done!

### Can I use multiple shortcodes in a Widget?

Yes, you can! You already know how.

## Donations

If you like the plugin and it helps you to offer better services at your site you can buy me a fruit!

(BTC) 1ATAnAsK2wwDGK6UKrUewJDWtZ6kgJXEYu

## Changelog

### 1.0.0
* Updated to work with Coinmarketcap API v2.
* Multiple fiat currencies added.

### 0.9
* First release.
* No changes.
