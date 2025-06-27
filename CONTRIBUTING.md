# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [GitHub](https://github.com/rifrocket/filament-alert-box).

## Pull Requests

- **[PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)** - Check the code style with `composer format`.

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

## Running Tests

```bash
composer test
```

## Code Style

We use [Laravel Pint](https://laravel.com/docs/pint) for code formatting:

```bash
composer format
```

## Development Setup

1. Fork the repository
2. Clone your fork locally
3. Install dependencies:
   ```bash
   composer install
   ```
4. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
5. Make your changes
6. Run tests:
   ```bash
   composer test
   ```
7. Format code:
   ```bash
   composer format
   ```
8. Commit and push
9. Create a Pull Request

## Reporting Issues

When creating an issue, please provide:

- **PHP Version**
- **Laravel Version** 
- **Filament Version**
- **Package Version**
- **Steps to reproduce**
- **Expected behavior**
- **Actual behavior**

## Feature Requests

We're always looking for suggestions to improve this package. If you have a suggestion, please:

1. Check if the feature has already been requested
2. Create a detailed issue explaining:
   - What problem it solves
   - How you envision it working
   - Any alternative solutions you've considered

## Code of Conduct

Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in this project you agree to abide by its terms.

**Happy coding**!
