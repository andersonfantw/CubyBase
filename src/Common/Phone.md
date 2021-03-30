# CubyBase/Common/Phone

提供可擴充的電話號碼驗證，並可將輸入的電話號碼依設定格式輸出。

## Installation

Package is installable via composer.

```bash
~$ composer request cuby/CubyBase
```

## Basic Usage

```php
use CubyBase\Common\Phone;

$phone = new Phone('+85212345678');
or 
$phone = new Phone();
$phone->create('+85212345678');
```

You can call it statically

```php
$phone = Phone('+85212345678');
or
$phone = Phone::create('+85212345678');
```

Valid a phone

```php
$phone->isValid();
or 
Phone::create('+85213245678')->isValid();
```

Get phone country code

```php
$phone->getCountryCode();
//zh-hk
or 
Phone::create('+85213245678')->getCountryCode();
//zh-hk
```

測試一組電話號碼。

輸入的電話號碼僅為數字。若要由class解析電話號碼，請使用create。

```php
Phone::valid('85212345678');
```

測試一組電話號碼是不是指定的國家

```php
Phone::valid('85212345678','zh-hk');
```