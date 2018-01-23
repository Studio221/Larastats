# Larastats

A simple Laravel package allowing you to fetch stats from any of your models created between two dates passed in parameters.


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


## Examples

### Controller

Date format : 2018-01-23
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

### View using 'count' as a parameter

```html
<div class="col-md-4">
	{{-- $userCount return an integer, 53 for example --}}
	<p>{{ $userCount }}</p>
	<p>Total Users</p>
</div>
```
### View using 'graph' as a parameter using Morris.js

```html
<div class="card-box">
	<div id="stats-container"></div>
</div>
<script>
	// Date Range user graph
	const url_string = window.location.href,
	  url = new URL(url_string),
	  start = url.searchParams.get('start') ? moment(url.searchParams.get('start')) : moment().subtract(7, 'days'),
	  end = url.searchParams.get('end') ? moment(url.searchParams.get('end')) : moment();
	
	function cb(start, end) {
	  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	}
	
	$('input[name="users-daterange"]').daterangepicker({
	  'locale': {
	    'format': 'MM/DD/YYYY',
	    'separator': ' - ',
	    'applyLabel': 'Confirm',
	    'cancelLabel': 'Cancel',
	    'fromLabel': 'From',
	    'toLabel': 'to',
	    'customRangeLabel': 'Custom',
	    'weekLabel': 'S',
	    'daysOfWeek': [
	      'Sun',
	      'Mon',
	      'Tue',
	      'Wed',
	      'Thu',
	      'Fri',
	      'Sat'
	    ],
	    'monthNames': [
	      'January',
	      'February',
	      'March',
	      'April',
	      'May',
	      'June',
	      'July',
	      'August',
	      'September',
	      'October',
	      'November',
	      'December'
	    ],
	    'firstDay': 0
	  },
	  startDate: start,
	  endDate: end,
	}, cb);
	
	cb(start, end);
	
	$('input[name="users-daterange"]').on('apply.daterangepicker', function (ev, picker) {
	  document.location.href = `{{ config('url') }}/dashboard?start=${picker.startDate.format('YYYY-MM-DD')}&end=${picker.endDate.format('YYYY-MM-DD')}`;
	});
	
	// User graphic evolution
	var data = {!! $userStatsDatas !!};
	new Morris.Line({
	  // ID of the element in which to draw the chart.
	  element: 'stats-container',
	  data: data,
	  xkey: 'x',
	  ykeys: ['y'],
	  xLabel: 'Jours',
	  yLabelFormat: function (y) {return y != Math.round(y) ? '' : y;},
	  xLabelFormat: function (d) {
	    return d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
	  },
	  labels: ['Users'],
	  lineWidth: 2,
	  dateFormat: function (date) {
	    d = new Date(date);
	    return d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
	  },
	});
</script>
```