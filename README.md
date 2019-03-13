# vtiger-cli

```bash
$ vendor/bin/vtiger addEntityMethod Contacts \\MyPackage\\MyClass::myMethod
```

```bash
$ vendor/bin/vtiger apply \\MyPackage\\MyClass::myMethod
```

```bash
$ vendor/bin/vtiger install
```

```bash
$ vendor/bin/vtiger setPassword admin mypass
```

```bash
$ vendor/bin/vtiger dumpDatabase
```

```bash
$ vendor/bin/vtiger dumpFiles
```

```bash
$ vendor/bin/vtiger dumpAll
```

### Testing

```bash
$ docker-compose run vtiger composer install
$ docker-compose run vtiger vendor/bin/phpunit tests
```



