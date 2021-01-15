# Changelog

All notable changes to TART (Terminal Art for Artisan) will be documented in this file.

## [1.1.0] - 2025-11-16

### Rebranding
- **Package renamed to TART** (Terminal Art for Artisan)
  - Namespace changed from `Profss\ConsoleArtist` to `Profss\Tart`
  - Command renamed from `console-artist:demo` to `tart:demo`
  - All references updated throughout codebase
  - More memorable, catchy name

## [1.0.0] - 2025-11-16

### Added
- Initial release of TART (Terminal Art for Artisan) package
- Extracted from legacy BaseCommand class (388 lines → 44 lines)
- Modular trait-based architecture:
  - `HasColoredOutput` - Color formatting and basic output
  - `HasBlocks` - Block-style messages (success, warning, error, etc.)
  - `HasLineBuilding` - Build output line-by-line with columns
  - `HasInteractivity` - Interactive features with auto-answer support
- Theme system with 4 built-in themes:
  - `DefaultTheme` (blue)
  - `SuccessTheme` (green)
  - `ErrorTheme` (red)
  - `Theme` (customizable base)
- Support classes:
  - `LineFormatter` - Line padding, centering, path highlighting
  - `ColorHelper` - Color formatting utilities
- Laravel adapter: `StyledCommand`
- Comprehensive documentation (README, INSTALLATION, PACKAGE-INFO)
- Unit and integration tests
- MIT License

### Features
- Beautiful colored terminal output
- Block-style messages (headers, footers, success, warnings, errors)
- Line-by-line output building with column support
- Path highlighting for file paths
- Auto-answer mode for non-interactive scripts
- Logo rendering (ProFusion and EnMasse logos)
- Horizontal rules and blank lines
- Theme switching and customization
- Full backward compatibility with existing BaseCommand API

### Fixed
- Fixed return value bug in original `run()` method (was returning `1` instead of parent result)
- Fixed bitwise operator bug (`>>` → `>`) in line length checks
- Fixed method signature compatibility issue with Laravel's `confirm()` method
- Improved method visibility (protected instead of private for extensibility)

### Technical
- PHP 8.0+ required
- PSR-4 autoloading
- Comprehensive PHPDoc comments
- Type hints throughout
- Symfony Console 5.0+ or 6.0+ compatibility
- Laravel 9.0+ compatibility

### Testing
- Unit tests for LineFormatter
- Unit tests for ColorHelper
- Unit tests for Theme classes
- Integration tests for StyledCommand
- Example command included

## [1.1.0] - 2025-11-16

### Added
- **Automatic Logo Creation** - New `AsciiArt` support class for creating branded logos
  - `displayTextLogo()` - Create text logos with automatic decoration
  - `displayAsciiLogo()` - Display multi-line ASCII art with decoration
  - `displayCustomLogo()` - Full control over logo creation
  - Three built-in styles: standard, box, and banner
  - Automatic colorful header/footer decoration blocks
  - Customizable colors, width, and padding
  - See [LOGO-CREATION.md](LOGO-CREATION.md) for full documentation
- Added `logo:demo` command to demonstrate logo creation features
- Added comprehensive logo creation examples

### Changed
- Enhanced `StyledCommand` with new logo display methods
- Added `AsciiArt` class to `Support` namespace

## [1.0.1] - 2025-11-16

### Fixed
- **Emoji Alignment Issue** - Fixed padding and alignment for multi-byte characters (emojis)
  - Added `LineFormatter::visualLength()` method for proper UTF-8 character counting
  - Updated `pad()`, `padding()`, and `center()` to use `mb_strlen()` instead of `strlen()`
  - Changed `substr()` to `mb_substr()` for multi-byte safety
  - Lines with emojis (✓, ✗, ⚠, ℹ, 🎉) now align correctly
  - Added comprehensive tests for emoji handling

### Changed
- Updated `BaseCommand::entityBlock()` to use `LineFormatter::visualLength()`
- Added 5 new unit tests for multi-byte character support

## [Unreleased]

### Planned
- Symfony Console adapter (for non-Laravel projects)
- Table rendering support
- Progress bar enhancements
- Animation support (spinners, loading indicators)
- Additional theme presets
- Tree/hierarchy view rendering

---

**Note:** This package was extracted from an internal project to provide reusable, beautiful CLI output formatting for PHP applications.

