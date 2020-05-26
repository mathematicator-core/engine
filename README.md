Math PHP computational engine
=============================

[![Integrity check](https://github.com/mathematicator-core/engine/workflows/Integrity%20check/badge.svg)](https://github.com/mathematicator-core/engine/actions?query=workflow%3A%22Integrity+check%22)
[![codecov](https://codecov.io/gh/mathematicator-core/engine/branch/master/graph/badge.svg)](https://codecov.io/gh/mathematicator-core/engine)
[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg)](./LICENSE)

Extremely complex library for advance work with math patterns, tokens and computing.

> Please help improve this documentation by sending a Pull request.

Install by Composer:

```
composer require mathematicator-core/engine
```

### What is this package responsible for?

This package contains set of tools that other [mathematicator-core](https://github.com/mathematicator-core)
packages have in common.

- Basic controllers
- System / common entities (DAOs)
- Translator (helper and common translations)
- Common exceptions
- Common router

Contribution
----

### Tests

All new contributions should have its unit tests in `/tests` directory.

Before you send a PR, please, check all tests pass.

This package uses [Nette Tester](https://tester.nette.org/). You can run tests via command:
```bash
composer test
````

Before PR, please run complete code check via command:
```bash
composer cs:install # only first time
composer fix # otherwise pre-commit hook can fail
````
