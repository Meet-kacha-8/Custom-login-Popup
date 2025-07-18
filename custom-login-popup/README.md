# Custom Login Popup – Documentation

Below are the details of the Custom Login Popup plugin implemented on your WordPress site.

## Plugin Overview

This plugin adds a login, registration, and forgot password form in a popup modal, integrated into the header menu. It offers a seamless, styled experience without redirecting to default WordPress pages.

## File & Naming Conventions

- All plugin files start with `__`, e.g., `__frontend.php`, `__admin.php`.
- Classes and variables are consistently prefixed with `CLP_` and `clp_` respectively.
- The structure is modular and adheres to WordPress coding standards.

## Backend Settings

Located under **Login Popup → Settings:**
- **Default Role**: Define which role is assigned to new users (Subscriber, Customer, Member).
- **Popup Colors**: Choose Primary and Secondary colors for the popup. Changes reflect on the frontend automatically.

## Frontend Features

- Login and Logout links added to the header menu.
- Popup includes Login, Register, and Forgot Password forms.
- AJAX functionality for login, logout, and reset password flows.
- Reset Password page is styled and created automatically on activation.

## Why This Plugin?

A custom-built solution ensures lightweight performance, branding consistency, and easy maintenance. It’s tailored specifically for your needs without unnecessary bloat.

If you have any questions or want further adjustments, feel free to reach out.

Thank you.


# PHPUnit Testing – Documentation

We are currently in the process of implementing PHPUnit tests for the Custom Login Popup plugin. This is part of our ongoing effort to ensure the plugin maintains high code quality and behaves as expected even as future enhancements are made.

## Next Steps

Once the PHPUnit test suite is complete, we will provide further details on how to run the tests and maintain them going forward. For now, this feature is under active development.

If you have any questions or would like updates on the progress of testing, please let me know.

Thank you.


# Custom Login Popup Plugin - Unit Testing Guide

## Test Coverage

The provided unit tests validate the following functionality of the Custom Login Popup plugin:
- Plugin main file exists.
- Reset password and popup template files exist.
- Helper functions:
  - Detect if WooCommerce is active.
  - Detect if Membership plugin is active.

## How to Run the Tests

Make sure you have PHP and Composer installed.

### 1. Install dependencies

Run the following in the plugin folder:
```bash
composer install
```

### 2. Run tests

Run PHPUnit from the plugin root folder:
```bash
vendor/bin/phpunit
```

### Notes:
- Works on Windows (CMD or PowerShell), macOS, and Linux terminals.
- No external WordPress test library is required for the included tests.
- Ensure your PHP version is >= 7.4.

## Test Files

- `tests/TestHelpers.php`: contains all unit test cases.
- `phpunit.xml`: PHPUnit configuration file.
- `vendor/`: created after running `composer install`, contains PHPUnit and dependencies.