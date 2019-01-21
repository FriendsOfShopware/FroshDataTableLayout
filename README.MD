# Category Data Table Layout

[![Travis CI](https://travis-ci.org/FriendsOfShopware/FroshDataTableLayout.svg?branch=master)](https://travis-ci.org/FriendsOfShopware/FroshDataTableLayout)

![FroshDataTableLayout](https://raw.githubusercontent.com/FriendsOfShopware/FroshDataTableLayout/master/Resources/store/images/0.png)

This plugin for Shopware adds data table to the available product layouts of categories.
The table columns can be configured through a backend app. You may add and remove columns,
their labels and contents, either by key of the `$sArticles` array and/or through a JavaScript
return value.

To render and update the tables content the popular jQuery plugin [datatables](https://datatables.net/) is used. 

The plugin comes pre-configured with a few columns. You can use these entries as a reference
on how to customize the table to your needs.

You can find a working demo [here](http://shopware.davidneustadt.de/genusswelten/tees-und-zubehoer/).

### Features

* Fully configurable table content through the backend app
* Freely add, remove and rearrange columns
* Render data table only where neccessary by assigning the custom product layout to appropriate categories
* Ajax pagination and search
* Use JavaScript to enhance the output values of `$sArticles`

## Installation

* Clone this repository into a folder **FroshDataTableLayout** within the **custom/plugins** directory of the Shopware installation.
* Install the plugin through the Plugin-Manager within the Shopware backend.

### Install with composer

* Change to your root installation of shopware
* Run command `composer require frosh/data-table-layout` and install and activate plugin with Plugin Manager 

## Requirements

* Shopware 5.5.0 or higher
* PHP 7.0
