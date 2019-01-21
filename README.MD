# Category Data Table Layout

[![Travis CI](https://travis-ci.org/FriendsOfShopware/FroshDataTableLayout.svg?branch=master)](https://travis-ci.org/FriendsOfShopware/FroshDataTableLayout)

![FroshDataTableLayout](https://raw.githubusercontent.com/FriendsOfShopware/FroshDataTableLayout/master/Resources/store/images/0.png)

This plugin for Shopware adds data table to the available product layouts of categories.
The table columns can be configured through a backend app. You may add and remove columns,
edit their labels and contents, either by key of the `$sArticles` array and/or through a JavaScript
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

## Customize

The backend app used to customize the table can be found in the "Content" menu. You can add, remove,
edit columns and rearrange their order by drag and drop. When editing/creating columns you will
find three input fields:

* __Label__: Will be displayed in the head of the column. After the first request the label will be
stored in a text snippet with the namespace `frontend/plugins/frosh/datatablelayout/column` and the name being
identical to the label. You can use that snippet for translations to other languages.
* __Property__: The data source of the column. This would be a key of the `$sArticle` array, e.g. `ordernumber`. You can
use nested properties by seperating keys by a `.`, e.g. `image.thumbnails.0.sourceSet`
* __Render Script__: You can optionally provide a JavaScript return statement to alter or enhance
the output of the data source. Please note the following exampe.

### Example

To display a thumbnail of the article in column:

__Property:__ image.thumbnails.0.sourceSet  
__Render Script:__ 
```JavaScript
return '<img style="margin:0 auto;max-height:30px" title="' + row.articleName + '" srcset="' + data + '">';
```

## Installation

* Clone this repository into a folder **FroshDataTableLayout** within the **custom/plugins** directory of the Shopware installation.
* Install the plugin through the Plugin-Manager within the Shopware backend.

### Install with composer

* Change to your root installation of shopware
* Run command `composer require frosh/data-table-layout` and install and activate plugin with Plugin Manager 

## Requirements

* Shopware 5.5.0 or higher
* PHP 7.0
