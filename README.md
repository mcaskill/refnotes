# RefNotes

A simple API for collecting footnotes with PHP.

```php
$code = RefList::add( "We predict too much for the next year and yet far too little for the next 10." );
RefList::add( "The airman's earth, if free men make it, will be truly round: a globe in practice, not in theory.", $code );

RefList::add( 'Science has not yet mastered prophecy.', 'record-pending', [
    'marker' => '*'
] );
RefList::append_data( [ 'foo' => 'bar' ], 'record-pending' );

RefList::add( "Across the sea of space, the stars are other suns." );
RefList::add( "Where ignorance lurks, so too do the frontiers of discovery and imagination.", RefList::get_last_code() );

$notes = RefList::get_codes();

foreach ( $notes as $code ) {
    $data = RefList::get_data( $code );
    $messages = RefList::get_message( $code );

    // To infinite... and beyond!
}
```

## Installation

### With Composer

```
$ composer require mcaskill/refnotes
```

```json
{
    "require": {
        "mcaskill/refnotes": "dev-master"
    }
}
```

```php
<?php

require 'vendor/autoload.php';

use RefNotes\RefList;

printf( RefList::add( 'Hello, World!' ) );
```
### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download [RefList.php](https://github.com/mcaskill/RefNotes/blob/master/src/RefNotes/RefList.php) from the repo and save the file into your project path somewhere.

```php
<?php

require 'path/to/RefList.php';

use RefNotes\RefList;

printf( RefList::add( 'Hello, World!' ) );
```
