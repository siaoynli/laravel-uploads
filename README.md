# laravel 上传文件包



## install

this package  for  laravel

```
composer require siaoynli/laravel-uploads
```

add the ServiceProvider to the providers array in config/app.php

```
Siaoynli\Upload\UploadServiceProvider::class,
```

If you want to use the facade to log messages, add this to your facades in app.php:

```
 'Upload' => Siaoynli\Upload\Facades\Upload::class,
```

Copy the package config to your local config with the publish command:

```
php artisan vendor:publish --provider="Siaoynli\Upload\UploadServiceProvider"
```

## Usage

```
use Upload;


//upload
$info=Upload::do()
$info=Upload::type("video")->do()

## Result

```
//upload  result

array:6 [▼
  "state" => "SUCCESS"
  "original_name" => "0eb30f2442a7d9337afbe24aa94bd11373f001b3.jpg"
  "ext" => "jpg"
  "mime" => "image/jpeg"
  "size" => 130759
  "url" => "/uploads/image/2019-07-10/b40383942859e40ee1f1eb3dd889e01d9b68dcb5.jpg"
]

//upload error
[
  "state"=>"error message"
]

```

> strict mode 值为true，即严格校验文件
