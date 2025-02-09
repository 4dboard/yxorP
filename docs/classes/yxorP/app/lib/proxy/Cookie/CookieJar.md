***

# cookieJar





* Full name: `\yxorP\lib\proxy\cookie\cookieJar`
* This class implements:
[`\yxorP\lib\proxy\cookie\cookieJarInterface`](./cookieJarInterface.md)



## Properties


### cookies



```php
private $cookies
```






***

### strictMode



```php
private $strictMode
```






***

## Methods


### __construct



```php
public __construct(mixed $strictMode = false, mixed $cookieArray = []): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$strictMode` | **mixed** |  |
| `$cookieArray` | **mixed** |  |




***

### setCookie



```php
public setCookie(\yxorP\lib\proxy\cookie\setCookie $cookie): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie` | **\yxorP\lib\proxy\cookie\setCookie** |  |




***

### removeCookieIfEmpty



```php
private removeCookieIfEmpty(\yxorP\lib\proxy\cookie\setCookie $cookie): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie` | **\yxorP\lib\proxy\cookie\setCookie** |  |




***

### clear



```php
public clear(mixed $domain = null, mixed $path = null, mixed $name = null): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | **mixed** |  |
| `$path` | **mixed** |  |
| `$name` | **mixed** |  |




***

### fromArray



```php
public static fromArray(array $cookies, mixed $domain): mixed
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookies` | **array** |  |
| `$domain` | **mixed** |  |




***

### getCookieValue



```php
public static getCookieValue(mixed $value): mixed
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




***

### shouldPersist



```php
public static shouldPersist(\yxorP\lib\proxy\cookie\setCookie $cookie, mixed $allowSessionCookies = false): mixed
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie` | **\yxorP\lib\proxy\cookie\setCookie** |  |
| `$allowSessionCookies` | **mixed** |  |




***

### getCookieByName



```php
public getCookieByName(mixed $name): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **mixed** |  |




***

### toArray



```php
public toArray(): mixed
```











***

### getIterator



```php
public getIterator(): mixed
```











***

### clearSessionCookies



```php
public clearSessionCookies(): mixed
```











***

### count



```php
public count(): mixed
```











***

### extractCookies



```php
public extractCookies(\yxorP\lib\psr\http\message\requestInterface $request, \yxorP\lib\psr\http\message\responseInterface $response): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\yxorP\lib\psr\http\message\requestInterface** |  |
| `$response` | **\yxorP\lib\psr\http\message\responseInterface** |  |




***

### getCookiePathFromRequest



```php
private getCookiePathFromRequest(\yxorP\lib\psr\http\message\requestInterface $request): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\yxorP\lib\psr\http\message\requestInterface** |  |




***

### withCookieHeader



```php
public withCookieHeader(\yxorP\lib\psr\http\message\requestInterface $request): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\yxorP\lib\psr\http\message\requestInterface** |  |




***


***

