#!/bin/bash

# Local development setup script for Filament AlertBox Package

set -e

echo "🚀 Setting up Filament AlertBox Package for development..."

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "📋 Detected PHP version: $PHP_VERSION"

# Determine Laravel version based on PHP version
if php -r "exit(version_compare(PHP_VERSION, '8.2.0', '<') ? 1 : 0);"; then
    echo "⚠️  PHP < 8.2 detected, using Laravel 10"
    LARAVEL_VERSION="^10.0"
    TESTBENCH_VERSION="^8.0"
else
    echo "✅ PHP >= 8.2 detected, using Laravel 11"
    LARAVEL_VERSION="^11.0"
    TESTBENCH_VERSION="^9.0"
fi

echo "📦 Installing dependencies..."

# Install dependencies with appropriate versions
composer require "laravel/framework:$LARAVEL_VERSION" "orchestra/testbench:$TESTBENCH_VERSION" --no-interaction --no-update

echo "🔄 Updating all dependencies..."
composer update --prefer-dist --no-interaction

echo "✅ Setup complete!"
echo ""
echo "Available commands:"
echo "  composer test          - Run tests"
echo "  composer format        - Format code with Pint"
echo "  composer test-coverage - Run tests with coverage"
echo ""
echo "🎉 Happy coding!"
