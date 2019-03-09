# vtiger-cli

```bash
$ vendor/bin/vtiger addEntityMethod Contacts \\MyPackage\\MyClass::myMethod
```

```bash
$ vendor/bin/vtiger require \\MyPackage\\MyClass::myMethod
```

```bash
$ vendor/bin/vtiger apply
```

### Testing


```bash
$ docker-compose run vtiger composer install
$ docker-compose run vtiger phpunit vendor/bin/phpunit
```



