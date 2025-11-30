# 🔄 Gendiff - Configuration Files Difference Generator [PHP edition]

[![Actions Status](https://github.com/ElenaManukyan/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/ElenaManukyan/php-project-48/actions)
[![PHP CI](https://github.com/ElenaManukyan/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/ElenaManukyan/php-project-48/actions/workflows/ci.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ElenaManukyan_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=ElenaManukyan_php-project-48)

## 📖 Description

**Gendiff** is a powerful CLI utility and library that compares two configuration files and shows the difference between them. It supports nested structures and multiple output formats.

### ✨ Features

- 📁 Supports **JSON** and **YAML** file formats
- 🌳 Handles **nested structures** with unlimited depth
- 🎨 Multiple output formats: `stylish`, `plain`, `json`
- 🔧 Can be used as **CLI tool** or **PHP library**
- ✅ Fully tested with PHPUnit

---

## 🚀 Installation

```bash
git clone https://github.com/ElenaManukyan/php-project-48.git
cd php-project-48
make install
```

### 📋 Requirements

- PHP >= 8.1
- Composer

---

## 💻 Usage

### As CLI Tool

```bash
# Default format (stylish)
./gendiff file1.json file2.json

# With specific format
./gendiff --format plain file1.yml file2.yml
./gendiff --format json file1.json file2.json

# Help
./gendiff -h
```

### As PHP Library

```php
<?php

use function Differ\Differ\genDiff;

// Default format (stylish)
$diff = genDiff($pathToFile1, $pathToFile2);

// With specific format
$diff = genDiff($pathToFile1, $pathToFile2, 'plain');
$diff = genDiff($pathToFile1, $pathToFile2, 'json');

echo $diff;
```

---

## 🎨 Output Formats

### Stylish (default)

Tree-like format with visual markers for changes:

```
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
    }
}
```

### Plain

Human-readable text format:

```
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
```

### JSON

Structured format for programmatic use:

```json
[
    {
        "key": "common",
        "type": "nested",
        "children": [...]
    }
]
```

---

## 🔍 Legend

| Symbol | Meaning |
|--------|---------|
| `+` | Added in second file |
| `-` | Removed from first file |
| ` ` | Unchanged |

---

## 🧪 Development

```bash
# Run tests
make test

# Run linter
make lint

# Run tests with coverage
make test-coverage
```

---

## 📄 License

MIT

---

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
