# Gendiff [PHP edition]

[![Actions Status](https://github.com/ElenaManukyan/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/ElenaManukyan/php-project-48/actions)
[![PHP CI](https://github.com/ElenaManukyan/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/ElenaManukyan/php-project-48/actions/workflows/ci.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)

## Описание

Gendiff — утилита для сравнения двух конфигурационных файлов и вывода различий между ними.

## Установка

```bash
git clone https://github.com/ElenaManukyan/php-project-48.git
cd php-project-48
make install
```

## Использование

### Как CLI-утилита

```bash
./gendiff file1.json file2.json
```

### Как библиотека

```php
<?php

use function Differ\Differ\genDiff;

$diff = genDiff($pathToFile1, $pathToFile2);
print_r($diff);
```

## Пример работы

```
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
```

## Asciinema demo
### Comparison of flat files (JSON) + an example of the utility's capabilities
[![asciicast](https://asciinema.org/a/yAgglQUAOVi6kd4K0zpKwfUD1.svg)](https://asciinema.org/a/yAgglQUAOVi6kd4K0zpKwfUD1)
### Comparison of flat files (yaml)
[![asciicast](https://asciinema.org/a/WNKsrn6hsMu7jMpAgdkAH01pV.svg)](https://asciinema.org/a/WNKsrn6hsMu7jMpAgdkAH01pV)
### Recursive comparison (JSON + YML)
[![asciicast](https://asciinema.org/a/K3yo5M8TL5iT5HW0TJtLcbc3E.svg)](https://asciinema.org/a/K3yo5M8TL5iT5HW0TJtLcbc3E)
### Flat format
[![asciicast](https://asciinema.org/a/XUFs5iD8sVuEYXsrLUgD231hR.svg)](https://asciinema.org/a/XUFs5iD8sVuEYXsrLUgD231hR)
### Output in JSON
[![asciicast](https://asciinema.org/a/6TSx2pGcS5P4GGmh10GaJ3jrc.svg)](https://asciinema.org/a/6TSx2pGcS5P4GGmh10GaJ3jrc)
