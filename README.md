# vtiger-cli

[![StyleCI](https://github.styleci.io/repos/137904364/shield?branch=master)](https://github.styleci.io/repos/137904364)
[![Build Status](https://travis-ci.org/javanile/vtiger-cli.svg?branch=master)](https://travis-ci.org/javanile/vtiger-cli)
[![codecov](https://codecov.io/gh/javanile/vtiger-cli/branch/master/graph/badge.svg)](https://codecov.io/gh/javanile/vtiger-cli)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/9bf441fc44d94bafbbe5f509251acb68)](https://www.codacy.com/app/francescobianco/vtiger-cli?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=javanile/vtiger-cli&amp;utm_campaign=Badge_Grade)

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
