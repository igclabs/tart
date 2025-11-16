# Contributing to TART

Thank you for considering contributing to TART! This guide will help you get started.

## Code of Conduct

Be respectful, inclusive, and professional. We're building tools to make developers' lives better!

## How to Contribute

### Reporting Bugs

1. Check if the issue already exists in the issue tracker
2. Include:
   - PHP version
   - TART version
   - Minimal code example to reproduce
   - Expected vs actual behavior
   - Terminal environment details

### Suggesting Features

1. Open an issue describing the feature
2. Explain the use case
3. Provide code examples of how it would work
4. Discuss alternatives you've considered

### Pull Requests

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass (`composer test`)
6. Update documentation
7. Commit with clear messages
8. Push to your fork
9. Open a Pull Request

## Development Setup

```bash
# Clone your fork
git clone https://github.com/igclabs/tart.git
cd tart

# Install dependencies
composer install

# Run tests
composer test

# Run tests with coverage
composer test-coverage
```

## Coding Standards

### PHP Standards

- Follow PSR-12 coding style
- Use PHP 8.0+ features (typed properties, named arguments)
- Add type hints to all methods
- Write PHPDoc comments for public methods

### Example

```php
<?php

namespace IGC\Tart\Support;

class Example
{
    /**
     * Do something useful.
     *
     * @param string $input The input to process
     * @param int $max Maximum value
     * @return string The processed result
     */
    public function doSomething(string $input, int $max = 100): string
    {
        // Implementation
        return $input;
    }
}
```

## Testing Guidelines

### Unit Tests

- Test individual methods in isolation
- Mock dependencies
- Cover edge cases
- Name tests descriptively

```php
public function test_visual_length_handles_emojis(): void
{
    $this->assertEquals(6, LineFormatter::visualLength('✓ Done'));
}
```

### Integration Tests

- Test actual command execution
- Test trait combinations
- Verify output formatting

## Documentation

### When to Update Docs

- New features → Update README and relevant guide
- API changes → Update Quick Reference
- Bug fixes → Update CHANGELOG
- New examples → Add to examples/ directory

### Documentation Style

- Use clear, concise language
- Provide code examples
- Include use cases
- Show expected output when helpful

## Commit Messages

Follow conventional commit format:

```
feat: add gradient color block support
fix: emoji alignment in centered text
docs: update logo creation examples
test: add tests for custom themes
refactor: extract color helper methods
```

## Pull Request Checklist

Before submitting:

- [ ] Tests pass (`composer test`)
- [ ] New features have tests
- [ ] Documentation updated
- [ ] CHANGELOG.md updated
- [ ] Code follows PSR-12
- [ ] No breaking changes (or clearly documented)
- [ ] Examples added/updated if relevant

## Feature Guidelines

### What We're Looking For

✅ **Good Additions:**
- New output formatting methods
- Additional themes
- Enhanced logo creation features
- Framework adapters (Symfony, etc.)
- Improved emoji/Unicode support
- Performance optimizations
- Better testing utilities

### What to Avoid

❌ **Not a Good Fit:**
- Features specific to one application
- Breaking changes without strong justification
- Overly complex APIs
- Features that conflict with package philosophy
- Heavy dependencies

## Getting Help

- **Questions:** Open a discussion
- **Bugs:** Open an issue
- **Features:** Open an issue for discussion first
- **Security:** Email security@igcenterprises.com (do not open public issues)

## Recognition

Contributors will be:
- Listed in CHANGELOG.md
- Credited in release notes
- Recognized in the community

## Areas Needing Help

Current priorities:

1. **Symfony Adapter** - Pure Symfony Console support
2. **Table Rendering** - Beautiful table output
3. **Progress Bars** - Enhanced progress indicators
4. **Animations** - Spinners and loading indicators
5. **More Themes** - Community theme library
6. **Documentation** - Translations, examples, tutorials

## Development Workflow

1. **Discuss** - Open an issue to discuss major changes
2. **Branch** - Create a feature branch
3. **Code** - Implement with tests
4. **Test** - Ensure all tests pass
5. **Document** - Update relevant docs
6. **Submit** - Open pull request
7. **Review** - Address feedback
8. **Merge** - Celebrate! 🎉

## Release Workflow

1. Make sure `composer test` passes and `CHANGELOG.md` documents the release.
2. Run `./release.sh "your commit message"` from the project root.
3. The script bumps the patch version in `version.txt`, commits, tags (`vX.Y.Z`), and pushes to every available `origin`/`gitlab` remote.
4. Publish the tag on GitHub/Packagist as needed—Packagist will pick up the new tag automatically.

> The commit message argument is optional; the script falls back to `Increase version number to X.Y.Z` when omitted.

## Questions?

Feel free to open an issue for any questions about contributing!

---

**Thank you for making TART better!** 🎨✨

