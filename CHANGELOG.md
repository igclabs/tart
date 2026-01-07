# Changelog

All notable changes to TART will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Interactive Input**: New `prompt()` method for text input with validation support
- **Password Input**: New `password()` method for hidden password entry (cross-platform)
- **Progress Bars**: Visual progress tracking with percentages and labels via `progressBar()`
- **Spinners**: Animated loading indicators with 7 styles (dots, dots2, dots3, line, arrow, pulse, bounce)
- **Lists**: Three list types - `bulletList()`, `orderedList()`, and `taskList()`
- **Tables**: Beautiful table rendering with `renderTable()` and auto-width calculation
- **Demo Command**: New `tart:new-features` command showcasing all new features
- **17 new unit tests** for all new features (total: 53 tests, 118 assertions)

### Changed
- Updated README with new features
- Updated Quick Reference guide with new API methods
- Enhanced documentation with usage examples

### Fixed
- PHPStan level 7 compliance maintained (0 errors)
- All existing tests continue to pass

## [1.1.3] - 2024-11-18

### Fixed
- PHPStan errors resolved (61 → 0 errors)
- Runtime bugs in `LineFormatter::highlightPath()` and `HasColoredOutput::bad()`
- Unsafe `new static()` usage replaced with `new self()`
- Unreachable match arms in demo commands
- README badge PHP version corrected to ^8.2

### Added
- PHP-CS-Fixer configuration for code style enforcement
- Array type hints throughout codebase for PHPStan compliance
- Composer scripts: `cs-fix` and `cs-check`

## [1.1.2] - 2024-11-16

### Added
- Fluent theme API with `Theme::make()` and chainable methods
- Fluent logo builder with `$this->logo()` API
- New demo command `tart:fluent-demo` showcasing fluent APIs

## [1.1.0] - 2024-11-16

### Added
- Initial public release
- Basic output methods (say, good, bad, state, cool)
- Block messages (header, title, success, notice, warning, failure, stat, footer)
- Logo generation (text, ASCII, boxed, banner)
- Theme system with 3 built-in themes
- Line building for progressive output
- Path highlighting
- Laravel and Symfony support
- Demo commands

[Unreleased]: https://github.com/igclabs/tart/compare/v1.1.3...HEAD
[1.1.3]: https://github.com/igclabs/tart/compare/v1.1.2...v1.1.3
[1.1.2]: https://github.com/igclabs/tart/compare/v1.1.0...v1.1.2
[1.1.0]: https://github.com/igclabs/tart/releases/tag/v1.1.0
