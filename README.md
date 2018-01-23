# Larastats

A simple Laravel package allowing you to fetch stats from any of your models.


## Installation

### With Composer

```
$ composer require bigsnowfr/larastats @dev
```

```json
{
    "require": {
        "bigsnowfr/larastats": "@dev"
    }
}
```


## Example
```php
<?php

use Bigsnowfr\Larastats\LarastatsFacade; 

public function index(Request $request)
    {
        $datas = [
          'userCount'      => [User::class, 'count'],
          'votesCount'     => [Vote::class, 'count'],
          'userStatsDatas' => [User::class, 'graph']
        ];


        foreach ($datas as $key => $data) {
            $$key = LarastatsFacade::getStatByDate($data[0], $request->input('start'), $request->input('end'),
              $data[1]);
        }

        return view('admin.pages.dashboard',
          compact(['userCount', 'votesCount', 'userStatsDatas']));
    }
```