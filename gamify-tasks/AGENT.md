# AGENT.md - Gamify Tasks (Yii2 Application)

## Build/Test Commands
- **Build CSS**: `npm run build` (compiles Tailwind CSS)
- **Run tests**: `vendor/bin/codecept run` (all tests)
- **Run single test**: `vendor/bin/codecept run unit tests/unit/ExampleTest.php`
- **Run test suite**: `vendor/bin/codecept run unit` (unit only)
- **Install dependencies**: `composer install` (PHP) and `npm install` (Node.js)
- **Start dev server**: `php yii serve` (Yii console command)

## Architecture & Structure
- **Framework**: Yii2 Basic Application Template with custom TaskManagement module
- **Database**: Configured via `config/db.php`, uses ActiveRecord pattern
- **Key directories**: `models/` (ActiveRecord), `controllers/` (web controllers), `commands/` (console), `views/` (templates)
- **Module**: TaskManagement module in `module/TaskManagement/`
- **Assets**: Web assets in `web/`, compiled CSS in `web/css/dist/`

## Code Style & Conventions
- **PHP namespace**: `app\` root namespace, PSR-4 autoloading
- **Model naming**: PascalCase classes extending `ActiveRecord`, table names with `{{%prefix}}`
- **Method docs**: Use PHPDoc with `@param`, `@return`, brief descriptions
- **Imports**: Use statements at top, Yii framework imports like `use Yii;`
- **Database**: snake_case column names (e.g., `auth_key`, `password_hash`)
- **Error handling**: Yii2 framework patterns, validation rules in models
