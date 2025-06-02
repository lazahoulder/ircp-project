# Using Laravel Sail for Testing

This document explains how to use Laravel Sail to run tests in this project.

## What is Laravel Sail?

Laravel Sail is a light-weight command-line interface for interacting with Laravel's Docker development environment. Sail provides a great starting point for building a Laravel application using PHP, MySQL, and Redis without requiring prior Docker experience.

## Why Use Sail for Testing?

Running tests through Sail ensures that all required PHP extensions (including the XML extension needed for DOMDocument) are properly installed and configured in the Docker environment, avoiding issues that might occur in your local PHP installation.

## Prerequisites

- Docker installed on your system
- Docker Compose installed on your system

## Starting Sail

Before running tests, you need to start the Sail environment:

```bash
./vendor/bin/sail up -d
```

This command starts the Docker containers in detached mode.

## Running Tests

Once Sail is running, you can run the tests using the following command:

```bash
./vendor/bin/sail test
```

To run specific test files or filter tests, you can use:

```bash
./vendor/bin/sail test --filter=RegistrationTest
```

## Stopping Sail

When you're done, you can stop the Sail environment:

```bash
./vendor/bin/sail down
```

## Troubleshooting

If you encounter any issues with Sail, try the following:

1. Make sure Docker is running on your system
2. Try rebuilding the Sail containers:

```bash
./vendor/bin/sail build --no-cache
```

3. Check the Sail logs:

```bash
./vendor/bin/sail logs
```

## Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Documentation](https://docs.docker.com/)
