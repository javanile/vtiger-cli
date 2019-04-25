# vtiger-cli

[![StyleCI](https://github.styleci.io/repos/137904364/shield?branch=master)](https://github.styleci.io/repos/137904364)
[![Build Status](https://travis-ci.org/javanile/vtiger-cli.svg?branch=master)](https://travis-ci.org/javanile/vtiger-cli)
[![codecov](https://codecov.io/gh/javanile/vtiger-cli/branch/master/graph/badge.svg)](https://codecov.io/gh/javanile/vtiger-cli)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/9bf441fc44d94bafbbe5f509251acb68)](https://www.codacy.com/app/francescobianco/vtiger-cli?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=javanile/vtiger-cli&amp;utm_campaign=Badge_Grade)

## Get Started

Install vtiger-cli on your work-station
```bash
$ composer global require javanile/vtiger-cli
```

Create a `vtiger.json` file into your work-station then place your existing  
Vtiger installation path into `vtiger_dir` key as follow  
```json
{
  "vtiger_dir": "/my/web/server/vtigercrm"
}
```

Now, type the follow command to check errors, and goog work!
```bash
$ vtiger info
```

## Documentation

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
$ docker-compose run --rm vtiger composer install
$ docker-compose run --rm vtiger phpunit tests
```
