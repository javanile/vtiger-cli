## vtiger

[![StyleCI](https://github.styleci.io/repos/137904364/shield?branch=master)](https://github.styleci.io/repos/137904364)
[![Build Status](https://travis-ci.org/javanile/vtiger-cli.svg?branch=master)](https://travis-ci.org/javanile/vtiger-cli)
[![codecov](https://codecov.io/gh/javanile/vtiger-cli/branch/master/graph/badge.svg)](https://codecov.io/gh/javanile/vtiger-cli)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/9bf441fc44d94bafbbe5f509251acb68)](https://www.codacy.com/app/francescobianco/vtiger-cli?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=javanile/vtiger-cli&amp;utm_campaign=Badge_Grade)
![vtiger](https://github.com/javanile/vtiger-cli/raw/main/vtiger.png)

Use vtiger-cli is very simple, it adds a professional touch and a lot of time saved to your work.

### Get Started

#### Install

PowerShell (Windows) 

```PowerSchell
PS C:\Users\SamSempiol> curl git.io/vtiger.ps1 -o setup; .\setup
```

CMD.EXE (Windows) 

```cmd
C:\Users\SamSempiol> curl git.io/vtiger.cmd -o setup.cmd & setup
```

Linux / macOS

```bash
$ curl -fsSL git.io/vtiger | sudo bash -
```

### Examples

### Official Documentation

Documentation for installing Laravel can be found on the Laravel website.

**`②`** Create a `vtiger.json` file into your machine then place your existing `vtiger_dir` path inside
Install vtiger-cli on your work-station
```bash
$ composer global require javanile/vtiger-cli
```

Create a `vtiger.json` file into your work-station and place your existing Vtiger installation path into `vtiger_dir` key as follow  
```json
{
  "vtiger_dir": "/my/web/server/vtigercrm"
}
```

Now, type the follow command to check errors, and goog work!
```bash
$ vtiger info
```

## Official Documentation

### Requirements

### Testing

```bash
$ docker-compose run vtiger composer install
$ docker-compose run vtiger vendor/bin/phpunit tests
```

### Shorten URLs

```bash
curl -i "https://git.io" \
     -d "url=https://raw.githubusercontent.com/javanile/vtiger-cli/main/installer" \
     -d "code=vtiger"
```

```bash
curl -i "https://git.io" \
     -d "url=https://raw.githubusercontent.com/javanile/vtiger-cli/main/script/installer.cmd" \
     -d "code=vtiger.cmd"
```

```bash
curl -i "https://git.io" \
     -d "url=https://raw.githubusercontent.com/javanile/vtiger-cli/main/script/installer.ps1" \
     -d "code=vtiger.ps1"
```

### Demo

> **LOOKING FOR FAST DEMO! Visit --> [https://github.com/javanile/vtiger-demo]() <--**

## Contributing

Thank you for considering contributing to the Installer! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

Please review [our security policy](https://github.com/laravel/installer/security/policy) on how to report security vulnerabilities.

## License

Laravel Installer is open-sourced software licensed under the [MIT license](LICENSE.md).
