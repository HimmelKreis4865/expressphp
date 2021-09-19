# express.php
Express.php is a new HTTP - Server especially made for RESTful APIs written in PHP.

## Features
### Fast
The Library is handles requests fast and precise, it consumes around 20ms per request.

### Easy
This project comes up with an easy to use syntax, that similar to [express.js](https://github.com/expressjs/express)


## Get started
### Installation
Download from github, and drop in your target project.

### Docs
#### The basic application
```php
<?php

use express\App;
use express\io\Request;
use express\io\Response;

require "src/express/App.php";

$app = new App();

# All routes have to be set here. After listen, no code will be executed

$app->listen(80);
```
#### Add a Route

To add a basic GET route, you can use the following code:
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get("/", function (Request $request, Response $response) {
	# Code that should be executed once a request received
});
```
 - For a POST route, use `$app->post()`
 - For a PUT route, use `$app->put()`
 - For a PATCH route, use `$app->patch()`
 - For a DELETE route, use `$app->delete()`

#### Query parameters
HTTP Queries are the part after the `?` in an URL. This library comes up with a simple API for handling it:
When registering the route, you can simply add (for example) `?name=username`, the request now requires a query parameter with the name `name`.
A request for this would look something like `localhost/users?name=dummyname`. In the code, this means that there is a new property called like the query parameter name, `username` in this case (The value you defined when setting up the route). It can simply be accessed using `$request->name`
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get("/users?name=username", function (Request $request, Response $response) {
	echo $request->username;
});

$app->get("/messages?id=message_id", function (Request $request, Response $response) {
	echo $request->message_id;
});
```

### Route parameters
Route parameters are custom parameters that can contain a client - defined value (matching a pattern, if set).
This can be done by using `#name`, `name` will be the property name accessible in the request. 
This can contain any value `#message_id`, ...
```php
<?php

use express\io\Request;
use express\io\Response;

$app->post("/users/#userId/nick", function (Request $request, Response $response) {
	echo $request->userId;
});
```
`$request->userId` can now contain nearly any value. To prevent this, we can use patterns:

#### Route Parameter Patterns
Patterns are used to specify which values a parameter can contain.
There are multiple settings to use, but in general, patterns are JSON encoded arrays, set to the route
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users/{"name": "userId", "len-min": 16, "len-max": 16}', function (Request $request, Response $response): void {
	
});
```
Now, that you know how its basically built, lets speak of the possible settings you are able to set:

| Name | Description | Values | Required |
|---|---|---|---|
| name | Sets the name of the parameter | Any string (Without /) | ✔️|
| type | Sets the required of the parameter | string/int/float | ❌ |
| len-min | Sets the minimum length of the parameter | any number (smaller than len-max) | ❌ |
| len-max | Sets the maximum length of the parameter | any number (bigger than len-min) | ❌ |

#### Redirect requests
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users', function (Request $request, Response $response): void {
	$response->redirect("/members");
});
```
#### Set a response body
You can set a response code by using `$response->body()`. This can either be a string, or an array that will get JSON encoded once the request is sent.
String:
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users', function (Request $request, Response $response): void {
	$response->body("Access denied");
});
```
Array: (For JSON encoding)
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users', function (Request $request, Response $response): void {
	$response->body(["error" => "Access denied"]);
});
```

#### Response Codes
You can set a response code for the response using `$response->code()`. All types there you can find all supported status codes with their names in `express\utils\StatusCodes`.
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users', function (Request $request, Response $response): void {
	$response->code(403);
	$response->body(["error" => "Access denied"]);
});
```
If your response code is not supported yet, use `$response->customResponseCodeMessage()`.

#### Respond as a HTML 
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/users', function (Request $request, Response $response): void {
	$response->html("/members");
});
```

#### Change the HTTP Content-Type
```php
<?php

use express\io\Request;
use express\io\Response;

$app->get('/', function (Request $request, Response $response): void {
	$response->contentType("text/plain");
});
```
You can check [this page](https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types) for a basic list of common content types.