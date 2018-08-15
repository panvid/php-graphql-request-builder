#GraphQL Request Builder
This library builds a request for sending to a GraphQL server.

##Example
To create following request payload
```graphql
{
  field {
    search(criteria: {start: "2019-08-23"}) {
      errors {
        code
        type
        description
      }
      id
    }
  }
}
```

you need to execute following PHP code
```php
<?php
declare(strict_types=1);

use GraphQL\RequestBuilder\Argument;
use GraphQL\RequestBuilder\Type;

$searchType = new Type('search');
$searchType->addArgument(new Argument('criteria', new Argument('start', '2019-08-23')));
$searchType->addSubTypes([
    (new Type('errors'))->addSubTypes(['code', 'type', 'description']),
    'id'
]);

$field = (new Type('field'))->addSubType($searchType);
```