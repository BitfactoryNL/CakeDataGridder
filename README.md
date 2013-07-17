CakeDataGridder
===============

A CakePHP plugin to easy create DataGrids in CakePHP with functionalities as: pagination, sorting, searching etc.

## Requirements

The master branch has the following requirements:

* CakePHP 2.2.0 or greater.
* PHP 5.3.0 or greater.
* jQuery 1.9 or greater

## Installation

* Clone/Copy the files in this directory into `app/Plugin/DataGridder`
* Ensure the plugin is loaded in `app/Config/bootstrap.php` by calling `CakePlugin::load('DataGridder');`
* Include the helper in your `AppController.php`:
	* `public $helpers = array('DataGridder.DataGrid');`

## Documentation

In your view you can create a simple DataGrid by doing something like this:

```php
$this->DataGrid->addColumn('Id', 'User.id');
$this->DataGrid->addColumn('Id', 'User.username', array('sort' => true));

//Actions column to add actions to the row
$this->DataGrid->addColumn('Actions', null, array('type' => 'actions'));

//Add delete action to the actions column
$this->DataGrid->addAction('Delete', array('action' => 'delete'), array('User.id'));

echo $this->DataGrid->generate($users);
```

This code will generate a DataGrid with 3 columns for all the users we pass. The DataGrid Helper uses the Set::extract format to query the array data. So instead of `User.id` you can also use `/User/id`.

When you are using multiple DataGrids on one page you can reset the DataGrid settings:

```php
$this->DataGrid->reset();
```

### Tree
It is also possible to give a threaded result from `$this->Model->find('threaded')` to the DataGrid. The Helper recognizes the array structure and gives you extra functionalities, like expanding and collapsing.

### Columns
Adding a column can be done with several options, to add extra functionality to the column:

```php
$this->DataGrid->addColumn($label, $valuePath, $options);
```

#### String column
The String column is the default type of column. It simply retrieves the value of the array and places it inside the column. No extra functionalities.

```php
$options = array(
	'type' => 'string'
);
```

#### Image column
The Image column creates an Image tag of the retrieved value. When you have the BradCrumb/CakeImageCropResize plugin inside your project. You have extra functionality to resize and crop the image. For this type of column.

```php
$this->DataGrid->addColumn('Image', 'User.image', array(
	'type'		=> 'image',
	'resize'	=> array(
		'width'		=> 80,
		'height'	=> 80,
		'autocrop'	=> true,
		'crop'		=> true
	)
));
```

#### Switcher column
A switcher column switches a field between 2 states: enabled and disabled.

```php
$this->DataGrid->addColumn('Active', 'User.active', array(
	'type'				=> 'switcher',
	'url'				=> array(				//The url where the switch is triggered
		'action' => 'active'
	),
	'trailingParams'	=> array('User.id'),	//Parameters to add to the url
	'icon'				=> 'active' 			//Add the default Icon class and the active class
));
```

#### Actions column
The actions column is the container for the actions you can add with `addAction`.

```php
$this->DataGrid->addColumn('Actions', null, array(
	'type' => 'actions'
));

/**
 * @param $label
 * @param $url
 * @param $trailingParams
 * @param $options
 */
$this->DataGrid->addAction('Delete', array(
	'action' => 'delete'
), array(
	'User.id'
), $options);
```

#### Conditional column
With the Conditional column it is possible to show a value according to 1 or more conditions.

```php
$this->DataGrid->addColumn('Active', 'User.active', array(
	'type'			=> 'conditional',
	'conditions'	=> array('User.active' => '1'),	//Check if User.active == 1
	'true'			=> 'Active',					//If true then print "Active"
	'false'			=> 'Inactive'					//If false then print "Active"
));
```

A more advanced example:

```php
$this->DataGrid->addColumn('Active', 'User.active', array(
	'type'			=> 'conditional',
	'conditions'	=> array('User.usergroup' => '1'),	//Check if User.usergroup == 1
	'true'			=> array(							//If true
		'type'	=> 'string',							//We want a string value
		'url'	=> '...',								//Whit a link
		'rawData' => 'Set active state',				//And instead of the value we want the text "Set active state"
	),
	'false'			=> '-'								//If false then print "-"
));
```

You can see dat you can create conditions with as result a new column. So it is also possible to nest conditions. Simply use type `conditional` again, with `true` or `false`.


### Default DataGrid settings
It is possible to set default settings for the DataGrid.

```php
$this->DataGrid->defaults(array(
	'ajax'			=> true,				//Do we use AJAX for pagination, sorting and switching
	'update'		=> '#content',			//Conainer to update when we do an AJAX request
	'column'		=> array(				//Default settings for columns
		'sort'				=> false,		//Sorting on or off
		'type'				=> 'string',	//Type of the column
		'htmlAttributes'	=> false,		//Other HTML attributes
		'iconClass'			=> 'icon'		//Icon class
	),
	'grid'			=> array(				//Default grid settings
		'class' => 'data_grid'				//Class for datagrid
	),
	'pagination'	=> array(				//Default settings for pagination
		'numbers' => array()				//Default settings for numbers
	),
	'filter'		=> array()				//Default settings for filters
));
```

### Filters
It is possible to add a search filter to filter the datagrid. The API is the same as the $this->Form->input() method.

```php
$this->DataGrid->addFilter($fieldName, $options);
```

The filter submits to the same URL. You have to implement the filter yourself in the Controller. When AJAX is enabled, the submit will be done threw AJAX.