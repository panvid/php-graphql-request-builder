# GraphQL Request Builder
This library builds a request for sending to a GraphQL server.

## What is GraphQL?
*GraphQL* is a query language to easy request data from remote web servers. There are several pros for using *GraphQL*
instead of *REST* like

- decreasing request amount
- saving traffic in payload
- avoid backend changes on changing client requested data

For a full description see [How to GraphQL](https://www.howtographql.com/).

### Naming conventions
The schema of *GraphQL* is defined by two easy attributes:

- *Type*s
- *Argument*s

*Type* define a structured requested data object. *Argument*s can define these types.

#### Example
A type *forum* can have *posts*, which has *authors* and a *title*. If you want to receive all *author* ant post *title*
information as response your request can look like this:

```graphql
{
  forum {
    posts {
      authors,
      title
    }
  }
}
```

To specify your requested data for crawling only the **last 5** *posts* you can modify your request like this:

```graphql
{
  forum {
    posts(last: 5) {
      authors,
      title
    }
  }
}
```

*GraphQL* requested data can complex as you want:

```graphql
{
  forum {
    posts(last: 5) {
      authors(registration: {date: "2019-08-08"}, visible: true) {
        surname,
        prename(startingWith: "a"),
        birthday
      },
      title
    },
    users(last: 10, sort: "registrationDate", order: "DESC")
  }
}
```

## Why this library?
This library helps building this **payload structure** without any `string` concatenation or other strange ideas.

### Example
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
use GraphQL\RequestBuilder\RootType;
use GraphQL\RequestBuilder\Type;

$searchType = (new Type('search'))
    ->addArgument(new Argument('criteria', new Argument('start', '2019-08-23')))
    ->addSubTypes([
        (new Type('errors'))->addSubTypes(['code', 'type', 'description']),
        'id'
    ]
);

echo (string) (new RootType('field'))->addSubType($searchType);
```